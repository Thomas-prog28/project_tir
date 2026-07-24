<?php

namespace App\Controller;

use App\Entity\Member;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager,
        UserAuthenticatorInterface $userAuthenticator,
        LoginFormAuthenticator $loginFormAuthenticator
    ): Response {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // encode the plain password
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            //Photo de profil (optionnelle)
            /** @var ?\Symfony\component\HttpFoundation\file\UploadedFile $pictureFile */
            $pictureFile = $form->get('pictureFile')->getData();
            if ($pictureFile) {
                $user->setPictureFile($pictureFile);
            }

            //If number licence checked, automatically create member link
            $licenceNumber = $form->get('licenceNumber')->getData();
            $isMember = !empty($licenceNumber);

            if ($isMember) {
                $member = new Member();
                $member->setLicenceNumber($licenceNumber);
                $member->setUser($user);

                $entityManager->persist($member);
            }

            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            //connecte automatiquement l'utilisateur après inscription
            $userAuthenticator->authenticateUser($user, $loginFormAuthenticator, $request);

            //redirection conditionnelle selon le statit membre
            if ($isMember) {
                return $this->redirectToRoute('member_dashboard');
            }

            return $this->redirectToRoute('app_home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
