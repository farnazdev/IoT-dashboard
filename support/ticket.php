<?php
include "../alarm/includes/db.inc.php";
try{
    $s = $pdo->prepare("select mobile1, mobile2, mobile3 from userinfo where username=:username");
    $s->bindValue(":username",$_GET['user']);
    $s->execute();
}catch(PDOException $e){
	exit();
}
$has_mobile = false;
if($s->rowCount() > 0){
    $has_mobile = true;
}

if(isset($_POST['sendticket'])){
    //check value of inputs
    if(isset($_POST['subject']) and $_POST['subject'] != "" and ($has_mobile or (isset($_POST['name']) and $_POST['name'] != "" and isset($_POST['mobile']) and $_POST['mobile'] != ""))){
        try{
            $s = $pdo->prepare("insert into userinfo set name=:name, username=:username, mobile1=:mobile");
            $s->bindValue(":name",$_POST['name']);
            $s->bindValue(":username",$_GET['user']);
            $s->bindValue(":mobile",$_POST['mobile']);
            $s->execute();
        }catch(PDOException $e){
        	exit();
        }
        include_once "./includes/db.inc.php";
        $username = $_COOKIE['login'];
        try{
            $s = $pdo->prepare("insert into tickets set username=:username, subject=:subject, status=:status, date=CURDATE(), time=CURTIME() ");
            $s->bindValue(":username",$_GET['user']);
            $s->bindValue(":subject",$_POST['subject']);
            $s->bindValue(":status",1);
            $s->execute();
        }catch(PDOException $e){
        	echo "<script>location.replace('https://avahiva.ir/dashboard/support/?user=".$username."&from=erins')</script>";
        	exit();
        }
        try{
            $s = $pdo->prepare("select id from tickets where username=:username ORDER BY id");
            $s->bindValue(":username",$_GET['user']);
            $s->execute();
        }catch(PDOException $e){
        	echo "<script>location.replace('https://avahiva.ir/dashboard/support/?user=".$username."&from=erins')</script>";
        	exit();
        }
        $idticket = $s->fetchAll();
        $idticket = array_reverse($idticket);
        $name_file = "";
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["attachment"]["name"]);
        move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file);
        try{
            $s = $pdo->prepare("insert into messages set username=:username, text=:text, type=:type, idticket=:idticket, date=CURDATE(), time=CURTIME(), attachment=:attachment");
            $s->bindValue(":username",$_GET['user']);
            $s->bindValue(":text",$_POST['text']);
            $s->bindValue(":type","user");
            $s->bindValue(":idticket",$idticket[0]['id']);
            $s->bindValue(":attachment", $target_file);
            $s->execute();
            include "../includes/func.inc.php";
            date_default_timezone_set("Asia/Tehran");
            $timeNow = miladiBeShamsi(date('Y'), date('m'), date('d'), "/") . " " . date('H:i:s');
            $username = $_GET['user'];
            $subject = $_POST['subject'];
            if($subject == "setup"){
                $subject = "در راه اندازی دستگاه مشکل دارم";
            }else if($subject == "dashboard"){
                $subject = "به داشبورد دسترسی ندارم ";
            }else if($subject == "data"){
                $subject = "داده های ارسال شده توسط دستگاه اشتباه است";
            }else if($subject == "connection"){
                $subject = "داده های ارسال شده توسط دستگاه اشتباه است";
            }else{
                $subject = "سایر موارد";
            }
            $command = $_POST['text'];
            $link = $target_file;
            $msg = "کاربر با نام کاربری $username تیکت ارسال کرده است.\nموضوع:$subject\nتوضیحات: $command\n";
            if($link != "uploads/"){
                $link = "https://avahiva.ir/dashboard/support/" . $link;
                $msg = $msg . "عکس: \n$link";
            }
            if(!$has_mobile){
                $mobile = $_POST['mobile'];
            }else{
                $row = $s->fetch();
                $mobile = $row['mobile1']; 
            }
            $msg = $msg . "موبایل: $mobile";
            sendMessageToBale(4992452353, $msg);
            header("location: ./showticket.php?id=" . $idticket[0]['id'] ."&user=". $_GET['user']);
            exit();
        }catch(PDOException $e){
        	exit();
        }
    }else{
        echo "<script>alert('fill all fields')</script>";
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
        <link rel="shortcut icon" href="./images/hoshi.png"/>
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
                        <a href="../user/index.php?from=reg&user=<?php echo $_GET['user'];?>" class="text-decoration-none ">
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
        <div style="direction:rtl;" class="bg-color-dark">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="row justify-content-center">
                        <div class=" col-11 col-sm-10 col-md-8 col-lg-6 mt-5">
                            <div class="float-start">
                            <a href="./index.php?user=<?php echo $_GET['user'];?>" class="text-decoration-none">
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
                <div class=" col-11 col-sm-10 col-md-8 col-lg-6 p-5 mb-5 rounded-1 bg-color shadow">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3 row">
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                <label  class="form-label text-light me-1">موضوع:</label>
                                <select class="form-select button border border-0 text-light shadow rounded" name="subject">
                                    <option value="" class="bg-dark" selected>موضوع خود را انتخاب کنید</option>
                                    <option value="setup" class="bg-dark" >در راه اندازی دستگاه مشکل دارم</option>
                                    <option value="dashboard" class="bg-dark">به داشبورد دسترسی ندارم یا نمیتوانم وارد داشبورد شوم</option>
                                    <option value="data" class="bg-dark">داده های ارسال شده توسط دستگاه اشتباه است</option>
                                    <option value="connection" class="bg-dark">دستگاه به اینترنت وصل نمیشود</option>
                                    <option value="other" class="bg-dark">سایر موارد(در بخش توضیحات بنویسید)</option>
                                </select>
                            </div>   
                        </div>
                        <div class="mb-3">
                            <label  class="form-label text-light me-1">توضیحات(*):</label>
                            <textarea class="form-control h-25 button border border-0 text-light rounded" rows="10" name="text"></textarea>
                        </div>
                        <?php if(!$has_mobile){?>
                        <div class="mb-3">
                            <label  class="form-label text-light me-1 ">نام و نام خانوادگی(*):</label>
                            <input class="btn rounded py-2 px-3 button" type="text" name="name">
                        </div>
                        <div class="mb-3">
                            <label  class="form-label text-light me-1 ">شماره موبایل(*):</label>
                            <input class="btn rounded py-2 px-3 button" type="text" name="mobile">
                        </div>
                        <?php } ?>
                        <div class="mb-3 row">
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                <label class="form-label">درصورت نیاز عکس دستگاه خود را آپلود کنید:</label>
                                <input class="form-control btn btn-dark button rounded" type="file" name="attachment" multiple>
                            </div>
                        </div>
                        <div class="text-center">
                            <input class="btn bg-blue rounded py-2 px-3 " type="submit" name="sendticket" value="ارسال">
                        </div>
                        <div class="my-5 row">
                            <div class="col-12">
                                <label class="form-label">شماره تماس واحد پشتیبانی: 09396594187</label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>