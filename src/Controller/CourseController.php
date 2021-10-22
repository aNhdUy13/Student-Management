<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\CourseType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;




class CourseController extends AbstractController
{
    #[Route('/course', name: 'course_index')]
    public function courseIndex(){
        $courses = $this->getDoctrine()->getRepository(Course::class)->findAll();
        return $this->render(
            'course/index.html.twig',
            [
                'courses' => $courses
            ]
        );
    }

    #[Route('/course/detail/{id}',name : 'course_detail')]
    public function courseDetail($id){
        $course = $this->getDoctrine()->getRepository(Course::class)->find($id);
        if ($course == null){
            $this->addFlash('Error','Course not exist !');  
            return $this->redirectToRoute('course_index');
        }
        else{
            return $this->render(
                'course/detail.html.twig',
                [
                    'course' => $course
                ]
            );
        }
    }

    #[Route('/course/delete/{id}', name : 'course_delete')]
    public function courseDelete($id){

    } 

    #[Route('/course/add', name : 'course_add')]
    public function courseAdd(Request $request){

    }

    #[Route('course/update/{id}', name : 'course_update')]
    public function courseUpdate(Request $request, $id){
        
    }


}
