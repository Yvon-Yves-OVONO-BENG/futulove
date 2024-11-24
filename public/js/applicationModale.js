// Get the modal
var modal = document.getElementById("myModal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// Get the logo image element in the modal
var modalLogo = document.getElementById("modal-logo");

// Get the buttons
var playstoreBtn = document.getElementById("playstore-btn");
var appstoreBtn = document.getElementById("appstore-btn");

// When the user clicks on the playstore button, open the modal and set the logo
playstoreBtn.onclick = function() {
    modal.style.display = "block";
    modalLogo.src = "images/logoApplications/playStore1.png"; // Replace with the path to your Play Store logo
}

// When the user clicks on the appstore button, open the modal and set the logo
appstoreBtn.onclick = function() {
    modal.style.display = "block";
    modalLogo.src = "images/logoApplications/appleStore1.png"; // Replace with the path to your App Store logo
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}