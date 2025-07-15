<?php
include("../header.php");
$username = $_SESSION['username'];
$clientId=$_GET['id'];
include '../includes/db.inc.php';
echo "<script>console.log('username: ".$_COOKIE['login']."')</script>";
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel Export Data</title>


    <!-- <link rel="stylesheet" href="css/bootstrap.min.css"> -->
    <!--<link rel="stylesheet" href="css2/style.css">-->
    <!-- <script src="js/bootstrap.min.js"></script> -->
    <!--<link rel="shortcut icon" href="../assets/images/com-logo.png"/>-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="./jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
    integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  <link rel="stylesheet" href="./jquery.md.bootstrap.datetimepicker.style.css" />
    <script src="script.js?v=26"></script>

</head>
<body class="bg-body pt-5">
   
<div class="container text-light">
    <div class="card margintoppp shadow " style="background: #185c37;">
        <div class="card-header">
            <img src="img/Logo_Hoshi.png" alt=""></div>
        <div class="card-body">
            <form _lpchecked="1">
                <div class="row">
                        <div class="d-lg-flex justify-content-between col-lg-6 col-md-12 form-group">
                            <label class="control-label font-weight-bold clo-lg-2 me-2">ClientID</label>
                            <input type="text" class="form-control col-lg-9" placeholder="<?php echo $clientId; ?>" name="client" id="id" disabled>
                        </div>
                </div>

                <section>
                    <div class="row">
                
                      <div class="col-md-6 form-group">
                        <label for="min" class="font-weight-bold"> Min </label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text cursor-pointer" id="enter_date"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                          </div>
                          <input type="text" name="min" id="min" placeholder="Min Value" class="form-control form-group"
                            aria-label="enter_date" aria-describedby="enter_date" />
                            <!-- <span id="min-miladi"></span> -->
                          <label type="text" name="enter_date_2" id="enter_date_2" class="form-control form-group bg-light"
                            aria-label="enter_date" aria-describedby="enter_date"  />
                        </div>
                      </div>
                      <div class="col-md-6 form-group">
                        <label for="max" class="font-weight-bold"> Max </label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text cursor-pointer" id="exit_date"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                          </div>
                          <input type="text" name="max" id="max" placeholder="Max Value" class="form-control form-group" aria-label="exit_date"
                            aria-describedby="exit_date"  />
                            <!-- <span id="max-miladi"></span> -->

                          <label type="text" name="exit_date_2" id="exit_date_2" class="form-control form-group bg-light"
                            aria-label="exit_date" aria-describedby="exit_date" />
                        </div>
                      </div>
                    </div>
                </section>
                <div class="d-lg-flex justify-content-between">
                    <input type="button" class="form-control btn btn-light mt-2 " style="width: 32%;" value="Export Excel File" onclick="sendParameter('<?php echo $clientId; ?>');">
                    <a class="form-control btn btn-light mt-2 " style="width: 32%;" href="https://hivaindbackup.ir/export/ExcelExport.php?id=<?php echo $clientId; ?>" target="_blank">Daily Excel export</a>
                    <input type="button" class="form-control btn btn-light mt-2" style="width: 32%;" value="Export All Data" onclick="sendParameter7('<?php echo $clientId; ?>');">
                </div>
                <div class="d-lg-flex">    
                    <div class="col-lg-3">
                        <label class="text-light">DownSampling</label>
                        <select class="btn btn-light mt-2" aria-label="Default select example" id="time">
                            <option value="15" selected>15 minutes</option>
                            <option value="30">30 minutes</option>
                            <option value="60">1 hour</option>
                        </select>
                    </div>
                    <input type="button" class="col-lg-9 form-control btn btn-light mt-2" value="Export Excel File Data with downsampling" onclick="sendParameteDS('<?php echo $clientId; ?>');">
                </div>
            </div>
        </form>
    </div>
</div>
<script src="./jquery.md.bootstrap.datetimepicker.js" type="text/javascript"></script>

<script type="text/javascript">
    $('#enter_date').MdPersianDateTimePicker({
      targetTextSelector: '#min',
      targetDateSelector: '#enter_date_2',
      fromDate: true,
      groupId: 'enter_date',
      modalMode: true,
      disableAfterToday: true,
    //   disableBeforeDate: new Date()-14
    });

    $('#exit_date').MdPersianDateTimePicker({
      targetTextSelector: '#max',
      targetDateSelector: '#exit_date_2',
      toDate: true,
      groupId: 'enter_date',
      modalMode: true,
      disableAfterToday: true

    });
  </script>
<!--<?php echo "<script>sendParameter('321')</script>";?>-->
</body>
</html>
