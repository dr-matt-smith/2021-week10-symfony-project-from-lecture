<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Bed;
use App\Entity\Timber;

class BedFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $oak = new Timber();
        $oak->setName('oak');

        $deal = new Timber();
        $deal->setName('deal');

        $pine = new Timber();
        $pine->setName('pine');


        $bed1 = new Bed();
        $bed1->setName('sleigh');
        $bed1->setSize('superking');
        $bed1->setPrice(499);
        $bed1->setTimber($oak);
        $bed1->setImage('sleigh.png');

        $bed2 = new Bed();
        $bed2->setName('basic');
        $bed2->setSize('double');
        $bed2->setPrice(199);
        $bed2->setTimber($deal);
        $bed2->setImage('double.png');

        $bed3 = new Bed();
        $bed3->setName('sleigh2');
        $bed3->setSize('queen');
        $bed3->setPrice(399);
        $bed3->setTimber($oak);
        $bed3->setImage('default.png');

        $bed4 = new Bed();
        $bed4->setName('sleigh3');
        $bed4->setSize('double');
        $bed4->setPrice(299);
        $bed4->setTimber($pine);
        $bed4->setImage('default.png');

        $bed5 = new Bed();
        $bed5->setName('kids');
        $bed5->setSize('single');
        $bed5->setPrice(99);
        $bed5->setTimber($pine);
        $bed5->setImage('default.png');


        $manager->persist($oak);
        $manager->persist($deal);
        $manager->persist($pine);

        $manager->persist($bed1);
        $manager->persist($bed2);
        $manager->persist($bed3);
        $manager->persist($bed4);
        $manager->persist($bed5);

        $manager->flush();
    }
}
