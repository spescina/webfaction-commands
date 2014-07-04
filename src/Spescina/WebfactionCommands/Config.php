<?php

namespace Spescina\WebfactionCommands;

use \Config as LaravelConfig;


/**
 * Class Config
 * @package Spescina\WebfactionCommands
 */
trait Config {

    /**
     * @param $key
     * @return mixed
     */
    public function getConfig($key)
    {
        $config = LaravelConfig::get('webfaction-commands::environments.' . $this->environment . '.' . $key);

        return $config;
    }

    /**
     * @return array
     */
    public function getAvailableEnvironments()
    {
        $config = LaravelConfig::get('webfaction-commands::environments');

        return array_keys($config);
    }

} 