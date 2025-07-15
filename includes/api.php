<?php
header('Content-Type: application/json');

function getApiUrls($username) {
    return [
        'all_Data' => "https://hivaind.ir/wil/allDataUser.php?usr={$username}",
        'all_Data_backup' => "https://hivaindbackup.ir/wil/allDataUser.php?usr={$username}",
        'user_check' => "https://hivaind.ir/property/user-check.php?usr={$username}",
        'log_Last_json' => "https://hivaind.ir/wil/loglastjson81.php?id=",
        'information_ID' => "https://hivaind.ir/wil/informationID.php?id="
    ];
}

header('Content-Type: application/json');

if (isset($_GET['username'])) {
    $username = $_GET['username'];
    echo json_encode(getApiUrls($username));
} else {
    echo json_encode(['error' => 'No username provided']);
}
