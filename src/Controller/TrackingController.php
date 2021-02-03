<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrackingController extends AbstractController
{
    /**
     * @Route("/tracking", name="tracking")
     */
    public function index(): Response
    {
        return $this->render('tracking/index.html.twig', [
            'controller_name' => 'TrackingController',
        ]);
    }
}
