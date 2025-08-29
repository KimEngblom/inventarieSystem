var currentCounter = parseInt(localStorage.getItem('currentCounter')) || 0;
var totCounter = parseInt(localStorage.getItem('totCounter')) || 0;

var currentNumber = document.getElementById("currentNumber");
var totalNumber = document.getElementById("totalNumber");
var minusButton = document.getElementById("minusButton");
var plusButton = document.getElementById("plusButton");
var resetCounter = document.getElementById("resetCounter");
var saveTotalCounter = document.getElementById("saveTotalCounter");
var saveCounterToDB = document.getElementById("saveCounterToDB");
currentNumber.textContent  = "Current " + currentCounter;
totalNumber.textContent  = "Total " + totCounter; 


plusButton.onclick = function() {
      currentCounter++;
      localStorage.setItem('currentCounter', currentCounter);
      currentNumber.textContent  = "Current " + currentCounter;

      totCounter++;
      localStorage.setItem('totCounter', totCounter);
      totalNumber.textContent  = "Total " + totCounter;
      saveTotalCounter.value = totCounter;     
};

minusButton.onclick = function(){
      currentCounter--;
      localStorage.setItem('currentCounter', currentCounter);
      currentNumber.textContent  = "Current " + currentCounter;
};

resetCounter.onclick = function() {
      currentCounter = 0;
      totCounter = 0;
      localStorage.setItem('currentCounter', currentCounter);
      localStorage.setItem('totCounter', totCounter);
      currentNumber.textContent  = "Current " + currentCounter;
      totalNumber.textContent  = "Total " + totCounter;
      saveTotalCounter.value = totCounter;
};

// Save date "function"
var date = new Date();

//format date 

var year    = date.getFullYear();
var month   = ("0" + (date.getMonth() + 1)).slice(-2);
var day     = ("0" + date.getDate()).slice(-2); 

var formattedDate = year + "-" + month + "-" + day;


document.getElementById("saveDateCounter").value = formattedDate;