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
                <a class="ms-3 text-start">
                  <img src="./images/hoshiLogo.png" alt="Logo" width="90" height="45" class="d-inline-block align-text-top my-3">
                </a>
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
                            <?php if($_GET['ac'] == "re"){ echo "ثبت نام با موفقیت انجام شد";}else{echo "بروز رسانی با موفقیت انجام شد";}?>
                        </p>
                        <a type="button" class="btn bcbox rounded p-2" href="../user/index.php?from=reg&user=<?php echo $_COOKIE['login'];?>">
                            بازگشت به صفحه اصلی
                        </a>
                    </div>
                </div>
            </div>
    </body>
</html>