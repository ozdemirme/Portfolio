<?php
  
//So the process-registraion handles registration form

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize form data
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
    $password = $_POST['password'];

    // validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: register.php?message=Invalid email address.');
        exit();
    }

    // connect to the MySQL database 
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "mywebsite";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname); //connects to the database. If the connection fails it displays the error message

    // check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // check if email or username already exists using prepared statements
    $checkExistenceQuery = $conn->prepare("SELECT * FROM users WHERE email=? OR username=?"); //It checks whether the email or username exists in the database
    $checkExistenceQuery->bind_param("ss", $email, $username);
    $checkExistenceQuery->execute();
    $result = $checkExistenceQuery->get_result();

    if ($result->num_rows > 0) {
        // email or username already exists, redirect to register.php and display alert
        header('Location: register.php?message=Email or username already exists. Please choose different credentials.');
        exit();
    } else {
        // email and username do not exist proceed with registration
        // use prepared statements for the insert query
        $insertQuery = $conn->prepare("INSERT INTO users (email, username, password) VALUES (?, ?, ?)");
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $insertQuery->bind_param("sss", $email, $username, $hashedPassword);

        if ($insertQuery->execute()) {

            // redirect to index.php on success
            header('Location: index.php');
            exit();
        } else {
            echo 'Error: Registration failed.';
        }
    }

    $conn->close();
} else {
    // redirect to the registration form if accessed directly
    header('Location: register.php');
    exit();
}
?>
