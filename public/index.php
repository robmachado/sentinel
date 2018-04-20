<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once '../vendor/autoload.php';

use Sentinel\Sentinel;

$s = new Sentinel();
$s->search();


$memory = json_decode($s->memory->formated());
$system = json_decode($s->system->formated());
$disk = json_decode($s->disk->formated());
$connections = json_decode($s->connections->formated());

echo "<pre>";
print_r($s);
echo "</pre>";


$memoryinfo = "<small><p>Memoria Total: $memory->totalservermemory<br>Memoria Livre: $memory->freeservermemory <br>PHP Alocada: $memory->phpmemoryallocate<br>PHP Usada: $memory->phpmemoryusage<br>PHP Peak: $memory->phppeakmemoryusage</p></small>";

$swap = "<small><p>SWAP Total: $memory->totalswap<br>Swap Usado: $memory->swapusage</p></small>";
$uptime = "<small><p>Uptime: $system->uptimedays dias, $system->uptimehours horas e $system->uptimeminutes minutos</p></small>";

$descriptions = "<h3>Sistema</h3><small><p>OS: $system->os $system->ostype <br>Release : $system->osrelease $system->osversion <br>Nucleos: $system->cores<p></small>";
$activeconn = "<small><p>Conexões Ativas: $connections->number<br>";
foreach($connections->iplist as $ip) {
    $activeconn .= "$ip<br>";
}

$template = "<!DOCTYPE html>
<html lang=\"pt_br\">
<head>
    <meta charset=\"utf-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <title>DashBoard</title>
    <link rel=\"stylesheet\" type=\"text/css\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css\">
    <link rel=\"stylesheet\" type=\"text/css\" href=\"https://www.jqueryscript.net/css/jquerysctipttop.css\">
    <link rel=\"stylesheet\" type=\"text/css\" href=\"base.css\">
    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js\"></script>
    <script src=\"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js\"></script>
    <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js\"></script>
</head>
<body>
    <div class=\"container\" style=\"margin:50px auto;\">
        <h1>DashBoard</h1>
        <hr>
        <div class=\"row\">
            <div class=\"col-sm\">
                <div class=\"GaugeMeter\" id=\"memory\" data-percent=\"$memory->memoryusage\" data-append=\"%\" data-size=\"200\" data-theme=\"Blue\" data-back=\"RGBa(0,0,0,.3)\" data-animate_gauge_colors=\"1\" data-animate_text_colors=\"1\" data-width=\"15\" data-label=\"Memory\" data-style=\"Arch\" data-label_color=\"#333333\"></div>
                     $memoryinfo
            </div>
            <div class=\"col-sm\">
                <div class=\"GaugeMeter\" id=\"load\" data-percent=\"$system->loadm15\" data-append=\"%\" data-size=\"200\" data-theme=\"Blue\" data-back=\"RGBa(0,0,0,.3)\" data-animate_gauge_colors=\"1\" data-animate_text_colors=\"1\" data-width=\"15\" data-label=\"Load\" data-style=\"Arch\" data-label_color=\"#333333\"></div>
                    $uptime
            </div>
            <div class=\"col-sm\">
                <div class=\"GaugeMeter\" id=\"disk\" data-percent=\"$disk->usage\" data-append=\"%\" data-size=\"200\" data-theme=\"Blue\" data-back=\"RGBa(0,0,0,.3)\" data-animate_gauge_colors=\"1\" data-animate_text_colors=\"1\" data-width=\"15\" data-label=\"Disk\" data-style=\"Arch\" data-label_color=\"#333333\"></div>
                $swap
            </div>
        </div>
        <div class=\"row\">
            <div class=\"col-sm\">
                $descriptions
            </div>
            <div class=\"col-sm\">
                $activeconn
            </div>
        </div>    
    </div>
    <script src=\"GaugeMeter.js\"></script>
    <script>
        $(\".GaugeMeter\").gaugeMeter();
    </script>
    <script type=\"text/javascript\">
        
    </script>
</body>
</html>";

echo $template;