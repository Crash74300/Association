<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubventionController extends AbstractController
{
    #[Route('/association/subvention', name: 'app_subvention')]
    public function index(): Response
    {
        return $this->render('subvention/index.html.twig');
    }
}
