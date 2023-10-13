<?php

namespace App\Controller;

use App\Entity\Membres;
use App\Form\AddMembresType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


class AddMembresController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    #[Route('/membres', name: 'app_membres')]
    public function index(): Response
    {
        return $this->render('add_membres/index.html.twig');
    }

    #[Route('/add/membres', name: 'app_add_membres')]
    public function add(Request $request): Response
    {

        $membre = new Membres();
        $roleAsso = "";
        $form = $this->createForm(AddMembresType::class, $membre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $dataForm = $form->getData()->getRole();
            $association = $this->getUser()->getId();

            $dataAsso = $this->entityManager->getRepository(Membres::class)->findOneBy(array('role' => $dataForm, 'user' => $association));

            if ($dataAsso != null) {
                $roleAsso = $dataAsso->getRole();
            }

        if ($roleAsso == null || $roleAsso == 'Membre') {

            $membre->setUser($this->getUser());
            $this->entityManager->persist($membre);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_membres');

        } else {
            $erreur = $form->getData()->getRole();
            $this->addFlash('warning', "Le rôle de {$erreur} est déjà occupé!");
        }

    }
        return $this->render('add_membres/add_membres.html.twig',[
            'form' => $form->createView()
        ]);
    }
    #[Route('/modifier/membres/{id}', name: 'app_edit_membres')]
    public function edit(Request $request, $id): Response
    {

        $membre = $this->entityManager->getRepository(Membres::class)->findOneById($id);

        if(!$membre || $membre->getUser() !== $this->getUser()){
        return $this->redirectToRoute('app_membres');
    }
        $form = $this->createForm(AddMembresType::class, $membre);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->flush();
            return $this->redirectToRoute('app_membres');

        }
        return $this->render('add_membres/add_membres.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('/supprimer/membres/{id}', name: 'app_remove_membres')]
    public function remove($id): Response
    {

        $membre = $this->entityManager->getRepository(Membres::class)->findOneById($id);

        if($membre || $membre->getUser() == $this->getUser()){
            $this->entityManager->remove($membre);
            $this->entityManager->flush();
        }
        return $this->redirectToRoute('app_membres');

    }
}
