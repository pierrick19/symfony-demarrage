<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * Page à la racine du nom de domaine
     * @Route("/")
     */
    public function index()
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    /**
     * localhost:8000/hello
     *
     * URL de la page
     * @Route("/hello")
     */
    public function hello()
    {
        // rendu du fichizer qui construit le html
        // contenu dans la page
        // Chemin à partri de la racine du repetoire templates
        return $this->render('index/hello.html.twig');
    }

    /**
     * @Route("/bonjour/{qui}")
     */
    public function bonjour($qui)
    {

        return $this->render(
            'index/bonjour.html.twig',
            [
                'nom' => $qui
            ]

        );
    }

    /**
     * @Route("/salut/{qui}", defaults={"qui":"à toi"})
     */
    public function salut($qui)
    {
        return $this->render(
            'index/salut.html.twig',
            [
                'qui' => $qui
            ]
        );
    }

}
