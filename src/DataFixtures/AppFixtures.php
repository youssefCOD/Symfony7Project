<?php

namespace App\DataFixtures;

use App\Entity\Keywords;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    public function __construct(private readonly SluggerInterface $slugger)
    {

    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $keywords = [
            'France' , 'Politics' , 'World' , 'It' , 'Technology' , 'Economy'
        ];
            foreach($keywords as $key){
                $newKey = new Keywords();
                $newKey->setName($key);

                $slug = strtolower($this->slugger->slug($newKey->getName()));
                $newKey->setSlug($slug);

                $manager->persist($newKey);
            }

        $manager->flush();
    }
}
