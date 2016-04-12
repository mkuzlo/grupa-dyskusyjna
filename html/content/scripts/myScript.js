function changeCounter() {
   var message = document.getElementById("message");
   var counter = document.getElementById("counter");
   var val = message.value.toString().length;
   counter.innerHTML = val + "/2000";
   var button = document.getElementById("button");
   
   if(val>2000){
       button.disabled = true;
   }
   else{
        button.disabled = false;
   }
}