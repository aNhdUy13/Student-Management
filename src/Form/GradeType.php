<?php

namespace App\Form;

use App\Entity\Grade;
use App\Entity\Student;
use App\Entity\Subject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class GradeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('grade',IntegerType::class,[
                'label' => 'Grade',
                'required' => true
            ])
            ->add('subject',EntityType::class,[
                'label' => 'Subject Name',
                'class' => Subject::class,
                'choice_label' => "name",

                'multiple' => false,
                'expanded' => false
            ])
            ->add('student',EntityType::class,[
                'label' => 'Student Name',
                'class' => Student::class,
                'choice_label' => "name",

                'multiple' => false, // true: Có thể chọn nhiều, false: Chỉ chọn 1 
                'expanded' => false // true: checkbox, false: dropdown list
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Grade::class,
        ]);
    }
}
