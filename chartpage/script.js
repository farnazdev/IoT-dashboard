window.onload = function () {
    setInterval(function () {
        DateTime();
    }, 1000);
}

function DateTime() {
    var dateTime = new Date();
    var date = dateTime.getFullYear() + "/" + parseInt(parseInt(dateTime.getMonth()) + 1) + "/" + dateTime.getDate();
    var time = dateTime.getHours() + ":" + dateTime.getMinutes() + ":" + dateTime.getSeconds();

    document.getElementById("dateToday").textContent = date;
    document.getElementById("timeToday").textContent = time;
}
