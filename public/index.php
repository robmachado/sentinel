<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<!DOCTYPE html>
<html lang="pt_br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DashBoard</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://www.jqueryscript.net/css/jquerysctipttop.css">
    <link rel="stylesheet" type="text/css" href="base.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container" style="margin:50px auto;">
        <h1>DashBoard</h1>
        <div class="row">
            <div class="col-sm">
            </div>
            <div class="col-sm">
                <div class="GaugeMeter" id="PreviewGaugeMeter_2" data-percent="28" data-append="%" data-size="200" data-theme="Blue" data-back="RGBa(0,0,0,.3)" data-animate_gauge_colors="1" data-animate_text_colors="1" data-width="20" data-label="Memory" data-style="Arch" data-label_color="#333333"></div>
            </div>
            <div class="col-sm">
                One of three columns
            </div>
        </div>
    </div>
    <script src="GaugeMeter.js"></script>
    <script>
        $(".GaugeMeter").gaugeMeter();
    </script>
    <script type="text/javascript">
        
    </script>
</body>
</html>