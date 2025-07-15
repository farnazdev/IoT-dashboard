<?php
$username = $_GET['user'];
echo "<script>console.log('".$username."')</script>";
include "../alarm/includes/db.inc.php";
try{
    $s = $pdo->prepare("select msng from Alarms where username=:username order by id");
    $s->bindValue(":username", $username);
    $s->execute();
}catch(PDOException $e){
	echo "error in inser data".$e->getMessage();
	exit();
}
$msng = "0000";
if($s->rowCount()>0){
    $msng = array_reverse($s->fetchAll())[0]['msng'];
    
}
if(isset($_POST['pay']) ){
    if(!is_array($_POST['msg'])){
        echo "<script>alert('لطفا یک پیام رسان را انتخاب کنید.')</script>";
    }else{
        $msng = "0000";
        echo "<script>console.log('".$_POST['msg']."')</script>";
        foreach($_POST['msg'] as $msg){
            if($msg == "bale"){
                $msng[0] = "1"; 
            }else if($msg == "telegram"){
                $msng[1] = "1"; 
            }else if($msg == "sms"){
                $msng[2] = "1"; 
            }else if($msg == "excel"){
                $msng[3] = "1"; 
            }
        }
        $info = $_POST['p_validation'] . $msng . $username;
        $url = "http://avahiva.ir/dashboard/pardakht/index.php?amount=" . $_POST['rial'] . "&info=" . $info;
        echo "<script>location.replace('".$url."')</script>";
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
                border: 0px;
            }
            .bcbox{
                background-color:rgb(108, 114, 147, 0.2);
            }
            #top{
                text-align:left;
            }
            @media only screen and (max-width: 768px){
                #top{
                    text-align:center;
                }
                #down{
                    margin:auto;
                    justify-content: center;
                }
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
        <div class="bg-color-dark w-100 h-100">
            <div class="row">
                <div class="col-12">
                    <div class="row justify-content-center">
                        <div class=" col-11 col-sm-10 col-md-8 col-lg-9 mt-4">
                            <div class="float-start">
                                <a href="./panel.php?user=<?php echo $username;?>" class="text-decoration-none">
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
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 mt-3" id="top">
                    <img src="./images/alarm.png" class="rounded-1" style="width:180px; height:180px;">
                </div>
                <div class="col-12 col-sm-12 col-md-8 col-lg-8 mt-3">
                    <div class="row" >
                        <form method="post">
                            <div class="col-10 bcbox p-5 rounded-1" id="down">
                                <p class="fs-3 fw-bold">
                                    پنل آلارم hoshi
                                </p>
                                <div class="d-flex flex-row mt-5">
                                    <label>
                                        مدت زمان اعتبار:
                                    </label>
                                    <select name="p_validation" class="form-select w-50 rounded-1 me-2 border border-0" onchange="onPrice()" id="p_validation">
                                        <!--<option value="1d">-->
                                        <!--    1 روزه-->
                                        <!--</option>-->
                                        <option value="01" selected >
                                            یک ماهه
                                        </option>
                                        <option value="03">
                                            سه ماهه
                                        </option>
                                        <option value="06">
                                            شش ماهه
                                        </option>
                                        <option value="12">
                                            یک ساله
                                        </option>
                                        <!--<option value="in">-->
                                        <!--    نا محدود-->
                                        <!--</option>-->
                                    </select>
                                </div>
                                <div class="d-flex flex-row mt-3">
                                    <p class="mt-1">
                                        قیمت محصول:  &nbsp
                                    </p>
                                    <p id="price" class="fs-5">100,000</p>
                                    <input type="text" name="rial" value="1000000" id="rial" class="d-none" >
                                    <p class="mt-1">
                                        &nbspتومان
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <svg width="16" height="16" fill="white" class="bi bi-aspect-ratio" viewBox="0 0 16 16">
                                      <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h13A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 12.5v-9zM1.5 3a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z"/>
                                      <path d="M2 4.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1H3v2.5a.5.5 0 0 1-1 0v-3zm12 7a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1H13V8.5a.5.5 0 0 1 1 0v3z"/>
                                    </svg>
                                    <label class="form-label text-light">پیام آلارم در چه پیام رسانی برای شما ارسال شود؟</label>
                                    <div>
                                        <input class="form-check-input bcbox" type="checkbox" value="bale" name="msg[]" 
                                        <?php if($msng[0] == "1"){ echo "checked";}?>>
                                        <label class="form-check-label text-light me-1">
                                            بله
                                        </label>
                                    </div>
                                    <div>
                                        <input class="form-check-input bcbox" type="checkbox" value="telegram" name="msg[]"
                                        <?php if($msng[1] == "1"){ echo "checked";}?>>
                                        <label class="form-check-label text-light me-1">
                                            تلگرام
                                        </label>
                                    </div>
                                    <div>
                                        <input class="form-check-input bcbox" type="checkbox" value="sms" name="msg[]"
                                        <?php if($msng[2] == "1"){ echo "checked";}?>>
                                        <label class="form-check-label text-light me-1">
                                            sms(هزینه هر پیامک 1000 تومان)
                                        </label>
                                    </div>
                                </div> 
                                <div class="mb-3">
                                    <div>
                                        <input class="form-check-input bcbox" type="checkbox" value="excel" name="msg[]"
                                        <?php if($msng[3] == "1"){ echo "checked";}?>>
                                        <label class="form-check-label text-light me-1">
                                            فعال کردن گرفتن سابقه داده ها در فرمت اکسل
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col text-center mt-5">
                                        <input type="submit" class="btn bg-blue rounded-1 py-3 px-5" name="pay" value="پرداخت"/>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function onPrice(){
                var pValidation = document.getElementById("p_validation").value;
                if(pValidation === "1d"){
                    document.getElementById("price").innerHTML = "1,000";
                    document.getElementById("rial").value = 10000;
                }else if(pValidation === "01"){
                    document.getElementById("price").innerHTML = "100,000";
                    document.getElementById("rial").value = 1000000;
                }else if(pValidation === "03"){
                    document.getElementById("price").innerHTML = "250,000";
                    document.getElementById("rial").value = 2500000;
                }else if(pValidation === "06"){
                    document.getElementById("price").innerHTML = "400,000";
                    document.getElementById("rial").value = 4000000;
                }else if(pValidation === "12"){
                    document.getElementById("price").innerHTML = "800,000";
                    document.getElementById("rial").value = 8000000;
                }else if(pValidation === "in"){
                    document.getElementById("price").innerHTML = "800,000";
                    document.getElementById("rial").value = 8000000;
                }
            }
            onPrice();
        </script>
    </body>
</html>