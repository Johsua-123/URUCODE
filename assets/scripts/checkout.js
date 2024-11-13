var modal = document.getElementById("orderModal");

var btn = document.getElementById("placeOrder");

var span = document.getElementsByClassName("close")[0];

btn.onclick = function(event) {
    event.preventDefault();
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

document.getElementById("goHome").onclick = function() {
    window.location.href = "index.php";
}