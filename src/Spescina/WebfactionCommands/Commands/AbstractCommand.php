<?php

namespace Spescina\WebfactionCommands\Commands;


use Config as LaravelConfig;
use Exception;
use Illuminate\Console\Command;
use Spescina\WebfactionCommands\Config;

/**
 * Class AbstractCommand
 * @package Spescina\WebfactionCommands\Commands
 */
abstract class AbstractCommand extends Command {

    use Config;

    /**
     * @var array
     */
    protected $tasks = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return bool
     */
    protected function isEnvironmentAvailable()
    {
        if (!in_array($this->environment, $this->getAvailableEnvironments()))
        {
            return false;
        }

        return true;
    }

    /**
     * @param $logs
     */
    protected function log($logs)
    {
        $that = $this;

        array_map(function ($value) use ($that)
        {

            $that->info($value);

        }, $logs);
    }

    /**
     * @throws \InvalidArgumentException
     */
    protected function getEnvironment()
    {
        $this->environment = $this->argument('environment');

        if (!$this->isEnvironmentAvailable())
        {
            throw new \InvalidArgumentException('Environment not available.');
        }
    }

    /**
     * @param bool $confirm
     */
    protected function exec($confirm = false)
    {
        $cases = $confirm ? "[*yes|no]" : "[yes|*no]";

        if ($this->confirm("Do you wish to continue? $cases", $confirm))
        {
            SSH::into($this->getRemoteConnection())->run($this->tasks, function ($line)
            {
                echo $line . PHP_EOL;
            });
        }
    }

    /**
     * @throws \Exception
     */
    protected function connection()
    {
        $connectionName = 'webfaction';

        if (!LaravelConfig::has("remote.connections.$connectionName"))
        {
            throw new Exception("'$connectionName' connection not configured");
        }

        return $connectionName;
    }

} 