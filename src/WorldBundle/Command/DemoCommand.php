<?php

namespace WorldBundle\Command;

// use Shapecode\Bundle\CronBundle\Annotation\CronJob;
// use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

/**
 * Class DemoCommand
 * 
 *
 * @CronJob("*\/1 * * * *")
 * Will be executed every 1 minutes
 */
class DemoCommand extends ContainerAwareCommand
{
    protected $em;

    /**
     * @inheritdoc
     */
    public function configure()
    {
		$this->setName('command:demo');
    }
    
    /**
     * @inheritdoc
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
		$this->em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $Inventory = $this->em->getRepository('WorldBundle:Inventory')->findOneById(2);

        $Inventory->addQuantity(2);
        $this->em->persist($Inventory);
        $this->em->flush();
    }
}