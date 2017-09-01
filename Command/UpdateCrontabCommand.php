<?php

namespace TEAEbook\Bundle\CrontabBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateCrontabCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('crontab:update')
            ->setDescription('Update the crontab.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $crontabUpdater = $this->getContainer()->get('crontab.updater');

        $output->write('Updating crontab... ');

        $crontabUpdater->update();

        $output->writeln('<info>Crontab updated.</info>');
    }
}
