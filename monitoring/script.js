var clientId;
var clientName;
var timeNow;
var dateNow;
var dateTimeUpdate;
var connectionStatus;
var connectionColor;
var delay;
var refresh;
var inputsValue=[];
var inputTagName=[];

window.onload=function() {
    SetContentTag();
    console.log("inputTagName: "+inputTagName)
    console.log("inputsValue: "+inputsValue)

    setInterval(function() {
        SetContentTag();
        DateTime();
        console.log("inputTagName: "+inputTagName)
        console.log("inputsValue: "+inputsValue)
    },refresh*1000);

}

function DateTime() {
    var dateTime=new Date();
    var date=dateTime.getFullYear()+"/"+dateTime.getMonth()+1+"/"+dateTime.getDate();
    var time=dateTime.getHours()+":"+dateTime.getMinutes();

    //document.getElementById("dateToday").textContent=date;
    //document.getElementById("timeToday").textContent=time;
}

function GetUrl(id,user) {
    var url_str=window.location.href;
    var url=new URL(url_str);

    clientId=id;
    clientName=user;
    refresh=parseInt(url.searchParams.get("refresh"));

}

function Get(myUrl){
    let httpreq=new XMLHttpRequest();
    httpreq.open("GET",myUrl,false);
    httpreq.send(null);
    return httpreq.responseText;
}

function SetInput(input) {
    inputTagName.push(input);
}

function GetDataFromApi(){
    var hostData="http://hivaind.ir/wil/loglastjson81.php?id="+clientId;
    var json_obGetData=JSON.parse(Get(hostData));

    //timeNow=new Date().toLocaleTimeString('fa-IR');
    //dateNow=new Date().toLocaleDateString('fa-IR');
    console.log("-----------------emptyyyyyy----------------")
    inputsValue=[];


    for(var i=0;i<inputTagName.length;i++){
        inputsValue.push(GetInputParameter(inputTagName[i],json_obGetData));
    }

    delay=parseInt(json_obGetData.delay);
    dateTimeUpdate=String(json_obGetData.time_date);
    console.log("dateTimeUpdate: "+dateTimeUpdate);
    console.log("delay: "+delay);
    if(delay<10){
        connectionStatus="Connected";
        connectionColor="green";

    }
    else{
        connectionStatus="Disconnected";
        connectionColor="red";

    }

}

function GetInputParameter(value,json_objGet){
    switch (value) {
        case "inputA":
            value = parseFloat(parseFloat(json_objGet.inputA) / 100);
            break;
        case "inputB":
            value = parseFloat(parseFloat(json_objGet.inputB) / 100);
            break;
        case "inputC":
            value = parseFloat(parseFloat(json_objGet.inputC) / 100);
            break;
        case "inputD":
            value = parseFloat(parseFloat(json_objGet.inputD) / 100);
            break;
        case "inputE":
            value = parseFloat(parseFloat(json_objGet.inputE) / 100);
            break;
        case "inputF":
            value = parseFloat(parseFloat(json_objGet.inputF) / 100);
            break;
        case "inputG":
            value = parseFloat(parseFloat(json_objGet.inputG) / 100);
            break;
        case "inputH":
            value = parseFloat(parseFloat(json_objGet.inputH) / 100);
            break;
    }
    return value;
}


function SetContentTag(){
    GetDataFromApi();

    document.getElementById("txtDateTime").textContent=dateTimeUpdate;
    document.getElementById("txtConnection").style.color=connectionColor;
    document.getElementById("txtConnection").textContent=connectionStatus;
    document.getElementById("txtRefresh").textContent=refresh;

    for(var i=0;i<inputTagName.length;i++){
        document.getElementById(inputTagName[i]).textContent=inputsValue[i];
    }


}

function SendUrl(input) {
    //var url = "http://localhost:1234/DashManage/chart/chartapi.php?id=" + clientId + "&in=" + input;
     var url = "http://hoshiserver.ir/DashManage/chart/chartapi.php?id=" + clientId + "&in=" + input ;
   
    

    window.open(url,"_blank");
}