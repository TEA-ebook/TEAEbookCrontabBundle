<?php

declare(strict_types=1);

namespace TEAEbook\Bundle\CrontabBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TiBeN\CrontabManager\CrontabJob;

class ListCrontabCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'crontab:list';

    protected function configure()
    {
        $this
            ->setDescription('List the jobs configured in the crontab.')
            ->setHelp('This command allows you to list all the jobs created in the crontab')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $jobsFinder = $this->getContainer()->get('crontab.finder.jobs');
        $env = $this->getApplication()->getKernel()->getEnvironment();

        $output->writeln(sprintf('Jobs defined in the crontab for environment "<info>%s</info>":', $env));

        $table = new Table($output);
        $table->setHeaders(['Periodicity', 'Command', 'Description', 'Enabled']);

        $table->setRows(array_map(function (CrontabJob $job) {
            $periodicity = !empty($job->shortCut)
                ? sprintf('@%s', $job->shortCut)
                : sprintf(
                    '%s %s %s %s %s',
                    $job->minutes ?? '*',
                    $job->hours ?? '*',
                    $job->dayOfMonth ?? '*',
                    $job->months ?? '*',
                    $job->dayOfWeek ?? '*'
                );

            return [
                $periodicity,
                $job->taskCommandLine,
                $job->comments ?: 'N/A',
                $job->enabled ? 'Yes' : 'No',
            ];
        }, iterator_to_array($jobsFinder->findAll())));

        $table->render();
    }
}
