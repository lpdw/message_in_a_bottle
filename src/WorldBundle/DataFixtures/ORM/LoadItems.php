<?php

namespace WorldBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use WorldBundle\Entity\Item;

class LoadItemData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $item = new Item();
        $item->setName('wood');
        $item->setDescription('A fine piece of wood. Very useful. Trust us.');
        $item->setImage('no_image');
        $manager->persist($item);

        $item = new Item();
        $item->setName('rock');
        $item->setDescription('A rough and weighty rock. Maybyou can use it to crush a coconut - or your own hand.');
        $item->setImage('no_image');
        $manager->persist($item);

        $item = new Item();
        $item->setName('fabric');
        $item->setDescription('A soft and nice bit of fabric. Could be useful. Or not.');
        $item->setImage('no_image');
        $manager->persist($item);


        $item = new Item();
        $item->setName('bottle');
        $item->setDescription('A glassy bottle with a paper in it. Your best friend against solitude.');
        $item->setImage('no_image');
        $manager->persist($item);

        $manager->flush();
    }

    public function getOrder() {
        return 1;
    }
}
