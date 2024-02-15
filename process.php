<?php

//process php handles forgot password

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // get and sanitize form data
    $username = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Additional validation for the new password and confirm password
    if ($newPassword !== $confirmPassword) {
        // Passwords do not match, redirect to the password reset form with a message
        header('Location: password_reset.html?message=Passwords do not match.');
        exit();
    }

    // database connection info
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "mywebsite";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // check if the user exists in the database
    $query = $conn->prepare("SELECT * FROM users WHERE username=? AND email=?");
    $query->bind_param("ss", $username, $email);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        // user found, update the password in the database
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateQuery = $conn->prepare("UPDATE users SET password=? WHERE username=? AND email=?");
        $updateQuery->bind_param("sss", $hashedPassword, $username, $email);
        $updateQuery->execute();

        // redirect to login.php with a message
        header('Location: login.php?message=Password reset successful. You can now log in with your new password.');
        exit();
    } else {
        // user not found, redirect to password_reset.php with a message
        header('Location: forgot.php?message=User not found or email is incorrect.');
        exit();
    }

    $conn->close();
} else {
    // redirect to the login form if accessed directly
    header('Location: login.php');
    exit();
}
?>
