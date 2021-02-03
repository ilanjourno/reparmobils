<?php

namespace App\Controller;

use App\Entity\ElectronicCategory;
use App\Form\ElectronicCategoryType;
use App\Repository\ElectronicCategoryRepository;
use Doctrine\ORM\QueryBuilder;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ElectronicCategoryController extends AbstractController
{
    /**
     * @Route("/admin/electronic/category", name="electronic_category_index", methods={"GET", "POST"})
     */
    public function index(Request $request, ElectronicCategoryRepository $electronicCategoryRepository, DataTableFactory $dataTableFactory): Response
    {
        $table = $dataTableFactory->create()
        ->setTemplate('@DataTables/datatable_html.html.twig', ['className' => 'table table-striped'])
        ->add('id', TextColumn::class, ['label' => '#'])
        ->add('name', TextColumn::class, ['label' => 'Nom'])
        ->add('actions', TextColumn::class, [
            'data' => function($context) {
                return $context->getId();
            }, 
            'render' => function($value, $context){
                $show = sprintf('<a href="%s" class="btn btn-primary">Regarder</a>', $this->generateUrl('electronic_category_show', ['id' => $value]));
                $edit = sprintf('<a href="%s" class="btn btn-primary">Modifier</a>', $this->generateUrl('electronic_category_edit', ['id' => $value]));
                return $show.$edit;
            }, 
            'label' => 'Actions',
        ])
        ->createAdapter(ORMAdapter::class, [
            'entity' => ElectronicCategory::class,
            'query' => function (QueryBuilder $builder) {
                return $builder
                    ->select('e')
                    ->from(ElectronicCategory::class, 'e')
                ;
            },
        ])->handleRequest($request);

        if ($table->isCallback()) {
            return $table->getResponse();
        }
        return $this->render('electronic_category/index.html.twig', [
            'electronic_categories' => $electronicCategoryRepository->findAll(),
            'datatable' => $table
        ]);
    }

    /**
     * @Route("/api/electronics/category", name="api_electronic_category_index", methods={"GET"})
    */
    public function apiIndex(Request $request, ElectronicCategoryRepository $repository, SerializerInterface $serializer){
        $response = new Response($serializer->serialize($repository->findAllApi(), 'json', ['groups' => 'API']));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/admin/electronic/category/new", name="electronic_category_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $electronicCategory = new ElectronicCategory();
        $form = $this->createForm(ElectronicCategoryType::class, $electronicCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($electronicCategory);
            $entityManager->flush();

            return $this->redirectToRoute('electronic_category_index');
        }

        return $this->render('electronic_category/new.html.twig', [
            'electronic_category' => $electronicCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/electronic/category/{id}", name="electronic_category_show", methods={"GET"})
     */
    public function show(ElectronicCategory $electronicCategory): Response
    {
        return $this->render('electronic_category/show.html.twig', [
            'electronic_category' => $electronicCategory,
        ]);
    }

    /**
     * @Route("/admin/electronic/category/{id}/edit", name="electronic_category_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ElectronicCategory $electronicCategory): Response
    {
        $form = $this->createForm(ElectronicCategoryType::class, $electronicCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('electronic_category_index');
        }

        return $this->render('electronic_category/edit.html.twig', [
            'electronic_category' => $electronicCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/electronic/category/{id}", name="electronic_category_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ElectronicCategory $electronicCategory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$electronicCategory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($electronicCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('electronic_category_index');
    }
}
