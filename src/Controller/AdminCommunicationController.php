<?php

namespace App\Controller;

use App\Entity\Communication;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCommunicationController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/communication', name: 'app_admin_communication')]
    public function index(): Response
    {
        $communication = $this->entityManager->getRepository(Communication::class)->findAll();

        return $this->render('admin_home/admin_communication.html.twig', [
            'communications' => $communication,
        ]);

    }

    #[Route('/admin/remove/communication/{id}', name: 'app_remove_communication')]
    public function remove($id): Response
    {
        $communication = $this->entityManager->getRepository(Communication::class)->findOneById($id);
        $this->entityManager->remove($communication);
        $this->entityManager->flush();

    return $this->redirectToRoute('app_admin_communication');

}
}
