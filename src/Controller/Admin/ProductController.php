<?php

namespace App\Controller\Admin;

use App\Entity\Files;
use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Services\FileUploader;
use Doctrine\ORM\QueryBuilder;
use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;

/**
 * @Route("/admin/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product_index", methods={"GET", "POST"})
     */
    public function index(Request $request, ProductRepository $productRepository, DataTableFactory $dataTableFactory): Response
    {
        $table = $dataTableFactory->create()
        ->setTemplate('@DataTables/datatable_html.html.twig', ['className' => 'table table-striped'])
        ->add('id', TextColumn::class, ['label' => '#'])
        ->add('name', TextColumn::class, ['label' => 'Nom'])
        ->add('description', TextColumn::class, ['label' => 'Description'])
        ->add('price', TextColumn::class, ['label' => 'Prix'])
        ->add('quantity', TextColumn::class, ['label' => 'Quantité disponible'])
        ->add('actions', TextColumn::class, [
            'data' => function($context) {
                return $context->getId();
            }, 
            'render' => function($value, $context){
                $show = sprintf('<a href="%s" class="btn btn-primary">Regarder</a>', $this->generateUrl('product_show', ['id' => $value]));
                $edit = sprintf('<a href="%s" class="btn btn-primary">Modifier</a>', $this->generateUrl('product_edit', ['id' => $value]));
                return $show.$edit;
            }, 
            'label' => 'Actions',
        ])
        ->createAdapter(ORMAdapter::class, [
            'entity' => Product::class,
            'query' => function (QueryBuilder $builder) {
                return $builder
                    ->select('e')
                    ->from(Product::class, 'e')
                ;
            },
        ])->handleRequest($request);

        if ($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
            'datatable' => $table
        ]);
    }

    /**
     * @Route("/new", name="product_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            foreach ($product->getUploadedFiles() as $key => $value) {
                $file = new Files();
                $fileName = $fileUploader->upload($value);
                $file = $file->setFile($fileName);
                $file->setProduct($product);
                $entityManager->persist($file);
            }
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_show", methods={"GET"}, requirements={"id":"\d+"})
     */
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_index');
    }
}
