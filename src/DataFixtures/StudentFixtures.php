<?php

namespace App\DataFixtures;

use App\Entity\Student;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class StudentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i <= 5; $i++) { 
            $student = new Student();
            $student -> setName("Student $i");
            $student -> setDob(\DateTime::createFromFormat('Y-m-d','2021-12-13'));
            $student -> setGender("Male");
            $student -> setPhoneNumber("123456");
            $student -> setImage("student.png");

            $manager -> persist($student);
        }

        $manager->flush();
    }
}
