
function getMaxDateFunction() {
    var d = new Date();
    var y = d.getFullYear();
    var m = d.getMonth();
    var da = d.getDate() +0;
    var h = d.getHours();
    var mi = d.getMinutes();
    var se = d.getSeconds();
    var mDate = new Date(y, m, da, h, mi, se);
    return mDate;
};

function getMinDateFunction() {
    var d = new Date();
    var y = d.getFullYear();
    var m = d.getMonth();
    var da = d.getDate() - 14;
    var h = d.getHours();
    var mi = d.getMinutes();
    var se = d.getSeconds();
    var mDate = new Date(y, m, da, h, mi, se);
    return mDate;
};

function sendParameter(myId){
    //var myId=document.getElementById("id").textContent;
    var minBase=document.getElementById("enter_date_2").textContent;
    var maxBase=document.getElementById("exit_date_2").textContent;
    const dMin = new Date(minBase);
    var min = String(dMin.getFullYear())+"-"+String(dMin.getMonth()+1)+"-"+String(dMin.getDate());
    const dMax = new Date(maxBase);
    var max = String(dMax.getFullYear())+"-"+String(dMax.getMonth()+1)+"-"+String(dMax.getDate());
    var url="https://hivaind.ir/export/ExcelExport.php?id="+myId+"&min="+min+"&max="+max;
    console.log("min: "+minBase);
    console.log(url);
    window.open(url,"_blank");
}
function sendParameter7(myId){
    var minBase=document.getElementById("enter_date_2").textContent;
    var maxBase=document.getElementById("exit_date_2").textContent;
    
    console.log(minBase[4]);
    console.log(minBase.length);
    if(minBase[4] === "/" && maxBase[4] === "/"){
        const dMin = new Date(minBase);
        var min = String(dMin.getFullYear())+"-"+String(dMin.getMonth()+1)+"-"+String(dMin.getDate());
        const dMax = new Date(maxBase);
        var max = String(dMax.getFullYear())+"-"+String(dMax.getMonth()+1)+"-"+String(dMax.getDate());
        var url="https://hivaind.ir/export/ExcelExportAll.php?id="+myId+"&min="+min+"&max="+max;
        console.log(url);
        window.open(url,"_blank");
    }else if(minBase[4] != "/" && maxBase[4] != "/"){
        alert("Set the minimum time and maximum time ");
    }else if(minBase[4] === "/"){
        alert("Set the maximum time ");
    }else if(maxBase[4] === "/"){
        alert("Set the minimum time");
    }
}
function sendParameter15(myId){
    var minBase=document.getElementById("enter_date_2").textContent;
    var maxBase=document.getElementById("exit_date_2").textContent;
    
    console.log(minBase[4]);
    console.log(minBase.length);
    if(minBase[4] === "/" && maxBase[4] === "/"){
        const dMin = new Date(minBase);
        var min = String(dMin.getFullYear())+"-"+String(dMin.getMonth()+1)+"-"+String(dMin.getDate());
        const dMax = new Date(maxBase);
        var max = String(dMax.getFullYear())+"-"+String(dMax.getMonth()+1)+"-"+String(dMax.getDate());
        var url="https://hivaind.ir/export/ExcelExportAll.php?id="+myId+"&min="+min+"&max="+max+"&dwn=180";
        console.log(url);
        window.open(url,"_blank");
    }else if(minBase[4] != "/" && maxBase[4] != "/"){
        alert("Set the minimum time and maximum time ");
    }else if(minBase[4] === "/"){
        alert("Set the maximum time ");
    }else if(maxBase[4] === "/"){
        alert("Set the minimum time");
    }
}
function sendParameteDS(myId){
    var minBase=document.getElementById("enter_date_2").textContent;
    var maxBase=document.getElementById("exit_date_2").textContent;
    var downsampling = parseInt(document.getElementById("time").value);
    console.log(minBase[4]);
    console.log(minBase.length);
    if(minBase[4] === "/" && maxBase[4] === "/"){
        const dMin = new Date(minBase);
        var min = String(dMin.getFullYear())+"-"+String(dMin.getMonth()+1)+"-"+String(dMin.getDate());
        const dMax = new Date(maxBase);
        var max = String(dMax.getFullYear())+"-"+String(dMax.getMonth()+1)+"-"+String(dMax.getDate());
        var url="https://hivaind.ir/export/exportTiming.php?id="+myId+"&min="+min+"&max="+max+"&time="+downsampling;
        console.log(url);
        window.open(url,"_blank");
    }else if(minBase[4] != "/" && maxBase[4] != "/"){
        alert("Set the minimum time and maximum time ");
    }else if(minBase[4] === "/"){
        alert("Set the maximum time ");
    }else if(maxBase[4] === "/"){
        alert("Set the minimum time");
    }
}










