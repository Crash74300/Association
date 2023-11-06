<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AddAdminType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;



class AddAdminController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/add/admin', name: 'app_add_admin')]
    public function index(Request $request, UserPasswordHasherInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(AddAdminType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            $role = ['ROLE_ADMIN'] ;

            $password = $encoder->hashPassword($user,$user->getPassword()) ;
            $user->setPassword($password);
            $user->setRoles($role);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $this->addFlash('notice', "L'administrateur à bien été créé.");
            return $this->redirectToRoute('app_admin_home');
        }

        return $this->render('add_admin/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
