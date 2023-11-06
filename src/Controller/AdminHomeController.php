<?php

namespace App\Controller;

use App\Entity\Association;
use App\Entity\Communication;
use App\Entity\User;
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
        $finish = $this->entityManager->getRepository(Communication::class)->findBy(array('finish' => '1'));
        $admin = $this->getUser()->isSuperAdmin();

        return $this->render('admin_home/index.html.twig',[
            'communications'=>$communication,
            'finish' => $finish,
            'admin' => $admin,
        ]);
    }
    #[Route('/admin/gestion/admin', name: 'app_admin_edit')]
    public function edit(): Response
    {
        $admin = $this->entityManager->getRepository(User::class)->findAll();

        if($this->getUser()->isSuperAdmin()){
            return $this->render('admin_home/edit.html.twig',[
                'admin'=> $admin
            ]);
        }else{
            return $this->render('admin_home/index.html.twig');
        }

    }
    #[Route('/admin/remove/admin/{id}', name: 'app_admin_remove')]
    public function remove($id): Response
    {
        $admin = $this->entityManager->getRepository(User::class)->findOneById($id);

        if($this->getUser()->isSuperAdmin()){
            $this->entityManager->remove($admin);
            $this->entityManager->flush();
            $this->addFlash('notice', "L'administrateur a bien été supprimé.");
            return $this->redirectToRoute('app_admin_edit');
        }else{
            return $this->render('admin_home/edit.html.twig');
        }

    }
}
