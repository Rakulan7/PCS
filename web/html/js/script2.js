// Ouvrir le modal lorsque "S'IDENTIFIER" est cliqué
document.getElementById("openModal").addEventListener("click", function() {
  document.getElementById("myModal").style.display = "block";
});

// Fermer le modal lorsque l'utilisateur clique sur la croix ou en dehors du formulaire
var modal = document.getElementById("myModal");
var closeBtn = document.getElementsByClassName("close")[0];

window.onclick = function(event) {
  if (event.target == modal) {
      modal.style.display = "none";
  }
};

closeBtn.onclick = function() {
  modal.style.display = "none";
};
