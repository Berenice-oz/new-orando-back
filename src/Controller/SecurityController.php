<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use App\Security\LoginFormAuthenticator;
use App\Entity\User;

class SecurityController extends AbstractController
{
   
    
    /**
     * @param AutenticationUtils $authenticationUtils
     * @return Response
     * 
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /** 
     * @Route("/redirectafterlogout", name="redirectafterlogout")
     */
    //public function redirectafterlogout()
    //{
        //return $this->redirect('http://localhost:8080/');
    //}
    


    /**
     * 
     * @param LoginFormAuthenticator $authenticator
     * @param GuardAuthenticatorHandler $guardHandler
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param UserPasswordEncoderInterface $userEncoder
     * 
     * @Route("/api/login/check", name="login_check", methods={"POST"})
     *
     */
    public function loginCheck(LoginFormAuthenticator $authenticator, GuardAuthenticatorHandler $guardHandler, Request $request, SerializerInterface $serializer, UserPasswordEncoderInterface $userEncoder)
    {
        
        // récupèrer le contenu du json
        $jsonContent = $request->getContent();
        // le  transformer en entité User
        $user = $serializer->deserialize($jsonContent, User::class, 'json');

        $userId = $user->getId();

        $password = $user->getPassword();
        $hashPassword = $userEncoder->encodePassword($user, $password);
        
        
        
        return $guardHandler->authenticateUserAndHandleSuccess(
            $user,          // the User object you just created
            $request,
            $authenticator, // authenticator whose onAuthenticationSuccess you want to use
            'main'          // the name of your firewall in security.yaml
        );
       
        
    }

 

   

}
