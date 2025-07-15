<?php
// session_start();
// $amount = $_SESSION['amount'];
$information = $_GET['info'];
$j=0;
for($i=0; $i<strlen($information); $i++){
    if(substr($information,$i,1) == "_"){
        $j = $i;
        break;
    }
}
$info = substr($information, 0, $j);
$amount = substr($information, $j+1);
$data = array("merchant_id" => "b8e15a68-131c-422a-ad5b-150941835d4e",
    "amount" => $amount,
    "callback_url" => "http://avahiva.ir/dashboard/pardakht/verify.php?info=" . $info ,
    "description" => "خرید تست",
    "metadata" => [ "email" => "info@email.com","mobile"=>"09035612275"],
    );
$jsonData = json_encode($data);
$ch = curl_init('https://api.zarinpal.com/pg/v4/payment/request.json');
curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($jsonData)
));

$result = curl_exec($ch);
$err = curl_error($ch);
$result = json_decode($result, true, JSON_PRETTY_PRINT);
curl_close($ch);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    if (empty($result['errors'])) {
        if ($result['data']['code'] == 100) {
            header('Location: https://www.zarinpal.com/pg/StartPay/' . $result['data']["authority"]);
        }
    } else {
         echo'Error Code: ' . $result['errors']['code'];
         echo'message: ' .  $result['errors']['message'];

    }
}

?>
