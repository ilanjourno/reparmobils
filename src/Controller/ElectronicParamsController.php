<?php

namespace App\Controller;

use App\Entity\Electronic;
use App\Entity\ElectronicParams;
use App\Form\ElectronicParamsType;
use App\Repository\ElectronicParamsRepository;
use Doctrine\ORM\QueryBuilder;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/electronic/{electronic}/params")
 */
class ElectronicParamsController extends AbstractController
{

    private $electronic;

    /**
     * @Route("/", name="electronic_params_index", methods={"GET", "POST"})
     */
    public function index(Request $request, Electronic $electronic, ElectronicParamsRepository $electronicParamsRepository, DataTableFactory $dataTableFactory): Response
    {
        $this->electronic = $electronic;

        $table = $dataTableFactory->create()
        ->setTemplate('@DataTables/datatable_html.html.twig', ['className' => 'table table-striped'])
        ->add('id', TextColumn::class, ['label' => '#'])
        ->add('name', TextColumn::class, ['label' => 'Nom'])
        ->add('type', TextColumn::class, ['label' => 'Type'])
        ->add('multipleOrNot', TextColumn::class, ['label' => 'Nombre de choi(x) possible', 'render' => function($value, $context) {
            return $value == true ? 'Plusieurs' : 'Un seul';
        }])
        ->add('actions', TextColumn::class, [
            'data' => function($context) {
                return $context->getId();
            }, 
            'render' => function($value, $context){
                $show = sprintf('<a href="%s" class="btn btn-primary">Regarder</a>', $this->generateUrl('electronic_params_show', ['electronic' => $this->electronic->getId(), 'id' => $value]));
                $edit = sprintf('<a href="%s" class="btn btn-primary">Modifier</a>', $this->generateUrl('electronic_params_edit', ['electronic' => $this->electronic->getId(), 'id' => $value]));
                return $show.$edit;
            }, 
            'label' => 'Actions',
        ])
        ->createAdapter(ORMAdapter::class, [
            'entity' => ElectronicParams::class,
            'query' => function (QueryBuilder $builder) {
                return $builder
                    ->select('e')
                    ->where('e.electronic = :electronic')
                    ->setParameter('electronic', $this->electronic)
                    ->from(ElectronicParams::class, 'e')
                ;
            },
        ])->handleRequest($request);

        if ($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('electronic_params/index.html.twig', [
            'electronic_params' => $electronicParamsRepository->findAll(),
            'datatable' => $table,
            'electronic_id' => $electronic->getId()
        ]);
    }

    /**
     * @Route("/new", name="electronic_params_new", methods={"GET","POST"})
     */
    public function new(Request $request, Electronic $electronic): Response
    {
        $electronicParam = new ElectronicParams();
        $form = $this->createForm(ElectronicParamsType::class, $electronicParam);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $electronicParam->setElectronic($electronic);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($electronicParam);
            $entityManager->flush();

            return $this->redirectToRoute('electronic_params_index', [
                'electronic' => $electronic->getId()
            ]);
        }

        return $this->render('electronic_params/new.html.twig', [
            'electronic_param' => $electronicParam,
            'form' => $form->createView(),
            'electronic' => $electronic
        ]);
    }

    /**
     * @Route("/{id}", name="electronic_params_show", methods={"GET"})
     */
    public function show(ElectronicParams $electronicParam): Response
    {
        return $this->render('electronic_params/show.html.twig', [
            'electronic_param' => $electronicParam,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="electronic_params_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ElectronicParams $electronicParam): Response
    {
        $form = $this->createForm(ElectronicParamsType::class, $electronicParam);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('electronic_params_index');
        }

        return $this->render('electronic_params/edit.html.twig', [
            'electronic_param' => $electronicParam,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="electronic_params_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ElectronicParams $electronicParam): Response
    {
        if ($this->isCsrfTokenValid('delete'.$electronicParam->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($electronicParam);
            $entityManager->flush();
        }

        return $this->redirectToRoute('electronic_params_index');
    }
}
