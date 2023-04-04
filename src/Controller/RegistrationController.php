<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="user_registration")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // handle the submit
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // Encode the password
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // save the user
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('dashboard');
        }

        return $this->render(
            'pages/register.html.twig',
            array('form' => $form->createView())
        );
    }

    public function buildForm($user) {
        return $this->createFormBuilder($user)
            ->add('username', TextType::class)
            ->add('oldPassword', PasswordType::class)
            ->add('newPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ))
            ->add('submit', SubmitType::class)
            ->getForm();
    }

    /**
     * @Route("/recover/{id}", name="password_recover")
     */
    public function changePasswdAction($id, Request $request, UserPasswordEncoderInterface $passwordEncoder, AuthenticationUtils $utils) {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $userInfo = ['plainPassword' => null];

        $form = $this->createForm(ChangePasswordType::class, $userInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userInfo = $form->getData();
            $newPassword = $form->get('newPassword')->getData();
            $password = $passwordEncoder->encodePassword($user, $newPassword);
            $user->setPassword($password);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            if ($user == $this->getUser()){
                return $this->redirectToRoute('login');
            } else {
                return $this->redirectToRoute('dashboard');
            }
        }

        return $this->render('security/recover.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }
}
