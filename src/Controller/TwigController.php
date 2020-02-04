<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TwigController
 * @package App\Controller
 *
 * Préfixe de route : toutes les url définies dans les routes
 * de ce contrôleur seront préfixées par /twig
 * @Route("/twig")
 */
class TwigController extends AbstractController
{
    /**
     * L'url de cette route est /twig ou /twig/ parce qu'il y a
     * le préfixe de route défini pour la classe
     * @Route("/")
     */
    public function index()
    {
        $test = 'Variable de test dans le contrôleur';
        // la fonction dump() fait l'équivalent d'un var_dump() qui va
        // se loger dans la barre de debug
        dump($test);

        return $this->render(
            'twig/index.html.twig',
            [
                'demain' => new \DateTime('+1day')
            ]
        );
    }
}