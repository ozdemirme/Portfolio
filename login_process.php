<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // get and sanitize form data
    $username = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS); //It retrieves the username and password data from the form and securely cleans it.
    $password = $_POST['password']; 

    // database connection info
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "mywebsite";

    //that creates a connection to the database
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // check if the user exists in the database
    $query = $conn->prepare("SELECT * FROM users WHERE username=?"); //Checks whether the username exists in the database.
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // verify the password
        if (password_verify($password, $row['password'])) { //It compares the password entered by the user with the password in the database.
            // password is correct, set session variable and perform login actions
            session_start();
            $_SESSION['username'] = $username;

            // you can redirect to a dashboard or any other page
            header('Location: index.php');
            exit();
        } else {
            // incorrect password, redirect to login.html with a message
            header('Location: login.php?message=Incorrect password.');
            exit();
        }
    } else {
        // user not found, redirect to login.php with a message
        header('Location: login.php?message=User not found.');
        exit();
    }

    $conn->close();
} else {
    // redirect to the login form if accessed directly
    header('Location: login.php');
    exit();
}
?>
