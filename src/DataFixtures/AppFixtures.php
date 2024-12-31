<?php

namespace App\DataFixtures;

use App\Entity\Sorte;
use App\Entity\Einkauf;
use App\Entity\Verkauf;
use App\Entity\Fahrer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 0; $i < 4; $i++) {
            switch ($i) {
                case 0:
                    $type = "405";
                    $price = 25000;
                    $g = 50;
                    $g05 = 30;
                    break;
                case 1:
                    $type = "505";
                    $price = 30000;
                    $g = 60;
                    $g05 = 35;
                    break;
                case 2:
                    $type = "1050";
                    $price = 35000;
                    $g = 70;
                    $g05 = 40;
                    break;
            }
            $sorte = new Sorte();
            $sorte->setName('Weizenmehl: Type '.$type);
            $sorte->setEinkaufspreisProKg($price);
            $sorte->setVerkaufspreis1g($g);
            $sorte->setVerkaufspreis05g($g05);
            $manager->persist($sorte);
        }

        $manager->flush();
    }
}
