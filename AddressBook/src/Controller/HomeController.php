<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/hello/{name}", requirements={"name": "[a-zA-Z]+"})
     */
    public function hello($name)
    {
        return new Response("Hello $name", 200, ['Content-Type' => 'text/plain']);
    }
}
