// admin Login
function adminLogin() {
    // Get user input values
    var userName = document.getElementById('userName').value.trim();
    var password = document.getElementById('password').value.trim();

    // Sanitize user input to prevent XSS (sanitize for basic characters)
    userName = userName.replace(/</g, "&lt;").replace(/>/g, "&gt;");
    password = password.replace(/</g, "&lt;").replace(/>/g, "&gt;");

    // Prepare the form data
    var form = new FormData();
    form.append('userName', userName);
    form.append('password', password);

    // Create the XMLHttpRequest
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            if (r.responseText.trim() == 'success') {
                // Redirect to admin page on successful login
                location.href = 'admin.php';
            } else {
                // Display generic error message to avoid information leaks
                alert(r.responseText);
            }
        }
    };

    // Send the request (POST method)
    r.open("POST", "adminLoginprocess.php", true);
    r.send(form);
}

// add product image change
function tProductImage(x) {
    var image = document.getElementById("img_input_" + x);
    image.click();

    image.onchange = function () {
        var file_count = image.files.length;
        if (file_count == 1) {
            var file = image.files[0];
            var url = window.URL.createObjectURL(file);
            var div = document.getElementById("di_" + x);  // Target the div instead of img

            // Set the background image of the div
            div.style.backgroundImage = "url('" + url + "')";
            div.style.backgroundSize = "contain";  // Optional: to make the image cover the div
            div.style.backgroundPosition = "center";  // Optional: to center the image
            div.style.backgroundRepeat = "no-repeat";  // Optional: to prevent image repetition

            // Hide the span element
            document.getElementById("img_span_" + x).className = "d-none";
        } else {
            alert("Please select an image.");
        }
    }
}

// update product image change

function imageget(x, y) {
    var imgElement = document.getElementById("img_div_" + x + "_" + y);
    if (imgElement) imgElement.style.display = 'none';
}
function uProductImage(x, y) {
    var image = document.getElementById("img_input_" + x + "_" + y);
    image.click();
    image.onchange = function () {
        var file_count = image.files.length;
        if (file_count == 1) {
            var file = image.files[0];
            var url = window.URL.createObjectURL(file);
            var div = document.getElementById("di_" + x + "_" + y); // Target the div instead of img

            // Set the background image of the div
            div.style.backgroundImage = "url('" + url + "')";
            div.style.backgroundSize = "contain"; // Optional: to make the image cover the div
            div.style.backgroundPosition = "center"; // Optional: to center the image
            div.style.backgroundRepeat = "no-repeat"; // Optional: to prevent image repetition

            // Hide the span element
            document.getElementById("img_span_" + x).className = "d-none";
        } else {
            alert("Please select an image.");
        }
    }
}

// list town
function list_town() {

    var did = document.getElementById("ad_id").value;

    var r = new XMLHttpRequest();
    var form = new FormData();
    form.append("did", did);

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            if (r.responseText == "Error") {
                document.getElementById("at_id").value = null;
            } else if (r.responseText == "Please select a ditsrict.") {
                document.getElementById("at_id").value = null;
            } else {
                document.getElementById("at_id").innerHTML = r.responseText;
            }
        }
    }
    r.open("POST", "process/change-city-process.php", true);
    r.send(form);

}

function list_dfee() {

    var did = document.getElementById("dfd_id").value;

    var r = new XMLHttpRequest();
    var form = new FormData();
    form.append("did", did);

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            if (r.responseText == "Error") {
                document.getElementById("df-table").value = null;
            } else if (r.responseText == "Please select a ditsrict.") {
                document.getElementById("df-table").value = null;
            } else {
                document.getElementById("df-table").innerHTML = r.responseText;
            }
        }
    }
    r.open("POST", "process/changecity.php", true);
    r.send(form);

}

// add town columns
var town_col_count = 0;
function add_town_col() {
    var town_col = document.getElementById("town_col");
    if (town_col_count <= 5) {
        town_col_count = town_col_count + 1;
        town_col.innerHTML += "<div class='col-6 col-md-4'>" +
            "<div class='form-floating mb-3'>" +
            "<input type='text' class='form-control rounded-0' id='tc_" + town_col_count + "' value='' placeholder='charges'>" +
            "<label for=''>Town " + town_col_count + " name</label>" +
            "</div>" +
            "</div>";
            document.getElementById("num").value = town_col_count;
    } else {
        alert("A maximum of six towns can be added at a time.");
    }


}

function admin_logout() {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            if (r.responseText == "done") {
                window.location.href = "authentication-login.php";
            } else if (r.responseText == "Something went wrong !") {
                location.reload();
            }
        }
    }

    r.open("POST", "process/admin-logout.php", true);
    r.send();
}