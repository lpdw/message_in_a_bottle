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
        $item->setDescription('A fine piece of wood');
        $item->setImage('no_image');
        $manager->persist($item);

        $item = new Item();
        $item->setName('rock');
        $item->setDescription('A rough and weighty rock');
        $item->setImage('no_image');
        $manager->persist($item);

        $item = new Item();
        $item->setName('fabric');
        $item->setDescription('A soft and nice bit of fabric');
        $item->setImage('no_image');
        $manager->persist($item);

        $manager->flush();
    }

    public function getOrder() {
        return 1;
    }
}
