<?php

namespace App\DataFixtures;

use App\Entity\Sclass;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class SclassFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i <= 4 ; $i++) { 
            $Sclass = new Sclass();
            $Sclass -> setName("Class $i");
            $Sclass -> setMaximum(rand(20,40));
            
            $manager -> persist($Sclass);
        }

        $manager->flush();
    }
}
