
// my existing validation function
function validateForm() {
    var email = document.getElementById('email').value;
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    var rePassword = document.getElementById('repassword').value;

    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // reset previous error messages
    document.getElementById('email-error').innerText = '';
    document.getElementById('username-error').innerText = '';
    document.getElementById('password-error').innerText = '';

    if (!emailRegex.test(email)) {
        document.getElementById('email-error').innerText = 'Please enter a valid email address.';
        return false;
    }

    if (username.length < 5) {
        document.getElementById('username-error').innerText = 'Username must be at least 5 characters long.';
        return false;
    }

    if (password.length < 6) {
        document.getElementById('password-error').innerText = 'Password must be at least 6 characters long.';
        return false;
    }

    if (password !== rePassword) {
        document.getElementById('password-error').innerText = 'Passwords do not match.';
        return false;
    }

    return true;
}

// check if a message parameter is present in the URL
const urlParams = new URLSearchParams(window.location.search);
const message = urlParams.get('message');

// display an alert if a message is present
if (message) {
    alert(message);
}

// javaScript function to submit the form when the remove button is clicked
function removeItem(itemName) {
    document.getElementById('remove_item_input').value = itemName;
    document.getElementById('remove_item_form').submit();
}

// check for checkout flag and perform actions
if (typeof checkoutFlag !== 'undefined' && checkoutFlag) {
    alert("Thank you! Your order has been completed.");
    window.location.href = "menu.php";
}
