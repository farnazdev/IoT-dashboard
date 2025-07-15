<?php

session_start();
unset($_SESSION['state_login']);
unset($_SESSION['usertype']);
unset($_SESSION['username']);
unset($_SESSION['captchaValid']);
unset($_SESSION['CAPTCHA_CODE']);
unset($_SESSION['password']);
unset($_SESSION['email']);
unset($_SESSION['type']);


session_unset();

session_destroy();

?>

<script type="text/javascript">
location.replace("../login/login.php");
</script>