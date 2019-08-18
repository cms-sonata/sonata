<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationType;
use App\Security\Role;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class SecurityController extends AbstractController
{
    use TargetPathTrait;

    /**
     * @Route("/login", name="security_login")
     * @param Request             $request
     * @param Security            $security
     * @param AuthenticationUtils $helper
     *
     * @return Response
     */
    public function login(Request $request, Security $security, AuthenticationUtils $helper): Response
    {
        if ($security->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('index');
        }

        $this->saveTargetPath($request->getSession(), 'main', $this->generateUrl('index'));

        return $this->render('security/login.html.twig', [
            'last_username' => $helper->getLastUsername(),
            'error' => $helper->getLastAuthenticationError(),
        ]);
    }

    /**
     * @Route("/registration", name="security_registration")
     * @param Request                      $request
     * @param EntityManagerInterface       $em
     * @param UserPasswordEncoderInterface $encoder
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function registration(Request $request, Security $security, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        if ($security->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('index');
        }

        $form = $this->createForm(RegistrationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $users = new Users();
            $users->setLogin($form->get('login')->getData());
            $users->setPassword($encoder->encodePassword($users, $form->get('password')->getData()));
            $users->setEmail($form->get('email')->getData());
            $users->setFName($form->get('f_name')->getData());
            $users->setLName($form->get('l_name')->getData());
            $em->persist($users);
            $em->flush();
            return $this->redirectToRoute('index');
        }
        return $this->render('security/registration.html.twig', [
            'controller_name' => 'IndexController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout(): void
    {
        throw new \Exception('This should never be reached!');
    }
}
