<?php

namespace App\DataFixtures;

use App\Entity\Grade;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class GradeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i = 0; $i < 10; $i++ ){
            $grade = new Grade();
            $grade-> setGrade(rand(1, 10));
            
            $manager -> persist($grade);
        }

        $manager->flush();
    }
}
