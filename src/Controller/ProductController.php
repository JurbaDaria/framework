<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product/{id}', name: 'app_product')]
    public function view(int $id)
    {
       $data = [
        'id' => $id, 
        
       ];

       $randomNumber = rand(0,4);

       return $this->render('product/index.html.twig' , [ 
        'product' => $id,
        'number'  => $randomNumber,
        'id'      => $id,
        'data'    => $data,
        'date'    => new DateTime("now"),
       ]);

    }
}
