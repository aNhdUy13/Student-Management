<?php

namespace App\Controller;

use App\Entity\Sclass;
use App\Form\SclassType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * @IsGranted("ROLE_USER")
 */
class SclassController extends AbstractController
{
    #[Route('/sclass', name: 'sclass_index')]
    public function index(): Response
    {
        $sclasses =$this -> getDoctrine() -> getRepository(Sclass::class) -> findAll();
        
        return $this->render('sclass/index.html.twig',
        [
            'classes' => $sclasses,
        ]);
    }
/**
 * @IsGranted("ROLE_USER")
 */
    #[Route('/sclass/detail/{id}', name : "sclass_detail")]
    public function classDetailAction($id){
        $sclass = $this -> getDoctrine() -> getRepository(Sclass::class) -> find($id);

        return $this -> render('sclass/detail.html.twig', 
        [
            'class' => $sclass,
        ]);
    }
    /**
 * @IsGranted("ROLE_ADMIN")
 */
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

    /**
 * @IsGranted("ROLE_ADMIN")
 */
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

    /**
 * @IsGranted("ROLE_ADMIN")
 */
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
