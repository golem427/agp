<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Contact;
use App\Entity\Blogpost;
use App\Entity\Categorie;
use App\Entity\Realisation;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Types\DateTimeImmutableType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $userPasswordHasherInterface;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->userPasswordHasherInterface = $hasher;
    }


    public function load(ObjectManager $manager): void
    {
        // use the factory to create a Faker\Generator instance
        $faker = Factory::create('fr_FR');

        // generate data by calling methods
        // echo $faker->name();
        // 'Vince Sporer'
        // echo $faker->email();
        // 'walter.sophia@hotmail.com'
        // echo $faker->text();
        // 'Numquam ut mollitia at consequuntur inventore dolorem.'

        // On crée un user
        $user = new User();

        $user->setEmail('contact@aguadopeinture.fr')
            ->setNom($faker->firstName('Jose'))
            ->setRoles(['ROLE_ADMIN']);

        $password = $this->userPasswordHasherInterface->hashPassword($user, 'admin');
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();

            // On crée 10 blogposts

        //     for ($i = 0; $i < 10; $i++) 
        //     {
        //         $blogpost = new Blogpost();

        //         $blogpost->setTitre($faker->word())
        //         ->setCreatedAt(new DateTimeImmutable())
        //         ->setContenu($faker->text(350))
        //             ->setSlug($faker->slug(3))
        //             ->setUser($user)
        //             ->setFile('karin.jpg');

        //         $manager->persist($blogpost);
        //     }

        


        //     // On crée 9 catégories

        //     for ($j=0; $j<9; $j++) 
        //     {
        //         $categorie = new Categorie();

        //         $categorie->setNom($faker->word())
        //             ->setDescription($faker->words(10, true))
        //             ->setSlug($faker->slug());

        //         $manager->persist($categorie);
        //         $manager->flush();


        //         // A chaque catégorie créée, on associe 3 réalisations

        //         for ($k=0; $k<3; $k++) 
        //         {
        //             $realisation = new Realisation();

        //             $realisation->setNom($faker->words(3, true))
        //                 ->setDescription($faker->text())
        //                 ->setPortfolio($faker->randomElement([true, false]))
        //                 ->setSlug($faker->slug(3))
        //                 ->setThumbnail('alex.jpg')
        //                 ->setCreatedAt(new DateTimeImmutable())
        //                 ->setUser($user);

        //             $manager->persist($realisation);
        //             $manager->flush();
        //         }
                
        //     }


        //     // On crée 5 demandes de contacts

        //     for ($m=0; $m<5; $m++) 
        //     {
        //         $contact = new Contact();

        //         $contact->setNom($faker->word())
        //             ->setEmail($faker->email())
        //             ->setSubject($faker->word())
        //             ->setMessage($faker->words(10, true))
        //             ->setCreatedAt($faker->dateTimeBetween('-6 month', 'now'));

        //         $manager->persist($contact);
        //     }
        //     $manager->flush();
        // }
    }
}