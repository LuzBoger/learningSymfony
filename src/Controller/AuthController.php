<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Attribute\Route;

class AuthController extends AbstractController
{

    #[Route('/register', name: 'app_register')]
    public function register(): Response
    {
        return $this->render('auth/register.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }

    #[Route('/reset', name: 'app_reset')]
    public function reset(): Response
    {
        return $this->render('auth/reset.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/forgot', name: 'app_forgot')]
    public function forgotPassword(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->get('email');

            if (!$email) {
                $this->addFlash('error', 'Veuillez fournir une adresse email.');
                return $this->redirectToRoute('app_forgot');
            }

            // Recherche de l'utilisateur par email
            $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

            if (!$user) {
                // Utilisateur non trouvé
                $this->addFlash('error', 'Aucun utilisateur trouvé pour cet email.');
                return $this->redirectToRoute('app_forgot');
            }

            // Génération d'un token de réinitialisation
            $resetToken = Uuid::uuid4()->toString();
            $user->setResetToken($resetToken);

            // Sauvegarde du token
            $entityManager->flush();

            // Envoi de l'email
            $emailMessage = (new TemplatedEmail())
                ->from('no-reply@example.com')
                ->to($user->getEmail())
                ->subject('Réinitialisation de votre mot de passe')
                ->htmlTemplate('email/reset.html.twig')
                ->context([
                    'resetToken' => $resetToken,
                    'userEmail' => $user->getEmail(),
                ]);
            $mailer->send($emailMessage);
            $this->addFlash('success', 'Un email de réinitialisation a été envoyé à votre adresse email.');
            return $this->render('auth/forgot.html.twig');
        }

        return $this->render('auth/forgot.html.twig');
    }

    #[Route('/confirm', name: 'app_reset')]
    public function confirm(): Response
    {
        return $this->render('auth/confirm.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }
}
