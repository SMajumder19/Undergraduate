function Calculate(){
    var revenue = document.getElementById("revenue").value;
    var expense = document.getElementById("expense").value;

    var result = (parseFloat(revenue)) - (parseFloat(expense));

    if(!isNaN(result)){
        document.getElementById("cal-output").innerHTML = result;
        if(result < 0){
            document.getElementById("cal-status").innerHTML = "Loss";
        }
        else{
            document.getElementById("cal-status").innerHTML = "Profit";
        }
    }
}