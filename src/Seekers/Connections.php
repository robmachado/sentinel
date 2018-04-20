<?php

namespace Sentinel\Seekers;

class Connections
{
    /**
     * @var array
     */
    public $iplist = [];
    /**
     * @var int
     */
    public $number;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->search();
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
     * Search for active connections
     * @return void
     */
    protected function search()
    {
        $cmd = "netstat -ntu | egrep ':80|:443|:3360' | grep -v LISTEN | awk '{print $5}' | cut -d: -f1 | sort | uniq -c | sort -rn | grep -v 127.0.0.1";
        @exec($cmd, $result);
        $this->number = 0;
        foreach ($result as $res) {
            $r = explode(" ", trim($res));
            if (filter_var($r[1], FILTER_VALIDATE_IP)) {
               $this->iplist[] = $r[1]; 
               $this->number++;
            }
        }
    }
}
