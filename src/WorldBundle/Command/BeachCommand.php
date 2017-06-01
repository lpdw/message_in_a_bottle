<?php

namespace WorldBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

/**
 * Class DemoCommand
 * 
 *
 * @CronJob("0 *\/4 * * *")
 * Will be executed every 4h
 */
class BeachCommand extends ContainerAwareCommand
{
    protected $em;

    /**
     * @inheritdoc
     */
    public function configure()
    {
		$this->setName('beach:update');
    }
    
    /**
     * @inheritdoc
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
		$this->em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $WorldGames = $this->em->getRepository('WorldBundle:WorldGame')->findAll();

        $items = $this->em->getRepository('WorldBundle:Item')->getAllItem()->getResult();
        foreach ($WorldGames as $key => $WorldGame) {
            foreach ($WorldGame->getIslands() as $i => $island) {
                $beach = $island->getBeach();
                $beach->removeAllDrop();
                $beach->addDrop($items[rand(0,count($items)-1)]);
                $this->em->persist($beach);
                $this->em->flush();
            }
        }
    }
}