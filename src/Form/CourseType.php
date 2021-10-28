<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, 
            [
                'label' => "Course Name",
                'required' => true,
            ])
            ->add('duration', IntegerType::class,
            [
                'label' => "Course Duration",
                'required' => true,
            ])
            ->add('covercourse', FileType::class,
            [
                'label' => "CoverCourse",
                'data_class' => null,
                'required' => is_null($builder->getData()->getCovercourse())

            ])
            ->add('starttime',DateType::class,
            [
                'label' => "Start Time",
                'widget' => 'single_text'
            ])
            ->add('endtime',DateType::class,
            [
                'label' => "End Time",
                'widget' => 'single_text'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
