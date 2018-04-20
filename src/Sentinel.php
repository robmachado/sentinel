<?php

namespace Sentinel;

use Exception;
use Sentinel\Seekers\System;
use Sentinel\Seekers\Memory;
use Sentinel\Seekers\Disk;
use Sentinel\Seekers\Connections;

class Sentinel
{
    /**
     * @var string
     */
    public $os;
    public $system;
    public $memory;
    public $disk;
    public $connections;

    /**
     * Constructor
     * @throws Exception
     */
    public function __construct()
    {
        $this->os = PHP_OS;
        if ($this->os == 'WINNT') {
            throw new \Exception('This class does not work in windows environment.');
        }
    }
    
    public function search()
    {
        $this->system = new System();
        $this->memory = new Memory();
        $this->disk = new Disk();
        $this->connections = new Connections();
    }
}
