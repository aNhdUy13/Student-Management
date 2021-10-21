<?php

namespace App\Controller;

use App\Entity\Sclass;
use App\Form\SclassType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SclassController extends AbstractController
{
    #[Route('/sclass', name: 'sclass_index')]
    public function index(): Response
    {
        $sclass =$this -> getDoctrine() -> getRepository(Sclass::class) -> findAll();
        
        return $this->render('sclass/index.html.twig',
        [
            'classes' => $sclass,
        ]);
    }

    #[Route('/sclass/delete/{id}', name : "sclass_delete")]
    public function deleteAction($id){
        $Sclass = $this -> getDoctrine() 
        -> getRepository(Sclass::class) 
        -> find($id);

        if($Sclass == null){
            $this -> addFlash('Error','Cannot Found Class !');
        }else {
            $manager = $this->getDoctrine()->getManager();

            $manager->remove($Sclass);

            $manager->flush();

            $this -> addFlash('Success','Class Deleted successfully !');
        }

        return $this -> redirectToRoute('sclass_index');
    }


    #[Route('/sclass/add', name : "sclass_add")]
    public function addClassAction(Request $request)
    {
        $Sclass = new SClass();
        $form = $this->createForm(SclassType::class, $Sclass);
        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid()) {
            $manager = $this-> getDoctrine() -> getManager();

            $manager->persist($Sclass);
            $manager->flush();

            $this -> addFlash('Success', "Class Added Success!");

            return $this -> redirectToRoute('sclass_index');
        }


        return $this -> render('Sclass/add.html.twig', [
            'form' => $form->createView()
        ]);

    }


    #[Route('/sclass/update/{id}', name : "sclass_update")]
    public function updateClassAction($id, Request $request)
    {
        $Sclass = $this -> getDoctrine() -> getRepository(Sclass::class)
            -> find($id);

        $form = $this -> createForm(SclassType::class, $Sclass);
        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid()){
            $manager = $this-> getDoctrine() -> getManager();

            $manager->persist($Sclass);

            $manager->flush();

            $this -> addFlash('Success', "Class Updated Successfully !");

            return $this -> redirectToRoute('sclass_index');
        }

        return $this -> render('Sclass/update.html.twig', [
            'form' => $form -> createView()
        ]);
    }
}