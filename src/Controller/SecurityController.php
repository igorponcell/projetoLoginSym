<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $utils) {
        $errors = $utils->getLastAuthenticationError();
        $lastUsername = $utils->getLastUsername();

            return $this->render('security/index.html.twig', [
                "error" => $errors,
                "last_username" => $lastUsername
            ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(){
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');

    }
}
