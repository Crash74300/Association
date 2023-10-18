<?php

namespace App\Controller;

use App\Entity\Association;
use App\Form\PasswordAssociationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AssociationPasswordController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    #[Route('/association/password/{id}', name: 'app_association_password')]
    public function index(Request $request, UserPasswordHasherInterface $encoder, $id): Response
    {
        $association = $this->entityManager->getRepository(Association::class)->findOneById($id);



        $form = $this->createForm(PasswordAssociationType::class, $association);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {
            $old_pwd = $form->get('old_password')->getData();
        if($encoder->isPasswordValid($association, $old_pwd)) {
            $new_pwd = $form->get('new_password')->getData();
            $password = $encoder->hashPassword($association, $new_pwd);
            $association->setPassword($password);

            $this->entityManager->flush();
            $this->addFlash('notice', 'Votre mot de passe à bien été modifié.');
            return $this->redirectToRoute('app_association_home');
        }
}


        return $this->render('association_home/association_password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
