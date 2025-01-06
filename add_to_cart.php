<?php
session_start();

// Function to fetch the latest product information from the database
function fetchProductInfo($productId) {
    // Example database connection and query (replace with your actual database logic)
    $conn = new mysqli('localhost', 'username', 'password', 'database');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $stmt = $conn->prepare('SELECT id, name, price FROM products WHERE id = ?');
    $stmt->bind_param('i', $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
    return $product;
}

// Get product ID from request (e.g., from a form submission or query parameter)
$productId = $_GET['product_id'] ?? null;

if ($productId) {
    // Fetch product information from the database
    $product = fetchProductInfo($productId);

    if ($product) {
        // Add product to cart
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Check if the product is already in the cart
        $productFound = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] === $product['id']) {
                $productFound = true;
                break;
            }
        }
        unset($item); // Break the reference with the last element

        // If the product is not in the cart, add it
        if (!$productFound) {
            $_SESSION['cart'][] = ['id' => $product['id'], 'name' => $product['name'], 'price' => $product['price']];
        }
    }
}

// Redirect to checkout page
header('Location: checkout.php');
exit();
?>