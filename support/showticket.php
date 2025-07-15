<?php
include "./includes/db.inc.php";
$username = $_GET['user'];
try{
    $s = $pdo->prepare("select subject from tickets where id=:idticket");
    $s->bindValue(":idticket",$_GET['id']);
    $s->execute();
}catch(PDOException $e){
	echo "error in select data".$e->getMessage();
	exit();
}
$result = $s->fetch();
$subject = $result['subject'];
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
try{
    $s = $pdo->prepare("select text, type, attachment, time, date from messages where idticket=:id ORDER BY id");
    $s->bindValue(":id",$_GET['id']);
    $s->execute();
}catch(PDOException $e){
	echo "error in select data".$e->getMessage();
	exit();
}
if(isset($_POST['send'])){
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["attachment"]["name"]);
    move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file);
    try{
        $s = $pdo->prepare("insert into messages set text=:text, username=:username, type=:type, idticket=:idticket, date=CURDATE(), time=CURTIME(), attachment=:attachment");
        $s->bindValue(":text",$_POST['text']);
        $s->bindValue(":username",$username);
        $s->bindValue(":type","user");
        $s->bindValue(":idticket",$_GET['id']);
        $s->bindValue(":attachment", $target_file);
        $s->execute();
        include "../includes/func.inc.php";
        date_default_timezone_set("Asia/Tehran");
        $timeNow = miladiBeShamsi(date('Y'), date('m'), date('d'), "/") . " " . date('H:i:s');
        $text = $_POST['text'];
        $link = $target_file;
        $msg = "کاربر با نام کاربری $username تیکت ارسال کرده است.\nموضوع:$subject\nتوضیحات: $command\n";
        if($link != "uploads/"){
            $link = "https://avahiva.ir/dashboard/support/" . $link;
            $msg = $msg . "عکس: $link";
        }
        sendMessageToBale(4992452353, $msg);
        header("location:./showticket.php?id=".$_GET['id']."&user=".$username);
        exit();
    }catch(PDOException $e){
    	echo "error in select data".$e->getMessage();
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
                background:rgb(108, 114, 147, 0.5);
            }
            .bcbox2{
                background:rgb(108, 114, 147, 0.8);
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
                        <a href="../user/index.php?from=reg&user=<?php echo $username;?>" class="text-decoration-none ">
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
                <div class=" col-12">
                    <div class="row justify-content-center">
                        <div class="col-11 col-sm-10 col-md-8 col-lg-6 mt-5">
                            <div class="float-end">
                                <p class="">مشاهده درخواست </p>
                            </div>
                            <div class="float-start">
                                <a href="./index.php?user=<?php echo $username;?>" class="text-decoration-none">
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
                <div class="col-10 col-sm-10 col-md-8 col-lg-6 p-5 mb-5 mt-2 rounded-1 bg-color shadow">
                    <div class="mb-3">
                        <div class="flex-grow d-flex">
                            <p>
                                موضوع:&nbsp
                            </p>
                            <p class="fw-bold"><?php echo $subject; ?></p>
                            
                        </div>
                    </div>
                    <?php foreach($s as $row){?>
                    <?php if($row['type'] == "user"){?>
                    <div class="row justify-content-start">
                        <div class="col-10 ">
                            <div class="mb-3 bcbox rounded-1 p-3">
                                <p class="" style="white-space: pre-line"><?php echo $row['text']?></p>
                                <?php if($row['attachment'] != "uploads/"){?>
                                    <div class="d-flex">
                                        <p>فایل پیوست شده: </p>
                                        <a class="me-2 text-info text-decoration-none" href="<?php echo './' . $row['attachment'];?>" download>download</a>
                                        <img src="<?php echo $row['attachment']?>" class="me-2" style="width:30px; height:30px">
                                    </div>
                                <?php }?>
                            </div>
                             <p class="" style="white-space: pre-line"><?php echo $row['time']. " " . $row['date'];?></p>
                        </div>
                    </div>
                    <?php }else if($row['type'] == "admin"){?>
                    <div class="row justify-content-end">
                        <div class="col-10">
                            <div class="mb-3 bcbox rounded-1 p-3">
                                <p class="" style="white-space: pre-line"><?php echo $row['text']?></p>
                                <?php if($row['attachment'] != "uploads/"){?>
                                    <div class="d-flex">
                                        <p>فایل پیوست شده: </p>
                                        <a class="me-2 text-info text-decoration-none" href="<?php echo './' . $row['attachment'];?>" download>download</a>
                                        <img src="<?php echo $row['attachment']?>" class="me-2" style="width:30px; height:30px">
                                    </div>
                                <?php }?>
                            </div>
                            <div class="text-start">
                                <p class="" style="white-space: pre-line"><?php echo $row['time']. " " . $row['date'];?></p>
                            </div>
                             
                        </div>
                    </div>     
                    <?php }?>
                    <?php }?>
                    <form method="POST" name="send" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label  class="form-label text-light me-1">توضیحات(*):</label>
                            <textarea class="form-control h-25 button border border-0 text-light rounded-1 p-3" rows="10" name="text"></textarea>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-4">
                                <label class="form-label">پیوست:</label>
                                <input class="form-control btn btn-dark button rounded" type="file" name="attachment" multiple>
                            </div>
                        </div>
                        <div class="text-center">
                            <input class="btn bg-blue rounded py-2 px-3 " type="submit" name="send" value="ارسال">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>