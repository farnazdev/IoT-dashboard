<?php
$url = "https://hivaind.ir/wil/allDataUser.php?usr=haraz";
$url_json = @file_get_contents($url);
$data = json_decode($url_json, true);
echo "<script>console.log(".json_encode($data).");</script>";