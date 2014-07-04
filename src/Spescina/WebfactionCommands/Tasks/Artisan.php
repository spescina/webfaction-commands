<?php

namespace Spescina\WebfactionCommands\Tasks;



/**
 * Class Artisan
 * @package Spescina\WebfactionCommands\Tasks
 */
trait Artisan {

    /**
     *
     */
    public function artisanMigrate()
    {
        array_push($this->tasks, "php artisan migrate");
    }

    /**
     *
     */
    public function artisanDbSeed()
    {
        array_push($this->tasks, "php artisan db:seed");
    }

} 