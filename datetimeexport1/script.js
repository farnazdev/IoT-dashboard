$('#datetimepickermin').datetimepicker({
    format: "DD-MMM-YYYY",

    minDate: getMinDateFunction(),
    maxDate: getMaxDateFunction(),
    defaultDate: null,
    // use24hours: true,

});

$('#datetimepickermax').datetimepicker({
    format: "DD-MMM-YYYY",
    minDate: getMinDateFunction(),
    maxDate: getMaxDateFunction(),
    defaultDate: null,
});

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

function sendParameter(){
    var myId=document.getElementById("id").value;
    var min=document.getElementById("min").value;
    var max=document.getElementById("max").value;
    var url="https://hivaind.ir/export/ExcelExport.php?id="+myId+"&min="+min+"&max="+max;

    window.open(url,"_blank");
}