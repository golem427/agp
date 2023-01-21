<?php

namespace App\DataFixtures;

use App\Entity\Blogpost;
use App\Entity\Categorie;
use App\Entity\Realisation;
use App\Entity\User;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraints\NotNull;

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
    $user = new User();

           $user->setEmail('user@test.fr')
                ->setNom($faker->lastName())
                ->setPrenom($faker->firstName())
                ->setTelephone($faker->phoneNumber())
                ->setApropos($faker->text())
                ->setFacebook('facebook');

            $password=$this->hasher->hashPassword($user, 'password');
            $user->setPassword($password);

            $manager->persist($user);
            $manager->flush();



// On crée 10 blogposts

for ($i=0; $i<10; $i++){
    $blogpost = new Blogpost();

           $blogpost->setTitre($faker->word())
                    ->setCreatedAt($faker->dateTimeBetween('-6 month', 'now'))
                    ->setContenu($faker->text(350))
                    ->setSlug($faker->slug(3))
                    ->setUser($user);

            $manager->persist($blogpost);
        }

            $manager->flush();


        // On crée 5 catégories

for ($j=0; $j<5; $j++)
    {
    $categorie = new Categorie();

           $categorie->setNom($faker->word())
                    ->setDescription($faker->words(10,true))
                    ->setSlug($faker->slug());

            $manager->persist($categorie);


            // On crée 3 réalisations par catégorie

            for ($k=0; $k<3; $k++)
            {
                $realisation = new Realisation();

                    $realisation->setNom($faker->words(3, true))
                                ->setLargeur($faker->randomFloat(2, 20, 60))
                                ->setLongueur($faker->randomFloat(2, 20, 60))
                                ->setEnVente($faker->randomElement([true, false]))
                                ->setDateRealisation($faker->dateTimeBetween('-6 month', 'now'))
                                ->setCreatedAt($faker->dateTimeBetween('-6 month', 'now'))
                                ->setDescription($faker->text())
                                ->setPortfolio($faker->randomElement([true, false]))
                                ->setSlug($faker->slug())
                                ->setFile('img2/hotels/andrew-neel-B4rEJ09-Puo-unsplash (1).jpg')
                                ->addCategorie($categorie)
                                ->setPrix($faker->randomFloat(2, 100, 9999))
                                ->setUser($user);
                                

                        $manager->persist($realisation);
            }
        }
            $manager->flush();
        }

}
            


