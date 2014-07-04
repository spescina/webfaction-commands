<?php

namespace Spescina\WebfactionCommands\Tasks;



/**
 * Class Composer
 * @package Spescina\WebfactionCommands\Tasks
 */
trait Composer {

    /**
     *
     */
    public function composerInstall()
    {
        array_push($this->tasks, "composer install --no-dev");
    }

} 