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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class AuthController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/register', name: 'app_register')]
    public function register(): Response
    {
        return $this->render('auth/register.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }

    #[Route('/reset/{token}', name: 'app_reset')]
    public function reset(Request $request,
                          string $token,
                          UserPasswordHasherInterface $passwordHasher): Response
    {
// 1. Chercher l'utilisateur avec le token
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['resetToken' => $token]);

        // 2. Si l'utilisateur n'est pas trouvé, renvoyer une erreur
        if (!$user) {
            $this->addFlash('error', 'Jeton de réinitialisation invalide ou expiré.');
            return $this->redirectToRoute('app_login');
        }

        // 3. Traiter le formulaire POST
        if ($request->isMethod('POST')) {
            $password = $request->request->get('password');
            $confirmPassword = $request->request->get('confirm_password');

            // Vérifier si les mots de passe sont identiques
            if ($password !== $confirmPassword) {
                $this->addFlash('error', 'Les mots de passe ne correspondent pas.');
                return $this->render('reset.html.twig', [
                    'token' => $token
                ]);
            }

            // 4. Hasher le mot de passe et le sauvegarder
            $hashedPassword = $passwordHasher->hashPassword($user, $password);
            $user->setPassword($hashedPassword);

            // Optionnel : Effacer le token après utilisation
            $user->setResetToken(null);

            $this->entityManager->flush();

            // 5. Ajouter un message de succès et rediriger
            $this->addFlash('success', 'Votre mot de passe a été réinitialisé avec succès. Connectez-vous !');
            return $this->redirectToRoute('app_login');
        }

        // 6. Afficher le formulaire de réinitialisation
        return $this->render('auth/reset.html.twig', [
            'token' => $token
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

    #[Route('/confirm', name: 'app_confirm')]
    public function confirm(): Response
    {
        return $this->render('auth/confirm.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }
}
