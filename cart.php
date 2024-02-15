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
function getUserIdByUsername($username, $conn) { //connects to the database. If the connection fails it displays the error message
    $query = $conn->prepare("SELECT id FROM users WHERE username=?"); //It checks whether the email or username exists in the database
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['id'];
    }

    return null;
}

// Get user ID from the session
$user_id = null;
if (isset($_SESSION['username'])) {
    $user_id = getUserIdByUsername($_SESSION['username'], $conn);
}

// Retrieve cart items for the current user
$cart_items = [];
if ($user_id !== null) {
    $stmt = $conn->prepare("SELECT item_name, item_price FROM cart_items WHERE user_id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $cart_items[] = $row;
    }

    $stmt->close();
}

// Handle item removal
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_item'])) {
    $item_name = $_POST['remove_item'];

    $stmt = $conn->prepare("DELETE FROM cart_items WHERE user_id=? AND item_name=?");
    $stmt->bind_param("is", $user_id, $item_name);

    if ($stmt->execute()) {
        echo '<script>alert("Item ' . $item_name . ' removed from cart successfully!");</script>';
    } else {
        echo '<script>alert("Error removing item from cart: ' . $stmt->error . '");</script>';
    }

    $stmt->close();
}

// Handle checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    // Get the total amount
    $totalAmount = array_sum(array_column($cart_items, 'item_price'));

    // Insert order details into the new 'orders' table
    $insertOrderStmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, order_date) VALUES (?, ?, NOW())");
    $insertOrderStmt->bind_param("id", $user_id, $totalAmount);

    if ($insertOrderStmt->execute()) {
        $orderId = $insertOrderStmt->insert_id;

        // Insert items into the 'order_items' table
        $insertItemsStmt = $conn->prepare("INSERT INTO order_items (order_id, item_name, item_price) VALUES (?, ?, ?)");
        $insertItemsStmt->bind_param("iss", $orderId, $itemName, $itemPrice);

        foreach ($cart_items as $item) { //It is an array method that allows us to create a loop and run this loop sequentially.
            $itemName = $item['item_name'];
            $itemPrice = $item['item_price'];
            $insertItemsStmt->execute();
        }

        $insertItemsStmt->close();

        // Delete items from cart
        $deleteStmt = $conn->prepare("DELETE FROM cart_items WHERE user_id=?");
        $deleteStmt->bind_param("i", $user_id);

        if ($deleteStmt->execute()) {
            echo '<script>alert("Thank you for your order! Items removed from cart.");</script>';
            // Redirect to menu.php
            echo '<script>window.location.href = "menu.php";</script>';
        } else {
            echo '<script>alert("Error processing order: ' . $deleteStmt->error . '");</script>';
        }

        $deleteStmt->close();
    } else {
        echo '<script>alert("Error processing order: ' . $insertOrderStmt->error . '");</script>';
    }

    $insertOrderStmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/cart.css">
    <title>Cart</title>
    <script src="./Script/script.js"></script>
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
        <div class="cart">
            <h2>Shopping Cart</h2>

            <?php foreach ($cart_items as $item): ?>
                <div class="item">
                    <div class="item-details">
                        <h3><?php echo $item['item_name']; ?></h3>
                        <span>€<?php echo $item['item_price']; ?></span>
                    </div>
                    <div class="item-actions">
                        <form method="post">
                            <input type="hidden" name="remove_item" value="<?php echo $item['item_name']; ?>">
                            <button class="remove" type="submit">Remove</button>
                        </form>
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" value="1" min="1">
                    </div>
                </div>
            <?php endforeach; ?> 

            <form method="post">
                <input type="hidden" name="checkout">
                <div class="total">
                    <span>Total: €<?php echo array_sum(array_column($cart_items, 'item_price')); ?></span>
                    <button class="checkout" type="submit">Checkout</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

