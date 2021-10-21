<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;

use Symfony\Component\HttpFoundation\Request;
use function PHPUnit\Framework\throwException;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

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
             //code xử lý ảnh upload
            //B1: lấy ảnh từ file upload
            $image = $student->getImage();
            //B2: tạo tên mới cho ảnh => tên file ảnh là duy nhất
            $imgName = uniqid(); //unique ID
            //B3: lấy ra phần đuôi (extension) của ảnh
            $imgExtension = $image -> guessExtension();
            //B4: gộp tên mới + đuôi tạo thành tên file ảnh hoàn thiện
            $imageName = $imgName . "." . $imgExtension;
            //B5: di chuyển file ảnh upload vào thư mục chỉ định
            try {
                $image->move(
                    $this->getParameter('student_image'),
                    $imageName
                    //Lưu ý: cần khai báo tham số đường dẫn của thư mục
                    //cho "book_cover" ở file config/services.yaml
                );
            } catch (FileException $e) {
                throwException($e);
            }
            //B6: lưu tên vào database
            $student->setImage($imageName);


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
    public function updateStudentAction($id, Request $request){
        $student = $this
             -> getDoctrine() 
            -> getRepository(Student::class)
            -> find($id);

        if($student == null){
            $this -> addFlash('Error', 'Student Not Found !');
            return $this -> redirectToRoute('student_index');
        }

        else{
            $form = $this -> createForm(StudentType::class, $student);
            $form -> handleRequest($request);

            if ($form -> isSubmitted() && $form -> isValid()) 
            {
                // lấy dữ liệu ảnh từ form 
                $file = $form['image'] -> getData();

                if($file != null) {
                    $image = $student -> getImage();

                    //  tạo tên mới cho ảnh => tên file ảnh là duy nhất
                    $imgName = uniqid();

                    // lấy ra phần đuôi (extension) của ảnh
                    $imgExtension = $image->guessExtension();

                    $imageName = $imgName . "." . $imgExtension;

                    try {
                        $image->move(
                            $this->getParameter('student_image'),
                            $imageName
                            //Lưu ý: cần khai báo tham số đường dẫn của thư mục
                            //cho "book_cover" ở file config/services.yaml
                        );
                    } catch (FileException $e) {
                        throwException($e);
                    }
                    // lưu tên vào database
                    $student->setImage($imageName);
                }

                $manager = $this -> getDoctrine()->getManager();
                $manager->persist($student);
                $manager->flush();

                $this->addFlash('Success', "Edit book successfully !");
                return $this->redirectToRoute("student_index");
            }

            return $this -> render('student/update.html.twig',
            [
                'form' => $form->createView()
            ]);
        }
    }
}
