function countdown(seconds) {
  seconds = parseInt(sessionStorage.getItem("seconds"))||seconds;

  function tick() {
    seconds--; 
    sessionStorage.setItem("seconds", seconds)
    var counter = document.getElementById("timer");
    var current_minutes = parseInt(seconds/60);
    var current_seconds = seconds % 60;
    counter.innerHTML = current_minutes + ":" + (current_seconds < 10 ? "0" : "") + current_seconds;
    if( seconds > 0 ) {
      setTimeout(tick, 1000);
    }if(seconds == 0){
      sessionStorage.clear();
      window.location.href='me.html';
    } 
  }
  tick();
}

countdown(3600); //place your time here