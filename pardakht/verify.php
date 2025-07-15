<?php
$status = $_GET['Status'];
$info = $_GET['info'];
$pd = substr($info, 0, 2);
$ms = substr($info, 2, 4);
$user = substr($info, 6);
$duration = 1;
if(strtoupper($status) == "OK"){
    if($pd == "1d"){
        $product = "پنل یک روزه";
        $duration = 1 * 24 * 60 * 60; 
    }else if($pd == "01"){
        $product = "پنل یک ماهه";
        $duration = 1 * 30 * 24 * 60 * 60;  
    }else if($pd == "03"){
        $product = "پنل سه ماهه";
        $duration = 3 * 30 * 24 * 60 * 60;  
    }else if($pd == "06"){
        $product = "پنل شش ماهه";
        $duration = 6 * 30 * 24 * 60 * 60;  
    }else if($pd == "12"){
        $product = "پنل یک ساله";
        $duration = 365 * 24 * 60 * 60;  
    }else if($pd == "in"){
        $product = "پنل نامحدود";
    }
    $msg_success = " خرید ". $product . " با موفقیت انجام شد.";
    include "../includes/func.inc.php";
    date_default_timezone_set("Asia/Tehran");
    $DateTime = miladiBeShamsi(date('Y'), date('m'), date('d'), "/") . " " . date('H:i:s');
    $timeNow = mktime(date('H'), date('i'), date('s'), date('m'), date('d'), date('Y'));
    $msg = " کاربر با نام کاربری" . $user . " " . $product . " را خرید.\n #buy \n#" . $user . "\n" . $DateTime;

    sendMessageToBale(5147058395 , $msg); 
    include "../alarm/includes/db.inc.php";
    try{
        $s = $pdo->prepare("select duration,startdate, starttime from Alarms where username=:username order by id");
        $s->bindValue(":username", $user);
        $s->execute();
    }catch(PDOException $e){
    	echo "error in inser data".$e->getMessage();
    	exit();
    }
    if($s->rowCount()>0){
        $row = array_reverse($s->fetchAll());
        $start = $row[0]['startdate'] . " " . $row[0]['starttime'];
        $ts_endpanel =  mktime(intval(substr($start,11,2)),
                               intval(substr($start,14,2)),
                               intval(substr($start,17,2)),
                               intval(substr($start,5,2)),
                               intval(substr($start,8,2)),
                               intval(substr($start,0,4))) + $row[0]['duration'];
        if($ts_endpanel - $timeNow > 0){
            $ts_startpanel = $ts_endpanel; 
        }else{
            $ts_startpanel = $timeNow;
        }
    }else{
        $ts_startpanel = $timeNow;
    }
    try{
        $s = $pdo->prepare("insert into Alarms set username=:username, startdate=:startdate, starttime=:starttime, duration=:duration, msng=:msng");
        if($pd == "in"){
            $s->bindValue(":duration", "infinite");
        }else{
            $s->bindValue(":duration", $duration."");
        }
        $s->bindValue(":username", $user);
        $s->bindValue(":msng", $ms);
        $s->bindValue(":startdate", date('Y-m-d', $ts_startpanel));
        $s->bindValue(":starttime", date('H:i:s', $ts_startpanel));
        $s->execute();
    }catch(PDOException $e){
    	echo "error in insert data".$e->getMessage();
    	exit();
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0 ">
        <title>ASTROCYTE</title>
        <link rel="stylesheet" href="../assets/css/style.css?v=2">
        <link rel="shortcut icon" href="../alarm/images/hoshi.png"/>
        <style>
            @font-face {
              font-family: vazir;
              src: url('../alarm/fonts/Vazir.eot');
              src: url('../alarm/fonts/Vazir.ttf') format('truetype');
              font-weight: normal;
              font-style: normal;
            }
            body{
                font-family:vazir;
            }
            html{
                overflow-x:hidden;
                background:#14151b;
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
                    <div class="col text-start">
                        <a class="ms-3">
                            <img src="../alarm/images/hoshiLogo.png" alt="Logo" width="90" height="45" class="d-inline-block align-text-top my-3">
                        </a>
                    </div>
                    <div class="col text-end mt-4 me-5">
                        <a href="../user/index.php?from=reg&user=<?php echo $user;?>" class="text-decoration-none ">
                            <div class="d-inline-flex flex-row">
                                <p class="text-light me-1"> صفحه اصلی</p>
                                <svg width="20" height="20" fill="white" class="bi bi-house-door-fill" viewBox="0 0 16 16">
                                  <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5Z"/>
                                </svg>
                            </div> 
                        </a>
                    </div>
                </div>
            </div>
        </div>
            <div class="position-absolute top-50 start-50 translate-middle">
                <div class="row justify-content-center">
                    <div class="col text-center">
                        <svg width="50" height="50" fill="#198754" class="bi bi-check2-circle" viewBox="0 0 16 16">
                          <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                          <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                        </svg>
                        <p class="text-light fs-3 my-3">
                            <?php echo $msg_success;?>
                        </p>
                        <?php if($s->rowCount()<1){?>
                        <p class="text-light fs-5 my-3">
                            در 24 ساعت آینده پنل برای شما فعال میشود
                        </p>
                        <?php } ?>
                        <a type="button" class="btn bcbox rounded p-2" href="../alarm/panel.php?user=<?php echo $user;?>">
                            بازگشت به پنل آلارم
                        </a>
                    </div>
                </div>
            </div>
    </body>
</html>

