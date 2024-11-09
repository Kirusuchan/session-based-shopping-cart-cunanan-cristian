<?php
session_start();
include 'cart_helper.php'; 

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Get item data from POST
$item_id = isset($_POST['id']) ? (int)$_POST['id'] : null;
$size = isset($_POST['size']) ? $_POST['size'] : null;
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

if ($item_id && $size) {
    $found = false;
    foreach ($_SESSION['cart'] as &$cart_item) {
        if ($cart_item['id'] === $item_id && $cart_item['size'] === $size) {
            // Add quantity but cap the total at 100
            $cart_item['quantity'] = min(100, $cart_item['quantity'] + $quantity);
            $found = true;
            break;
        }
    }

    if (!$found) {
        // If the item is new to the cart, ensure its quantity does not exceed 100
        $_SESSION['cart'][] = ["id" => $item_id, "size" => $size, "quantity" => min(100, $quantity)];
    }
}

// Use the helper function to get the total item count in the cart
$cart_count = get_cart_count();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Purchase - T-SHIRT SHOP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body>
    <header class="header bg-light py-3 mb-4">
            <div class="container d-flex justify-content-between align-items-center">
                <h1 class="h4 m-0">T-SHIRT SHOP</h1>
                <a href="cart.php" class="cart-badge">
                    <i class="bi bi-cart"></i> Cart
                    <span class="cart-count"><?php echo $cart_count; ?></span>
                </a>
            </div>
    </header>
    <!-- Confirmation Message -->
    <div class="container mt-5 text-center">
        <div class="alert alert-success rounded-3 shadow-sm">
            <i class="bi bi-check-circle-fill text-success mb-3" style="font-size: 3rem;"></i>
            <h2 class="fw-bold">Success!</h2>
            <p class="lead mt-3">Your product has been successfully added to the cart.</p>
            <div class="mt-4">
                <a href="index.php" class="btn btn-outline-primary btn-lg me-2"><i class="bi bi-arrow-left"></i> Continue Shopping</a>
                <a href="cart.php" class="btn btn-success btn-lg"><i class="bi bi-cart-check-fill"></i> View Cart</a>
            </div>
        </div>
    </div>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
        }

        .cart-badge {
            position: relative;
            color: #fff;
            background-color: #007bff;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 1.1rem;
            transition: background-color 0.3s ease;
        }

        .cart-badge:hover {
            background-color: #0056b3;
        }

        .cart-count {
            background-color: #ffc107;
            color: #000;
            border-radius: 50%;
            font-size: 0.9rem;
            padding: 4px 8px;
            margin-left: 8px;
        }

        .header {
            border-bottom: 1px solid #ddd;
            padding: 1rem 0;
        }

        .alert {
            border: 1px solid #d4edda;
            background-color: #e9f7ef;
        }

        .btn-outline-primary {
            transition: background-color 0.3s, border-color 0.3s;
        }

        .btn-outline-primary:hover {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            transition: background-color 0.3s ease;
        }

        .btn-success:hover {
            background-color: #218838;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
