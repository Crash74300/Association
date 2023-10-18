<?php

namespace App\Controller;

use App\Form\DemandeCommunicationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandeCommunicationController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    #[Route('/association/communication', name: 'app_demande_communication')]
    public function index(Request $request,): Response
    {
        $user = $this->getUser();
       $form = $this->createForm(DemandeCommunicationType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $description = $form->get('description')->getData();
            dd($description);

                $this->addFlash('notice', 'Votre mot de passe à bien été modifié.');
                return $this->redirectToRoute('app_association_home');

        }

        return $this->render('demande_communication/index.html.twig', [
            'form' => $form->createView(),
            'panneau'
        ]);
    }
}
