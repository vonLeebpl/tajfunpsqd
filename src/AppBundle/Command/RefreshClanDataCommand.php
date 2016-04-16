<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RefreshClanDataCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('wot:refresh_clan_data')
            ->setDescription('Refresh active event clan data')
            ->addArgument(
                'clan',
                InputArgument::REQUIRED,
                'Clan_id to refresh?'
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        // is active event
        $event = $em->getRepository('AppBundle:Event')->isActiveEvent();
        if (!$event)
        {
            $output->writeln(sprintf('No active event, escaping run'));
            return;
        }

        $clan_id = $input->getArgument('clan');
        $output->writeln(sprintf('Refreshing clan %s', $clan_id));

        $clan = $em->getRepository('AppBundle:Clan')->findOneById($clan_id);
        if ($clan)
        {
                $em->remove($clan);
                $em->flush();
        }

        $wot_service = $this->getContainer()->get('app.wot_service');
        $wot_service->refreshClanEventData($clan_id, $event);

    }
}
