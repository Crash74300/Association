<?php

namespace App\Controller;

use App\Entity\Association;
use App\Entity\Communication;
use App\Form\CommunicationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Sodium\add;
use function Symfony\Component\Clock\now;

class DemandeCommunicationController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    #[Route('/association/communication}', name: 'app_demande_communication')]
    public function index(Request $request): Response
    {
        $communication = new Communication();

       $form = $this->createForm(CommunicationType::class, $communication);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
                $communication = $form->getData();
                $communication->setName($this->getUser()->getName());
                $communication->setPhone($this->getUser()->getPhone());
                $communication->setEmail($this->getUser()->getEmail());
                $communication->setCreatedAt(now());

                $this->entityManager->persist($communication);
                $this->entityManager->flush();
                $this->addFlash('notice', 'Votre demande à bien été envoyé.');
                return $this->redirectToRoute('app_association_home');

        }

        return $this->render('demande_communication/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
