<?php
$id = $_GET['id'];
echo "<script>console.log('$id')</script>";
$file = @file_get_contents("https://hivaind.ir/ALR/wil/getlogid.php?id=$id");
$has_alarm = 0;
if($file != false){
    $info_alarm = json_decode($file);
    echo "<script>console.log('$file')</script>";
    if(!isset($info_alarm->error)){
        if(isset($info_alarm->status)){
            echo "<script>alert('No alarm has been sent in the last month')</script>";
        }else{
            $alarm = array();
            $input = array("inputB", "inputC", "inputD");
            $msg = array("3", "0", "-");
            for($i=0; $i<3; $i++){
                for($j=0; $j<3; $j++){
                    $alarm[$input[$i]][$msg[$j]] = 0;
                }
            }
            $labels = json_decode(@file_get_contents("https://hivaind.ir/DashManage/label.php?id=$id"));
            echo "<script>console.log('".json_encode($labels)."')</script>";
            $countB = 0; 
            $nameB = $labels->inputB;
            $countC = 0;
            $nameC = $labels->inputC;
            $countD = 0;
            $nameD = $labels->inputD;
            echo "<script>console.log('". $labels->inputB ."')</script>";
            foreach($info_alarm as $info){
                if($info->msg == "3" or $info->msg == "0" or $info->msg == "-"){
                    if($info->input == "inputB"){
                        $countB++;
                    }else if($info->input == "inputC"){
                        $countC++;
                    }else if($info->input == "inputD"){
                        $countD++;
                    }
                    $alarm[$info->input][$info->msg]++;
                }
            }
            if($countB == 0 and $countC == 0 and $countD == 0){
                echo "<script>alert('No alarm has been sent in the last month')</script>";
            }
        }
    }else{
        echo "<script>alert('The alarm has not been activated for this device')</script>";
    }
}else{
    echo "<script>alert('please try again...')</script>";
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../assets/css/style.css">
        <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
        <title>Alarm Reporting</title>
        <style>
            #chartdivB {
              width: 100%;
              max-width:100%;
              height: 500px;
            }
            #chartdivC {
              width: 100%;
              max-width:100%;
              height: 500px;
            }
            #chartdivD {
              width: 100%;
              max-width:100%;
              height: 500px;
            }
            .bg-color{
                background: rgb(108, 114, 147, 0.2);
            }
        </style>
    </head>
    <body>
        <div class="row mt-5">
            <div class="col-12">
                <!--<p class="text-light fs-5">id:<?php echo " ". $id;?></p>-->
                <div class="row justify-content-center">
                <?php if($countB != 0){?>
                    <div class="col-10 col-sm-10 col-md-8 col-lg-5 rounded bg-color m-2 p-4">
                        <p class="text-light fs-5"><?php echo $nameB;?></p>
                        <div id="chartdivB"></div>
                    </div>
                <?php }
                if($countC != 0){?>
                    <div class="col-10 col-sm-10 col-md-8 col-lg-5 rounded bg-color m-2 p-4">
                        <p class="text-light fs-5"><?php echo $nameC;?></p>
                        <div id="chartdivC"></div>
                    </div>
                <?php }
                if($countD != 0){ ?>
                    <div class="col-10 col-sm-10 col-md-8 col-lg-5 rounded bg-color m-2 p-4">
                        <p class="text-light fs-5"><?php echo $nameD;?></p>
                        <div id="chartdivD"></div>
                    </div>
                <?php }?>
                </div>
            </div>
        </div>
                
        
        <script>
            <?php if($countB != 0){?>
                showChart("B", "<?php echo $alarm['inputB']['-'];?>", "<?php echo $alarm['inputB']['3'];?>", "<?php echo $alarm['inputB']['0'];?>");
            <?php }
            if($countC != 0){?>
                showChart("C", "<?php echo $alarm['inputC']['-'];?>", "<?php echo $alarm['inputC']['3'];?>", "<?php echo $alarm['inputC']['0'];?>");
            <?php }
            if($countD != 0){ ?>
                showChart("D", "<?php echo $alarm['inputD']['-'];?>", "<?php echo $alarm['inputD']['3'];?>", "<?php echo $alarm['inputD']['0'];?>");
            <?php }?>
            function showChart(input, dis, max, min){
                var root = am5.Root.new("chartdiv"+input); 
                root.setThemes([
                    am5themes_Animated.new(root)
                ]);
                root.interfaceColors.set("text", am5.color(0xffffff));
                var chart = root.container.children.push(
                    am5percent.PieChart.new(root, {
                        endAngle: 270,
                        layout:root.verticalLayout,
                        innerRadius: am5.percent(60)
                    })
                );
                var series = chart.series.push(
                    am5percent.PieSeries.new(root, {
                        valueField: "value",
                        categoryField: "category",
                        endAngle: 270
                    })
                );
                series.set("colors", am5.ColorSet.new(root, {
                    colors: [
                        am5.color(0xdc3545),
                        am5.color(0x0dcaf0),
                        am5.color(0xfd7e14)
                    ]
                }))
                series.slices.template.setAll({
                    strokeWidth: 1,
                    stroke: am5.color(0xffffff),
                    cornerRadius: 10,
                    shadowOpacity: 0.1,
                    shadowOffsetX: 2,
                    shadowOffsetY: 2,
                    shadowColor: am5.color(0xffffff),
                    fillPattern: am5.GrainPattern.new(root, {
                        maxOpacity: 0.2,
                        density: 0.5,
                        colors: [am5.color(0xffffff)]
                    })
                })
                series.slices.template.states.create("hover", {
                    shadowOpacity: 1,
                    shadowBlur: 10
                })
                
                series.ticks.template.setAll({
                    strokeOpacity:0.4,
                    strokeDasharray:[2,2]
                })
                series.states.create("hidden", {
                    endAngle: -90
                });
                series.labels.template.set("visible", false);
                series.ticks.template.set("visible", false);
                series.data.setAll([{
                    category: "More than the allowed range َ",
                    value: parseInt(max)
                }, {
                    category: "Less than the allowed range",
                    value: parseInt(min)
                }, {
                    category: "Device disconnection",
                    value: parseInt(dis)
                }]);
                var legend = chart.children.push(am5.Legend.new(root, {
                    centerX: am5.percent(50),
                    x: am5.percent(50),
                    marginTop: 15,
                    marginBottom: 15,
                }));
                legend.markerRectangles.template.adapters.add("fillGradient", function() {
                    return undefined;
                }) 
                legend.data.setAll(series.dataItems);
                series.appear(1000, 100);
            }
        </script>
    </body>
</html>