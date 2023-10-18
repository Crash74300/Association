<?php

namespace App\Controller;
use App\Entity\Association;
use App\Form\EditAssociationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AssociationHomeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }
    #[Route('/association/home', name: 'app_association_home')]
    public function index(): Response
    {

        return $this->render('association_home/index.html.twig');

    }

    #[Route('/association/edit/{id}', name: 'app_edit_association')]
    public function edit(Request $request, $id): Response
    {

        $association = $this->entityManager->getRepository(Association::class)->findOneById($id);

        $form = $this->createForm(EditAssociationType::class, $association);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->flush();
            $this->addFlash('notice', 'Votre association à bien été mise à jour.');
            return $this->redirectToRoute('app_association_home');

        }

        return $this->render('association_home/association_edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
