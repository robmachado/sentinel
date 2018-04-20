<?php

namespace Sentinel\Seekers;

class Format
{
    /**
     * Converts bytes into their multiples
     * @param int $size
     * @param int $precision
     * @return string
     */
    public static function bytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('B', 'kB', 'MB', 'GB', 'TB', 'PT');   
        return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
    }
}
