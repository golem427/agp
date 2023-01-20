<?php

namespace App\DataFixtures;

use App\Entity\User;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
            $this->hasher = $hasher;
    }


    public function load(ObjectManager $manager): void
{
      // use the factory to create a Faker\Generator instance
$faker = Factory::create();

// generate data by calling methods
// echo $faker->name();
// 'Vince Sporer'
// echo $faker->email();
// 'walter.sophia@hotmail.com'
// echo $faker->text();
// 'Numquam ut mollitia at consequuntur inventore dolorem.'

// On crée un user

for ($i=0; $i<6; $i++){
    $user = new User();

           $user->setEmail('user@test.fr')
                ->setPrenom($faker->firstName())
                ->setNom($faker->lastName())
                ->setTelephone(($faker->phoneNumber()))
                ->setApropos($faker->text())
                ->setInstagram('instagram');

            $password=$this->hasher->hashPassword($user, 'password');
            $user->setPassword($password);

            $manager->persist($user);}
            $manager->flush();
}
}