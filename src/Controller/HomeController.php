<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(ProductRepository $productRepository): Response
    {
        $lastestProducts = $productRepository->findLastest();
        
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'lastest_products' => $lastestProducts
        ]);
    }
}
