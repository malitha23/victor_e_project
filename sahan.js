function login() {
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value.trim();
    var remember = document.getElementById("remember").checked;

    // Check if email or password is empty
    if (email === "" || password === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Missing Information',
            text: 'Please enter both email and password.',
            confirmButtonText: 'OK',
            confirmButtonColor: '#f39c12', // Orange color for warning
        });
        return;
    }

    let formData = new FormData();
    formData.append("email", email);
    formData.append("password", password);
    formData.append("remember", remember);

    fetch("loginpro.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.text())
        .then(data => {
            if (data == 1) {
                Swal.fire({
                    title: '<span style="color: white; font-size: 24px;">Login Successful!</span>',
                    html: '<span style="color: white; font-size: 18px;">Welcome back! You have successfully logged in.</span>',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 3000,  // Alert will disappear after 3 seconds
                    position: 'center',
                    background: 'rgba(0, 0, 0, 0.8)',
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                }).then(() => {
                    // After alert closes, redirect to the homepage
                    window.location = "index.php";
                });
            } else {
                Swal.fire({
                    title: 'Login Failed!',
                    text: data,
                    icon: 'error',
                    confirmButtonText: 'Try Again',
                    backdrop: `
                    rgba(255,0,0,0.4)
                    url("https://media.giphy.com/media/5t9IcFhUEk2PzxHcYK/giphy.gif")
                    right top
                    no-repeat
                `
                });
            }
        })
        .catch(error => {
            Swal.fire({
                title: 'Network Error!',
                text: 'Something went wrong. Please try again later.',
                icon: 'error',
                confirmButtonText: 'Okay'
            });
        });

}
function forgotpassword() {
    let email = document.getElementById("email").value.trim();

    if (email === "") {
        alert("Please enter your email address.");
        return;
    }
    var req = new XMLHttpRequest();
    req.open("POST", "forgotpasspro.php", true);
    var form = new FormData();
    form.append("email", email);
    req.onload = function () {
        if (req.status === 200) {
            let response = req.responseText;
            if (response == 1) {
                forgotpasswordformo();
                alert("check your inbox");
            } else {
                alert(response);
            }
        } else {
            alert("An error occurred while processing your request. Please try again.");
        }
    };
    req.onerror = function () {
        alert("Failed to send request. Check your network connection.");
    };
    req.send(form);
}
function forgotpasswordformo() {
    const modal = new bootstrap.Modal(document.getElementById('forgotPasswordModal'));
    modal.show();
}
function updatePassword() {
    const verificationCode = document.getElementById('verificationCode').value;
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    let email = document.getElementById("email").value.trim();

    // Validate inputs
    if (!verificationCode || !newPassword || !confirmPassword) {
        alert('Please fill in all fields.');
        return;
    }
    if (newPassword !== confirmPassword) {
        alert('Passwords do not match.');
        return;
    }

    // Prepare data to send
    const data = new FormData();
    data.append('verificationCode', verificationCode);
    data.append('newPassword', newPassword);
    data.append("email", email);

    // Create and send AJAX request
    const req = new XMLHttpRequest();
    req.open('POST', 'updatepasswordpr.php', true);

    req.onload = function () {
        if (req.status === 200) {
            const response = JSON.parse(req.responseText); // Assuming the server returns JSON
            if (response.success) {
                alert('Password updated successfully!');
                // Optionally close the modal after success
                const modal = bootstrap.Modal.getInstance(document.getElementById('forgotPasswordModal'));
                modal.hide();
            } else {
                alert('Error: ' + response.message);
            }
        } else {
            alert('An error occurred while processing your request.');
        }
    };

    req.onerror = function () {
        alert('Network error. Please try again later.');
    };

    req.send(data);
}
function Register() {

    const mobile = document.getElementById("mobile").value.trim();
    const email = document.getElementById("emailTwo").value.trim();
    const password = document.getElementById("enter-password").value.trim();

    // Validate mobile number
    if (!mobile) {
        Swal.fire({
            icon: 'warning',
            title: 'Mobile Number Missing',
            text: 'Please enter your mobile number.',
            confirmButtonText: 'OK',
            confirmButtonColor: '#f39c12', // Orange color for warning
        });
        return;
    }

    // Validate mobile number length
    if (!/^[0-9]{10}$/.test(mobile)) {
        Swal.fire({
            icon: 'warning',
            title: 'Invalid Mobile Number',
            text: 'Mobile number must be 10 digits.',
            confirmButtonText: 'OK',
            confirmButtonColor: '#f39c12',
        });
        return;
    }

    // Validate email address
    if (!email) {
        Swal.fire({
            icon: 'warning',
            title: 'Email Address Missing',
            text: 'Please enter your email address.',
            confirmButtonText: 'OK',
            confirmButtonColor: '#f39c12',
        });
        return;
    }

    // Validate email format
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        Swal.fire({
            icon: 'warning',
            title: 'Invalid Email Address',
            text: 'Please enter a valid email address.',
            confirmButtonText: 'OK',
            confirmButtonColor: '#f39c12',
        });
        return;
    }

    // Validate password
    if (!password) {
        Swal.fire({
            icon: 'warning',
            title: 'Password Missing',
            text: 'Please enter your password.',
            confirmButtonText: 'OK',
            confirmButtonColor: '#f39c12',
        });
        return;
    }

    // Validate password length
    if (password.length < 6) {
        Swal.fire({
            icon: 'warning',
            title: 'Weak Password',
            text: 'Password must be at least 6 characters long.',
            confirmButtonText: 'OK',
            confirmButtonColor: '#f39c12',
        });
        return;
    }

    var form = new FormData();
    form.append("mobile", mobile);
    form.append("email", email);
    form.append("password", password);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        // Ensure the request is complete and check the status
        if (req.readyState === 4) {
            if (req.status === 200) {
                var x = req.responseText;
                if (x == 1) {
                    Swal.fire({
                        title: '<span style="color: white; font-size: 24px;">Success!</span>',
                        html: '<span style="color: white; font-size: 18px;">Registered successfully.</span>',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 3000,
                        background: 'rgba(0, 0, 0, 0.8)',
                        showClass: {
                            popup: 'animate__animated animate__zoomIn'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__zoomOut'
                        }
                    });

                    // Automatically fill the email and password fields
                    document.getElementById("email").value = email;
                    document.getElementById("password").value = password;

                    // Call the login function after the alert
                    setTimeout(() => { login(); }, 2000);
                } else {
                    Swal.fire({
                        title: 'Oops!',
                        text: x,
                        icon: 'error',
                        confirmButtonText: 'Try Again',
                        backdrop: `
                            rgba(255,0,0,0.4)
                            url("https://media.giphy.com/media/5t9IcFhUEk2PzxHcYK/giphy.gif")
                            center left
                            no-repeat
                        `
                    });
                }
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'Error: ' + req.status,
                    icon: 'error',
                    confirmButtonText: 'Okay'
                });
            }
        }
    };
    req.open("POST", "registerpro.php", true);
    req.send(form);
}
function updatepro() {
    var firstname = document.getElementById("first-name").value;
    var lastname = document.getElementById("last-name").value;
    var mobile = document.getElementById("mobile").value;
    var birthday = document.getElementById("birthday").value;
    var district = document.getElementById("district").value;
    var city = document.getElementById("city").value;
    var address1 = document.getElementById("address-line-1").value;
    var address2 = document.getElementById("address-line-2").value;
    var email = document.getElementById("email").value;


    var form = new FormData();


    form.append("firstname", firstname);
    form.append("lastname", lastname);
    form.append("mobile", mobile);
    form.append("birthday", birthday);
    form.append("district", district);
    form.append("city", city);
    form.append("address1", address1);
    form.append("address2", address2);
    form.append("email", email);
    var req = new XMLHttpRequest();
    req.open("POST", "updateProfilepro.php", true);
    req.onreadystatechange = function () {
        if (req.readyState === 4 && req.status === 200) {
            const responseText = req.responseText;
            if (responseText == "profile update") {
                Swal.fire({
                    title: '<span style="font-size: 22px; font-weight: bold; color: #333;">Profile Updated Successfully</span>',
                    html: '<p style="font-size: 16px; color: #555;">' + responseText + '</p>',
                    icon: 'success',
                    iconColor: '#28a745',
                    confirmButtonText: 'Continue',
                    confirmButtonColor: '#ff6600',
                    background: '#ffffff',
                    color: '#333',
                    width: '400px',
                    padding: '20px',
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    },
                    didOpen: () => {
                        document.querySelector('.swal2-confirm').style.borderRadius = '10px';
                    }
                }).then(() => {
                    location.reload();  // Corrected `window.reload()` to `location.reload()`
                });                
            } else {
                Swal.fire({
                    title: 'Alert',
                    text: responseText,
                    icon: 'info',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6',
                    background: '#f9f9f9',
                    color: '#333',
                });
            }
        } else if (req.readyState === 4) {
            Swal.fire({
                title: 'Alert',
                text: "An error occurred. Please try again.",
                icon: 'error',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6',
                background: '#f9f9f9',
                color: '#333',
            });
        }
    };
    req.send(form);
}
function plusprice(qty, id) {
    var form = new FormData();
    form.append("id", id);
    form.append("qty", qty + 1);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState === 4) {
            if (req.status === 200) {
                if (req.responseText == 0) {
                    Swal.fire({
                        title: 'Quantity NOT Updated',
                        text: 'Discounts are available for limited quantities only. Do not increase quantities beyond this.',
                        icon: 'success',
                        showConfirmButton: true,
                        confirmButtonColor: '#3085d6',
                        background: '#fefefe',
                        color: '#333',
                        timer: 10000,
                        timerProgressBar: true
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'quantity updated',
                        text: req.responseText,
                        icon: 'success',
                        showConfirmButton: true,
                        confirmButtonColor: '#3085d6',
                        background: '#fefefe',
                        color: '#333',
                        timer: 3000,
                        timerProgressBar: true,
                    });
                    location.reload();
                }
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to update quantity. Please try again.',
                    icon: 'error',
                    confirmButtonColor: '#d33',
                });
            }
        }
    };

    req.open("POST", "qtychange.php", true);
    req.send(form);
}
function minprice(qty, id) {
    var form = new FormData();
    form.append("id", id);
    form.append("qty", qty - 1);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState === 4) {
            if (req.status === 200) {
                if (req.responseText == 0) {
                    Swal.fire({
                        title: 'Quantity NOT Updated',
                        text: 'Discounts are available for limited quantities only. Do not increase quantities beyond this.',
                        icon: 'success',
                        showConfirmButton: true,
                        confirmButtonColor: '#3085d6',
                        background: '#fefefe',
                        color: '#333',
                        timer: 10000,
                        timerProgressBar: true
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'quantity updated',
                        text: req.responseText,
                        icon: 'success',
                        showConfirmButton: true,
                        confirmButtonColor: '#3085d6',
                        background: '#fefefe',
                        color: '#333',
                        timer: 3000,
                        timerProgressBar: true,
                    });
                    location.reload();
                }
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to update quantity. Please try again.',
                    icon: 'error',
                    confirmButtonColor: '#d33',
                });
            }
        }
    };

    req.open("POST", "qtychange.php", true);
    req.send(form);
}
function adtocart(sprice, discountPercentage, batchId) {
    alert(discountPercentage);
    console.log(sprice);
    console.log(discountPercentage);

    let discountedPrice = sprice - (sprice * (discountPercentage / 100));
    var req = new XMLHttpRequest();
    var form = new FormData();
    form.append("batch_id", batchId);
    form.append("price", sprice);
    form.append("discount", discountPercentage);
    form.append("final_price", discountedPrice);
    form.append("quantity", 1);

    req.open("POST", "adddispcart.php", true);
    req.onreadystatechange = function () {
        if (req.readyState === 4 && req.status === 200) {
            responseText = req.responseText;
            if (responseText == "cart is update") {
                Swal.fire({
                    title: "Hey...",
                    text: "Item added to cart successfully!",
                    icon: "success",
                    showConfirmButton: true,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "OK",
                    showClass: {
                        popup: "animate__animated animate__fadeInDown"
                    },
                    hideClass: {
                        popup: "animate__animated animate__fadeOutUp"
                    }
                });
            } else {
                Swal.fire({
                    title: "Notification",
                    text: responseText,
                    icon: "info",
                    showConfirmButton: true,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "OK",
                    showClass: {
                        popup: "animate__animated animate__fadeInDown"
                    },
                    hideClass: {
                        popup: "animate__animated animate__fadeOutUp"
                    }
                });
            }
        }
    };
    req.send(form);
}
function conditioncheck() {
    const checkboxes = document.querySelectorAll('input[name="condition[]"]');
    let result = [];

    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            result.push(`${checkbox.value}`);
        }
    });

    if (result.length < 2) {
        return (result.join('\n'));
    } else {
        return (0);
    }
}
function getCheckedBrands() {
    const checkboxes = document.querySelectorAll('#brandList input[type="checkbox"]');
    let brandid = [];
    let m = 0;

    for (let i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            brandid[m] = checkboxes[i].value;
            m++;
        }
    }

    if (brandid.length > 0) {
        return brandid;
    } else {
        return brandid;
    }
}
function gcs(groupid, catagoryid, subcatagoryid) {
    document.getElementById('groupset').value = groupid;
    document.getElementById('catgoryset').value = catagoryid;
    document.getElementById('subcatagoryset').value = subcatagoryid;
    advancesearch();
}
function advancesearch() {
    var searchtext = document.getElementById('searchtext').value || 0;
    var minprice = document.getElementById('minprice').value || 0;
    var maxprice = document.getElementById('maxprice').value || 0;
    var condition = conditioncheck();
    var brandid = getCheckedBrands();
    var groupid = document.getElementById('groupset').value || 0;
    var catagoryid = document.getElementById('catgoryset').value || 0;
    var subcatagoryid = document.getElementById('subcatagoryset').value || 0;
    var sort = document.getElementById('sorting').value || 0;
    var discountstatus = document.getElementById('discount').checked ? 1 : 0;
    var formData = new FormData();
    formData.append('searchtext', searchtext);
    formData.append('minprice', minprice);
    formData.append('maxprice', maxprice);
    formData.append('condition', condition);
    for (let index = 0; index < brandid.length; index++) {
        formData.append('brand' + index, brandid[index]);
    }
    formData.append("brandidlength", brandid.length);
    formData.append('groupid', groupid);
    formData.append('catagoryid', catagoryid);
    formData.append('subcatagoryid', subcatagoryid);
    formData.append('sort', sort);
    formData.append('discount', discountstatus);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'advancesearchpro.php', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById("shopveiw").innerHTML = xhr.responseText;
        } else {
            console.error('An error occurred during the request.');
        }
    };
    xhr.send(formData);
}
function signout() {
    Swal.fire({
        title: "Are you sure?",
        text: "You will be logged out of your account.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, Logout",
        cancelButtonText: "Cancel"
    }).then((result) => {
        if (result.isConfirmed) {
            fetch("signout.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ action: "logout" })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    Swal.fire({
                        title: "Logged Out",
                        text: "You have been successfully logged out.",
                        icon: "success",
                        confirmButtonColor: "#ff6600",
                    }).then(() => {
                        window.location.href = "index.php"; // Redirect to home or login page
                    });
                } else {
                    Swal.fire("Error", "Logout failed. Try again!", "error");
                }
            })
            .catch(error => Swal.fire("Error", "Something went wrong!", "error"));
        }
    });
}
function cartdelete(cartid) {
    Swal.fire({
        title: "Are you sure?",
        text: "You are about to remove this item from your cart.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, Delete",
        cancelButtonText: "Cancel",
        input: "text",
        inputPlaceholder: "Type 'DELETE' to confirm",
        inputValidator: (value) => {
            return value !== "DELETE" ? "You must type 'DELETE' to confirm!" : null;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "Deleting...",
                text: "Please wait...",
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            let formData = new FormData();
            formData.append("cartid", cartid);

            fetch("cartdelete.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                Swal.close(); // Close loading alert

                if (data.includes("successfully")) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "The item has been removed from your cart.",
                        icon: "success",
                        confirmButtonColor: "#ff6600"
                    }).then(() => {
                        location.reload(); // Refresh the cart page
                    });
                } else {
                    Swal.fire("Error", data, "error");
                }
            })
            .catch(error => Swal.fire("Error", "Something went wrong!", "error"));
        }
    });
}

