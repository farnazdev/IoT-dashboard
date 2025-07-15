<?php
include("../header.php");
$username = $_SESSION['username'];
$clientId = $_GET['id'];
$url = "";
include '../includes/db.inc.php';
if(isset($_POST['export'])){
    try{
		$s=$pdo->prepare('insert into actionUsers set username=:username, action=:action, ip=:ip, time=:time');
		$s->bindValue(':username',$_COOKIE['login']);
		if($_COOKIE['password'] == "ava123!@#"){
		    $s->bindValue(':action', "support team view chart page");
		}else{
		    $s->bindValue(':action', "user view chart page ");
		}
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			//ip from share internet
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			//ip pass from proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		$s->bindValue(':ip', $ip);
		date_default_timezone_set("Asia/Tehran");
		$s->bindValue(':time', date('Y/m/d H:i:s'));
		$s->execute();
	}
	catch(PDOException $e){
	    echo "insert". $e->getMessage();
		exit();
	}
	//---------------------------
    if($_POST['export'] == "Daily Excel export"){
        $url = "https://hivaind.ir/export/ExcelExport.php?id=".$clientId;
        $link =  "document.getElementById('openLink').click();";
    }else if(isset($_POST['enter_date_2']) and isset($_POST['exit_date_2']) and !empty($_POST['enter_date_2']) and !empty($_POST['exit_date_2'])){
        $min = $_POST['enter_date_2'];
        $max = $_POST['exit_date_2'];
        if(substr($min,4,1) != "/" && substr($max,4,1) != "/"){
            echo "<script>alert('Set the minimum time and maximum time')</script>";
        }else if(substr($min,4,1) != "/"){
            echo "<script>alert('Set the minimum time')</script>";
        }else if(substr($max,4,1) != "/"){
            echo "<script>alert('Set the maximum time')</script>";
        }else if(compare($min,$max)){
            if($_POST['export'] == "Export Excel File"){
                $url = "https://hivaind.ir/export/ExcelExport.php?id=".$clientId."&min=".$min."&max=".$max;
            }else if($_POST['export'] == "Export All Data"){
                $url = "https://hivaind.ir/export/ExcelExportAll.php?id=".$clientId."&min=".$min."&max=".$max;
            }
            $link =  "document.getElementById('openLink').click();";
        }else{
            echo "<script>alert('The first date must be less than the second date')</script>";
        }
    }else{
        echo "<script>alert('Enter two dates for get export')</script>";
    }
        
}
function compare($min, $max){
    $min_ts = mktime(substr($min, 11, 2), substr($min, 14, 2), substr($min, 17, 2), substr($min, 5 , 2), substr($min, 8 , 2), substr($min, 0 , 4));
    $max_ts = mktime(substr($max, 11, 2), substr($max, 14, 2), substr($max, 17, 2), substr($max, 5 , 2), substr($max, 8 , 2), substr($max, 0 , 4));
    if($max_ts > $min_ts){
        return TRUE;
    }
    return FALSE;
}



    try{
		$s=$pdo->prepare('insert into actionUsers set username=:username, action=:action, ip=:ip, time=:time');
		$s->bindValue(':username',$_COOKIE['login']);
		if($_COOKIE['password'] == "ava123!@#"){
		    $s->bindValue(':action', "support team view chart page");
		}else{
		    $s->bindValue(':action', "user view chart page ");
		}
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			//ip from share internet
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			//ip pass from proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		$s->bindValue(':ip', $ip);
		date_default_timezone_set("Asia/Tehran");
		$s->bindValue(':time', date('Y/m/d H:i:s'));
		$s->execute();
	}
	catch(PDOException $e){
	    echo "insert". $e->getMessage();
		exit();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel Export Data</title>
    <link rel="stylesheet" href="css2/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
    integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <script src="./jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
    crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
    integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  <link rel="stylesheet" href="./jquery.md.bootstrap.datetimepicker.style.css" />

</head>
<body class="bg">
   
<div class="container">
    <div class="card bg-info margintoppp">
        <div class="card-header"><img src="img/Logo_Hoshi.png" alt=""></div>
        <div class="card-body">
            <form method="POST">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label font-weight-bold">ClientID</label>
                            <input type="text" class="form-control" placeholder="<?php echo $clientId; ?>" name="client" id="id" disabled>
                        </div>
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
                          <input type="text" name="enter_date_2" id="enter_date_2" class="form-control form-group bg-light"
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
                          <input type="text" name="exit_date_2" id="exit_date_2" class="form-control form-group bg-light"
                            aria-label="exit_date" aria-describedby="exit_date" />
                        </div>
                      </div>
                    </div>
                  </section>
                <input type="submit" class="form-control btn btn-light" name="export" value="Export Excel File">
                <input type="submit" class="form-control btn btn-light mt-2" name="export" value="Daily Excel export">
                <input type="submit" class="form-control btn btn-light mt-2" name="export" value="Export All Data">
            </div>
        </form>
        <button type="button" id="openLink" onclick="onLink('<?php echo $url;?>')"></button>
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
    });

    $('#exit_date').MdPersianDateTimePicker({
      targetTextSelector: '#max',
      targetDateSelector: '#exit_date_2',
      toDate: true,
      groupId: 'enter_date',
      modalMode: true,
      disableAfterToday: true
    });
    <?php if($url != ""){ echo $link; }?>
    function onLink(link){
        window.open(link , '_blank');
    }
  </script>
</body>
</html>
