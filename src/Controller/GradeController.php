<?php

namespace App\Controller;

use App\Entity\Grade;
use App\Form\GradeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GradeController extends AbstractController
{
    #[Route('/grade', name: 'grade_view')]
    public function viewGrade(){
        $grades = $this->getDoctrine()->getRepository(Grade::class)-> findAll();

        return $this->render('grade/view.html.twig',[
            'grades' => $grades,
        ]);
        
    }

    #[Route('/grade/detail/{id}', name: 'grade_detail')]
    public function gradeDetail($id){
        $grade = $this->getDoctrine()->getRepository(Grade::class)-> find($id);

        return $this->render('grade/detail.html.twig',[
            'grade' => $grade,
        ]);
    }

    #[Route('/grade/delete/{id}', name: 'grade_delete')]
    public function deleteGrade($id){
        $grade = $this->getDoctrine()->getRepository(Grade::class)
        -> find($id);

        if($grade == null){
            $this -> addFlash('Error', 'Cannot find grade of this subject');
        }
        else{
            $manager = $this->getDoctrine()->getManager();

            $manager -> remove($grade);

            $manager->flush();

            $this -> addFlash('Success','Grade of this subject has been deleted');
            
        }
        return $this->redirectToRoute('grade_view');
    }

    #[Route('grade/add',name :'grade_add')]
    public function addGrade(Request $request){
        $grade = new Grade();
        $form = $this->createForm(GradeType::class, $grade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($grade);
            $manager->flush();

            $this->addFlash('Success', "Grade has been added successfully !");
            return $this->redirectToRoute("grade_view");
        }

        return $this->render (
            "grade/add.html.twig", 
            [
                'form' => $form->createView()
            ]
        );
    }

    #[Route('grade/update/{id}', name :'grade_update')]
    public function updateGrade(Request $request, $id){
        $grade = $this->getDoctrine()->getRepository(Grade::class)->find($id);
        $form = $this->createForm(GradeType::class, $grade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($grade);
            $manager->flush();

            $this->addFlash('Success', "Grade has been updated successfully !");
            return $this->redirectToRoute("grade");
        }

        return $this->render (
            "grade/edit.html.twig", 
            [
                'form' => $form->createView()
            ]
        );
    }
}
