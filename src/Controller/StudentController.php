<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    #[Route('/loginStudentManagement', name: 'loginStudentManagement')]
    public function login(): Response
    {
        return $this->render('student/login.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }
    #[Route('/logoutStudentManagement', name: 'logoutStudentManagement')]
    public function logout(): Response
    {
        return $this->render('student/logout.html.twig', [
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


    /* Regarding to Lecturer */
    #[Route('/studentManagement', name: 'studentManagement')]
    public function studentManagement(): Response
    {
        return $this->render('student/studentManagement.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }

    #[Route('/addStudent', name: 'addStudent')]
    public function addStudent(): Response
    {
        return $this->render('student/addStudent.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }
}
