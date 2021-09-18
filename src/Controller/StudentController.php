<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    #[Route('/studentManagement', name: 'studentManagement')]
    public function studentManagement(): Response
    {
        return $this->render('student/login.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }

    #[Route('/mainBoard', name: 'mainBoard')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }
}
