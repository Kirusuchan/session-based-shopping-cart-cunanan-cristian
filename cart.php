<?php
session_start();
include 'cart_helper.php'; 

// Fetch the total cart count
$cart_count = get_cart_count();

$items = [
    ["id" => 1, "name" => "Black and White Shirt", "price" => 550, "image" => "../imgs/v1B.png", "image_hover" => "../imgs/v1A.png"],
    ["id" => 2, "name" => "Red and White Shirt", "price" => 550, "image" => "../imgs/v2B.png", "image_hover" => "../imgs/v2A.png"],
    ["id" => 3, "name" => "Brown Shirt", "price" => 750, "image" => "../imgs/v3B.png", "image_hover" => "../imgs/v3A.png"],
    ["id" => 4, "name" => "Teal Shirt", "price" => 600, "image" => "../imgs/v4B.png", "image_hover" => "../imgs/v4A.png"],
    ["id" => 5, "name" => "Blue Shirt", "price" => 600, "image" => "../imgs/v5B.png", "image_hover" => "../imgs/v5A.png"],
    ["id" => 6, "name" => "Cream Shirt", "price" => 600, "image" => "../imgs/v6B.png", "image_hover" => "../imgs/v6A.png"],
    ["id" => 7, "name" => "Navy Jacket", "price" => 850, "image" => "../imgs/v7B.png", "image_hover" => "../imgs/v7A.png"],
    ["id" => 8, "name" => "Patterned Shirt", "price" => 650, "image" => "../imgs/v8B.png", "image_hover" => "../imgs/v8A.png"]
];

// Function to get cart item details
function get_cart_item_details($item_id) {
    global $items;
    foreach ($items as $item) {
        if ($item['id'] === $item_id) {
            return $item;
        }
    }
    return null;
}

// Calculate cart total
$total_price = 0;


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - T-SHIRT SHOP</title>
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
    <div class="container">
        <h2 class="mb-4">Your Shopping Cart</h2>
        
        <?php if (empty($_SESSION['cart'])): ?>
            <!-- Empty cart message -->
            <div class="alert alert-secondary text-center py-4" role="alert">
                Your cart is currently empty.
            </div>
            <div class="text-center">
                <a href="index.php" class="btn btn-primary btn-lg"><i class="bi bi-arrow-left"></i> Continue Shopping</a>
            </div>
        <?php else: ?>
            <!-- Cart items table -->
            <form action="update_cart.php" method="POST">
                <table class="table table-hover table-bordered cart-table">
                    <thead class="table-dark">
                        <tr>
                            <th>Product</th>
                            <th>Size</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['cart'] as $cart_item): ?>
                            <?php
                                $item_details = get_cart_item_details($cart_item['id']);
                                if ($item_details):
                                    $item_total = $item_details['price'] * $cart_item['quantity'];
                                    $total_price += $item_total;
                            ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?php echo $item_details['image']; ?>" class="cart-image me-3 rounded shadow-sm" alt="<?php echo $item_details['name']; ?>">
                                        <span><?php echo $item_details['name']; ?></span>
                                    </div>
                                </td>
                                <td class="text-center"><?php echo isset($cart_item['size']) ? $cart_item['size'] : 'N/A'; ?></td>
                                <td class="text-center">
                                    <input type="number" name="quantity[<?php echo $cart_item['id']; ?>]" 
                                        value="<?php echo $cart_item['quantity']; ?>" 
                                        min="1" max="100" 
                                        class="form-control d-inline-block text-center" 
                                        style="width: 70px;">
                                </td>

                                <td>₱<?php echo number_format($item_details['price'], 2); ?></td>
                                <td>₱<?php echo number_format($item_total, 2); ?></td>
                                <td class="text-center">
                                <a href="remove_confirm.php?product_id=<?php echo $cart_item['id']; ?>" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                            </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Cart total and action buttons -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4>Total: <span class="text-success">₱<?php echo number_format($total_price, 2); ?></span></h4>
                    <div>
                        <a href="index.php" class="btn btn-outline-primary"><i class="bi bi-arrow-left"></i> Continue Shopping</a>
                        <button type="submit" class="btn btn-success"><i class="bi bi-arrow-repeat"></i> Update Cart</button>
                        <a href="success.php" class="btn btn-primary"><i class="bi bi-credit-card"></i> Checkout</a>
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </div>

    <style>
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
        .cart-table th, .cart-table td {
            vertical-align: middle;
        }
        .cart-image {
            width: 60px;
            height: auto;
            border-radius: 5px;
        }
        .alert {
            border: 1px solid #c6c6c6;
            background-color: #f8f9fa;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
