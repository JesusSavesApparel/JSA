<?php
session_start();

// Function to fetch the latest product information from the database
function fetchProductInfo($productName) {
    // Example database connection and query (replace with your actual database logic)
    $conn = new mysqli('localhost', 'username', 'password', 'database');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $stmt = $conn->prepare('SELECT name, price FROM products WHERE name = ?');
    $stmt->bind_param('s', $productName);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
    return $product;
}

// Function to calculate the total price of the cart items
function calculateTotal($cartItems) {
    $total = 0;
    foreach ($cartItems as $item) {
        $total += $item['price'];
    }
    return $total;
}

// Assume $_SESSION['cart'] contains items in the form of ['name' => 'Product Name', 'price' => price]
$cartItems = $_SESSION['cart'] ?? [];

// Verify and update cart items with the latest product information
foreach ($cartItems as &$item) {
    $latestProductInfo = fetchProductInfo($item['name']);
    if ($latestProductInfo) {
        $item['price'] = $latestProductInfo['price'];
    }
}
unset($item); // Break the reference with the last element

$total = calculateTotal($cartItems);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Page</title>
</head>
<body>

    <h1>Checkout</h1>

    <h2>Order Summary</h2>
    <ul>
        <?php foreach ($cartItems as $item): ?>
            <li>
                <span><?php echo htmlspecialchars($item['name']); ?></span>
                <span>$<?php echo number_format($item['price'], 2); ?></span>
            </li>
        <?php endforeach; ?>
    </ul>

    <h3>Total: $<?php echo number_format($total, 2); ?></h3>

    <form action="process_checkout.php" method="POST">
        <!-- Additional fields like shipping details, payment method, etc. -->
        <button type="submit">Proceed to Checkout</button>
    </form>

</body>
</html>
