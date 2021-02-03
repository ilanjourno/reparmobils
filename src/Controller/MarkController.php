<?php

namespace App\Controller;

use App\Entity\Mark;
use App\Form\MarkType;
use App\Repository\MarkRepository;
use Doctrine\ORM\QueryBuilder;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/mark")
 */
class MarkController extends AbstractController
{
    /**
     * @Route("/", name="mark_index", methods={"GET", "POST"})
     */
    public function index(Request $request, MarkRepository $markRepository, DataTableFactory $dataTableFactory): Response
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
                $show = sprintf('<a href="%s" class="btn btn-primary">Regarder</a>', $this->generateUrl('mark_show', ['id' => $value]));
                $edit = sprintf('<a href="%s" class="btn btn-primary">Modifier</a>', $this->generateUrl('mark_edit', ['id' => $value]));
                return $show.$edit;
            }, 
            'label' => 'Actions',
        ])
        ->createAdapter(ORMAdapter::class, [
            'entity' => Mark::class,
            'query' => function (QueryBuilder $builder) {
                return $builder
                    ->select('e')
                    ->from(Mark::class, 'e')
                ;
            }
        ])->handleRequest($request);

        if ($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('mark/index.html.twig', [
            'marks' => $markRepository->findAll(),
            'datatable' => $table
        ]);
    }

    /**
     * @Route("/new", name="mark_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $mark = new Mark();
        $form = $this->createForm(MarkType::class, $mark);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($mark);
            $entityManager->flush();

            return $this->redirectToRoute('mark_index');
        }

        return $this->render('mark/new.html.twig', [
            'mark' => $mark,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mark_show", methods={"GET"})
     */
    public function show(Mark $mark): Response
    {
        return $this->render('mark/show.html.twig', [
            'mark' => $mark,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="mark_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Mark $mark): Response
    {
        $form = $this->createForm(MarkType::class, $mark);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mark_index');
        }

        return $this->render('mark/edit.html.twig', [
            'mark' => $mark,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mark_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Mark $mark): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mark->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($mark);
            $entityManager->flush();
        }

        return $this->redirectToRoute('mark_index');
    }
}
