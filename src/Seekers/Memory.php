<?php

namespace Sentinel\Seekers;

use Sentinel\Seekers\Format;

class Memory
{
    /**
     * @var float
     */
    public $totalservermemory;
    /**
     * @var float
     */
    public $freeservermemory;
    /**
     * @var float
     */
    public $memoryusage;
    /**
     * @var float
     */
    public $totalswap;
    /**
     * @var float
     */
    public $swapusage;
    /**
     * @var float
     */
    public $phpmemoryallocate;
    /**
     * @var float
     */
    public $phpmemoryusage;
    /**
     * @var float
     */
    public $phppeakmemoryusage;
    
    /**
     * Contructor
     */
    public function __construct()
    {
        $this->calculate();
        $this->correntPHPMemoryUsage();
    }

    /**
     * Return data from the server memory usage
     * @return string
     */
    public function formated()
    {
        $m = [];
        $m['totalservermemory'] = Format::bytes($this->totalservermemory);
        $m['freeservermemory'] = Format::bytes($this->freeservermemory);
        $m['totalswap'] = Format::bytes($this->totalswap);
        $m['memoryusage'] = round($this->memoryusage, 0);
        $m['swapusage'] = round($this->swapusage, 0);
        $m['phpmemoryallocate'] = Format::bytes($this->phpmemoryallocate);
        $m['phpmemoryusage'] = Format::bytes($this->phpmemoryusage, 0);
        $m['phppeakmemoryusage'] = Format::bytes($this->phppeakmemoryusage);
        return json_encode($m);
    }
    
    /**
     * Get corrent memory usage information
     * @return void
     */
    protected function calculate()
    {
        $free = shell_exec('free -btl');
        $free = (string)trim($free);
        $memArr = explode("\n", $free);
        $mArr = [];
        foreach ($memArr as $ma) {
            $ma = preg_replace('!\s+!', ' ', $ma);
            $mArr[] = $ma;
        }
        $mem = explode(" ", $mArr[1]);
        //$mem = array_filter($mem);
        //$mem = array_merge($mem);
        $swap = explode(" ", $mArr[4]);
        $swap_usage = round($swap[2]/$swap[1]*100, 1);
        $memory_usage = round($mem[2]/$mem[1] * 100, 1);
        $this->totalservermemory = $mem[1];
        $this->freeservermemory = $mem[3];
        $this->totalswap = $mem[1];
        $this->memoryusage = $memory_usage;
        $this->swapusage = $swap_usage;
    }

    /**
     * Get corrent memory usage by PHP
     * @return void
     */
    protected function correntPHPMemoryUsage()
    {
        $this->phpmemoryallocate = memory_get_usage(true);
        $this->phpmemoryusage = memory_get_usage(false);
        $this->phppeakmemoryusage = memory_get_peak_usage(false);
    }
}
