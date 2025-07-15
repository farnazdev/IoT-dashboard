<?php
    $clientID = "";
    $clientID = $_GET["id"];
    $infoID = json_decode(file_get_contents('https://hivaind.ir/wil/informationID.php?id='.$clientID));
    $username = $infoID->usr;
    $api_url = "https://hivaind.ir/property/user-check.php?usr=".strval($username);
    $json = file_get_contents($api_url);
    $allIdForUser = json_decode($json);
    $inputs = array();
    $ins = array();
    $sensors = array();
    $url_edit = "https://hivaind.ir/ALR/wil/Edit-configAPI.php?id=".$clientID;
    $file = file_get_contents($url_edit);
    $info = json_decode($file);
    $mianx = true;
    if(isset($info->status)){
        $mianx = false;
    }
    foreach($allIdForUser as $id){
        if($id->id == $clientID){
            foreach($id->input as $in){
                $arr = array("input"=>$in, "label"=>"");
                array_push($inputs, $arr);
                array_push($ins, $in);
            }
            foreach($id->sensor as $sen){
                array_push($sensors, $sen);
            }
        }
    }
    echo "<script>console.log('".json_encode($sensors)."')</script>";
    $apiLabel_url = "https://hivaind.ir/DashManage/label.php?id=".$clientID;
    $apiLabel_json = file_get_contents($apiLabel_url);
    $apiLabel = json_decode($apiLabel_json);
    
    include "../includes/db.inc.php";
    try{
        $s = $pdo->prepare("select device from idsdevice where clientid=:id");
        $s->bindValue(":id", $clientID);
        $s->execute();
    }catch(PDOException $e){
    	echo "error in select data".$e->getMessage();
    	exit();
    }
    $device = $s->fetch();
    echo "<script>console.log('device: ".$device['device']."')</script>";
    if(isset($_POST['changeInfo'])){
        if($_POST['device'] != "noselect"){
            if($device == ""){
                try{
                    $s = $pdo->prepare("insert into idsdevice set clientid=:id, device=:device");
                    $s->bindValue(":id", $clientID);
                    $s->bindValue(":device", $_POST['device']);
                    $s->execute();
                }catch(PDOException $e){
                	echo "error in select data".$e->getMessage();
                	exit();
                }
            }else{
                try{
                    $s = $pdo->prepare("update idsdevice set device=:device where clientid=:id");
                    $s->bindValue(":id", $clientID);
                    $s->bindValue(":device", $_POST['device']);
                    $s->execute();
                }catch(PDOException $e){
                	echo "error in select data".$e->getMessage();
                	exit();
                }
            }
        }else{
            try{
                $s = $pdo->prepare("delete from idsdevice where clientid=:id");
                $s->bindValue(":id", $clientID);
                $s->execute();
            }catch(PDOException $e){
            	echo "error in select data".$e->getMessage();
            	exit();
            }
        }
        if(isset($_POST['deviceName']) && !empty($_POST['deviceName'])){
                $deviceName = $_POST['deviceName'];
            	$content = http_build_query(array(
					// this is where you list all data you want to post 
					'id' => $clientID,
					'deviceName' => $deviceName
				));

				$context = stream_context_create(array(
					'http' => array(
						'method' => 'POST',
						'content' => $content,
					)
				));

				$callurl = file_get_contents('https://hivaind.ir/DashManage/updateLabel.php', null, $context);
        }
        if(isset($_POST['inputA']) && !empty($_POST['inputA'])){
            $inputA=$_POST['inputA'];
            	$content = http_build_query(array(
					// this is where you list all data you want to post 
					'id' => $clientID,
					'ina' => $inputA
				));

				$context = stream_context_create(array(
					'http' => array(
						'method' => 'POST',
						'content' => $content,
					)
				));

				$callurl = file_get_contents('https://hivaind.ir/DashManage/updateLabel.php', null, $context);

        }
        if(isset($_POST['inputB']) && !empty($_POST['inputB'])){
            $inputB=$_POST['inputB'];
            	$content = http_build_query(array(
					// this is where you list all data you want to post 
					'id' => $clientID,
					'inb' => $inputB
				));

				$context = stream_context_create(array(
					'http' => array(
						'method' => 'POST',
						'content' => $content,
					)
				));

				$callurl = file_get_contents('https://hivaind.ir/DashManage/updateLabel.php', null, $context);

       }
        if(isset($_POST['inputC']) && !empty($_POST['inputC'])){
            $inputC=$_POST['inputC'];
            	$content = http_build_query(array(
					// this is where you list all data you want to post 
					'id' => $clientID,
					'inc' => $inputC
				));

				$context = stream_context_create(array(
					'http' => array(
						'method' => 'POST',
						'content' => $content,
					)
				));

				$callurl = file_get_contents('https://hivaind.ir/DashManage/updateLabel.php', null, $context);

        }
        if(isset($_POST['inputD']) && !empty($_POST['inputD'])){
            $inputD=$_POST['inputD'];
            	$content = http_build_query(array(
					// this is where you list all data you want to post 
					'id' => $clientID,
					'ind' => $inputD
				));

				$context = stream_context_create(array(
					'http' => array(
						'method' => 'POST',
						'content' => $content,
					)
				));

				$callurl = file_get_contents('https://hivaind.ir/DashManage/updateLabel.php', null, $context);

        }
        if(isset($_POST['inputE']) && !empty($_POST['inputE'])){
            $inputE=$_POST['inputE'];
            	$content = http_build_query(array(
					// this is where you list all data you want to post 
					'id' => $clientID,
					'ine' => $inputE
				));

				$context = stream_context_create(array(
					'http' => array(
						'method' => 'POST',
						'content' => $content,
					)
				));

				$callurl = file_get_contents('https://hivaind.ir/DashManage/updateLabel.php', null, $context);

        }
        if(isset($_POST['inputF']) && !empty($_POST['inputF'])){
            $inputF=$_POST['inputF'];
            	$content = http_build_query(array(
					// this is where you list all data you want to post 
					'id' => $clientID,
					'inf' => $inputF
				));

				$context = stream_context_create(array(
					'http' => array(
						'method' => 'POST',
						'content' => $content,
					)
				));

				$callurl = file_get_contents('https://hivaind.ir/DashManage/updateLabel.php', null, $context);

        }
        if(isset($_POST['inputG']) && !empty($_POST['inputG'])){
            $inputG = $_POST['inputG'];
            	$content = http_build_query(array(
					// this is where you list all data you want to post 
					'id' => $clientID,
					'ing' => $inputG
				));
				$context = stream_context_create(array(
					'http' => array(
						'method' => 'POST',
						'content' => $content,
					)
				));
				$callurl = file_get_contents('https://hivaind.ir/DashManage/updateLabel.php', null, $context);
        }
        if(isset($_POST['inputH']) && !empty($_POST['inputH'])){
            $inputH=$_POST['inputH'];
            	$content = http_build_query(array(
					// this is where you list all data you want to post 
					'id' => $clientID,
					'inh' => $inputH
				));
				$context = stream_context_create(array(
					'http' => array(
						'method' => 'POST',
						'content' => $content,
					)
				));
				$callurl = file_get_contents('https://hivaind.ir/DashManage/updateLabel.php', null, $context);
        }
        if(isset($_POST['sensorA']) && !empty($_POST['sensorA'])){
            $sensor=$_POST['sensorA'];
            	$content = http_build_query(array(
					// this is where you list all data you want to post 
					'id' => $clientID,
					'sena' => $sensor
				));
				$context = stream_context_create(array(
					'http' => array(
						'method' => 'POST',
						'content' => $content,
					)
				));
				$callurl = file_get_contents('https://hivaind.ir/DashManage/updateLabel.php', null, $context);
        }
        if(isset($_POST['sensorB']) && !empty($_POST['sensorB'])){
            $sensor=$_POST['sensorB'];
            	$content = http_build_query(array(
					// this is where you list all data you want to post 
					'id' => $clientID,
					'senb' => $sensor
				));
				$context = stream_context_create(array(
					'http' => array(
						'method' => 'POST',
						'content' => $content,
					)
				));
				$callurl = file_get_contents('https://hivaind.ir/DashManage/updateLabel.php', null, $context);
        }
        if(isset($_POST['sensorC']) && !empty($_POST['sensorC'])){
            $sensor=$_POST['sensorC'];
            	$content = http_build_query(array(
					// this is where you list all data you want to post 
					'id' => $clientID,
					'senc' => $sensor
				));
				$context = stream_context_create(array(
					'http' => array(
						'method' => 'POST',
						'content' => $content,
					)
				));
				$callurl = file_get_contents('https://hivaind.ir/DashManage/updateLabel.php', null, $context);
        }
        if(isset($_POST['sensorC']) && !empty($_POST['sensorC'])){
            $sensor=$_POST['sensorC'];
            	$content = http_build_query(array(
					// this is where you list all data you want to post 
					'id' => $clientID,
					'senc' => $sensor
				));
				$context = stream_context_create(array(
					'http' => array(
						'method' => 'POST',
						'content' => $content,
					)
				));
				$callurl = file_get_contents('https://hivaind.ir/DashManage/updateLabel.php', null, $context);
        }
        if(isset($_POST['sensorD']) && !empty($_POST['sensorD'])){
            $sensor=$_POST['sensorD'];
            	$content = http_build_query(array(
					// this is where you list all data you want to post 
					'id' => $clientID,
					'send' => $sensor
				));
				$context = stream_context_create(array(
					'http' => array(
						'method' => 'POST',
						'content' => $content,
					)
				));
				$callurl = file_get_contents('https://hivaind.ir/DashManage/updateLabel.php', null, $context);
        }
        if(isset($_POST['sensorE']) && !empty($_POST['sensorE'])){
            $sensor=$_POST['sensorE'];
            	$content = http_build_query(array(
					// this is where you list all data you want to post 
					'id' => $clientID,
					'sene' => $sensor
				));
				$context = stream_context_create(array(
					'http' => array(
						'method' => 'POST',
						'content' => $content,
					)
				));
				$callurl = file_get_contents('https://hivaind.ir/DashManage/updateLabel.php', null, $context);
        }
        if(isset($_POST['sensorF']) && !empty($_POST['sensorF'])){
            $sensor=$_POST['sensorF'];
            	$content = http_build_query(array(
					// this is where you list all data you want to post 
					'id' => $clientID,
					'senf' => $sensor
				));
				$context = stream_context_create(array(
					'http' => array(
						'method' => 'POST',
						'content' => $content,
					)
				));
				$callurl = file_get_contents('https://hivaind.ir/DashManage/updateLabel.php', null, $context);
        }
        if(isset($_POST['sensorG']) && !empty($_POST['sensorG'])){
            $sensor=$_POST['sensorG'];
            	$content = http_build_query(array(
					// this is where you list all data you want to post 
					'id' => $clientID,
					'seng' => $sensor
				));
				$context = stream_context_create(array(
					'http' => array(
						'method' => 'POST',
						'content' => $content,
					)
				));
				$callurl = file_get_contents('https://hivaind.ir/DashManage/updateLabel.php', null, $context);
        }
        if(isset($_POST['sensorH']) && !empty($_POST['sensorH'])){
            $sensor=$_POST['sensorH'];
            	$content = http_build_query(array(
					// this is where you list all data you want to post 
					'id' => $clientID,
					'senh' => $sensor
				));
				$context = stream_context_create(array(
					'http' => array(
						'method' => 'POST',
						'content' => $content,
					)
				));
				$callurl = file_get_contents('https://hivaind.ir/DashManage/updateLabel.php', null, $context);
        }
        if($mianx){
            if(in_array('inputA', $ins)){
                if(isset($_POST['mininputA']) and isset($_POST['maxinputA']) and $_POST['mininputA'] != "" and $_POST['maxinputA'] != ""){
                    $minA = $_POST['mininputA'];
                    $maxA = $_POST['maxinputA'];
                }
            }else{
                $minA = $info->minA;
                $maxA = $info->maxA;
            }
            if(in_array('inputB', $ins)){
                
                if(isset($_POST['mininputB']) and isset($_POST['maxinputB']) and $_POST['mininputB'] != "" and $_POST['maxinputB'] != ""){
                    $minB = $_POST['mininputB'];
                    $maxB = $_POST['maxinputB'];
                }
            }else{
                $minB = $info->minB;
                $maxB = $info->maxB;
            }
            if(in_array('inputC', $ins)){
                if(isset($_POST['mininputC']) and isset($_POST['maxinputC']) and $_POST['mininputC'] != "" and $_POST['maxinputC'] != ""){
                    $minC = $_POST['mininputC'];
                    $maxC = $_POST['maxinputC'];
                }
            }else{
                $minC = $info->minC;
                $maxC = $info->maxC;
            }
            if(in_array('inputD', $ins)){
                if(isset($_POST['mininputD']) and isset($_POST['maxinputD']) and $_POST['mininputD'] != "" and $_POST['maxinputD'] != ""){
                    $minD = $_POST['mininputD'];
                    $maxD = $_POST['maxinputD'];
                }
            }else{
                $minD = $info->minD;
                $maxD = $info->maxD;
            }
            
            $url2 = "https://hivaind.ir/ALR/wil/configAPI.php?id=1047&tkn=kwcbm12wh85j&mina=0&maxa=0&minb=0&maxb=0&minc=0&maxc=0&mind=0&maxd=0";
            $url = "https://hivaind.ir/ALR/wil/configAPI.php?id=" .$clientID. "&tkn=kwcbm12wh85j&mina=" .$minA. "&maxa=" .$maxA. "&minb=" .$minB. "&maxb=" .$maxB. "&minc=" .$minC. "&maxc=" .$maxC. "&mind=" .$minD. "&maxd=" .$maxD;
            $result = file_get_contents($url);  
            if(!$result){
                echo "<script>alert('Your changes were not applied. Please try again');</script>";
            }else{  
                echo "<script>location.replace('https://avahiva.ir/dashboard/user/?user=".$username."')</script>";
            }
        }
        echo "<script>location.replace('https://avahiva.ir/dashboard/user/?user=".$username."')</script>";
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting</title>
    <link rel="stylesheet" href="./bootstrap.min.css">
    <link rel="stylesheet" href="../asset/css/style.css" />
    <link rel="icon" type="image/x-icon" href="./pic/icons8-setting-16.png">
    <script src="js/JavaScript.js"></script>
</head>
<body>
<div class="navbar_ffix">
    <div class="row">
        <div class="col-sm-2">
            <img src="pic/Logo_Hoshi.png" id="img-Logo" class="align-middle float-left" />
        </div>
        <div class="col-sm-8">
            <h1 class=" font-weight-bold text-center  align-middle d-flex justify-content-center text-white">Change Device Name</h1>
        </div>
        <div class="col-sm-1" style="cursor: pointer;">
            <p class="h1  float-right"  onclick="AllId();"><i class=" fas fa-address-card mx-auto d-block pb-1 text-right font-weight-bold text-white p-1 pr-4"></i></p>
        </div>
        <div class="col-sm-1"  style="cursor: pointer;">
            <p class="h1 float-right"  onclick="logout();"><i class=" fas fa-power-off mx-auto d-block pb-1 text-right font-weight-bold text-white p-1 pr-4"></i></p>
        </div>
    </div>
</div>
<?php
    if(isset($apiLabel->clientID)&&$apiLabel->clientID==$clientID){
?>
<div class="container main-div  shadow p-3 mb-5 bg-white ">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <form  name="login_action" method="post" class="form-group p-5 m-2">
                <label for="id" class="mt-3  font-weight-bold"><i class="far icon_color"></i> ClientID:</label>
                <input type="text"  class="form-control "   value="<?php echo $clientID; ?>" name="id" disabled>
                
                <label for="id" class="mt-3  font-weight-bold"><i class="far icon_color"></i> Select Device:</label>
                <select class="form-select form-control" name="device">
                    <option value="noselect" <?php if($device['device'] == ""){echo "selected";}?>>هیچ کدام</option>
                    <option value="wbm" <?php if($device['device'] == "wbm"){echo "selected";}?> >
                        WBM
                    </option>
                    <option value="arda" <?php if($device['device'] == "arda"){echo "selected";}?> >
                        دیتالاگر مدل arda    
                    </option>
                    <option value="ataman" <?php if($device['device'] == "ataman"){echo "selected";}?>>
                        دیتالاگر مدل ataman
                    </option>
                    <option value="aran" <?php if($device['device'] == "aran"){echo "selected";}?>>
                        دیتالاگر مدل aran
                    </option>
                    <option value="deepfreezer" <?php if($device['device'] == "deepfreezer"){echo "selected";}?>>
                        دیپ فریزر (تجهیز فردوس)
                    </option>
                    <option value="tissuecultureroom" <?php if($device['device'] == "tissuecultureroom"){echo "selected";}?>>
                        سردخانه دارو (تجهیز فردوس)
                    </option>
                    <option value="laboratoryfreezer" <?php if($device['device'] == "laboratoryfreezer"){echo "selected";}?>>
                        فریزر آزمایشگاهی (تجهیز فردوس)
                    </option>
                    <option value="refrigerator" <?php if($device['device'] == "refrigerator"){echo "selected";}?>>
                        یخچال آزمایشگاهی (تجهیز فردوس)
                    </option>
                    <option value="pharmaceuticalrefrigerator" <?php if($device['device'] == "Pharmaceuticalrefrigerator"){echo "selected";}?>>
                        یخچال دارویی (تجهیز فردوس)
                    </option>
                    <option value="freezerandlaboratoryrefrig" <?php if($device['device'] == "freezerandlaboratoryrefrig"){echo "selected";}?>>
                        یخچال و فریزر آزمایشگاهی(تجهیز فردوس)
                    </option>
                    <option value="laboratoryfreezerarminco" <?php if($device['device'] == "laboratoryfreezerarminco"){echo "selected";}?>>
                        فریزر آزمایشگاهی (آرمینکو)
                    </option>
                </select>
                
                <label for="deviceName" class="mt-3  font-weight-bold"><i class="far fa-edit icon_color"></i> Device Name:</label>
                <input type="text"  class="form-control " placeholder="Please Enter devicename ..." name="deviceName" value="<?php echo $apiLabel->deviceName;?>">

                <?php foreach ($inputs as $in){ ?>
                    <label  class="mt-3  font-weight-bold"><i class="far fa-edit icon_color"></i> <?php echo $in["input"]; ?> Name:</label>
                    <input type="text"  class="form-control "   placeholder="Please Enter Input Name ..."  name="<?php echo $in["input"]; $column=$in["input"];?>" value="<?php echo $apiLabel->$column;?>">
                    <?php   if($mianx){ 
                                $valuemin = "min".substr($in["input"],5,1);
                                $valuemax = "max".substr($in["input"],5,1); ?>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <label for="id" class="mt-3  font-weight-bold">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16">
                                  <path d="M3.204 5h9.592L8 10.481zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659"/>
                                </svg>
                                minimum:
                            </label>
                            <input type="text" class="form-control rounded" name="min<?php echo $in["input"]; ?>" value="<?php if(isset($info->$valuemin)){ echo $info->$valuemin;}?>">
                        </div>
                        <div class="col-12 col-lg-6">
                            <label for="id" class="mt-3  font-weight-bold">
                                <svg width="16" height="16" fill="currentColor" class="bi bi-caret-up" viewBox="0 0 16 16">
                                  <path d="M3.204 11h9.592L8 5.519zm-.753-.659 4.796-5.48a1 1 0 0 1 1.506 0l4.796 5.48c.566.647.106 1.659-.753 1.659H3.204a1 1 0 0 1-.753-1.659"/>
                                </svg>
                                maximum:
                            </label>
                            <input type="text" class="form-control rounded" name="max<?php echo $in["input"]; ?>" value="<?php if(isset($info->$valuemax)){ echo $info->$valuemax;}?>">
                        </div>
                    </div>
                    <?php } ?>
                <?php } ?>
                <?php foreach ($sensors as $sen){ ?>
                    <label  class="mt-3  font-weight-bold"><i class="far fa-edit icon_color"></i> <?php echo $sen; ?> Name:</label>
                    <input type="text"  class="form-control "   placeholder="Please Enter Input Name ..."  name="<?php echo $sen; $column=$sen;?>" value="<?php echo $apiLabel->$column;?>">
                <?php } ?>
                <input type="submit" class="form-control mt-3 btn_color font-weight-bold text-center" value="Set" name="changeInfo">
            </form>
        </div>
    </div>
</div>
</body>
</html>
<?php
    }
    else{
        echo "<script>alert('This ID is not set')</script>";
    }


?>