<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandeAutorisationController extends AbstractController
{
    #[Route('/association/demande/autorisation', name: 'app_demande_autorisation')]

    public function index(): Response
    {
        return $this->render('demande_autorisation/index.html.twig');
    }

    #[Route('/association/debit/boissons', name: 'app_boissons')]

    public function boissons(): Response
    {
        return $this->render('demande_autorisation/boissons.html.twig');
    }
}
