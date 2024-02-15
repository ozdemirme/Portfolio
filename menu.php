<?php
session_start();

// Replace with your actual database connection details
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "mywebsite";

$conn = new mysqli($servername, $db_username, $db_password, $dbname); 

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to get user ID by username
function getUserIdByUsername($username, $conn) {
    $query = $conn->prepare("SELECT id FROM users WHERE username=?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['id'];
    }

    return null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['username'])) {
    // Assuming you have the necessary form fields like item_name and item_price
    $item_name = $_POST['item_name'];
    $item_price = $_POST['item_price'];

    // Get user ID from the session
    $user_id = getUserIdByUsername($_SESSION['username'], $conn);

    if ($user_id !== null) {
        // Insert item into the cart_items table with the associated user_id
        $stmt = $conn->prepare("INSERT INTO cart_items (user_id, item_name, item_price) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $item_name, $item_price);

        if ($stmt->execute()) {
            // Item added to cart successfully, trigger JavaScript alert
            echo '<script>alert("Item added to cart successfully!");</script>';
        } else {
            // Error adding item to cart, trigger JavaScript alert
            echo '<script>alert("Error adding item to cart: ' . $stmt->error . '");</script>';
        }

        $stmt->close();
    } else {
        // Error retrieving user ID, trigger JavaScript alert
        echo '<script>alert("Error retrieving user ID.");</script>';
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/menu-2.css">
    <script defer src="./Script/script.js"></script>
    <title>Fast Food Menu</title>
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
                        echo '<a href="logout.php">Log Out</a>'; // Move "Log Out" link here
                    } else {
                        echo '<a href="login.php">Log In</a>';
                    }
                    ?>
                </li>
            </ul>
        </nav>
    </header>
    
    <section class="menu">
      
        <div class="dish">
            <img src="./images/cheeseburger.png" alt="Cheeseburger">
            <h3>Cheeseburger</h3>
            <p>Lorem ipsum dolor, sit amet consectetur adipisiectetur i aut perferendis.</p>
            <span>€5.99</span> <br>
            <form action="menu.php" method="POST">
                <input type="hidden" name="item_name" value="Cheeseburger">
                <input type="hidden" name="item_price" value="5.99">
                <button type="submit" class="add-to-cart">Add to Cart</button>
            </form>
        </div>

      
        <div class="dish">
            <img src="./images/pizza-2.png" alt="Pepperoni Pizza">
            <h3>Pepperoni Pizza</h3>
            <p>Lorem ipsum dolor, sit amet consectetur adipisiectetur i aut perferendis.</p>
            <span>€8.99</span> <br>
            <form action="menu.php" method="POST">
                <input type="hidden" name="item_name" value="Pepperoni Pizza">
                <input type="hidden" name="item_price" value="8.99">
                <button type="submit" class="add-to-cart">Add to Cart</button>
            </form>
        </div>

        <div class="dish">
            <img src="./images/ramen.png" alt="Ramen">
            <h3>Ramen</h3> 
            <p>Lorem ipsum dolor, sit amet consectetur adipisiectetur i aut perferendis.</p>
            <span>€2.99</span> <br>
            <form action="menu.php" method="POST">
                <input type="hidden" name="item_name" value="Ramen">
                <input type="hidden" name="item_price" value="2.99">
                <button type="submit" class="add-to-cart">Add to Cart</button>
            </form>
        </div>

        <div class="dish">
            <img src="./images/sushi.png" alt="Sushi">
            <h3>Sushi</h3>
            <p>Lorem ipsum dolor, sit amet consectetur adipisiectetur i aut perferendis.</p>
            <span>€2.99</span> <br>
            <form action="menu.php" method="POST">
                <input type="hidden" name="item_name" value="Sushi">
                <input type="hidden" name="item_price" value="2.99">
                <button type="submit" class="add-to-cart">Add to Cart</button>
            </form>
        </div>
    </section>
</body>

<footer>
    <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Help</a></li>
        <li><a href="#">Contact</a></li>
    </ul>

    <ul class="social-media">
        <
