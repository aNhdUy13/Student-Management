<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\Sclass;
use App\Form\SclassType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,
            [
                'label' => "Name",
                'required' => true
            ])

            ->add('dob',DateType::class,
            [
                'label' => "Date of Birth",
                'widget' => 'single_text'
            ])

            ->add('gender', ChoiceType::class,
            [
                'choices' =>
                [
                    "Male" => "Male",
                    "Female" => "Female",
                    "Other" => "Other"
                ],
                'required' => true
            ])

            ->add('phoneNumber', TextType::class,
            [
                'label' => "Phone Number"
            ])

            ->add('image', FileType::class,
            [
                'label' => "Image",
                'data_class' => null,
                'required' => is_null($builder->getData() -> getImage())

            ])

            ->add('class', EntityType::class,
            [
                'label' => "Class",
                'class' => Sclass::class,
                'choice_label' => "name",

                'expanded' => false,        // true: checkbox, false: dropdown list
                'multiple' => false,        // true: Có thể chọn nhiều, false: Chỉ chọn 1 

            ])

            -> add('course', EntityType::class,
            [
                'label' => "Course",
                'class' => Course::class,
                'choice_label' => "name",

                'multiple' => true,   // true: Có thể chọn nhiều, false: Chỉ chọn 1 
                'expanded' => false,  // true: checkbox, false: dropdown list
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
