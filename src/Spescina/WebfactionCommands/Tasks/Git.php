<?php

namespace Spescina\WebfactionCommands\Tasks;


/**
 * Class Git
 * @package Spescina\WebfactionCommands\Tasks
 */
trait Git {

    /**
     * @param $branch
     */
    public function gitCheckout($branch)
    {
        array_push($this->tasks, "git checkout -b $branch origin/$branch");
    }

    /**
     * @param $repository
     * @param $destination
     */
    public function gitClone($repository, $destination)
    {
        array_push($this->tasks, "git clone $repository $destination");
    }

    /**
     *
     */
    public function gitPull()
    {
        array_push($this->tasks, "git pull");
    }

} 