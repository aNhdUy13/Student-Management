<?php

namespace App\DataFixtures;

use App\Entity\Subject;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class SubjectFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i = 0; $i < 10 ;$i++){
            $subject = new Subject();
            $subject -> setName("Subject $i");
            $subject -> setSubjectCode(rand(1600,1690));
    
            $manager ->persist($subject);
        }        
        $manager->flush();
    }
}
