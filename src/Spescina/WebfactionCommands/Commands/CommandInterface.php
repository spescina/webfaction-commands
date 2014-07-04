<?php

namespace Spescina\WebfactionCommands\Commands;


interface CommandInterface {

    function fire();

    function getArguments();

    function getOptions();

    function queueTasks();

} 