<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\Association;
use App\Entity\ResetPassword;
use App\Form\ResetPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ResetPasswordController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    #[Route('/mot-de-passe-oublie', name: 'app_reset_password')]
    public function index(Request $request): Response
    {
        if($this->getUser()){
            return $this->redirectToRoute('app_association_home');
        }
        if($request->get('name')){
            $user = $this->entityManager->getRepository(Association::class)->findOneByName($request->get('name'));

            if($user){
                $to_email = $user->getEmail();
                $to_name = $user->getName();
                $reset_password = new ResetPassword();
                $reset_password->setUser($user);
                $reset_password->setToken(uniqid());
                $reset_password->setCreatedAt(new \DateTimeImmutable());
                $this->entityManager->persist($reset_password);
                $this->entityManager->flush();

                $url = $this->generateUrl('app_update_password', [
                    'token' => $reset_password->getToken()
                ]);
                $mail = new Mail();
                $mail->send($to_email, $to_name, 'Mot de passe oublié!', "Bonjour " .$user->getName()."<br>Réinitialisez le mot de passe de votre association en cliquant sur le lien çi-dessous. <br> <a href='".$url."'>Modifier le mot de passe</a>", "Réinitialiser votre mot de passe");
                $this->addFlash('notice', 'Vous allez recevoir dans quelques secondes un mail pour réinitialiser votre mot de passe.');

            }else{
                $this->addFlash('notice', 'Cet utilisateur est inconnue.');
            }
        }
        return $this->render('reset_password/index.html.twig');
    }

    #[Route('/modifier-mot-de-passe/{token}', name: 'app_update_password')]
    public function update(Request $request,UserPasswordHasherInterface $encoder, $token): Response
    {
        $reset_password = $this->entityManager->getRepository(ResetPassword::class)->findOneByToken($token);

        if(!$reset_password) {
            return $this->redirectToRoute('app_reset_password');
        }

            $now = new \DateTimeImmutable();
            if($now > $reset_password->getCreatedAt()->modify('+3 hour')){

                $this->addFlash('notice', 'Votre demande de mot de passe a expiré. Merci de la renouveller.');
                return $this->redirectToRoute('app_reset_password');
            }
            $form = $this->createForm(ResetPasswordType::class);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $new_pwd = $form->get('new_password')->getData();

                $password = $encoder->hashPassword($reset_password->getUser(), $new_pwd) ;
                $reset_password->getUser()->setPassword($password);
                $this->entityManager->flush();
                $this->addFlash('notice', 'Votre mot de passe à bien été mis à jour.');
                return $this->redirectToRoute('app_login');
            }
        return $this->render('reset_password/update.html.twig',[
            'form' => $form->createView()
        ]);
    }

}
