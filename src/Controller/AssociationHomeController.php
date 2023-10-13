<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AssociationHomeController extends AbstractController
{

    #[Route('/association/home', name: 'app_association_home')]
    public function index(): Response
    {

        return $this->render('association_home/index.html.twig');

    }
}
