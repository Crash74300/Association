<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\Association;
use App\Entity\Membres;
use App\Form\AddAssociationType;
use App\Form\AddMembresType;
use App\Form\EditAssociationType;
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


    #[Route('/admin/add/association', name: 'app_add_association')]
    public function index(Request $request, UserPasswordHasherInterface $encoder): Response
    {
        $notification = null;

        $user = new Association();
        $form = $this->createForm(AddAssociationType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            $to_name = $form->getData()->getName();
            $pass = $form->getData()->getPassword();
            $to_email = $form->getData()->getEmail();

            $search_name = $this->entityManager->getRepository(Association::class)->findOneByName($to_name);

            if(!$search_name) {
                $password = $encoder->hashPassword($user,$user->getPassword()) ;
                $user->setPassword($password);

                $this->entityManager->persist($user);
                $this->entityManager->flush();
                $mail = new Mail();
                $mail->send($to_email, $to_name, 'Votre espace association à été créé!', "Vous pouvez vous connecter et découvrir votre espace personnel pour gérer votre association. Une fois connecté, nous vous conseillons de modifier votre mot de passe pour garantir la sécurité de l'application.<br />Votre nom d'utilisateur: {$to_name} <br/>Votre mot de passe:  {$pass}", "Votre espace association à été créé!");
                $this->addFlash('notice', "L'association à bien été créé.");
                return $this->redirectToRoute('app_admin_association');
            }else{
                $this->addFlash('notice', "Ce nom existe déjà.");
            }


        }

        return $this->render('add_association/index.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }

    #[Route('/admin/edit/association/{id}', name: 'app_admin_edit_association')]
    public function edit(Request $request, $id): Response
    {

        $association = $this->entityManager->getRepository(Association::class)->findOneById($id);

        $form = $this->createForm(EditAssociationType::class, $association);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->flush();
            return $this->redirectToRoute('app_admin_association');

        }

        return $this->render('add_association/edit.html.twig', [
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
    #[Route('/admin/supprimer/association/{id}', name: 'app_remove_association')]
    public function remove($id): Response
    {

        $association = $this->entityManager->getRepository(Association::class)->findOneById($id);

            $this->entityManager->remove($association);
            $this->entityManager->flush();

        return $this->redirectToRoute('app_admin_association');

    }


}
