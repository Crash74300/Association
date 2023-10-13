<?php

namespace App\Controller;

use App\Entity\Association;
use App\Entity\Membres;
use App\Form\AddAssociationType;
use App\Repository\AssociationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AddAssociationController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }


    #[Route('/add/association', name: 'app_add_association')]
    public function index(Request $request, UserPasswordHasherInterface $encoder): Response
    {
        $user = new Association();
        $form = $this->createForm(AddAssociationType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();


            $password = $encoder->hashPassword($user,$user->getPassword()) ;
            $user->setPassword($password);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin_association');
        }

        return $this->render('add_association/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/association', name: 'app_admin_association')]
    public function show(): Response
    {
        $association = $this->entityManager->getRepository(Association::class);
        $all = $association->findAll();
        $membre = $this->entityManager->getRepository(Membres::class);
        $membres = $membre->findAll();


        return $this->render('add_association/admin_association.html.twig',[
            'associations' => $all,
            'membres' => $membres
        ]);
    }

    #[Route('/admin/detail/association{id}', name: 'app_admin_detail_association')]
    public function detail($id): Response
    {

        $association = $this->entityManager->getRepository(Association::class)->findOneById($id);

        $membre = $this->entityManager->getRepository(Membres::class);
        $membres = $membre->findAll();


        return $this->render('add_association/admin_detail_association.html.twig',[
            'association' => $association,
            'membres' => $membres
        ]);
    }
    #[Route('/supprimer/association/{id}', name: 'app_remove_association')]
    public function remove($id): Response
    {

        $association = $this->entityManager->getRepository(Association::class)->findOneById($id);

            $this->entityManager->remove($association);
            $this->entityManager->flush();

        return $this->redirectToRoute('app_admin_association');

    }


}
