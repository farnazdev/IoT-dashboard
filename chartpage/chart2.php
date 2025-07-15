<?php
$data = TRUE;
$userId = $_GET['id'];
$inputName = $_GET['in'];
$downSampling = 10;


$file = @file_get_contents("https://hivaind.ir/wil/arrayjsonv4.php?tname=test81mini&row=1&id=".$id->id."&in=time_date");
if($file == "" or $file == FALSE){
    $file = @file_get_contents("https://hivaindbackup.ir/wil/arrayjson.php?row=1&id=". $id->id ."&in=time_date");
}
date_default_timezone_set("Asia/Tehran");
$nowDate = date("mdHi");
$time = json_decode($file)->time_date;
$timeDate = $time[0];
$lastDate = date("mdHi", strtotime($timeDate));
$condition = ($nowDate - $lastDate);
if ($condition <= 7){
    $status = "connected";
} else {
    $status = "disconnected";
}



$json_user = @file_get_contents('http://hivaind.ir/property/jsonIDproperty.php?id=' . $userId);
if($json_user != false){
    $user = json_decode($json_user);
    $zero = "0";
    $username = strtolower($user->$zero->usr);
    $data = json_decode(@file_get_contents("https://hivaind.ir/DashManage/label.php?id=" . $userId));
    $inputValue = $data->$inputName;
}
//------------CHART DATA ------------
$input = array();
$inputjson = @file_get_contents("http://hivaind.ir/wil/arrayjsonv2.php?tname=test81mini&row=90000&id=" . $userId . "&in=" . $inputName);
include "../includes/func.inc.php";
if($inputjson != false){
    $input = json_decode($inputjson)->$inputName;
    $last = $input[0];
    $min = $last;
    $max = $last;
    $total = 0;
    $number = 0;
    $countData = count($input) * 10;
    echo "<script>console.log('".count($input)."')</script>";
    $time = json_decode(@file_get_contents("http://hivaind.ir/wil/arrayjsonv2.php?tname=test81mini&row=" . $countData . "&id=" . $userId . "&in=time_date"))->time_date;
    echo "<script>console.log('".count($time)."')</script>";
    if($time != null and $input != null) {
        $in = array();
        $td = array();
        $ms = array();
        $h = array();
        $j=0;
        for($i=0; $i < count($time); $i = $i + $downSampling){
            if($min > $input[$i] and $input[$i] > -9000){
                $min = $input[$i];
            }else if($max < $input[$i] and $input[$i] > -9000){
                $max = $input[$i];
            }
            if($input[$i] > -9000){
                $total += $input[$i];
                $number++;
            }
            array_push($in,$input[$i]);
            array_push($td,$time[$i]);
            array_push($ms,mktime(substr($time[$i], 11, 2), 
                                  substr($time[$i], 14, 2), 
                                  substr($time[$i], 17, 2), 
                                  substr($time[$i], 5 , 2), 
                                  substr($time[$i], 8 , 2), 
                                  substr($time[$i], 0 , 4)) * 1000);
            array_push($h, substr($time[$i], 11, 2));
        }
        $in = array_reverse($in);
        $td = array_reverse($td);
        $ms = array_reverse($ms);
        $h = array_reverse($h);
        $datas = array();
        if($in[0] <-9000){
            $i=1;
            while($in[$i]<-9000){
                $i++;
                if($i == count($in)){
                    $i--;
                    break;
                }
            }
            //-99.99
            $arr = array("date" => $ms[0],
                        "value" => floatval($in[$i]/100),
                        "shamsi" => miladiBeShamsi(substr($td[0], 0, 4),
                                                      substr($td[0], 5, 2),
                                                      substr($td[0], 8, 2),
                                                      "/") . substr($td[0], 10, 9),
                        "strokeSettings" => array(
                            "stroke" => "#dc3545",
                            "strokeDasharray" => [4,4]));
            array_push($datas, $arr);
        }
        for($i=0; $i <count($in)-1; $i++){
            if($h[$i] >= 6 and $h[$i] <= 20){
                $color = "#dc8c67";
            }else{
                $color = "#804d91";
            }
            if($in[$i]>-9000){
                if($in[$i+1]<-9000){
                    //-99.99
                    $arr = array("date" => $ms[$i],
                                    "value" => floatval($in[$i]/100),
                                    "shamsi" => miladiBeShamsi(substr($td[$i], 0, 4),
                                                              substr($td[$i], 5, 2),
                                                              substr($td[$i], 8, 2),
                                                              "/") . substr($td[$i], 10, 9),
                                    "strokeSettings" => array(
                                        "stroke" => "#dc3545",
                                        "strokeDasharray" => [4,4])
                                    );
                }else{ 
                    if($ms[$i+1]-$ms[$i] > 90000*$downSampling){
                        //disconnect
                        $arr = array("date" => $ms[$i],
                                    "value" => floatval($in[$i]/100),
                                    "shamsi" => miladiBeShamsi(substr($td[$i], 0, 4),
                                                              substr($td[$i], 5, 2),
                                                              substr($td[$i], 8, 2),
                                                              "/") . substr($td[$i], 10, 9),
                                    "strokeSettings" => array(
                                        "stroke" => "#ffffff",
                                        "strokeDasharray" => [4,4])
                                    );
                    }else{
                        //connect
                        $arr = array("date" => $ms[$i],
                                    "value" => floatval($in[$i]/100),
                                    "shamsi" => miladiBeShamsi(substr($td[$i], 0, 4),
                                                             substr($td[$i], 5, 2),
                                                             substr($td[$i], 8, 2),
                                                             "/") . substr($td[$i], 10, 9),
                                    "strokeSettings" => array(
                                        "stroke" => $color,
                                        "strokeDasharray" => [5,0]  
                                    )
                            );
                    }
                }
                array_push($datas, $arr);
            }
            
        }
    }
    $dataCount = count($h);
    $avg = $total / $number;
}

$time = date('h:i:s');
$date = date('Y/m/d');

?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1 ,user-scalable=no">
        <title>chart tables</title>
        <link rel="stylesheet" href="./assets/css/bootstrap.css">
        <script src="./assets/js/bootstrap.bundle.js"></script>
        <link rel="shortcut icon" href="./images/favicon.png">
        <style>
            html{
                overflow-x:hidden;
            }
            @media only screen and (min-width: 768px) {
                #chart{
                    width: 100%; 
                    height: 450px;
                    margin-bottom: 200px;
                }
                #mobile{
                    display:none;
                }
                #nomobile{
                    display:block;
                }
            }
            @media only screen and (max-width: 767px) {
                #chart{
                    width:100%;
                    height:300px;
                }
                #mobile{
                    display:block;
                }
                #nomobile{
                    display:none;
                }
            }
            .button:hover{
                background-color: #212529;
            }
            .button:focus{
                background-color: #212529;
            }
            .bg-color{
                background:#191c24;
            }
            .bg-color-dark{
                background:#14151b;
            }
            .bcbox{
                background:rgb(108, 114, 147, 0.2);
            }
            .inputs::placeholder{
                color:#fff;
            }
        </style>
    </head>
    <body class="bg-color-dark">
        <div class="row shadow mb-3">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 bg-color pb-2">
                <div class="d-flex justify-content-between">
                    <div class="d-flex justify-content-start">
                        <svg width="30" height="30" fill="currentColor" class="bi bi-link-45deg mt-3 ms-3 <?php if(status==="disconnected"){ echo "text-danger"; }else{echo "text-success";}?>" viewBox="0 0 16 16" >
                            <path d="M4.715 6.542 3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1.002 1.002 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4.018 4.018 0 0 1-.128-1.287z"/>
                            <path d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 1 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 1 0-4.243-4.243L6.586 4.672z"/>
                        </svg>
                        <div class="dropdown">
                            <button class="btn button mt-2 dropdown-toggle text-light" type="button" data-bs-toggle="dropdown" aria-expanded="false" id='username'>
                                <?php echo $username; ?>
                            </button>
                            <ul class="dropdown-menu bg-dark">
                                <li class="dropdown-item text-light button">ID: <?php echo $userId; ?></li>
                                <li class="dropdown-item text-light button"><?php echo $inputValue;?></li>
                            </ul>
                        </div>
                        <button type="button" onclick="ShowPoints()" class="btn btn-dark mt-2 shadow rounded-3 button bcbox">Show/Hide Points</button>
                        <button type="button" onclick="downloadChartImage()" class="btn btn-dark mt-2 shadow rounded-3 button bcbox">export</button>
                    </div>
                    <div class=" d-none d-sm-block">
                        <div class="d-flex justify-content-end mt-3">
                            <svg width="16" height="16" fill="white" class="bi bi-calendar2-minus mt-1 me-3" viewBox="0 0 16 16">
                                <path d="M5.5 10.5A.5.5 0 0 1 6 10h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z"/>
                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
                                <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4z"/>
                            </svg>
                            <div class="text-light me-3" id="dateToday"></div>
                            <div class="text-light me-3" id="timeToday"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>       
        <div class="position-relative top-0 start-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="shadow rounded-3">
                        <div id="chart"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-none d-sm-none d-md-block">
            <div class="row justify-content-center fixed-bottom mb-3">
                <div class="col-12 col-sm-6 col-md-2 col-lg-2">
                    <div class="rounded-3 p-2 bg-color text-light">
                        <p>Count</p>
                        <p class="text-center fs-1" style="color:#fca500"><?php echo count($td);?></p>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-2 col-lg-2">
                    <div class="rounded-3 p-2 bg-color text-light">
                        <p>Last</p>
                        <p class="text-center fs-1" style="color:#6eaea1"><?php echo floatval($last/100);?></p>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-2 col-lg-2">
                    <div class="rounded-3 p-2 bg-color text-light">
                        <p>Minimum</p>
                        <p class="text-center fs-1"  style="color:#4199FD"><?php echo floatval($min/100);?></p>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-2 col-lg-2">
                    <div class="rounded-3 p-2 bg-color text-light">
                        <p>Maximum</p>
                        <p class="text-center fs-1" style="color:#E10600"><?php echo floatval($max/100);?></p>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-2 col-lg-2">
                    <div class="rounded-3 p-2 bg-color text-light">
                        <p>Average</p>
                        <p class="text-center fs-1" style="color:#0E9F56"><?php echo number_format(floatval($avg/100),2);?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-block d-sm-block d-md-none" id="exportdiv">
            <div class="row justify-content-center fixed-bottom">
                <div class="col-5">
                    <div class="rounded-3 text-light">
                        <div class="d-flex fs-3">
                            <p>Count:</p>
                            <p class="text-center ms-2" style="color:#fca500"><?php echo count($td);?></p>
                        </div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="rounded-3 text-light">
                        <div class="d-flex fs-3">
                            <p>Last:</p>
                            <p class="text-center ms-2" style="color:#6eaea1"><?php echo floatval($last/100);?></p>
                        </div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="rounded-3 text-light">
                        <div class="d-flex fs-3">
                            <p>Min:</p>
                            <p class="text-center ms-2"  style="color:#4199FD"><?php echo number_format(floatval($min/100),2);?></p>
                        </div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="rounded-3 text-light">
                        <div class="d-flex fs-3">
                            <p>Max:</p>
                            <p class="text-center ms-2" style="color:#E10600"><?php echo number_format(floatval($max/100),2);?></p>
                        </div>
                    </div>
                </div>
                <div class="col-10">
                    <div class="rounded-3 text-light">
                        <div class="d-flex fs-3">
                            <p>Average</p>
                            <p class="text-center ms-2" style="color:#0E9F56"><?php echo number_format(floatval($avg/100),2);?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="./assets/js/index.js"></script>
        <script src="./assets/js/xy.js"></script>
        <script src="./assets/js/Animated.js"></script>
        <script src="./assets/js/Chart.js"></script>
        <script src="./assets/js/jquery.js"></script>
        <script src="./script.js?v=1"></script>
        <script src="./assets/js/exporting.js"></script>
        <script type='text/javascript'>
            var points=false;
            var chart;
            var series;
            var root = am5.Root.new("chart");
                // Set themes
                // https://www.amcharts.com/docs/v5/concepts/themes/
                root.setThemes([
                    am5themes_Animated.new(root)
                ]);
            
                root.interfaceColors.set("text", am5.color(0xffffff));
                root.interfaceColors.set("grid", am5.color(0xadadad));
                            
                //console.log(dataset);
                // Create chart
                // https://www.amcharts.com/docs/v5/charts/xy-chart/
                chart = root.container.children.push(
                    am5xy.XYChart.new(root, {
                        panX: false,
                        panY: false,
                        wheelX: "panX",
                        wheelY: "zoomX",
                    })
                );
                // Add cursor
                // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
                var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
                  behavior: "zoomX"
                }));
                cursor.lineY.set("visible", true);
            
                // Create axes
                // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
                var xAxis = chart.xAxes.push(
                    am5xy.DateAxis.new(root, {
                        maxDeviation: 0.1,
                        groupData: true,
                        baseInterval: {
                        timeUnit: "second",
                        count: 1
                        },
                        renderer: am5xy.AxisRendererX.new(root, {
                        minGridDistance: 50
                        }),
                        // tooltip: am5.Tooltip.new(root, {})
                    })
                );
            
                var yAxis = chart.yAxes.push(
                    am5xy.ValueAxis.new(root, {
                        maxDeviation: 0.1,
                        renderer: am5xy.AxisRendererY.new(root, {})
                    })
                );
            
            chart.set("scrollbarX", am5.Scrollbar.new(root, {
                  orientation: "horizontal"
                }));
        function createSeries(data) {
            series = chart.series.push(am5xy.LineSeries.new(root, {
              name: '<?php echo $_GET['in']?>',
              xAxis: xAxis,
              yAxis: yAxis,
              valueYField: "value",
              valueXField: "date",
              tooltip: am5.Tooltip.new(root, {
                    pointerOrientation: "horizontal",
                    getFillFromSprite: false,
                    labelText: "{name}:\n({valueY})\n {shamsi} "
              })
            }));
          
            series.strokes.template.setAll({
                    strokeWidth: 1,
                    templateField: "strokeSettings"
                });
          
            series.get("tooltip").label.set("text", "[bold]{name}[/]\n{valueX.formatDate()}: {valueY}")
            series.data.setAll(data);
            series.appear(1000, 100);
        }
            createSeries(<?php echo json_encode($datas); ?>);    
            function ShowPoints(){
                console.log("show points");
                if(!points){
                    points=true;
                    series.bullets.push(function(root) {
                        return am5.Bullet.new(root, {
                            sprite: am5.Circle.new(root, {
                                radius: 3,
                                fill: series.get("fill"),
                                fill:am5.color(0x202123),
                                stroke: am5.color(0xffffff),
                                pointerOrientation: "vertical",
                                strokeWidth: 1
                            })
                        });
                    });
                }else{
                    points=false;
                    series.bulletsContainer.children.clear();
                    series.bullets.clear();
                }
            }
            function downloadChartImage() {
                        var exporting = am5plugins_exporting.Exporting.new(root, {
                            filePrefix: "myChart",
                            pdfOptions: {
                                includeData: true,
                                addURL: false
                            }
                        });
                        exporting.events.on("pdfdocready", function(event) {

                          // Add title to the beginning
                          event.doc.content.unshift({
                            text: "<?php if($_GET['in'] == "temp"){echo "temperature";}else{echo "humidity";}?>",
                            margin: [0, 30],
                            style: {
                              fontSize: 25,
                              bold: true,
                            }
                          });
                          // Add logo
                          event.doc.content.unshift({
                            image: "data:image/png;base64,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",
                            fit: [119, 54]
                          });
                        
                        });
                        exporting.events.on("pdfdocready", function(event) {

                          // ...
                        
                          // Add a two-column intro
                          event.doc.content.push({
                            alignment: 'justify',
                            columns: [{
                              text: 'Count:'
                            }, {
                              text: 'Last Data:'
                            }, {
                              text: 'Minimum:'
                            }, {
                              text: 'Maximum:'
                            }, {
                              text: 'Average:'
                            }],
                            columnGap: 30,
                            margin: [10, 10],
                            style: {
                              color: "#3b3b3b"
                            }
                          });
                          event.doc.content.push({
                            alignment: 'center',
                            columns: [{
                              text: '<?php echo count($td) ?>'
                            }, {
                              text: '<?php echo floatval($last/100);?>'
                            }, {
                              text: '<?php echo floatval($min/100);?>'
                            }, {
                              text: '<?php echo floatval($max/100);?>'
                            }, {
                              text: '<?php echo number_format(floatval($avg/100),2);?>'
                            }],
                            columnGap: 10,
                            margin: [0, 10],
                            style: {
                              fontSize: 20,
                              color: "#000"
                            }
                          });
                        
                        });
                        exporting.download("pdf");
                    }
        </script>
    </body>
</html>