<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Cheese;
use App\Entity\Category;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('FR-fr');
        $slugify = new Slugify();

        for($i=1; $i <= 3; $i++){

            $user = new User();

            $hash = $this->encoder->encodePassword($user, 'password');

            $user->setFirstname($faker->firstname)
                 ->setLastname($faker->lastname)
                 ->setEmail($faker->email)
                 ->setHash($hash);

                 $manager->persist($user);
        }

        for($i=1; $i <= 3; $i++){
            $category = new Category();

            $title = $faker->sentence(1);
            $image = $faker->imageUrl(1000, 350);
            $description = $faker->paragraph(2);
            $slug = $slugify->slugify($title);

            $category->setTitle($title)
                    ->setImage($image)
                    ->setDescription($description)
                    ->setSlug($slug);

                    for($j=1; $j <= 10; $j++){
                        $cheese = new Cheese();
            
                        $title = $faker->sentence(3);
                        $image = $faker->imageUrl(1000, 350);
                        $description = $faker->paragraph(2);
                        $slug = $slugify->slugify($title);
            
                        $cheese->setTitle($title)
                                ->setDescription($description)
                                ->setImage($image)
                                ->setPrice(mt_rand(5, 20))
                                ->setStock(mt_rand(5, 20))
                                ->setCategory($category)
                                ->setSlug($slug);
                                
                                $manager->persist($cheese);
                    }

            $manager->persist($category);
        } 

        

        $manager->flush();
    }
}
