var pathBase = "webservice/control/";

// Closing login modal 
var modal = document.getElementById('loginForm');
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
