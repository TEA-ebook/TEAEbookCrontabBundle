TEAEbookCrontabBundle
=====================

Symfony bundle providing a clear syntax to write, commit and deploy cron jobs.

## Installation

Require the bundle:

```
composer require tea-ebook/crontab-bundle
```

And declare it into your `app/AppKernel.php` file:

```php
public function registerBundles()
{
    return array(
        // ...
        new TEAEbook\Bundle\CrontabBundle\CrontabBundle(),
    );
}
```

## Usage

### Configuring jobs

```yaml
# app/config/config.yml
crontab:
    working_directory: "%kernel.root_dir%/../"
    jobs:
        -
            periodicity: '0 * * * *' # every hour, at minute 0
            command: du -sh . >> app/logs/disk_usage.log
            description: Writes the project disk usage in app/logs/disk_usage.log
        -
            periodicity: '@daily'
            command: php app/console some:command
            enabled: false
            description: "This job is currently disabled as the 'some:command' command does not exist" 
```

### Updating the crontab

Sometime during your deployment, run the following command to update the system's
crontab:

```
php app/console crontab:update
```

Configured jobs can be listed by the following command:

```
php app/console crontab:list
```

## License

This bundle is under the [MIT](https://github.com/TEA-ebook/TEAEbookCrontabBundle/blob/master/LICENSE) license.
