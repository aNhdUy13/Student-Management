<?php

namespace App\DataFixtures;

use App\Entity\Course;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CourseFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++){
            $course = new Course();
            $course->setName("Course $i");
            $course->setDuration(rand(2,5));
            $course -> setCovercourse("22222.jpg");
            $course -> setStarttime(\DateTime::createFromFormat('Y-m-d','2021-12-13'));
            $course -> setEndtime(\DateTime::createFromFormat('Y-m-d','2021-12-13'));

            $manager -> persist($course);
        }

        $manager->flush();
    }
}
