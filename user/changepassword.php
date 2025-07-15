<?php
include("../header.php");

    $username = $_GET['user'];

    $apiUser_url="https://hivaind.ir/DashManage/users.php?usr=".$username;
    $apiUser_json=file_get_contents($apiUser_url);
    $apiUser=json_decode($apiUser_json);





?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Passwoed</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../asset/css/style.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script src="js/JavaScript.js"></script>

</head>
<body>
<?php
    if(isset($_POST['changePass'])){
        if(isset($_POST['oldPassword']) && !empty($_POST['oldPassword'])
        && isset($_POST['newPassword']) && !empty($_POST['newPassword'])
        && isset($_POST['reNewPassword']) && !empty($_POST['reNewPassword'])){
            $oldPassword=$_POST['oldPassword'];
            $newPassword=$_POST['newPassword'];
            $reNewPassword=$_POST['reNewPassword'];


            if(isset($apiUser->username)){
                if($newPassword===$reNewPassword){
                    $apiUpdatePassword_url="https://hivaind.ir/DashManage/updatePassword.php?usr=".$username."&pass=".$newPassword;
                    $apiUpdatePassword_json=file_get_contents($apiUpdatePassword_url);
                    $apiUpdatePassword=json_decode($apiUpdatePassword_json);

                    echo "<script>alert('Password changed successfully');location.replace('./index.php?action=logout')</script>";

                }
                else{
                    echo "<script>alert('The new password and its repetition are not the same!!!')</script>";
                }
            }
            else{
                echo "<script>alert('Old Password is wrong')</script>";
            }
        }
        else{
            echo "<script>alert('Some fields are not set , Please fill in all fields!!!')</script>";
        }
    }

    ?>

<div class="navbar_ffix  ">

    <div class="row">
        <div class="col-sm-2">
            <img src="pic/Logo_Hoshi.png" id="img-Logo" class="align-middle float-left" />
        </div>
        <div class="col-sm-8">
            <h1 class=" font-weight-bold text-center  align-middle d-flex justify-content-center text-white">Change Passwoed</h1>
        </div>
        <div class="col-sm-1"  style="cursor: pointer;">
            <p class="h1 float-right"  onclick="logout();"><i class=" fas fa-power-off mx-auto d-block pb-1 text-right font-weight-bold text-white p-1 pr-4"></i></p>
        </div>
    </div>
</div>


<div class="container main-div  shadow p-3 mb-5 bg-white ">
    <div class="row ">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <form name="login_action" action="" method="post" class="form-group p-5 m-2">
                <label for="username" class="mt-3  font-weight-bold"><i class="fas fa-user icon_color"></i>
                    Username:</label>
                <input type="text" class="form-control " placeholder="Please Enter username ..." name="username"
                     value="<?php echo $username; ?>"  disabled>

                <label for="oldPassword" class="mt-3  font-weight-bold"><i class="fas fa-key icon_color"></i>
                   Old Password:</label>
                <input type="password" class="form-control mb-3" name="oldPassword"
                       required>

                <label for="newPassword" class="mt-3  font-weight-bold"><i class="fas fa-key icon_color"></i>
                   New Password:</label>
                <input type="password" class="form-control mb-3" name="newPassword"
                       required>

                <label for="reNewPassword" class="mt-3  font-weight-bold"><i class="fas fa-key icon_color"></i>
                  Re New Password:</label>
                <input type="password" class="form-control mb-3" name="reNewPassword"
                       required>


                <input id="changePass" type="submit" class="form-control mt-3 btn_color font-weight-bold text-center" value="Change Password"
                       name="changePass">

            </form>

        </div>
    </div>

</div>

</body>
</html>