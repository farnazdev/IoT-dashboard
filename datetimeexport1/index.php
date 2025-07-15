<?php
include("../header.php");

if (!(isset($_SESSION["state_login"]) && $_SESSION["state_login"] === true)||
    isset($_SESSION["usertype"] ) && $_SESSION["usertype"] === "admin") {
    ?>
    <script type="text/javascript">
        location.replace("../logout.php");	 // منتقل شود logout.php به صفحه
    </script>
    <?php
}else{
    $username = $_SESSION['username'];

}
$clientId=$_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel Export Data</title>


    <link rel="stylesheet" href="css2/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css2/style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script>


    <script src="js2/bootstrap-datetimepicker.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

</head>
<body class="bg">
<div class="container">
    <div class="panel panel-primary margintoppp">
        <div class="panel-heading"><img src="img/Logo_Hoshi.png" alt=""></div>
        <div class="panel-body">
            <form _lpchecked="1">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">ClientID</label>
                            <input type="text" class="form-control" placeholder="<?php echo $clientId; ?>" name="client" id="id" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class='col-md-6'>
                        <div class="form-group">
                            <label class="control-label">Min</label>
                            <div class='input-group date' id='datetimepickermin'>
                                <input type='text' class="form-control" id="min" name="min" />
                                <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                            </div>
                        </div>
                    </div>
                    <div class='col-md-6'>
                        <div class="form-group">
                            <label class="control-label">Max</label>
                            <div class='input-group date' id='datetimepickermax'>
                                <input type='text' class="form-control" id="max" name="max" />
                                <span class="input-group-addon">
                           <span class="glyphicon glyphicon-calendar"></span>
                           </span>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="button" class="form-control btn btn-primary" value="Export Excel File" onclick="sendParameter();">
        </div>
        </form>
    </div>
</div>
<script src="script.js"></script>


</body>
</html>
