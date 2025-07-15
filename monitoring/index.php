<?php
include("../header.php");

$username = $_GET['user'];
$clientId=$_GET['id'];
$api_url = "https://hivaind.ir/property/user-check.php?usr=" .$username;
$json = file_get_contents($api_url);
$allIdForUser = json_decode($json);
$inputs = array();
foreach ($allIdForUser as $id){
    if($id->id==$clientId){
        foreach ($id->input as $in){
            $arr=array(
                "input"=>$in
            );
            array_push($inputs,$arr);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مانیتورینگ تاسیسات</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="script.js?version=1"></script>
    <?php
    echo "<script>GetUrl('$clientId','$username')</script>";
    ?>

</head>
<body class="grey-bg  p-3" >

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card p-2">
                <div class="row">
                    <h4 class="col-6" id="txtClientId"><?php echo $clientId;?></h4>
                    <h4 class="col-6" id="txtClientName"><?php echo $username;?></h4>
                </div>
                <div class="row">
                    <h5 class="text-primary  col-6">Client ID</h5>
                    <h5 class="text-primary col-6">Client Name</h5>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card p-2">
                <div class="row">
                    <h4 class="col-12" id="txtDateTime"></h4>
                </div>
                <div class="row">
                    <h5 class="text-primary col-12">Last Time Data Updated</h5>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card p-2">
                <div class="row">
                    <h4 class="col-12" id="txtConnection"></h4>
                </div>
                <div class="row">
                    <h5 class="text-primary col-12">Connection Status</h5>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card p-2">
                <div class="row">
                    <h4 class="col-12" id="txtRefresh"></h4>
                </div>
                <div class="row">
                    <h5 class="text-primary col-12">Refresh Time</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card p-2">
                <div class="row">
                    <h4 class="col-12" id="txtRefresh"></h4>
                </div>
                <div class="row">
                    <a class="btn col-5  btn-danger m-3" href="https://hivaind.ir/computation/multiComputationUI.php?id=<?=$clientId?>">multi Computation</a>
                </div>
            </div>
        </div>

    </div>

    <?php
    if(count($inputs)>0){


        ?>

        <div class="row">
            <?php
            foreach($inputs as $in){
                $inputNow=$in['input'];
                echo "<script>SetInput('$inputNow')</script>";
                ?>
                <div class="col-xl-3 col-sm-6 col-12" style="cursor: pointer;" onclick="SendUrl('<?php echo strval($in["input"]); ?>');">
                    <div class="card p-2">
                        <div class="row">
                            <h4 class="col-12" id="<?php echo $in['input']; ?>"></h4>
                        </div>
                        <div class="row">
                            <button class="btn btn-primary  col-6 m-3" ><?php echo $in["input"]; ?></button>
                        </div>
                    </div>
                </div>
                <?php
            }

            ?>
        </div>

        <?php
    }
    ?>

</div>
</body>

</html>
