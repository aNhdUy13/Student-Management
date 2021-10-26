<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Student; 
use App\Form\CourseType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



/**
 * @IsGranted('ROLE_USER')
 */
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


    /**
    * @IsGranted('ROLE_USER')
    */
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
    
    /**
    * @IsGranted('ROLE_ADMIN')
    */
    #[Route('/course/delete/{id}', name : 'course_delete')]
    public function courseDelete($id){
        $course = $this->getDoctrine()->getRepository(Course::class)->find($id);
        if ($course == null){
            $this->addFlash('Error','Course not exist !');  
        }
        else{
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($course);
            $manager->flush();
            $this->addFlash('Success','Course has been deleted !');
        }
        return $this->redirectToRoute('course_index');
    } 
    
    /**
    * @IsGranted('ROLE_ADMIN')
    */
    #[Route('/course/add', name : 'course_add')]
    public function courseAdd(Request $request){
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);
        $form -> handleRequest($request);

        if ($form -> isSubmitted() && $form -> isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($course);
            $manager->flush();

            $this -> addFlash('Success',"Course has been added successfully !");
            return $this->redirectToRoute("course_index");
        }

        return $this->render(
            "course/add.html.twig",
            [
                'form' => $form->createView()
            ]
        );

    }

    /**
    * @IsGranted('ROLE_ADMIN')
    */
    #[Route('course/update/{id}', name : 'course_update')]
    public function courseUpdate(Request $request, $id){
        $course = $this->getDoctrine()->getRepository(Course::class)->find($id);
        $form = $this->createForm(CourseType::class, $course);
        $form -> handleRequest($request);

        if ($form -> isSubmitted() && $form -> isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($course);
            $manager->flush();

            $this -> addFlash('Success',"Course has been updated successfully !");
            return $this->redirectToRoute("course_index");
        }

        return $this->render(
            "course/update.html.twig",
            [
                'form' => $form->createView()
            ]
            );
    }


}
