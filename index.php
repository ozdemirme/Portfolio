<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Style/style.css">
    <title>Online Food Order</title>
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

    <div class="hero">
        <h2>Delicious Food Delivered to Your Doorstep</h2>
        <p>Order your favorite meals online with Food Kingdom. Fast delivery and mouth-watering dishes!</p>
        <a href="menu.php" class="btn">Order Now</a>
    </div>

    <section class="menu">
        <div class="dish">
            <img src="./images/hamburger-1.jpg" width="400" alt="Burger"> 
            <h3>Classic Burger</h3>
            <p>A delicious classic burger with juicy beef patty, lettuce, and special sauce.</p>
            <span>€9.99</span>
        </div>

        <div class="dish">
            <img src="./images/pizza-1.jpg" width="400" alt="Pizza"> 
            <h3>Margherita Pizza</h3>
            <p>Authentic Margherita pizza with fresh mozzarella, tomatoes, and basil.</p>
            <span>€12.99</span>
        </div>

    </section>

    <footer>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Help</a></li>
            <li><a href="#">Contact</a></li>
          </ul>

          <ul class="social-media">
            <li><a href="#">Facebook</a></li>
            <li><a href="#">Instagram</a></li>
            <li><a href="#">Twitter</a></li>
          </ul>

        <p>&copy; 2023 Merve Ozdemir. All rights reserved.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>
