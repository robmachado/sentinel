<?php
require_once '../src/ServerMonitor.php';

$monitor = new ServerMonitor();
$em = $monitor->httpConnections();

$em = $monitor->numberProcesses();
$em = $monitor->correntMemoryUsage();
$em = $monitor->serverUptime();
echo "$em";
die;
$em = $monitor->serverMemoryUsage();
$em = $monitor->systemLoad();
echo "<pre>";
print_r($em);
echo "</pre>";
die;
$em = $monitor->serverMemoryUsage();

$mem = $monitor->correntMemoryUsage();
$cores = $monitor->systemCores();
echo $mem;