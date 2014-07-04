<?php

namespace Spescina\WebfactionCommands\Commands;

use Spescina\WebfactionCommands\Config;
use Spescina\WebfactionCommands\Tasks\Artisan;
use Spescina\WebfactionCommands\Tasks\Composer;
use Spescina\WebfactionCommands\Tasks\Git;
use Spescina\WebfactionCommands\Tasks\Shell;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class Update
 * @package Spescina\WebfactionCommands\Commands
 */
class Update extends AbstractCommand implements CommandInterface {

    use Config;

    use Artisan;
    use Composer;
    use Git;
    use Shell;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'wf:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the app on a WebFaction server';

    /**
     * @var
     */
    protected $environment;

    /**
     * @throws \Exception
     */
    function fire()
    {
        $this->getEnvironment();

        $this->queueTasks();

        $logs = [
            "You are going to install the app using these parameters.",
            "",
            "Environment: {$this->environment}",
            "",
            "Connection: {$this->connection()}",
            "Root directory: {$this->getConfig('app_folder')}",
            "",
            "Run migrations: {$this->option('migrate')}",
            "Run database seeding: {$this->option('seed')}",
            ""
        ];

        $this->log($logs);

        $this->exec(true);
    }

    /**
     *
     */
    function queueTasks()
    {

        $this->changeFolder($this->getConfig('app_folder'));


        $this->gitPull();


        $this->composerInstall();


        if ($this->option('migrate') === 'yes')
        {
            $this->artisanMigrate();
        }


        if ($this->option('seed') === 'yes')
        {
            $this->artisanDbSeed();
        }

    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    function getArguments()
    {
        return [
            ['environment', InputArgument::REQUIRED, 'The target environment [staging|production]'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    function getOptions()
    {
        return [
            ['migrate', null, InputOption::VALUE_OPTIONAL, 'Whether or not run migrations [yes|no]', 'no'],
            ['seed', null, InputOption::VALUE_OPTIONAL, 'Whether or not run database seeding [yes|no]', 'no'],
        ];
    }

} 