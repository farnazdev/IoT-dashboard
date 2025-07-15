var qs = new URLSearchParams(window.location.search);
var usr = qs.get('user');
var lang = "en";
console.log(usr);
$.getJSON("../includes/api.php", { username: usr }, function (data) {
    const userCheck = data.user_check;
    const logLastJson = data.log_Last_json; 
    const informationID = data.information_ID;

    console.log("✅ all_Data URL:", userCheck);

    setInterval(function(){
        console.log("update");
        $.getJSON(userCheck , function(data){
            console.log(data);
            for(var i=0; i<data.length; i++){
                inputs = data[i].input;
                for(var j=0; j<inputs.length; j++){
                    
                    update(data[i].id, inputs[j]);
                }
            }
            console.log(lang)
        });
    },10000);   

    function update(id, input){
        console.log("input= "+input);
        $.getJSON(logLastJson + id , function(data){
            $.getJSON(informationID + id , function(data1){
                console.log('data.inputD = ', data.inputD)
                if(data==null){
                    console.log("data is null...");
                }
                console.log("input= "+input);
                var inputId = "" + id + input;
                var inputValue;
                switch(String(input)){
                    case "inputA":
                        // inputValue = parseInt(data.inputA) + parseInt(data1.cA);
                        inputValue = parseInt(data.inputA);
                        break;
                    case "inputB":
                        // inputValue = parseInt(data.inputB) + parseInt(data1.cB);
                        inputValue = parseInt(data.inputB);
                        break;
                    case "inputC":
                        // inputValue = parseInt(data.inputC) + parseInt(data1.cC);
                        inputValue = parseInt(data.inputC);
                        break;
                    case "inputD":
                        // inputValue = parseInt(data.inputD) + parseInt(data1.cD);
                        inputValue = parseInt(data.inputD);
                        break;
                    case "inputE":
                        inputValue = data.inputE;
                        break;
                    case "inputF":
                        inputValue = data.inputF;
                        break;
                    case "inputG":
                        inputValue = data.inputG;
                        break;
                    case "inputH":
                        inputValue = data.inputH;
                        break;
                }
                if(inputValue < -9000){
                }else{
                    document.getElementById(inputId).innerHTML = inputValue/100;
                }
                console.log("id: " + id + " input: " + input + " value = " + inputValue);
            })
            
        }).fail(function() {
            console.log("fail")
            // $.getJSON("https://hivaindbackup.ir/wil/loglastjson81.php?id=" + id , function(data){
                
            //     if(data==null){
            //         console.log("data is null...");
            //     }
                
            //     var inputId = "" + id + input;
            //     var inputValue;
            //     switch(String(input)){
            //         case "inputA":
            //             inputValue = data.inputA;
            //             break;
            //         case "inputB":
            //             inputValue = data.inputB;
            //             break;
            //         case "inputC":
            //             inputValue = data.inputC;
            //             break;
            //         case "inputD":
            //             inputValue = data.inputD;
            //             break;
            //         case "inputE":
            //             inputValue = data.inputE;
            //             break;
            //         case "inputF":
            //             inputValue = data.inputF;
            //             break;
            //         case "inputG":
            //             inputValue = data.inputG;
            //             break;
            //         case "inputH":
            //             inputValue = data.inputH;
            //             break;
            //     }
            //     if(inputValue < -90){
            //         // document.getElementById(inputId).innerHTML = '<i class="mdi mdi-alert text-warning"></i>';
            //     }else{
            //         document.getElementById(inputId).innerHTML = inputValue/100;
            //     }
                
                
            // })
        })
        console.log("id: " + id + " input: " + input );
        
    }
    // window.onload = function () {
    //     GetURL();
    // }    
    
    // function GetURL() {
    //     let url_str = window.location.href;
    //     var url = new URL(url_str);
    //     var date = new Date;
    //     var day = date.getDate();
    //     var mount = date.getMonth() + 1;
    //     var year = date.getFullYear();
    //     var today = year + "-" + mount + "-" + day;
    //     var datePersian = new Date(today).toLocaleDateString('fa-IR');
    //     document.getElementById("txtDate").textContent = datePersian;
    //     var username = document.getElementById("txtUserId").textContent;
    // }

}).fail(function() {
  console.error("error in fetching data");
});

var base_direct="https://avahiva.ir/dashboard";

function monitoring(myId) {
    var url = base_direct+"/monitoring/index.php?id=" + myId + "&refresh=5";
    window.open(url, "_blank");
}

function excel(myId) {
    var url = base_direct+"/datetimeexport/index.php?id="+myId ;
    window.open(url, "_blank");

}

function SendConfigForm() {
    var url ="https://hivaind.ir/crud/formUI.php";
    window.open(url, "_blank");
}

function Get(myUrl) {
    let httpreq=new XMLHttpRequest();
    httpreq.open("GET",myUrl,false);
    httpreq.send(null);
    return httpreq.responseText;
}

function GetInputFromApi(inputValue,myId) {
    var hostData = logLastJson + myId;
    var json_obGetData=JSON.parse(Get(hostData));
    let value;
    switch (inputValue) {
        case "inputA":
            value = parseFloat(parseFloat(json_obGetData.inputA) / 100);
            break;
        case "inputB":
            value = parseFloat(parseFloat(json_obGetData.inputB) / 100);
            break;
        case "inputC":
            value = parseFloat(parseFloat(json_obGetData.inputC) / 100);
            break;
        case "inputD":
            value = parseFloat(parseFloat(json_obGetData.inputD) / 100);
            break;
        case "inputE":
            value = parseFloat(parseFloat(json_obGetData.inputE) / 100);
            break;
        case "inputF":
            value = parseFloat(parseFloat(json_obGetData.inputF) / 100);
            break;
        case "inputG":
            value = parseFloat(parseFloat(json_obGetData.inputG) / 100);
            break;
        case "inputH":
            value = parseFloat(parseFloat(json_obGetData.inputH) / 100);
            break;
    }
    document.write(value);

}

function setting(myId) {
    var url = base_direct+"/user/setting.php?id="+myId ;
    window.open(url, "_blank");
}
// function statusForm(myId) {
//     var url = "http://hoshiserver.ir/DashManage/userdashboard/timerStatus.php?id="+myId ;
//     window.open(url, "_blank");
// }

function changePass(username) {
    var url = base_direct+"/user/changepassword.php?user="+username ;
    window.open(url, "_blank");

}

function changelang() {
    console.log("change language")
    if(lang == "fa"){
        document.getElementById("cname").innerHTML = "Client Name";
        document.getElementById("profile").innerHTML = "Profile";
        document.getElementById("countid").innerHTML = "Count Of IDs:";
        document.getElementById("alarmpanel").innerHTML = "Alarm Panel";
        document.getElementById("help").innerHTML = "Help";
        document.getElementById("support").innerHTML = "Support";
        document.getElementById("mprofile").innerHTML = "Profile";
        document.getElementById("malarmpanel").innerHTML = "Alarm Panel";
        document.getElementById("mhelp").innerHTML = "Help";
        document.getElementById("msupport").innerHTML = "Support";
        document.getElementById("ddprofile").innerHTML = "Profile";
        document.getElementById("ddresetpassword").innerHTML = "reset password";
        document.getElementById("ddlogout").innerHTML = "Logout";
        document.getElementById("lang").innerHTML = "change language";
        lang = "en";
        console.log("to en")
    }else if(lang == "en"){
        document.getElementById("cname").innerHTML = "نام کاربری";
        document.getElementById("profile").innerHTML = "حساب کاربری";
        document.getElementById("countid").innerHTML = "تعداد دستگاه:";
        document.getElementById("alarmpanel").innerHTML = "پنل آلارم";
        document.getElementById("help").innerHTML = "راهنمایی";
        document.getElementById("support").innerHTML = "پشتیبانی";
        document.getElementById("mprofile").innerHTML = "حساب کاربری";
        document.getElementById("malarmpanel").innerHTML = "پنل آلارم";
        document.getElementById("mhelp").innerHTML = "راهنمایی";
        document.getElementById("msupport").innerHTML = "پشتیبانی";
        document.getElementById("ddprofile").innerHTML = "حساب کاربری";
        document.getElementById("ddresetpassword").innerHTML = "تغییر رمز عبور";
        document.getElementById("ddlogout").innerHTML = "خروج";
        document.getElementById("lang").innerHTML = "تغییر زبان";
        lang = "fa";
        console.log("to fa")
    }
}