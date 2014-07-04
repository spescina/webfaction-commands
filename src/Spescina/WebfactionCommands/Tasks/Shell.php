<?php

namespace Spescina\WebfactionCommands\Tasks;


/**
 * Class Shell
 * @package Spescina\WebfactionCommands\Tasks
 */
trait Shell {

    /**
     * @param $folder
     */
    public function changeFolder($folder)
    {
        array_push($this->tasks, "cd $folder");
    }

    /**
     * @param array $files
     * @internal param $folder
     */
    public function deleteFiles(array $files)
    {
        array_map(function($file){

            array_push($this->tasks, "rm -f $file");

        }, $files);
    }

    /**
     * @param $filename
     * @param null $content
     */
    public function touchFile($filename, $content = null)
    {
        $command = (isset($content)) ? "printf '$content' > $filename" : "touch $filename";

        array_push($this->tasks, $command);
    }

} 