//get query string
var query=new URLSearchParams(window.location.search);
//get data for user 
$.getJSON("http://hivaind.ir/property/jsonIDproperty.php?id=" +query.get('id'), function(data){

    var username=data[0].usr;  //get username
    document.getElementById("username").innerHTML=username; //set username
    document.getElementById("uid").innerHTML=query.get('id'); //set id 
    //set date and time
    /*var date=new Date();
    document.getElementById("date").innerHTML=miladi_be_shamsi(date.getFullYear(),date.getMonth(),date.getDay());
    document.getElementById("time").innerHTML=date.getHours()+":"+date.getMinutes();*/
    //get data for ids that connect       
    var url='http://hivaind.ir/property/user-check.php?usr='+username;
    $.getJSON(url, function(data){
        var countUsers=data.length;
        document.getElementById("countuser").innerHTML=countUsers;
    });
});
//Convert miladi date to shamsi 
function miladi_be_shamsi(gy, gm, gd) {
	var g_d_m, jy, jm, jd, gy2, days;
	g_d_m = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];
    gy2 = (gm > 2) ? (gy + 1) : gy;
	days = 355666 + (365 * gy) + ~~((gy2 + 3) / 4) - ~~((gy2 + 99) / 100) + ~~((gy2 + 399) / 400) + gd + g_d_m[gm - 1];
	jy = -1595 + (33 * ~~(days / 12053));
    days %= 12053;
	jy += 4 * ~~(days / 1461);
    days %= 1461;
	if (days > 365) {
        jy += ~~((days - 1) / 365);
	    days = (days - 1) % 365;
	}
    if (days < 186) {
	    jm = 1 + ~~(days / 31);
	    jd = 1 + (days % 31);
    } else {
	    jm = 7 + ~~((days - 186) / 30);
	    jd = 1 + ((days - 186) % 30);
    }
	return [jy + '/' + jm + '/' + jd];
}