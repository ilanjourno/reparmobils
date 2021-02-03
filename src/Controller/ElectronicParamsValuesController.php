<?php

namespace App\Controller;

use App\Entity\Electronic;
use App\Entity\ElectronicParams;
use App\Entity\ElectronicParamsValues;
use App\Form\ElectronicParamsValuesType;
use App\Repository\ElectronicParamsValuesRepository;
use Doctrine\ORM\QueryBuilder;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/electronic/{electronic}/param/{param}/values")
 */
class ElectronicParamsValuesController extends AbstractController
{

    private $electronic;
    private $electronicParams;

    /**
     * @Route("/", name="electronic_params_values_index", methods={"GET", "POST"})
     */
    public function index(Request $request, Electronic $electronic, ElectronicParams $electronicParams, ElectronicParamsValuesRepository $electronicParamsValuesRepository, DataTableFactory $dataTableFactory): Response
    {
        $this->electronicParams = $electronicParams;
        $this->electronic = $electronic;

        $table = $dataTableFactory->create()
        ->setTemplate('@DataTables/datatable_html.html.twig', ['className' => 'table table-striped'])
        ->add('id', TextColumn::class, ['label' => '#'])
        ->add('name', TextColumn::class, ['label' => 'Nom'])
        ->add('nickname', TextColumn::class, ['label' => $electronicParams->getType() == 'colors' ? 'La couleur' : 'Pseudo :', 'render' => function($value, $context){
            if($this->electronicParams->getType() == 'colors'){
                return sprintf("<span class='text-white badge badge-dark' style='background-color: $value'>$value</span>");
            }
            return sprintf("<span class='text-white'>$value</span>");
        }])
        ->add('actions', TextColumn::class, [
            'data' => function($context) {
                return $context->getId();
            }, 
            'render' => function($value, $context){
                $show = sprintf('<a href="%s" class="btn btn-primary">Regarder</a>', $this->generateUrl('electronic_params_values_show', ['electronic' => $this->electronic->getId(),'param' => $this->electronicParams->getId(),'id' => $value]));
                $edit = sprintf('<a href="%s" class="btn btn-primary">Modifier</a>', $this->generateUrl('electronic_params_values_edit', ['electronic' => $this->electronic->getId(),'param' => $this->electronicParams->getId(),'id' => $value]));
                return $show.$edit;
            }, 
            'label' => 'Actions',
        ])
        ->createAdapter(ORMAdapter::class, [
            'entity' => ElectronicParamsValues::class,
            'query' => function (QueryBuilder $builder) {
                return $builder
                    ->select('e')
                    ->where('e.param = :param')
                    ->setParameter('param', $this->electronicParams)
                    ->from(ElectronicParamsValues::class, 'e')
                ;
            },
        ])->handleRequest($request);

        if ($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('electronic_params_values/index.html.twig', [
            'electronic_params_values' => $electronicParamsValuesRepository->findAll(),
            'datatable' => $table,
            'electronic_id' => $electronic->getId(),
            'param_id' => $electronicParams->getId()
        ]);
    }

    /**
     * @Route("/new", name="electronic_params_values_new", methods={"GET","POST"})
     */
    public function new(Request $request, Electronic $electronic, ElectronicParams $electronicParams): Response
    {
        $electronicParamsValue = new ElectronicParamsValues();
        $form = $this->createForm(ElectronicParamsValuesType::class, $electronicParamsValue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $electronicParamsValue->setParam($electronicParams);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($electronicParamsValue);
            $entityManager->flush();

            return $this->redirectToRoute('electronic_params_values_index', [
                'electronic' => $electronic->getId(),
                'param' => $electronicParams->getId()
            ]);
        }

        return $this->render('electronic_params_values/new.html.twig', [
            'electronic_params_value' => $electronicParamsValue,
            'form' => $form->createView(),
            'electronic_id' => $electronic->getId(),
            'param' => $electronicParams
        ]);
    }

    /**
     * @Route("/{id}", name="electronic_params_values_show", methods={"GET"})
     */
    public function show(ElectronicParamsValues $electronicParamsValue): Response
    {
        return $this->render('electronic_params_values/show.html.twig', [
            'electronic_params_value' => $electronicParamsValue,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="electronic_params_values_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ElectronicParamsValues $electronicParamsValue, Electronic $electronic, ElectronicParams $electronicParams): Response
    {
        $form = $this->createForm(ElectronicParamsValuesType::class, $electronicParamsValue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('electronic_params_values_index', [
                'electronic' => $electronic->getId(),
                'param' => $electronicParams->getId()
            ]);
        }

        return $this->render('electronic_params_values/edit.html.twig', [
            'electronic_params_value' => $electronicParamsValue,
            'form' => $form->createView(),
            'electronic_id' => $electronic->getId(),
            'param' => $electronicParams
        ]);
    }

    /**
     * @Route("/{id}", name="electronic_params_values_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ElectronicParamsValues $electronicParamsValue): Response
    {
        if ($this->isCsrfTokenValid('delete'.$electronicParamsValue->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($electronicParamsValue);
            $entityManager->flush();
        }

        return $this->redirectToRoute('electronic_params_values_index');
    }
}
