<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class DoctrineController
 * @package App\Controller
 *
 * @Route("/doctrine")
 */
class DoctrineController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        return $this->render('doctrine/index.html.twig', [
            'controller_name' => 'DoctrineController',
        ]);
    }


    /**
     * @Route("/user/{id}", requirements={"id": "\d+"})
     *
     */
    public function getOneUser(UserRepository $repository, $id)
    {
        /*
         * Retourne un objet user de la classe entityuser dont les
         * attributs sont settes
         * à partir de la bdd dans la table user à l'id passé
         * en parametre ou null si l'id n'existe pas
         */
        $user=$repository->find($id);

        dump($user);

        // si l'id n'existe pas dans la table
        if (is_null($user)){
            throw new NotFoundHttpException();
        }
        return $this->render(
            'doctrine/get_user.html.twig',
            [
                'user'=>$user
            ]
            );
    }

    /**
     *
     * @Route("/users-list")
     */
    public function listUsers(UserRepository $repository)
    {

        /*
         * Retourne tous les utilisateurs de la table user
         * un tableau d'objets user
         */
        $users = $repository->findBy([], ['pseudo' => 'ASC']);

        dump($users);

         return $this->render(
             'doctrine/list_users.html.twig',
             [
              'users'=> $users
                 ]
         );
    }

    /**
     * @Route("/search-email")
     *
     */
    public function searchEmail(Request $request, UserRepository $repository)
    {
        $twigVariables=[];

        // equivalent if(isset($_GET['email'])
        if($request->query->has('email')){
            // findOneBy quand on est sur qu'il bn'y a pas plus d'un resultat
            // retourne un objet user ou null
              $user = $repository->findOneBy(
                  [
                      'email' => $request->query->get('email')
                  ]
              );
            $twigVariables['user']=$user;

        }

        return $this->render(
            'doctrine/search_email.html.twig',
            $twigVariables
        );
    }

    /**
     * @Route("/pseudo/user/{pseudo}")
     *
     */
    public function getByPseudo(UserRepository $repository, $pseudo)
    {

            // findOneBy quand il ya plusieurs resultats possibles
            // retourne un objet user ou null
            $users = $repository->findBy(
                [
                    'pseudo' => $pseudo
                ]
            );

        return $this->render(
            'doctrine/list_users.html.twig',
            [
                'users' => $users
            ]
        );
    }


    /**
     * @Route("/create-user")
     *
     */
    public function createUser(Request $request, EntityManagerInterface $manager)
    {
        if($request->isMethod('POST')){
            $data = $request->request->all();

            $user = new User();

            $user
                ->setPseudo($data['pseudo'])
                ->setEmail($data['email'])
                // le setter de birthdate attend un objet DateTime
                ->setBirthdate(new \DateTime($data['birthdate']));

            // indique au gestionnaire d'entité qu'il faudra entregistrer
            // en BDD au prochain flush
            $manager->persist($user);
            // enregistrement effectif
            $manager->flush();

        }

        return $this->render('doctrine/create_user.html.twig');
    }


    /**
     *
     * @Route("/search")
     *
     */
    public function search(Request $request, UserRepository $repository)
    {
        $twigVariables=[];

        // equivalent if(isset($_GET['email'])
        if($request->query->has('search')){
            // methode definie dans UserRepository

            $users= $repository->findByPseudoOrEmail(
                $request->query->get('search'));

            $twigVariables['users']=$users;

        }

        return $this->render(
            'doctrine/search.html.twig',
            $twigVariables
        );
    }

}
