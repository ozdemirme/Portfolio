<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="./style/login.css">
    <script src="./Script/script.js" defer></script>
</head>
<body>
    <header>
        <h1>Food Kingdom</h1>
        <nav>
            <ul>
            <li><a href="index.php">Home</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li id="loginListItem">
                    <?php
                    session_start();
                    if (isset($_SESSION['username'])) {
                        echo '<a href="#">' . $_SESSION['username'] . '</a>';
                    } else {
                        echo '<a href="login.php">Log In</a>';
                    }
                    ?>
                </li>
            </ul>
        </nav>
    </header>
<body>
    <div class="container">
        <form id="registrationForm" action="process-registration.php" method="post" class="login-form" onsubmit="return validateForm()">
            <h2>Sign Up</h2>

            <label for="email">E-mail:</label>
            <input type="text" id="email" name="email" required>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="repassword">Re-Password:</label>
            <input type="password" id="repassword" name="repassword" required>

            <button type="submit">Sign Up</button>

            <p class="redirect">Already have an account? <a href="login.php">Log in</a></p>
            <p class="forgot-password"><a href="#">Forgot your password?</a></p>
        </form>
    </div>
</body>
</html>
