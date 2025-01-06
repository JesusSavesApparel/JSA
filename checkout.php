<?php
session_start();

// Function to calculate total price
function calculateTotal($cartItems) {
    $total = 0;
    foreach ($cartItems as $item) {
        $total += $item['price'];
    }
    return $total;
}

// Assume $_SESSION['cart'] contains items in the form of ['name' => 'Product Name', 'price' => price]
$cartItems = $_SESSION['cart'] ?? [];
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