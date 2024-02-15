<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/login.css">
    <title>Login</title>
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
                    if (isset($_SESSION['username'])) {
                        echo '<a href="#">' . $_SESSION['username'] . '</a>';
                        echo '<a href="logout.php">Log Out</a>'; 
                    } else {
                        echo '<a href="login.php">Log In</a>';
                    }
                    ?>
                </li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <form action="login_process.php" method="post" class="login-form" onsubmit="return validateForm()">
            <h2>Login</h2>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>

            <p class="redirect">Don't have an account? <a href="register.php">Register now</a></p>
            <p class="forgot-password"><a href="forgot.php">Forgot your password?</a></p>
        </form>
    </div>

    <script src="./Script/script.js"></script>
</body>
</html>
