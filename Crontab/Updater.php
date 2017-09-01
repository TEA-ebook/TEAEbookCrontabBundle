<?php

namespace TEAEbook\Bundle\CrontabBundle\Crontab;

use TEAEbook\Bundle\CrontabBundle\Finder\JobsFinder;
use TiBeN\CrontabManager\CrontabRepository as CrontabManager;

class Updater
{
    private $crontabManager;
    private $jobsFinder;

    public function __construct(CrontabManager $crontabManager, JobsFinder $jobsFinder)
    {
        $this->crontabManager = $crontabManager;
        $this->jobsFinder = $jobsFinder;
    }

    public function update()
    {
        // Start by deleting all the jobs from the crontab and reinsert them later.
        // We have to do that because "real differential updates" are not supported.
        foreach ($this->crontabManager->getJobs() as $job) {
            $this->crontabManager->removeJob($job);
        }

        // Fetch jobs from the configuration
        foreach ($this->jobsFinder->findAll() as $job) {
            $this->crontabManager->addJob($job);
        }

        $this->crontabManager->persist();
    }
}
