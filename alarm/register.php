<?php
include './includes/db.inc.php';
$username = $_COOKIE['login'];
// echo "<script>console.log('".$_COOKIE['login']."')</script>";
try{
    $s = $pdo->prepare("select name, company, mobile1, mobile2, mobile3, email from userinfo where username=:username");
    $s->bindValue(":username", $username);
    $s->execute();
}catch(PDOException $e){
    echo "error in inser data".$e->getMessage();
    exit();
}
$has_user = "FALSE";
if($s->rowCount()){
    $has_user = "TRUE";
}
if(!isset($_GET['page']) and $has_user == "TRUE"){
    header("location:./panel.php?user=" . $username);
    exit();
}
if(isset($_GET['page']) and $has_user == "TRUE"){
    $row = $s->fetch();
}else{
    $row = array("name"=>"", "company"=>"", "mobile1"=>"", "mobile2"=>"", "mobile3"=>"");
}
if($_POST['submit']){
    if($has_user == "FALSE"){
        if(!empty($_POST['name']) and !empty($_POST['mobile'])){
            try{
                $s = $pdo->prepare("insert into userinfo set username=:username, name=:name, company=:company, mobile1=:mobile1, mobile2=:mobile2, mobile3=:mobile3");
                $s->bindValue(":username",$username);
                $s->bindValue(":name", $_POST['name']);
                $s->bindValue(":company", $_POST['company']);
                $s->bindValue(":mobile1", $_POST['mobile']);
                $s->bindValue(":mobile2", $_POST['mobile2']);
                $s->bindValue(":mobile3", $_POST['mobile3']);
                $s->execute();
                include "../includes/func.inc.php";
                date_default_timezone_set("Asia/Tehran");
                $DateTime = miladiBeShamsi(date('Y'), date('m'), date('d'), "/") . " " . date('H:i:s');
                $msg = " ❇️ کاربر با نام کاربری " .  $username. " ثبت نام کرد.\n #register \n #". $username . "\n" .$DateTime;
                sendMessageToBale(5147058395, $msg);
                if(isset($_GET['page'])){
                    header("location:./successregister.php?ac=re&user=" . $username);
                    exit();
                }else{
                    header("location:./panel.php?ac=re&user=" . $username);
                }
            }catch(PDOException $e){
            	echo "error in insert data".$e->getMessage();
            	exit();
            }
        }
    }else if($has_user == "TRUE"){
        if(!empty($_POST['name']) and !empty($_POST['mobile'])){
            try{
                $s = $pdo->prepare("update userinfo set name=:name, company=:company, mobile1=:mobile1, mobile2=:mobile2, mobile3=:mobile3 where username=:username ");
                $s->bindValue(":username",$username);
                $s->bindValue(":name", $_POST['name']);
                $s->bindValue(":company", $_POST['company']);
                $s->bindValue(":mobile1", $_POST['mobile']);
                $s->bindValue(":mobile2", $_POST['mobile2']);
                $s->bindValue(":mobile3", $_POST['mobile3']);
                $s->execute();
                include "../includes/func.inc.php";
                date_default_timezone_set("Asia/Tehran");
                $DateTime = miladiBeShamsi(date('Y'), date('m'), date('d'), "/") . " " . date('H:i:s');
                $msg = "*️⃣ کاربر با نام کاربری ".  $username. " پروفایل خود را به روز رسانی کرد. \n #update \n #". $username . "\n\n" .$DateTime;
                sendMessageToBale(5147058395, $msg);
                if(isset($_GET['page'])){
                    header("location:./successregister.php?ac=up&user=" . $username);
                }else{
                    header("location:./panel.php?ac=re&user=" . $username);
                }
                exit();
            }catch(PDOException $e){
            	echo "error in inser data".$e->getMessage();
            	exit();
            }
            
        }
    }
}

$color_icon = "#fff";
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
              src: url('./fonts/Vazir.eot');
              src: url('./fonts/Vazir.ttf') format('truetype');
              font-weight: normal;
              font-style: normal;
            }
            body{
                font-family:vazir;
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
                <div class="col-12">
                    <div class="row justify-content-center">
                        <div class=" col-11 col-sm-10 col-md-8 col-lg-6 mt-4">
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
                <div class=" col-11 col-sm-10 col-md-8 col-lg-6 p-5 mb-5 mt-2 rounded-1 bg-color shadow">
                    <form method="POST" name="register">
                        <div class="mb-3">
                            <svg width="16" height="16" fill="<?php echo $color_icon;?>" class="bi bi-person" viewBox="0 0 16 16">
                              <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/>
                            </svg>
                            <label  class="form-label text-light me-1">نام و نام خانوادگی(*):</label>
                            <input type="text" class="form-control button border border-0 text-light rounded" name="name" value="<?php echo $row['name']?>" required>
                        </div>
                        <div class="mb-3">
                            <svg width="16" height="16" fill="<?php echo $color_icon;?>" class="bi bi-buildings" viewBox="0 0 16 16">
                              <path d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022ZM6 8.694 1 10.36V15h5V8.694ZM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15Z"/>
                              <path d="M2 11h1v1H2v-1Zm2 0h1v1H4v-1Zm-2 2h1v1H2v-1Zm2 0h1v1H4v-1Zm4-4h1v1H8V9Zm2 0h1v1h-1V9Zm-2 2h1v1H8v-1Zm2 0h1v1h-1v-1Zm2-2h1v1h-1V9Zm0 2h1v1h-1v-1ZM8 7h1v1H8V7Zm2 0h1v1h-1V7Zm2 0h1v1h-1V7ZM8 5h1v1H8V5Zm2 0h1v1h-1V5Zm2 0h1v1h-1V5Zm0-2h1v1h-1V3Z"/>
                            </svg>
                            <label class="form-label text-light me-1"> نام شرکت:</label>
                            <input type="text" class="form-control button border border-0 text-light rounded" name="company" value="<?php echo $row['company']?>"> 
                        </div>
                        <div class="mb-3">
                            <svg width="16" height="16" fill="<?php echo $color_icon;?>" class="bi bi-phone float-end mt-1" viewBox="0 0 16 16">
                              <path d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z"/>
                              <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                            </svg>
                            <label class="form-label float-end text-light me-1">شماره موبایل(*):</label>
                            <input type="text" class="form-control button border border-0 text-light rounded" name="mobile" value="<?php echo $row['mobile1']?>"  required>
                        </div>
                        <div class="mb-3">
                            <svg width="16" height="16" fill="<?php echo $color_icon;?>" class="bi bi-phone float-end mt-1" viewBox="0 0 16 16">
                              <path d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z"/>
                              <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                            </svg>
                            <label class="form-label float-end text-light me-1">شماره موبایل دوم:</label>
                            <input type="text" class="form-control button border border-0 text-light rounded" name="mobile2" value="<?php echo $row['mobile2']?>">
                        </div>
                        <div class="mb-3">
                            <svg width="16" height="16" fill="<?php echo $color_icon;?>" class="bi bi-phone float-end mt-1" viewBox="0 0 16 16">
                              <path d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z"/>
                              <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                            </svg>
                            <label class="form-label float-end text-light me-1">شماره موبایل سوم:</label>
                            <input type="text" class="form-control button border border-0 text-light rounded" name="mobile3" value="<?php echo $row['mobile3']?>">
                        </div>
                        <div class="mb-3">
                            <svg width="16" height="16" fill="<?php echo $color_icon;?>" class="bi bi-envelope float-end mt-1" viewBox="0 0 16 16">
                              <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
                            </svg>
                            <label class="form-label float-end text-light me-1">ایمیل  :</label>
                            <input type="email" class="form-control button border border-0 text-light rounded" name="email" value="<?php echo $row['email']?>">
                        </div>
                        <div class="text-center">
                            <input class="btn bg-blue rounded py-2 px-3" type="submit" name="submit" value="<?php if($has_user == "FALSE"){ echo "ثبت نام";}else{echo "بروز رسانی";}?>">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>