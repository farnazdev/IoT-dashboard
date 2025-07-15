<?php
include("header.php");
$tableName = 'users';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
            integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="asset/css/style.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
          integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

</head>
<body>

<?php
if (!empty($_POST["forgotpassword"])) {
    if ((isset($_POST['email']) && !empty($_POST['email']))
        && (isset($_POST['username']) && !empty($_POST["username"]))) {
        $email = $_POST['email'];
        $username=$_POST['username'];
    } else {
        // exit("<h4>Some fields are not set , Please fill in all fields</h4>");
        exit('<script>alert("Some fields are not set , Please fill in all fields");window.history.back();</script>');

    }

    $apiUser_url = "https://hivaind.ir/DashManage/users.php?usr=" . $username;
    $apiUser_json = file_get_contents($apiUser_url);
    $apiUser = json_decode($apiUser_json);


    if (isset($apiUser->username)) {

        $_SESSION["user_username"] = $apiUser->username;
        $random_number = rand(100000, 999999);
        $has_number = md5($random_number);
        $url = 'http://www.hoshiserver.ir/DashManage/reset_password.php??' . $has_number;

        $apiUpdateForgotPassword_url = "https://hivaind.ir/DashManage/updateForgotPassword.php?usr=".$username."&email=".$email."&forgot=".$url ;
        $apiUpdateForgotPassword_json = file_get_contents($apiUpdateForgotPassword_url);
        $apiUpdateForgotPassword=json_decode($apiUpdateForgotPassword_json);

        if (isset($apiUpdateForgotPassword->status) && $apiUpdateForgotPassword->status=='forgot_password updated') {
            $to = $email;
            $subject = 'forgot password';
            $message = "Hello " . $_SESSION["user_username"] . '<br/>' . 'This email was sent by Hoshiserver to reset the password.' . '<br/>'
                . 'Please click the link below to change the password. ' . '<br/>' . '<br/>' . '
            <a href="' . $url . '"><input type="button" value="reset password"></a>';
            $headers = 'From: Forgotpassword@hoshiserver.ir' . "\r\n" .
                'MIME-Version: 1.0' . "\r\n" .
                'Content-type: text/html; charset=utf-8' . "\r\n" .
                'Content-Type: text/html; charset=ISO-8859-1';
            if (mail($to, $subject, $message, $headers))
                // echo("<h4>A password recovery link was sent to your email , Please check your email , if you do not receive an email check your spam</h4>");
                echo '<script>alert("A password recovery link was sent to your email , Please check your email , if you do not receive an email check your spam");location.replace("user/index.php?action=logout");</script>';

            else
                // echo "Email sending failed , please try again";
                echo '<script>alert("Email sending failed , please try again");location.replace("user/index.php?action=logout");</script>';

        } else {
            // echo("<h4>There was a problem sending the link to the email , please try again</h4>");
            echo '<script>alert("There was a problem sending the link to the email , please try again");location.replace("user/index.php?action=logout");</script>';

        }
    } else {
        // echo("<h4>Your email could not be found</h4>");
        echo '<script>alert("Your email could not be found Or your user does not have access to change the password!! ");window.history.back();</script>';

    }


}
?>


<div class="navbar_ffix">

    <img src="asset/img/Logo_Hoshi.png"" id="img-Logo" class="align-middle" />
    <h1 class=" font-weight-bold text-center  align-middle d-flex justify-content-center text-white">Forget
        Password</h1>
</div>

<div class="container main-div shadow p-3 mb-5 bg-white ">
    <div class="row ">
        <div class="col-lg-12 col-md-12 col-sm-12 ">
            <form name="forgot_password_action" action="" method="post" class="form-group p-5 m-2">
                <label for="username" class="mt-3  font-weight-bold"><i class="fas fa-user icon_color"></i> Username :</label>
                <input type="text" class="form-control mb-3" placeholder="Please Enter Username ..." name="username" required>

                <label for="username" class="mt-3  font-weight-bold"><i class="fas fa-mail-bulk icon_color"></i> Email :</label>
                <input type="email" class="form-control " placeholder="Please Enter Email ..." name="email" required>

                <input type="submit" class="form-control mt-3 btn_color font-weight-bold text-center" value="send email"
                       name="forgotpassword">
            </form>
        </div>
    </div>
</div>

</body>
</html>