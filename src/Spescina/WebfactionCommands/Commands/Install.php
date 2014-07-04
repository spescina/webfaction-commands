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
 * Class Install
 * @package Spescina\WebfactionCommands\Commands
 */
class Install extends AbstractCommand implements CommandInterface {

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
    protected $name = 'wf:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the app on a WebFaction server';

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
            "Git repository: {$this->getConfig('git_repository')}",
            "Git branch: {$this->getConfig('git_branch')}",
            "Root directory: {$this->getConfig('app_folder')}",
            "",
            "Run migrations: {$this->option('migrate')}",
            "Run database seeding: {$this->option('seed')}",
            ""
        ];

        $this->log($logs);

        $this->exec();
    }

    /**
     *
     */
    function queueTasks()
    {

        $this->changeFolder($this->getConfig('app_folder'));


        $this->deleteFiles(['index.html']);


        $this->gitClone($this->getConfig('git_repository'), '.');


        if ($this->getConfig('git_branch') !== 'develop')
        {
            $this->gitCheckout($this->getConfig('git_branch'));
        }


        $this->touchFile('.envvars.php', "<?php\n\nputenv(\"ENV={$this->environment}\");\n");


        $envFilename = ($this->environment === 'production') ? ".env.php" : ".env.{$this->environment}.php";
        $this->touchFile($envFilename, "<?php\n\nreturn [\n\t\"MYSQL_HOST\" => \"\",\n\t\"MYSQL_DATABASE\" => \"\",\n\t\"MYSQL_USERNAME\" => \"\",\n\t\"MYSQL_PASSWORD\" => \"\"\n];\n");


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