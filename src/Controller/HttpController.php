<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HttpController
 * @package App\Controller
 *
 * @Route("/http")
 */
class HttpController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        return $this->render('http/index.html.twig', [
            'controller_name' => 'HttpController',
        ]);
    }

    /**
     * @Route("/request")
     */
    public function request(Request $request)
    {
        // http://127.0.0.1:8000/http/request?nom=Anest&prenom=Julien
        dump($_GET); // ['nom' => 'Anest', 'prenom' => 'Julien']

        // $request->query est une surcouche en objet au tableau $_GET
        dump($request->query->all()); // ['nom' => 'Anest', 'prenom' => 'Julien']

        // $_GET['nom']
        dump($request->query->get('nom')); // 'Anest'

        dump($request->query->get('surnom')); // null

        // optionnel : valeur par défaut si null
        dump($request->query->get('surnom', 'John Doe')); // 'John Doe'

        // isset($_GET['surnom'])
        dump($request->query->has('surnom')); // false

        // GET ou POST
        dump($request->getMethod());

        // si le formulaire en POST est envoyé
        if ($request->isMethod('POST')) { // $request->getMethod() == 'POST'
            // $request->request est une surcouche en objet au tableau $_POST
            dump($request->request->all());
        }

        return $this->render('http/request.html.twig');
    }

//    public function session(Request $request)
//    {
//        // pour accéder à la session depuis l'objet Request
//        $session = $request->getSession();
//    }

    /**
     * @param SessionInterface $session
     *
     * @Route("/session")
     */
    public function session(SessionInterface $session)
    {
        // ajouter des éléments à la session
        $session->set('nom', 'Anest');
        $session->set('prenom', 'Julien');

        // les éléments stockés par l'objet Session le sont
        // dans $_SESSION['_sf2_attributes']
        dump($_SESSION);

        // tous les éléments de la session
        dump($session->all());

        // accéder à un élément de la session
        dump($session->get('prenom'));

        // supprimer un élément de la session
        $session->remove('nom');

        dump($session->all());

        // vider la session
        $session->clear();

        dump($session->all());

        $session->set('user', ['prenom' => 'Groucho', 'nom' => 'Marx']);

        dump($session->all());

        return $this->render('http/session.html.twig');
    }

    /**
     * @Route("/response")
     */
    public function response(Request $request)
    {
        // toutes les méthodes des contrôleurs doivent retourner
        // un objet instance de la classe Response
        $response = new Response('Contenu de la page');

        // http://127.0.0.1:8000/http/response?type=twig
        if ($request->query->get('type') == 'twig') {
            //
            // $this->render() retourne un objet instance de la classe Response
            // dont le contenu est le HTML construit par le template
            return $this->render('http/response.html.twig');
        }

        return $response;
    }
}