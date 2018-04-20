<?php

namespace Sentinel\Seekers;

class System
{
    /**
     * @var string
     */
    public $os;
    /**
     * @var string
     */
    public $osname = '';
    /**
     * @var string
     */
    public $hostname = '';
    /**
     * @var string
     */
    public $osrelease = '';
    /**
     * @var string
     */
    public $osversion = '';
    /**
     * @var string
     */
    public $ostype = '';
    /**
     * @var int
     */
    public $uptimedays = 0;
    /**
     * @var int
     */
    public $uptimehours = 0;
    /**
     * @var int
     */
    public $uptimeminutes = 0;
    /**
     * @var int
     */
    public $cores = 1;
    /**
     * @var float
     */
    public $loadm1;
    /**
     * @var float
     */
    public $loadm5;
        /**
     * @var float
     */
    public $loadm15;
    /**
     * @var int
     */
    public $proccount;
    
    /**
     * Constructor
     * @throws \Exception
     */
    public function __construct()
    {
        $this->os = PHP_OS;
        if ($this->os == 'WINNT') {
            throw new \Exception('This class does not work in windows environment.');
        }
        $this->info();
        $this->uptime();
        $this->systemCores();
        $this->systemLoad();
        $this->numberProcesses();
    }
    
    /**
     * Returns properties in json string
     * @return string
     */
    public function formated()
    {
        return json_encode(get_object_vars($this));
    }
    
    /**
     * Gets operational system info
     * @return void
     */
    protected function info()
    {
        $this->osname = php_uname('s');
        $this->hostname = php_uname('n');
        $this->osrelease = php_uname('r');
        $this->osversion = php_uname('v');
        $this->ostype = php_uname('m');
    }
    
    /**
     * Get the number of cores of the processor
     * @return void
     */
    protected function systemCores()
    {
        $cmd = '';
        switch ($this->os) {
            case ('Linux'):
                $cmd = "cat /proc/cpuinfo | grep processor | wc -l";
                break;
            case ('Freebsd'):
                $cmd = "sysctl -a | grep 'hw.ncpu' | cut -d ':' -f2";
                break;
        }
        $cpuCoreNo = intval(trim(shell_exec($cmd)));
        $this->cores = empty($cpuCoreNo) ? 1 : $cpuCoreNo;
    }
   
    /**
     * Returns the server uptime
     * @return void
     */
    protected function uptime()
    {
        $uptimestring = file_get_contents('/proc/uptime');
        $ticks = explode(" ", $uptimestring);
        $min = $ticks[0]/60;
        $hours = $min/60;
        $this->uptimedays = floor($hours/24);
        $this->uptimehours = floor($hours-($this->uptimedays*24));
        $this->uptimeminutes = floor($min-($this->uptimedays*60*24)-($this->uptimehours*60));
    }
    
   /**
    * Get system load as percentage
    * NOTE: This search must be done with a minimum interval of 15 minutes
    * @return void
    */
    protected function systemLoad()
    {
        $rs = sys_getloadavg();
        $this->loadm1 = round(($rs[0]*100)/$this->cores, 1);
        $this->loadm5 = round(($rs[1]*100)/$this->cores, 1);
        $this->loadm15 = round(($rs[2]*100)/$this->cores, 1);
    }
    
    /**
     * Get number of processes
     * @return void
     */
    protected function numberProcesses()
    {
        $this->proccount = 0;
        $dh = opendir('/proc');
        while ($dir = readdir($dh)) {
            if (is_dir('/proc/' . $dir)) {
                if (preg_match('/^[0-9]+$/', $dir)) {
                    $this->proccount ++;
                }
            }
        }
    }
}
