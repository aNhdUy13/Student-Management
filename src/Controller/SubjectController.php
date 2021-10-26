<?php

namespace App\Controller;

use App\Entity\Subject;
use App\Form\SubjectType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_USER")
 */
class SubjectController extends AbstractController
{   
    #[Route('/subject', name: 'subject_view')]
    public function viewSubject(){
        $subjects = $this->getDoctrine()->getRepository(Subject::class)-> findAll();

        return $this->render('subject/view.html.twig',[
            'subjects' => $subjects,
        ]);
        
    }
/**
 * @IsGranted("ROLE_USER")
 */
    #[Route('/subject/detail/{id}', name: 'subject_detail')]
    public function subjectDetail($id){
        $subject = $this->getDoctrine()->getRepository(Subject::class)-> find($id);

        return $this->render('subject/detail.html.twig',[
            'subject' => $subject,
        ]);
    }
    /**
 * @IsGranted("ROLE_ADMIN")
 */
    #[Route('/subject/delete/{id}', name: 'subject_delete')]
    public function deleteSubject($id){
        $subject = $this->getDoctrine()->getRepository(Subject::class)
        -> find($id);

        if($subject == null){
            $this -> addFlash('Error', 'Cannot find subject of this subject');
        }
        else{
            $manager = $this->getDoctrine()->getManager();

            $manager -> remove($subject);

            $manager->flush();

            $this -> addFlash('Success','Subject of this subject has been deleted');
            
        }
        return $this->redirectToRoute('subject_view');
    }
    /**
 * @IsGranted("ROLE_ADMIN")
 */
    #[Route('subject/add',name :'subject_add')]
    public function addSubject(Request $request){
        $subject = new Subject();
        $form = $this->createForm(SubjectType::class, $subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($subject);
            $manager->flush();

            $this->addFlash('Success', "Subject has been added successfully !");
            return $this->redirectToRoute("subject_view");
        }

        return $this->render (
            "subject/add.html.twig", 
            [
                'form' => $form->createView()
            ]
        );
    }
    /**
 * @IsGranted("ROLE_ADMIN")
 */ 
    #[Route('subject/update/{id}', name :'subject_update')]
    public function updateSubject(Request $request, $id){
        $subject = $this->getDoctrine()->getRepository(Subject::class)->find($id);
        $form = $this->createForm(SubjectType::class, $subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($subject);
            $manager->flush();

            $this->addFlash('Success', "Subject has been updated successfully !");
            return $this->redirectToRoute("subject_view");
        }

        return $this->render (
            "subject/update.html.twig", 
            [
                'form' => $form->createView()
            ]
        );
    }
}
