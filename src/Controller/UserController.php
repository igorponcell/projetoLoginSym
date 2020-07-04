<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("/user", name="user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->redirect("/user/user-list");
        return $this->showUsers();
    }

    /**
     * @Route("/user-list", name="user-list")
     */
    public function showUsers() {
        $users = $this->getDoctrine()->getRepository('App:User')->findAll();

        return $this->render('user/user-list.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function addUser(Request $request)
    {
        $form = $this->createForm(UserType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();

            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($user);
            $doctrine->flush();

            return $this->redirect('/user/user-list/');

        }

        return $this->render("user/signup.html.twig", [
            "form" => $form->createView(),
        ]);
    }



    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit($id, Request $request)
    {
        $user = $this->getDoctrine()->getRepository('App:User')->find($id);

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($user);
            $doctrine->flush();

            return $this->redirect('/user/user-list/');
        }

        return $this->render("user/edit.html.twig", [
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/remove/{id}", name="remove")
     */
    public function remove(Request $request, $id) {
        $user = $this->getDoctrine()->getRepository('App:User')->findOneBy(['id' => $id]);
        $this->getDoctrine()->getManager()->remove($user);
        $this->getDoctrine()->getManager()->flush();

        $users = $this->getDoctrine()->getRepository('App:User')->findAll();
        if(count($users) !== 0){

            return $this->redirect("/user/user-list");
            return $this->showUsers();
        } else {
            return $this->redirect("/");
        }
    }

}
