<?php
include("../classes/header.php");
include("../URL/url.inc");
include ("../includes/access.inc.php");
if(isset($_GET['action']) and $_GET['action']="logout"){
    logout();
}
$username = $_GET['user'];
// echo "<script>console.log('$username')</script>";

$api_url = "http://hivaind.ir/property/user-check.php?usr=" . strval($username);
$json = @file_get_contents($api_url);
if($json == "" or $json == FALSE){
    echo "<script>alert('The server is being updated')</script>";
}

$allIdForUser = json_decode($json);
$ids = array();
$ids_notSort = array();
$status = false;
if (isset($allIdForUser->status) && $allIdForUser->status == "clientID not found") {
    $countOfId = 0;
} else if(is_array($allIdForUser)) {
    $countOfId = count($allIdForUser);
}else{
    $countOfId = 0;
}
$device = array();
 
if ($countOfId > 0) {
    date_default_timezone_set("Asia/Tehran");
    $timeNow = intval(mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('Y')));
    foreach ($allIdForUser as $id) {
        // echo "<script>console.log('".json_encode($id)."')</script>";
        $inputs = array();
        foreach ($id->input as $in) {
            array_push($inputs, strval($in));
        }
        $sensors = array();
        foreach ($id->sensor as $sen) {
            array_push($sensors, strval($sen));
        }
        $file = @file_get_contents("https://hivaind.ir/wil/arrayjsonv4.php?tname=test81mini&row=1&id=".$id->id."&in=time_date");
        $time = json_decode($file)->time_date;
        $timeDate = $time[0];
        $lastDate = mktime(intval(substr($timeDate, 11, 2)),
                    intval(substr($timeDate, 14, 2)),
                    intval(substr($timeDate, 17, 2)),
                    intval(substr($timeDate, 5, 2)),
                    intval(substr($timeDate, 8, 2)),
                    intval(substr($timeDate, 0, 4)));
        $condition = ($timeNow - $lastDate);
        if ($condition <= 600){
            $status = true;
        } else {
            $status = false;
        }
        $clientID = strval($id->id);
        $apiLabel_url = "https://hivaind.ir/DashManage/label.php?id=" . $clientID;
        $apiLabel_json = @file_get_contents($apiLabel_url);
        $apiLabel = json_decode($apiLabel_json);
        $device_id = $apiLabel->clientID;
        echo "<script>console.log('deviceID',".json_encode($device_id).");</script>";

        $arr = array(
            "id" => $id->id,
            "input" => array_reverse($inputs),
            "sensor" => $sensors,
            "status" => $status,
            "row" => $apiLabel
        );
        array_push($ids_notSort, $arr);
    }
    foreach ($ids_notSort as $id) {
        if ($id["status"]) {
            array_push($ids, $id);
        }
    }
    foreach ($ids_notSort as $id) {
        if (!$id["status"]) {
            array_push($ids, $id);
        }
    }
   
}
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>DASHBOARD</title>
        <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
        <style>
            html,body{
                overflow: hidden;
                height: 100%;
                width:100%;
            }
        </style>
        <script src="./js/scriptoverview.js?v=2"></script>
        <script src="../../jquery.min.js"></script>
    </head>
    <body>
        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand"><img src="../assets/images/hoshiLogo.png"alt="logo"  style="width:50px;"/></a>
                <div class="text-light">
                    <?php echo $username;?>
                </div>
            </div>
        </nav>
        <div class="row justify-content-center">
            <?php foreach($ids as $id){
            ?>
            <div class="col-5 col-sm-4 col-md-3 col-lg-2 shadow rounded-3 m-1 p-2" style="border-style: solid; height:110px; <?php if($id["status"]){?> border-color: #198754; <?php }else{?> border-color: #dc3545;<?php }?>">
                <div class="d-flex justify-content-between" style="clear: both; font-size:11px; overflow:hidden; white-space: nowrap; display: inline-block;">
                    <div style="font-size:11px;" class="fw-bold text-light">
                        <?php if ($id["row"] != null) {
                                $thisIdRow = $id["row"];
                                if ($thisIdRow->deviceName != null && $thisIdRow->deviceName != ""){
                                    echo $thisIdRow->deviceName;
                                }else{
                                    echo "System";
                                }
                            }else{
                                echo "System";
                            }?>
                    </div>
                    <p style="color: #ffffff; font-size:11px;"><?php echo $thisIdRow->clientID; ?></p>
                </div>
                <div class="col-12">
                    <div class="w-100 bg-secondary mb-1" style='height:1px'></div>
                </div>
                <?php if($id["input"]!=null){
                        $json_last_url = @file_get_contents("https://hivaind.ir/wil/loglastjson81.php?id=" . $id["id"]);
                        $datasForthisId = json_decode($json_last_url);
                        $json_last_url = @file_get_contents("https://hivaind.ir/ALR/wil/Edit-configAPI.php?id=" . $id["id"]);
                        // echo "<script>console.log('".$json_last_url."')</script>";
                        $editconfig = json_decode($json_last_url);
                        foreach ($id["input"] as $in) {
                            $in_name = substr($in, 5, 1);
                            $min_name = 'min'.$in_name;
                            $max_name = 'max'.$in_name;
                            $min = $editconfig->$min_name;
                            $max = $editconfig->$max_name;
                        ?>
                <div class="d-flex text-light" style="font-size:12px;">
                    <?php $thisInputValue = floatval(floatval($datasForthisId->$in) / 100);?>
                    <div class="w-100">
                        <?php
                        if ($id["row"] != null) {
                            $thisIdRow = $id["row"];
                            if ($thisIdRow->$in != null) {
                                echo $thisIdRow->$in;
                            } else {
                                echo $in .": ";
                            }
                        }else{
                            echo $in .": ";
                        }
                        ?>
                    </div>
                    <div class="flex-shrink-1 fw-bold" id="<?php echo $id["id"].''.$in?>" style="<?php if(empty($editconfig->status)){if($thisInputValue<$min){echo "color:#0d6efd";}else if($thisInputValue>$max){echo "color:#dc3545";}}?>">
                        <?php if ($thisInputValue < -90) {
                          }else{
                            echo $thisInputValue;
                          }?>
                    </div>
                </div>
                <?php } ?>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
    </body>
</html>