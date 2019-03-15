<?php

declare(strict_types=1);

namespace TEAEbook\Bundle\CrontabBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateCrontabCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'crontab:update';

    protected function configure()
    {
        $this
            ->setDescription('Update the crontab.')
            ->setHelp('This command allows you to update the crontab')
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
