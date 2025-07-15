<?php
$username = $_COOKIE['login'];
echo "<script>console.log('".$_COOKIE['login']."')</script>";
if(isset($_GET['ac'])){
    echo "<script>alert('ثبت نام شما با موفقیت انجام شد.')</script>";
}
include "./includes/db.inc.php";
try{
    $s = $pdo->prepare("select id, starttime, startdate, duration, panel from Alarms where username=:username order by id");
    $s->bindValue(":username", $username);
    $s->execute();
}catch(PDOException $e){
	echo "error in select data".$e->getMessage();
	exit();
}
if($s->rowCount() == 0){
    $percent = 0;
}else{
    $results = $s->fetchAll();
    include "../includes/func.inc.php";
    date_default_timezone_set("Asia/Tehran");
    $timeNow = mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('Y'));
    $duration = 0;
    foreach($results as $row){
        $start = $row['startdate'] . " " . $row['starttime'];
        $ts_endpanel = mktime(intval(substr($start,11,2)),
                               intval(substr($start,14,2)),
                               intval(substr($start,17,2)),
                               intval(substr($start,5,2)),
                               intval(substr($start,8,2)),
                               intval(substr($start,0,4))) + intval($row['duration']);
        if($row['duration'] == 0){
            $duration = -1;
            $start_panel = $row['startdate'] . " " . $row['starttime'];
            break;
        }
        if($ts_endpanel - $timeNow > 0){
            if($duration == 0){
                $start_panel = $row['startdate'] . " " . $row['starttime'];
            }
            $duration +=  $row['duration'];
        }
    }
    if($duration > 0){
        $panel_days = intval($duration)/(24 * 60 * 60);
        $ts_endpanel =  mktime(intval(substr($start_panel,11,2)),
                                   intval(substr($start_panel,14,2)),
                                   intval(substr($start_panel,17,2)),
                                   intval(substr($start_panel,5,2)),
                                   intval(substr($start_panel,8,2)),
                                   intval(substr($start_panel,0,4))) + $duration;
        $end_panel = date('Y-m-d H:i:s', $ts_endpanel);
        
        $start_panel = miladiBeShamsi(intval(substr($start_panel,0,4)),intval(substr($start_panel,5,2)),intval(substr($start_panel,8,2)),"/") . " " . $row['starttime'];
        $end_panel = miladiBeShamsi(intval(substr($end_panel,0,4)),intval(substr($end_panel,5,2)),intval(substr($end_panel,8,2)),"/") . " " . $row['starttime'];
        
        $remain_days = ($ts_endpanel - $timeNow)/(24 * 60 * 60);
        if($remain_days - intval($remain_days) > 0){
            $remain_days = intval($remain_days) + 1;
        }
        if($duration != 0){
            $percent = (($ts_endpanel - $timeNow) * 100) / intval($duration);
        }else{
            $percent = 0;
        }
    }else{
        $percent = 100;
    }
}
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0 ">
        <title>ASTROCYTE</title>
        <link rel="stylesheet" href="../assets/css/style.css?v=2">
        <link rel="shortcut icon" href="./images/hoshi.png"/>
        <style>
            @font-face {
              font-family: vazir;
              src: url('./fonts/Vazir.eot');
              src: url('./fonts/Vazir.ttf') format('truetype');
              font-weight: normal;
              font-style: normal;
            }
            body{
                font-family:vazir;
                direction:rtl;
                background:#14151b;
            }
            html{
                overflow-x:hidden;
                
            }
            .bg-blue{
                background:#0095a3;
            }
            .bg-color{
                background:#191c24;
            }
            .bg-color-dark{
                background:#14151b;
            }
            .button{
                background:rgb(108, 114, 147, 0.2);
            }
            .button:focus{
                background:rgb(108, 114, 147, 0.2);
                outline:0;
            }
            .bcbox{
                background:rgb(108, 114, 147, 0.2);
            }
        </style>
    </head>
    <body>
        <div class="shadow bg-color">
            <div class="container-fluid">
                <div class="row">
                    <div class="col text-end mt-4 me-5">
                        <a href="../user/index.php?from=reg&user=<?php echo $username;?>" class="text-decoration-none ">
                            <div class="d-inline-flex flex-row">
                                <svg width="20" height="20" fill="white" class="bi bi-house-door-fill" viewBox="0 0 16 16">
                                  <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5Z"/>
                                </svg>
                                <p class="text-light me-1"> صفحه اصلی</p>
                            </div> 
                        </a>
                    </div>
                    <div class="col text-start">
                        <a class="ms-3">
                            <img src="../alarm/images/hoshiLogo.png" alt="Logo" width="90" height="45" class="d-inline-block align-text-top my-3">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-color-dark w-100">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="row justify-content-center">
                        <div class=" col-11 col-sm-10 col-md-8 col-lg-4 mt-4">
                            <div class="float-start">
                                <a href="../user/index.php?from=reg&user=<?php echo $username;?>" class="text-decoration-none">
                                    <div class="d-inline-flex flex-row">
                                        <p class="text-light me-1">
                                            بازگشت
                                        </p>
                                        <svg width="25" height="25" fill="white" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                                          <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                                        </svg>
                                    </div> 
                                </a> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-10 col-sm-10 col-md-8 col-lg-4 bg-color rounded-1 p-5 mt-2 mb-5">
                    <p class="text_light fs-3 text-center fw-bold">
                        پنل آلارم hoshi
                    </p>
                    <div id="radialprogress" class="text-center mt-5"></div>
                    <?php if($remain_days > 0){?>
                    <p class="text-light mt-3 text-end">
                        <?php echo $remain_days . " روز باقی مانده از " . $panel_days . " روز"?>
                    </p>
                    <?php }else if($row['panel']){?>
                    <p class="text_light">
                        اتمام پنل 
                    </p>
                    <?php } ?>
                    <?php if($timeNow < $ts_endpanel or $duration < 0){?>
                    <div class="row justify-content-center mt-5">
                        <div class="col bcbox p-4 rounded-1">
                            <div class="d-flex">
                                <div class="p-2 flex-grow-1">
                                    تاریخ شروع:
                                </div>
                                <div class="p-2" style="direction:ltr">
                                    <?php echo $start_panel;?>
                                </div>
                            </div>
                            <?php if($duration > 0){?>
                            <div class="d-flex">
                                <div class="p-2 flex-grow-1">
                                    تاریخ اعتبار:
                                </div>
                                <div class="p-2" style="direction:ltr">
                                    <?php echo $end_panel;?>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if($timeNow > $ts_endpanel and $duration > 0){ ?>
                    <div class="col-12 rounded-1 text-center mt-5">
                        <p>
                            شما بسته فعالی ندارید .
                        </p>
                        <p>
                             برای خرید روی گزینه زیر کلیک کنید.
                        </p>
                    </div>
                    <?php }else if($duration < 0){ ?>
                    <div class="col-12 rounded-1 text-end mt-5">
                        <p>
                            تعداد روزهای باقی مانده: بی نهایت
                        </p>
                    </div>
                    <?php } ?>
                    <div class="col-12 rounded-1 text-center mt-5">
                        <a type="button" class="btn bg-blue rounded-1 py-2 w-50 fs-5" href="./shop.php?user=<?php echo $username ?>">
                            خرید بسته آلارم
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <script src="../../jquery.min.js"></script>
        <script src="./js/d3.min.js"></script>
        <script>
            function drawProgress(end){ 
            var wrapper = document.getElementById('radialprogress');
            var start = 0;
            
            var colours = {
              fill: '#dc3545',
              track: 'rgb(108, 114, 147, 0.2)',
              text: '#00C0FF',
              stroke: '#191c24',
            }
            
            var radius = 70;
            var border = 40;
            var strokeSpacing = 1;
            var endAngle = Math.PI * 2;
            var formatText = d3.format('.0%');
            var boxSize = radius * 2;
            var count = end;
            var progress = start;
            var step = end < start ? -0.01 : 0.01;
            
            //Define the circle
            var circle = d3.svg.arc()
              .startAngle(0)
              .innerRadius(radius)
              .outerRadius(radius - border);
            
            //setup SVG wrapper
            svg = d3.select(wrapper)
              .append('svg')
              .attr('width', boxSize)
              .attr('height', boxSize);
            
              
            // ADD Group container
            var g = svg.append('g')
              .attr('transform', 'translate(' + boxSize / 2 + ',' + boxSize / 2 + ')');
            
            //Setup track
            var track = g.append('g').attr('class', 'radial-progress');
            track.append('path')
              .attr('fill', colours.track)
              .attr('stroke', colours.stroke)
              .attr('stroke-width', strokeSpacing + 'px')
              .attr('d', circle.endAngle(endAngle));
            //Add colour fill
            var value = track.append('path')
              .attr('fill', colours.fill)
              .attr('stroke', colours.stroke)
              .attr('stroke-width', strokeSpacing + 'px');
              value.attr('d', circle.endAngle(endAngle * end));
            }
            
            drawProgress(<?php echo $percent; ?>/100);
        </script>
    </body>
</html>