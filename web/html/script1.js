document.addEventListener("DOMContentLoaded", function() {
  var modal = document.getElementById("container1");
  var btn = document.getElementById("openModal");
  var span = document.getElementsByClassName("close")[0];

  btn.onclick = function() {
    modal.style.display = "block";    
  }

  span.onclick = function() {
    modal.style.display = "none";
  }

  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }

});

function showSignup() {
  document.getElementById("login-form").style.display = "none";
  document.getElementById("signup-form").style.display = "flex";
}

function showLogin() {
  document.getElementById("login-form").style.display = "flex";
  document.getElementById("signup-form").style.display = "none";
}

