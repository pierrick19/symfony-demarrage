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
     * Partie variable de la route optionnelle (avec une valeur par défaut) :
     * La route matche /salut/unNom : $qui vaut "unNom"
     * et matche aussi /salut et /salut/ : $qui vaut "à toi"
     *
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

    /**
     * id doit être un nombre (\d+ en expression régulière)
     *
     *
     * @Route("/categorie/{id}", requirements={"id": "\d+"})
     */
    public function categorie($id)
    {
        return $this->render(
            'index/categorie.html.twig',
            [
                'id' => $id
            ]
        );
    }



}
