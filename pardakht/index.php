<html>
    <?php
    // session_start();
        $amount=$_GET['amount'];
        // $_SESSION['amount']=$amount;
        $info = $_GET['info'] . "_" . $_GET['amount']
        
    ?>
    <meta http-equiv="Refresh" content="0;url='Request.php'" />

<script> window.location.replace('Request.php?info=<?php echo $info; ?>')</script>
</html>

