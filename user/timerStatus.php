<?php
include("../header.php");

if (!(isset($_SESSION["state_login"]) && $_SESSION["state_login"] === true) ||
    (isset($_SESSION["usertype"]) && $_SESSION["usertype"] === "admin")) {
    ?>
    <script type="text/javascript">
        location.replace("../logout.php");	 // منتقل شود logout.php به صفحه

    </script>
    <?php
} else {
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
}

$clientID = $_GET["id"];
$find = file_get_contents("http://hivaind.ir/control/timerApi.php?id=$clientID");
$info = json_decode($find, true); // decode the JSON feed
$statusTimer = $info['statusTimer'];
if ($statusTimer == '-') {
    $key = 'off';
} else {
    $key = 'on';
}
$project = $info['project'];
$deviceName = $info['deviceName'];
if ($_POST["update"]) {
    $key=$_POST["key"];
    $resultUpdate = file_get_contents("http://hivaind.ir/control/updateControl.php?id=$clientID&key=$key");
    echo "<meta http-equiv='refresh' content='0'>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>form status</title>
</head>
<style>
    body {
        background-color: #252B34;

    }
    .card{
        margin-top: 30%;
    }

    .on_off:after {
        left: 2%;
        content: "O";
        background: #696868;
        border: transparent;
        display: flex;
        align-items: center !important;
        justify-content: center !important;
    }

    .on_off:checked:after {
        left: 45%;
        content: "I";
        background: #55ff00;
        border: transparent;
        display: flex;
        align-items: center !important;
        justify-content: center !important;
    }

    .flipswitch {
        position: relative;
        background: white;
        width: 70px;
        height: 40px;
        -webkit-appearance: initial;
        border-radius: 20px;
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        outline: none;
        font-size: 14px;
        cursor: pointer;
        border: 1px solid #ddd;
    }

    .flipswitch:after {
        position: absolute;
        top: 10%;
        display: block;
        line-height: 20px !important;
        width: 50%;
        height: 80%;
        background: #fff;
        box-sizing: border-box;
        text-align: center;
        transition: all 0.3s ease-in 0s;
        color: black;
        border: #888 1px solid;
        border-radius: 20px;
    }

    .form-label {
        font-size: 24px;
    }
</style>

<body class="d-flex justify-content-center">
    <div class="col-sm-11 col-md-5 col-lg-3 card m-5">
        <div class="card-header">
            <div class="h3">
                <?= "$deviceName( id $clientID  )" ?>
            </div>

        </div>
        <div class="card-body d-flex justify-content-center">
            <?php
            if ($project == "control") {
            ?>
                <form class="center" action="" method="post">
                    <div class="d-flex align-items-center m-3">
                        <label class="form-label" for="key">
                            ON/OFF
                        </label>
                        <input type="hidden" id="key" name="key" value="off">
                        <input class="flipswitch on_off mx-3" type="checkbox" id="key" name="key" value="on" <?php if (!empty($key) && $key == 'on') echo "checked"; ?>>
                    </div>
                    <!-- Input For Edit Values -->
                    <input class="m-3 btn btn-info" type="submit" onclick="return confirm('Are you sure you want to update?')" name="update" value="Update">
                </form>
            <?php
            } else {
            ?>
                <div class="alert alert-danger" role="alert">
                    Your clientID for the Wil project is set up and this form
                    Your project is not supported!
                </div>
            <?php
            } ?>
        </div>

    </div>

</body>

</html>