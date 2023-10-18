<?php

namespace App\Controller;

use App\Entity\Communication;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminHomeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/admin/home', name: 'app_admin_home')]
    public function index(): Response
    {
        $communication = $this->entityManager->getRepository(Communication::class)->findAll();
        return $this->render('admin_home/index.html.twig',[
            'communications'=>$communication,
        ]);
    }
}
