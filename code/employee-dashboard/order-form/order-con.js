// Get today's date
var today = new Date();

// Extract date components
var day = today.getDate();
var month = today.getMonth() + 1; // Month is zero-based, so add 1
var year = today.getFullYear();

// Format the date as desired (e.g., "MM/DD/YYYY")
var formattedDate = month + '/' + day + '/' + year;

formattedDate = 'Date: ' + formattedDate;

// Display the date in the HTML element with id "date"
document.getElementById("date").textContent = formattedDate;

function goToOrderMan() {
    window.location.href = "order-man.php";
}

function goToRequest() {
    window.location.href = "send-request.php";
}