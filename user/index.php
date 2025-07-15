<?php
include("../classes/header.php");
include("../URL/url.inc");
include ("../includes/access.inc.php");
if(isset($_GET['action']) and $_GET['action']="logout"){
    logout();
}
if(!isset($_COOKIE['login'])){
    logout();  
}
$username = $_COOKIE['login']; 
// echo "<script>console.log('".getenv("REMOTE_ADDR")."')</script>";
include "../includes/db.inc.php"; 
echo "<script>console.log('username: ',".json_encode($username).");</script>";
$allInOne_url = "https://hivaind.ir/wil/allDataUser.php?usr=" . $username; 
$allInOne_json = @file_get_contents($allInOne_url);
$allData = json_decode($allInOne_json, true);
echo "<script>console.log('data: ',".json_encode($allInOne_url).");</script>";
$api_status = $allData['status'];  //{"status":"User not found"}

$clientIDs = [];
$activeInputs = [];
foreach ($allData as $data) {
    if (isset($data['clientID'])) {
        $clientID = (string)$data['clientID'];
        $clientIDs[] = $clientID;
        $activeInputs[$clientID] = $data['active_input'];
        $deviceNames[$clientID] = $data['labels']['deviceName'];   
        
        foreach($activeInputs[$clientID] as $activeInput){
            
            $lastLogValues[$clientID][$activeInput] = $data['lastData'][$activeInput] / 100;
            $activeInputName[$clientID][$activeInput] = $data['labels'][$activeInput];
            
            $inputs[$clientID][$activeInput] = substr($activeInput, 5,1);
            $min_Inputs[$clientID][$activeInput] = $data['config']['min' . $inputs[$clientID][$activeInput]];
            $max_Inputs[$clientID][$activeInput] = $data['config']['max' . $inputs[$clientID][$activeInput]];
            $enable_Inputs[$clientID][$activeInput] = $data['config']['en' . $inputs[$clientID][$activeInput]];
            $enable_devices[$clientID] = $data['config']['enDevice'];
        }
        
        $timeNow = intval(mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('Y')));
        $lastLogTimes[$clientID] = $data['time_date'];
        $lastTime[$clientID] = strtotime($lastLogTimes[$clientID]);
        $condition[$clientID] = $timeNow - $lastTime[$clientID];
        if($condition[$clientID] >= 600){
            $status[$clientID] = false;
        }else{
            $status[$clientID] = true;
        }
         
    }
}
// echo "<script>console.log('mins: ',".json_encode($min_Inputs).");</script>";
// echo "<script>console.log('maxs: ',".json_encode($max_Inputs).");</script>";
// echo "<script>console.log('ens: ',".json_encode($enable_Inputs).");</script>";
// echo "<script>console.log('en_device: ',".json_encode($enable_devices).");</script>";

// number of devices
if($status == "clientID not found"){
    $countOfIds = 0;
}else{
    $countOfIds = count($clientIDs);
}

// devices' images
$device = array();
if($countOfIds > 0){
    date_default_timezone_set("Asia/Tehran");
    foreach($clientIDs as $clientID){
        try{
            $s = $pdo->prepare("select device from idsdevice where clientid=:id");
            $s->bindValue(":id" , $clientID);
            $s-> execute();
        }catch(PDOException $e){
            echo "error in select data".$e->getMessage();
            exit();
        }
        if($s->rowCount() > 0){
            $device = $s->fetch();
            try{
                $s = $pdo->prepare("select picture from devices where devicename=:device");
                $s->bindValue(":device", $device['device']);
                $s->execute();
            }catch(PDOException $e){
                echo "error in select data".$e->getMessage();
                exit();
            }
            $result = $s ->fetch();
            $devices[$clientID] = $result['picture'];
        }else{
            $devices[$clientID] = "";
        }
    }
    // echo "<script>console.log(".json_encode($devices).");</script>";
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>USER DASHBOARD | Hoshi</title>
    <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../assets/css/style.css"> 
    <link rel="shortcut icon" href="../assets/images/favicon.png"/>
    <script src="../assets/jsforallpage/blink.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./js/script.js?v=115"></script>
<body>
<div class="container-scroller">
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
            <a class="sidebar-brand brand-logo"><img src="../assets/images/hoshiLogo.png"alt="logo"/></a>
            <a class="sidebar-brand brand-logo-mini"><img src="../assets/images/hoshiLogo-mini.png" alt="logo"/></a>
        </div>
        <ul class="nav">
            <li class="nav-item profile">
                <div class="profile-desc">
                    <div class="profile-pic">
                        <div class="count-indicator">
                            <form method="post" name="uploadImage">
                                <a class="btn" href="./upload.php">
                                    <img class="img-xs rounded-circle " src="../assets/images/faces/download.png" alt="">
                                </a>
                            </form>
                        </div>
                        <div class="profile-name">
                            <h5 class="mb-0 font-weight-normal"><?php echo $username; ?></h5>
                            <span id="cname">Client Name</span>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item nav-category">
                <div class="profile-name d-flex flex-row">
                    <span class="nav-link" id="countid">Count Of IDs:</span>
                    <span class="nav-link text-white"><?php echo count($clientIDs); ?></span>
                </div>
            </li>
            <li class="nav-item menu-items">
                <a class="nav-link" href="../alarm/register.php?user=<?php echo $username;?>&page=user" target="_blank">
                    <span class="menu-icon">
                        <svg width="16" height="16" fill="#ffc107" class="bi bi-person" viewBox="0 0 16 16">
                          <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/>
                        </svg>
                    </span>
                    <span class="menu-title" id="profile">Profile</span>
                </a>
            </li>
            <li class="nav-item menu-items">
                <a class="nav-link" href="../support/?user=<?php echo $username;?>" target="_blank">
                    <span class="menu-icon">
                        <svg width="16" height="16" fill="#0d6efd" viewBox="0 0 50 50">
                            <rect fill="none" height="50" width="50"/>
                            <path d="M44,20c0-1.104-0.896-2-2-2s-2,0.896-2,2  c0,0.476,0,14.524,0,15c0,1.104,0.896,2,2,2s2-0.896,2-2C44,34.524,44,20.476,44,20z" stroke="#0d6efd" stroke-miterlimit="10" stroke-width="2"/><path d="M28,47c1.104,0,2-0.896,2-2s-0.896-2-2-2  c-0.476,0-4.524,0-5,0c-1.104,0-2,0.896-2,2s0.896,2,2,2C23.476,47,27.524,47,28,47z" stroke="#0d6efd" stroke-miterlimit="10" stroke-width="2"/>
                            <path d="M8,19C8,9.611,15.611,2,25,2s17,7.611,17,17" stroke="#0d6efd" stroke-miterlimit="10" stroke-width="2"/><path d="M44,20c2.762,0,5,3.357,5,7.5  c0,4.141-2.238,7.5-5,7.5" stroke="#0d6efd" stroke-miterlimit="10" stroke-width="2"/>
                            <path d="M6,20c0-1.104,0.896-2,2-2s2,0.896,2,2  c0,0.476,0,14.524,0,15c0,1.104-0.896,2-2,2s-2-0.896-2-2C6,34.524,6,20.476,6,20z" stroke="#0d6efd" stroke-miterlimit="10" stroke-width="2"/<path d="M6,20c-2.761,0-5,3.357-5,7.5  C1,31.641,3.239,35,6,35" stroke="#0d6efd" stroke-miterlimit="10" stroke-width="2"/><path d="M42,37c0,5-3,8-8,8h-4" stroke="#0d6efd" stroke-miterlimit="10" stroke-width="2"/>
                        </svg>
                    </span>
                    <span class="menu-title" id="support">support</span>
                </a>
            </li>
            <li class="nav-item menu-items">
                <a class="nav-link" href="./overview.php?user=<?php echo $username;?>" target="_blank">
                    <span class="menu-icon">
                        <svg width="16" height="16" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                          <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                          <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2"/>
                          <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z"/>
                        </svg>
                    </span>
                    <span class="menu-title" id="support">overview</span>
                </a>
            </li>
        </ul>
    </nav>
    <div class="container-fluid page-body-wrapper">
        <nav class="navbar p-0 fixed-top d-flex flex-row">
            <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
                <a class="navbar-brand brand-logo-mini" href="../../index.php"><img
                            src="../assets/images/hoshiLogo-mini.png"
                            alt="logo"/></a>
            </div>
            <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="mdi mdi-menu"></span>
                </button>
                <ul class="navbar-nav w-100">
                    <li class="nav-item w-100">
                        <div class="nav-link mt-2 mt-md-0 d-none d-lg-flex ">
                            <div class="form-control d-flex align-items-stretch " id="timeDateContainer">
                                <i class="mdi mdi-calendar-today d-none d-sm-block text-warning px-2" id="calender"></i>
                                <div class=" flex-grow d-flex ">
                                    <h5 class=" pl-4 text-light text-time" id="dateToday"></h5>
                                    <h5 class="text-warning" style="padding-right:5px; padding-left:5px;"> | </h5>
                                    <h5 class="text-light text-time" id="timeToday"></h5>
                                </div>
                                <span id="output" class="col-1 col-sm-0 text-time"> ⚡</span>
                                <script>
                                    blink("output", "⚡");
                                </script>
                            </div>
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item dropdown">
                        <a class="nav-link" id="profileDropdown" href="#" data-bs-toggle="dropdown">
                            <div class="navbar-profile">
                                <img class="img-xs rounded-circle" src="../assets/images/faces/download.png" alt="">
                                <p class="mb-0 d-none d-sm-block navbar-profile-name"><?php echo $username; ?></p>
                                <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                             aria-labelledby="profileDropdown">
                            <a class="dropdown-item preview-item" onclick="changePass('<?php echo $username;?>');">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-dark rounded-circle">
                                        <i class="mdi mdi-security text-success"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content" onclick="changePass('<?php echo $username;?>');">
                                    <p class="preview-subject mb-1"
                                       id="ddresetpassword">reset password</p>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item preview-item" onclick="changelang();">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-dark rounded-circle">
                                        <svg width="16" height="16" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                          <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41m-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9"/>
                                          <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5 5 0 0 0 8 3M3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <p class="preview-subject mb-1" id="lang">change language</p>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item preview-item" id="logout" href=".?action=logout">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-dark rounded-circle">
                                        <i class="mdi mdi-logout text-danger"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <p class="preview-subject mb-1" id="ddlogout">Log out</p>
                                </div>
                            </a>
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav navbar-nav-right d-lg-none">
                    <li class="nav-item dropdown">
                        <a class="nav-link" id="profileDropdown" href="#" data-bs-toggle="dropdown">
                            <div class="navbar-profile">
                                <span class="mdi mdi-format-line-spacing"></span>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                            <a class="dropdown-item preview-item" href="../alarm/register.php?user=<?php echo $username;?>&page=user">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-dark rounded-circle">
                                        <svg width="16" height="16" fill="#ffc107" class="bi bi-person" viewBox="0 0 16 16">
                                          <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <p class="preview-subject mb-1"
                                       id="mprofile">Profile</p>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item preview-item" href="../support/?user=<?php echo $username;?>">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-dark rounded-circle">
                                        <span class="menu-icon">
                                            <svg width="16" height="16" fill="#0d6efd" viewBox="0 0 50 50">
                                                <rect fill="none" height="50" width="50"/>
                                                <path d="M44,20c0-1.104-0.896-2-2-2s-2,0.896-2,2  c0,0.476,0,14.524,0,15c0,1.104,0.896,2,2,2s2-0.896,2-2C44,34.524,44,20.476,44,20z" stroke="#0d6efd" stroke-miterlimit="10" stroke-width="2"/><path d="M28,47c1.104,0,2-0.896,2-2s-0.896-2-2-2  c-0.476,0-4.524,0-5,0c-1.104,0-2,0.896-2,2s0.896,2,2,2C23.476,47,27.524,47,28,47z" stroke="#0d6efd" stroke-miterlimit="10" stroke-width="2"/>
                                                <path d="M8,19C8,9.611,15.611,2,25,2s17,7.611,17,17" stroke="#0d6efd" stroke-miterlimit="10" stroke-width="2"/><path d="M44,20c2.762,0,5,3.357,5,7.5  c0,4.141-2.238,7.5-5,7.5" stroke="#0d6efd" stroke-miterlimit="10" stroke-width="2"/>
                                                <path d="M6,20c0-1.104,0.896-2,2-2s2,0.896,2,2  c0,0.476,0,14.524,0,15c0,1.104-0.896,2-2,2s-2-0.896-2-2C6,34.524,6,20.476,6,20z" stroke="#0d6efd" stroke-miterlimit="10" stroke-width="2"/<path d="M6,20c-2.761,0-5,3.357-5,7.5  C1,31.641,3.239,35,6,35" stroke="#0d6efd" stroke-miterlimit="10" stroke-width="2"/><path d="M42,37c0,5-3,8-8,8h-4" stroke="#0d6efd" stroke-miterlimit="10" stroke-width="2"/>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                                <div class="preview-item-content" >
                                    <p class="preview-subject mb-1"
                                       id="msupport">support</p>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item preview-item" href="./overview.php?user=<?php echo $username;?>">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-dark rounded-circle">
                                        <span class="menu-icon">
                                            <svg width="16" height="16" fill="white" class="bi bi-journal-text" viewBox="0 0 16 16">
                                              <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                                              <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2"/>
                                              <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z"/>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                                <div class="preview-item-content" >
                                    <p class="preview-subject mb-1"
                                       id="msupport">overview</p>
                                </div>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="main-panel">
            <div class="content-wrapper">
                <?php foreach($clientIDs as $clientId){ ?>
                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="card rounded-1">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 my-2">
                                        <span><?php echo $deviceNames[$clientId]; ?></span>
                                    </div>
                                </div>
                                <div class="display-mode fold">
                                    <h4 class="card-title">
                                        <?php if($devices[$clientId] != ""){ ?>
                                        <img src="<?php echo "../imagesdevices/". $devices[$clientId]  ?>" alt"" style="width:100px; height:100px;" class="rounded-3">
                                        <?php } ?>
                                        <span name="ClientID" class="text-secondary">ID: <?php echo $clientId; ?></span>
                                    </h4>
                                    <h4 class=" d-flex flex-row justify-content-between">
                                       <?php if($status[$clientId] == true){?>
                                            <svg width="25" height="25" fill="currentColor" class="bi bi-link-45deg mt-2" viewBox="0 0 16 16" color="#00ff00">
                                                <path d="M4.715 6.542 3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1.002 1.002 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4.018 4.018 0 0 1-.128-1.287z"/>
                                                <path d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 1 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 1 0-4.243-4.243L6.586 4.672z"/>
                                            </svg>
                                  		<?php }else if($status[$clientId] == false){?>
                                            <svg width="25" height="25" fill="currentColor" class="bi bi-link-45deg mt-2" viewBox="0 0 16 16" color="#ff0000">
                                                <path d="M4.715 6.542 3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1.002 1.002 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4.018 4.018 0 0 1-.128-1.287z"/>
                                                <path d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 1 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 1 0-4.243-4.243L6.586 4.672z"/>
                                            </svg>
                                  		<?php } ?>	
                                  		<span class="decore pointer" >
                                            <?php $url = "https://avahiva.ir/chart.php?id=".$clientId."&user=".$username;?>
                                            <a class="decore  pointer link-underline-opacity-0" target="_blink" href="<?php echo $url; ?>">
                                                <svg width="16" height="16" fill="currentColor" class="bi bi-graph-up" viewBox="0 0 16 16">
                                                  <path fill-rule="evenodd" d="M0 0h1v15h15v1H0zm14.817 3.113a.5.5 0 0 1 .07.704l-4.5 5.5a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61 4.15-5.073a.5.5 0 0 1 .704-.07"/>
                                                </svg>
                                            </a>
                                        </span>
                                        <span class="decore pointer" >
                                            <?php $url = "https://hivaind.ir/ALR/wil/configMonitor.php?id=".$clientId;?>
                                            <a class="decore  pointer link-underline-opacity-0" target="_blink" href="<?php echo $url; ?>">
                                                <svg width="20" height="20" fill="white" class="bi bi-journal-text" viewBox="0 0 16 16">
                                                    <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                                                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
                                                    <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
                                                </svg>
                                            </a>
                                        </span>
                                        <span class="decore  pointer">
                                            <a class="link-underline-opacity-0" onclick="excel(<?php echo $clientId; ?>)">
                                                <svg viewBox="0 0 48 48" width="25px" height="25px">
                                                    <path fill="#169154" d="M29,6H15.744C14.781,6,14,6.781,14,7.744v7.259h15V6z"/>
                                                    <path fill="#18482a" d="M14,33.054v7.202C14,41.219,14.781,42,15.743,42H29v-8.946H14z"/>
                                                    <path fill="#0c8045" d="M14 15.003H29V24.005000000000003H14z"/>
                                                    <path fill="#17472a" d="M14 24.005H29V33.055H14z"/>
                                                    <g>
                                                        <path fill="#29c27f" d="M42.256,6H29v9.003h15V7.744C44,6.781,43.219,6,42.256,6z"/>
                                                        <path fill="#27663f" d="M29,33.054V42h13.257C43.219,42,44,41.219,44,40.257v-7.202H29z"/>
                                                        <path fill="#19ac65" d="M29 15.003H44V24.005000000000003H29z"/>
                                                        <path fill="#129652" d="M29 24.005H44V33.055H29z"/>
                                                    </g>
                                                    <path fill="#0c7238" d="M22.319,34H5.681C4.753,34,4,33.247,4,32.319V15.681C4,14.753,4.753,14,5.681,14h16.638 C23.247,14,24,14.753,24,15.681v16.638C24,33.247,23.247,34,22.319,34z"/>
                                                    <path fill="#fff" d="M9.807 19L12.193 19 14.129 22.754 16.175 19 18.404 19 15.333 24 18.474 29 16.123 29 14.013 25.07 11.912 29 9.526 29 12.719 23.982z"/>
                                                </svg>                             
                                            </a>
                                        </span>
                                        <i id="redirectLogin"></i>
                                        <span class="decore  pointer"><i class="mdi icon-size mdi-settings" onclick="setting(<?php echo $clientId; ?>)"></i></span>
                                    </h4>
                                </div>
                                <div class="row">
                                    <?php foreach($activeInputs[$clientId] as $activeInput){ ?>
                                    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body bg-card-sp rounded" style="<?php if($enable_devices[$clientId] == '1' and $enable_Inputs[$clientId][$activeInput] == '1' and $lastLogValues[$clientId][$activeInput] > '-99.00'){if($lastLogValues[$clientId][$activeInput]< $min_Inputs[$clientId][$activeInput]){echo "box-shadow: 0 0 10px rgba(13, 110, 253, 0.4);";}else if($lastLogValues[$clientId][$activeInput]>$max_Inputs[$clientId][$activeInput]){echo "box-shadow: 0 0 10px rgba(220, 53, 69, 0.4);";}} ?>"> 
                                                <div class="row">
                                                    <div class="col-9">
                                                        <div class="d-flex align-items-center align-self-start">
                                                            <div class="mb-0 fs-4" name="txtInputValue" id="<?php echo $clientId.$activeInput ?>">
                                                                <?php echo $lastLogValues[$clientId][$activeInput] ?>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="icon">
                                                            <?php
                                                            if(!$status[$clientId]){
                                                                 echo '<svg fill="#ccc" width="20px" height="25px" viewBox="0 0 1024 1024" class="icon">
                                                                        <path d="M917.7 148.8l-42.4-42.4c-1.6-1.6-3.6-2.3-5.7-2.3s-4.1.8-5.7 2.3l-76.1 76.1a199.27 199.27 0 0 0-112.1-34.3c-51.2 0-102.4 19.5-141.5 58.6L432.3 308.7a8.03 8.03 0 0 0 0 11.3L704 591.7c1.6 1.6 3.6 2.3 5.7 2.3 2 0 4.1-.8 5.7-2.3l101.9-101.9c68.9-69 77-175.7 24.3-253.5l76.1-76.1c3.1-3.2 3.1-8.3 0-11.4zM769.1 441.7l-59.4 59.4-186.8-186.8 59.4-59.4c24.9-24.9 58.1-38.7 93.4-38.7 35.3 0 68.4 13.7 93.4 38.7 24.9 24.9 38.7 58.1 38.7 93.4 0 35.3-13.8 68.4-38.7 93.4zm-190.2 105a8.03 8.03 0 0 0-11.3 0L501 613.3 410.7 523l66.7-66.7c3.1-3.1 3.1-8.2 0-11.3L441 408.6a8.03 8.03 0 0 0-11.3 0L363 475.3l-43-43a7.85 7.85 0 0 0-5.7-2.3c-2 0-4.1.8-5.7 2.3L206.8 534.2c-68.9 69-77 175.7-24.3 253.5l-76.1 76.1a8.03 8.03 0 0 0 0 11.3l42.4 42.4c1.6 1.6 3.6 2.3 5.7 2.3s4.1-.8 5.7-2.3l76.1-76.1c33.7 22.9 72.9 34.3 112.1 34.3 51.2 0 102.4-19.5 141.5-58.6l101.9-101.9c3.1-3.1 3.1-8.2 0-11.3l-43-43 66.7-66.7c3.1-3.1 3.1-8.2 0-11.3l-36.6-36.2zM441.7 769.1a131.32 131.32 0 0 1-93.4 38.7c-35.3 0-68.4-13.7-93.4-38.7a131.32 131.32 0 0 1-38.7-93.4c0-35.3 13.7-68.4 38.7-93.4l59.4-59.4 186.8 186.8-59.4 59.4z"/>
                                                                      </svg>';
                                                            }else if($lastLogValues[$clientId][$activeInput] < -90){
                                                                echo '<svg fill="#aa0000" width="20px" height="25px" viewBox="0 0 1024 1024" class="icon">
                                                                        <path d="M917.7 148.8l-42.4-42.4c-1.6-1.6-3.6-2.3-5.7-2.3s-4.1.8-5.7 2.3l-76.1 76.1a199.27 199.27 0 0 0-112.1-34.3c-51.2 0-102.4 19.5-141.5 58.6L432.3 308.7a8.03 8.03 0 0 0 0 11.3L704 591.7c1.6 1.6 3.6 2.3 5.7 2.3 2 0 4.1-.8 5.7-2.3l101.9-101.9c68.9-69 77-175.7 24.3-253.5l76.1-76.1c3.1-3.2 3.1-8.3 0-11.4zM769.1 441.7l-59.4 59.4-186.8-186.8 59.4-59.4c24.9-24.9 58.1-38.7 93.4-38.7 35.3 0 68.4 13.7 93.4 38.7 24.9 24.9 38.7 58.1 38.7 93.4 0 35.3-13.8 68.4-38.7 93.4zm-190.2 105a8.03 8.03 0 0 0-11.3 0L501 613.3 410.7 523l66.7-66.7c3.1-3.1 3.1-8.2 0-11.3L441 408.6a8.03 8.03 0 0 0-11.3 0L363 475.3l-43-43a7.85 7.85 0 0 0-5.7-2.3c-2 0-4.1.8-5.7 2.3L206.8 534.2c-68.9 69-77 175.7-24.3 253.5l-76.1 76.1a8.03 8.03 0 0 0 0 11.3l42.4 42.4c1.6 1.6 3.6 2.3 5.7 2.3s4.1-.8 5.7-2.3l76.1-76.1c33.7 22.9 72.9 34.3 112.1 34.3 51.2 0 102.4-19.5 141.5-58.6l101.9-101.9c3.1-3.1 3.1-8.2 0-11.3l-43-43 66.7-66.7c3.1-3.1 3.1-8.2 0-11.3l-36.6-36.2zM441.7 769.1a131.32 131.32 0 0 1-93.4 38.7c-35.3 0-68.4-13.7-93.4-38.7a131.32 131.32 0 0 1-38.7-93.4c0-35.3 13.7-68.4 38.7-93.4l59.4-59.4 186.8 186.8-59.4 59.4z"/>
                                                                      </svg>';
                                                            }else{
                                                                echo '<svg fill="#00aa11" width="20px" height="25px" viewBox="0 0 1024 1024" class="icon">
                                                                        <path d="M917.7 148.8l-42.4-42.4c-1.6-1.6-3.6-2.3-5.7-2.3s-4.1.8-5.7 2.3l-76.1 76.1a199.27 199.27 0 0 0-112.1-34.3c-51.2 0-102.4 19.5-141.5 58.6L432.3 308.7a8.03 8.03 0 0 0 0 11.3L704 591.7c1.6 1.6 3.6 2.3 5.7 2.3 2 0 4.1-.8 5.7-2.3l101.9-101.9c68.9-69 77-175.7 24.3-253.5l76.1-76.1c3.1-3.2 3.1-8.3 0-11.4zM769.1 441.7l-59.4 59.4-186.8-186.8 59.4-59.4c24.9-24.9 58.1-38.7 93.4-38.7 35.3 0 68.4 13.7 93.4 38.7 24.9 24.9 38.7 58.1 38.7 93.4 0 35.3-13.8 68.4-38.7 93.4zm-190.2 105a8.03 8.03 0 0 0-11.3 0L501 613.3 410.7 523l66.7-66.7c3.1-3.1 3.1-8.2 0-11.3L441 408.6a8.03 8.03 0 0 0-11.3 0L363 475.3l-43-43a7.85 7.85 0 0 0-5.7-2.3c-2 0-4.1.8-5.7 2.3L206.8 534.2c-68.9 69-77 175.7-24.3 253.5l-76.1 76.1a8.03 8.03 0 0 0 0 11.3l42.4 42.4c1.6 1.6 3.6 2.3 5.7 2.3s4.1-.8 5.7-2.3l76.1-76.1c33.7 22.9 72.9 34.3 112.1 34.3 51.2 0 102.4-19.5 141.5-58.6l101.9-101.9c3.1-3.1 3.1-8.2 0-11.3l-43-43 66.7-66.7c3.1-3.1 3.1-8.2 0-11.3l-36.6-36.2zM441.7 769.1a131.32 131.32 0 0 1-93.4 38.7c-35.3 0-68.4-13.7-93.4-38.7a131.32 131.32 0 0 1-38.7-93.4c0-35.3 13.7-68.4 38.7-93.4l59.4-59.4 186.8 186.8-59.4 59.4z"/>
                                                                      </svg>';
                                                            }?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-9">
                                                        <div class="d-flex align-items-center align-self-start">
                                                            <h6 class="text-muted font-weight-normal float-start mt-3" name="txtIn" id="<?php echo $clientId.$activeInput ?>">
                                                                <?php echo $activeInputName[$clientId][$activeInput]; ?>
                                                            </h6> 
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="icon icon-box-warning ">
                                                        <?php $url="../chartpage/chart.php?id=".$clientId."&in=".$activeInput;?>
                                                        	<a target="_blank" href="<?php echo $url;?>">
                                                                <i name="txtIn" class="mdi mdi-chart-line pointer icon-item pointer"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="row">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
                <?php } ?>
            </div>
        </div>
        <script src="../assets/jsforallpage/datetimescript.js?v=4"></script>
        <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
</body>