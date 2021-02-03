<?php

namespace App\Controller\Admin;

use App\Entity\Electronic;
use App\Form\ElectronicType;
use App\Repository\ElectronicRepository;
use App\Entity\ElectronicCategory;
use Doctrine\ORM\QueryBuilder;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class ElectronicsController extends AbstractController
{
    /**
     * @Route("/admin/electronics/", name="electronics_index", methods={"GET", "POST"})
     */
    public function index(Request $request, ElectronicRepository $ElectronicsRepository, DataTableFactory $dataTableFactory): Response
    {
        $table = $dataTableFactory->create()
        ->setTemplate('@DataTables/datatable_html.html.twig', ['className' => 'table table-striped'])
        ->add('id', TextColumn::class, ['label' => '#'])
        ->add('name', TextColumn::class, ['label' => 'Nom'])
        // ->add('colors', TextColumn::class, ['label' => 'Nom'])
        ->add('actions', TextColumn::class, [
            'data' => function($context) {
                return $context->getId();
            }, 
            'render' => function($value, $context){
                $show = sprintf('<a href="%s" class="btn btn-primary">Regarder</a>', $this->generateUrl('electronics_show', ['id' => $value]));
                $edit = sprintf('<a href="%s" class="btn btn-primary">Modifier</a>', $this->generateUrl('electronics_edit', ['id' => $value]));
                return $show.$edit;
            }, 
            'label' => 'Actions',
        ])
        ->createAdapter(ORMAdapter::class, [
            'entity' => Electronic::class,
            'query' => function (QueryBuilder $builder) {
                return $builder
                    ->select('e')
                    ->from(Electronic::class, 'e')
                ;
            },
        ])->handleRequest($request);

        if ($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('admin/electronic/index.html.twig', [
            'electronics' => $ElectronicsRepository->findAll(),
            'datatable' => $table
        ]);
    }

    /**
     * @Route("/api/electronics/{id}", name="api_electronics_index", methods={"GET"})
     */
    public function apiIndex(Request $request, ElectronicCategory $category, SerializerInterface $serializer, NormalizerInterface $normalizerInterface)
    {
        $data = $normalizerInterface->normalize($category->getElectronics());
        dd($data);
        $response = new Response($serializer->serialize($category->getElectronics(), 'json', ['groups' => 'API']));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/admin/electronics/new", name="electronics_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $electronics = new Electronic();
        $form = $this->createForm(ElectronicType::class, $electronics);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($electronics);
            $entityManager->flush();

            return $this->redirectToRoute('electronics_index');
        }

        return $this->render('admin/electronic/new.html.twig', [
            'electronics' => $electronics,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/electronics/{id}", name="electronics_show", methods={"GET"})
     */
    public function show(Electronic $electronics): Response
    {
        return $this->render('admin/electronic/show.html.twig', [
            'electronic' => $electronics,
        ]);
    }

    /**
     * @Route("/admin/electronics/{id}/edit", name="electronics_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Electronic $electronics): Response
    {
        $form = $this->createForm(ElectronicType::class, $electronics);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('electronics_index');
        }

        return $this->render('admin/electronic/edit.html.twig', [
            'electronic' => $electronics,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/electronics/{id}", name="electronic_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Electronic $electronics): Response
    {
        if ($this->isCsrfTokenValid('delete'.$electronics->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($electronics);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin/electronic/ectronics_index');
    }
}
