<?php

declare(strict_types=1);

namespace TEAEbook\Bundle\CrontabBundle\Finder;

use TiBeN\CrontabManager\CrontabJob;

class JobsFinder
{
    private $jobsConfig;
    private $workingDirectory;

    public function __construct(array $jobsConfig, string $workingDirectory)
    {
        $this->jobsConfig = $jobsConfig;
        $this->workingDirectory = $workingDirectory;
    }

    public function findAll(): \Traversable
    {
        foreach ($this->jobsConfig as $jobConfig) {
            yield $this->createJob($jobConfig);
        }
    }

    private function createJob(array $jobConfig): CrontabJob
    {
        $command = $jobConfig['command'];

        if (!empty($this->workingDirectory)) {
            $command = sprintf('cd %s && %s', $this->workingDirectory, $command);
        }

        $job = CrontabJob::createFromCrontabLine(sprintf('%s %s', $jobConfig['periodicity'], $command));
        $job->enabled = $jobConfig['enabled'];

        if ($jobConfig['description']) {
            $job->comments = $jobConfig['description'];
        }

        return $job;
    }
}
