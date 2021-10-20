<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'student_index')]
    public function index()
    {
        $students = $this -> getDoctrine()->getRepository(Student::class)->findAll();

        return $this->render('student/index.html.twig', [
            'students' => $students
        ]);
    }

    #[Route('/student/detail/{id}', name: 'student_detail')]
    public function detail($id){
        $student = $this -> getDoctrine()
            ->getRepository(Student::class)
            -> find($id);

            return $this->render('student/detail.html.twig', [
                'student' => $student
            ]);
    }

    #[Route('/student/delete/{id}', name: 'student_delete')]
    public function deleteStudentAction($id){
        $student = $this -> getDoctrine()
            ->getRepository(Student::class)
            -> find($id);

        if($student == null){
            $this -> addFlash('Error', 'Student can not be found !');
        }else{
            $manager = $this->getDoctrine()->getManager();

            $manager -> remove($student);

            $manager->flush();

            $this -> addFlash('Success', 'Student deleted successfully !');
        }

        return $this->redirectToRoute('student_index');
    }


    #[Route('/student/add', name: 'student_add')]
    public function addStudentAction(Request $request){
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $manager->persist($student);

            $manager->flush();

            $this -> addFlash('Success', "Student Added Success!");

            return $this -> redirectToRoute('student_index');
        }

        return $this -> render('student/add.html.twig',
        [
            'form' => $form->createView(),
        ]);

    }

    #[Route('student/update/{id}', name: 'student_update')]
    public function updateStudentAction(Request $request){

    }
}
