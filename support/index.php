<?php
if(isset($_GET['from']) and $_GET['from'] == "erins"){
    echo "<script>alert('درخواست شما ارسال نشد  لطفا چند لحظه بعد مجدد تلاش کنید.')</script>";
}
include './includes/db.inc.php';
$username = $_COOKIE['login'];
try{
    $s = $pdo->prepare("select id, subject, status, date, time, department from tickets where username=:username");
    $s->bindValue(":username",$username);
    $s->execute();
}catch(PDOException $e){
	echo "<script>location.replace('https://avahiva.ir/dashboard/user/?user=".$username."&from=unload')</script>";
	exit();
}
echo "<script>console.log('".$s->rowCount()."')</script>";
$tickets = array();
$has_message = true; 
foreach($s as $row){
    if($row['status']){
        try{
            $t = $pdo->prepare("select id,type from messages where idticket=:idticket ORDER BY id");
            $t->bindValue(":idticket",$row['id']);
            $t->execute();
        }catch(PDOException $e){
        	echo "<script>location.replace('https://avahiva.ir/dashboard/user/?user=".$username."&from=unload')</script>";
        	exit();
        }
        if(!$t->rowCount()){
            try{
                $t = $pdo->prepare("delete from tickets where id=:id");
                $t->bindValue(":id",$row['id']);
                $t->execute();
            }catch(PDOException $e){
            	echo "<script>location.replace('https://avahiva.ir/dashboard/user/?user=".$username."&from=unload')</script>";
            	exit();
            }
            $has_message = false;
        }else{
            foreach($t as $type){
                if($type['type'] == 'user'){
                    $status = "درحال بررسی";
                }else{
                    $status = "پاسخ داده شده";
                }
            }
        }
    }else{
        $status = "بسته شده";
    }
    switch ($row['department']) {
        case "fanni":
            $department =  "پشتیبانی فنی";
            break;
        case "mali":
            $department =  "پپشتیبانی مالی";
            break;
        case "market":
            $department =  "فروش ";
            break;
        case "manager":
            $department =  "مدیریت";
            break;
        case "marjuee":
            $department =  "ارجاع دستگاه";
            break;
    }
    if($has_message){
        $tickets[] = array("id"=>$row['id'], "department"=>$department, "subject"=>$row['subject'], "status"=>$status, "date"=>$row['date'], "time"=>$row['time']);
    }
    $has_message = true;
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
                background:#14151b;
            }
            html{
                overflow-x:hidden;
                background:#14151b;
            }
            .bg-blue{
                background:#0095a3;
            }
            .text-bc{
                color:rgb(108, 114, 147, 0.8);
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
                            <div class="float-start">
                                <a class="btn bg-blue rounded py-2 px-3" href="./ticket.php?user=<?php echo $username?>">
                                    درخواست جدید
                                </a>
                            </div>
                            <div>
                                <p class="">
                                    درخواست های من
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-10 col-sm-10 col-md-11 col-lg-7 p-5 mb-5 mt-3 rounded-1 bg-color shadow  d-none d-md-block">
                    <table class="table table-striped text-center">
                        <thead> 
                            <tr> 
                                <th scope="col" class="fw-bold">
                                    موضوع
                                </th> 
                                <th scope="col" class="fw-bold">
                                    وضعیت تیکت
                                </th> 
                                <th scope="col" class="fw-bold">
                                    واحد پشتیبانی
                                </th>
                                <th scope="col" class="fw-bold">
                                    تاریخ
                                </th> 
                                <th scope="col" class="fw-bold">...</th> 
                            </tr> 
                        </thead> 
                        <tbody> 
                        <?php foreach($tickets as $ticket){?>
                                <tr> 
                                    <td class="text-light"><?php echo $ticket['subject']?></td> 
                                    <td class="text-light"><?php echo $ticket['status'];?></td> 
                                    <td class="text-light"><?php echo $ticket['department'];?></td>
                                    <td class="text-light"><?php echo $ticket['time']. " " . $ticket['date'];?></td> 
                                    <td class="text-light">
                                        <a class="btn bg-blue rounded" href="./showticket.php?id=<?php echo $ticket['id'];?>&user=<?php echo $username;?>">
                                            مشاهده درخواست
                                        </a>
                                    </td> 
                                </tr> 
                            </form>
                        <?php }?>
                        </tbody>
                    </table>
                    <?php if(!$s->rowCount()){?>
                        <p class="text-center mt-5">
                            هنوز درخواستی ثبت نشده است
                        </p>
                    <?php } ?>
                </div>
                <div class="col-10 col-sm-9 col-md-11 col-lg-7 mb-5 mt-3  d-block d-sm-block d-md-none d-lg-none">
                    <?php foreach($tickets as $ticket){?>
                    <div class="w-100 rounded-1 bg-color shadow p-4 mb-4">
                        <div class="d-flex flex-row mb-2">
                            <div class="text-bc">
                                موضوع: &nbsp
                            </div>
                            <div class="">
                                <?php echo $ticket['subject']?>
                            </div>
                        </div>
                        <div class="d-flex flex-row mb-2">
                            <div class="text-bc">
                                وضعیت تیکت: &nbsp
                            </div>
                            <div class="">
                                <?php echo $ticket['status'];?>
                            </div>
                        </div>
                        <div class="d-flex flex-row mb-2">
                            <div class="text-bc">
                                 واحد پشتیبانی: &nbsp
                            </div>
                            <div class="">
                                <?php echo $ticket['department'];?>
                            </div>
                        </div>
                        <div class="d-flex flex-row mb-3">
                            <div class="text-bc">
                                تاریخ: &nbsp
                            </div>
                            <div class="">
                                <?php echo $ticket['time']. " " . $ticket['date'];?>
                            </div>
                        </div>
                        <div class="text-start">
                            <a class="btn bg-blue rounded" href="./showticket.php?id=<?php echo $ticket['id'];?>&user=<?php echo $username;?>">
                                مشاهده درخواست
                            </a>
                        </div>
                    </div>   
                    <?php }?>
                </div>
            </div>
        </div>
    </body>
</html>