<?php

namespace App\Controller;

use App\Entity\Grade;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GradeController extends AbstractController
{
    #[Route('/grade', name: 'grade_view')]
    public function viewGrade(){
        $grade = $this->getDoctrine()->getRespority(Grade::class);

        return $this->render('grade/view.html.twig',[
            'grade' => $grade,
        ]);
    }

    #[Route('/grade/detail/{id}', name: 'grade_detail')]
    public function gradeDetail($id){
        $grade = $this->getDoctrine()->getRespority(Grade::class)-> findAll($id);

        return $this->render('grade/detail.html.twig',[
            'grade' => $grade,
        ]);
    }

}
