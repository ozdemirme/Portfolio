<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/contact-2.css">
    <title>Contact Us</title>
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
        <form action="#" method="post" class="contact-form">
            <h2>Contact Us</h2>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="4" required></textarea>

            <button type="submit">Send Message</button>
        </form>
    </div>
</body>
</html>
