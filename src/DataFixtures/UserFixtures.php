<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{   private $hasher;
    public function __construct (UserPasswordHasherInterface $hasher){
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {
        $email = new User();
        $email->setEmail("user@gmail.com");
        $email->setPassword($this->hasher->hashPassword($email, "123456"));
        $email->setRoles(['ROLE_USER']);
        $manager->persist($email);

        $email = new User();
        $email->setEmail("admin@gmail.com");
        $email->setPassword($this->hasher->hashPassword($email, "123456"));
        $email->setRoles(['ROLE_ADMIN']);
        $manager->persist($email);

        $manager->flush();
    }
}
