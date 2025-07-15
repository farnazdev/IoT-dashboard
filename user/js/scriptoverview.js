var qs = new URLSearchParams(window.location.search);
var usr = qs.get('user');
var url = "https://hivaind.ir/property/user-check.php?usr=" + usr;
var lang = "en";
setInterval(function(){
    console.log("update");
    $.getJSON(url , function(data){
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
    $.getJSON("https://hivaind.ir/wil/loglastjson81.php?id=" + id , function(data){
        $.getJSON("https://hivaind.ir/wil/informationID.php?id=" + id , function(data1){
            $.getJSON("https://hivaind.ir/ALR/wil/Edit-configAPI.php?id=" + id , function(data2){
                if(data==null){
                    console.log("data is null...");
                }
                console.log("input= "+input);
                var inputId = "" + id + input;
                var inputValue;
                var min;
                var max;
                switch(String(input)){
                    case "inputA":
                        inputValue = parseInt(data.inputA) + parseInt(data1.cA);
                        min = data2.minA;
                        max = data2.maxA;
                        break;
                    case "inputB":
                        inputValue = parseInt(data.inputB) + parseInt(data1.cB);
                        min = data2.minB;
                        max = data2.maxB;
                        break;
                    case "inputC":
                        inputValue = parseInt(data.inputC) + parseInt(data1.cC);
                        min = data2.minC;
                        max = data2.maxC;
                        break;
                    case "inputD":
                        inputValue = parseInt(data.inputD) + parseInt(data1.cD);
                        min = data2.minD;
                        max = data2.maxD;
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
                if(inputValue > -9000){
                    document.getElementById(inputId).innerHTML = parseInt(inputValue)/100;
                    if(parseInt(inputValue) > parseInt(max)*100){
                        document.getElementById(inputId).style.color = "#dc3545";
                    }else if(parseInt(inputValue) < parseInt(min)*100){
                        document.getElementById(inputId).style.color = "#0d6efd";
                    }
                    
                }
            });
        });
    });   
}







