<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/login.css">
    <title>Password Reset</title>
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
        <form action="process.php" method="post" class="login-form" onsubmit="return validateForm()">
            <h2>Password Reset</h2>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">E-mail:</label>
            <input type="text" id="email" name="email" required>

            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <div class="button-container">
                <button class="form-button" type="submit">Reset Password</button>
            </div>

            <p class="redirect">Remember your password? <a href="login.html">Log in now</a></p>
        </form>
    </div>

    <script src="./Script/script.js"></script>
</body>
</html>
