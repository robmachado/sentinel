<?php

namespace Sentinel\Seekers;

use Sentinel\Seekers\Format;

class Disk
{
    /**
     * @var float
     */
    public $totalspace;
    /**
     * @var float
     */
    public $freespace;
    /**
     * @var float
     */
    public $usage;
    
    public function __construct()
    {
        $this->diskUsage();
    }

    /**
     * Returns properties in json string
     * @return string
     */
    public function formated()
    {
        $m = [];
        $m['totalspace'] = Format::bytes($this->totalspace);
        $m['freespace'] = Format::bytes($this->freespace);
        $m['usage'] = round($this->usage, 0);
        return json_encode($m);
    }
    
    /**
     * Get the amount of disk
     * @return void
     */
    protected function diskUsage()
    {
        $this->totalspace = disk_total_space('/');
        $this->freespace = disk_free_space('/');
        $diskuse = round(100-(($this->freespace/$this->totalspace)*100), 2);
        $this->usage = $diskuse;
    }
}
