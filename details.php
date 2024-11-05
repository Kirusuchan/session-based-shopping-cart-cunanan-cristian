<?php
session_start();
include 'cart_helper.php';

// List of items
$items = [
    ["id" => 1, "name" => "Black and White Shirt", "price" => 550, "image" => "../imgs/v1B.png", "image_hover" => "../imgs/v1A.png", "description" => "A stylish black and white shirt for every occasion."],
    ["id" => 2, "name" => "Red and White Shirt", "price" => 550, "image" => "../imgs/v2B.png", "image_hover" => "../imgs/v2A.png", "description" => "Stand out with this bold red and white shirt."],
    ["id" => 3, "name" => "Brown Shirt", "price" => 750, "image" => "../imgs/v3B.png", "image_hover" => "../imgs/v3A.png", "description" => "A casual brown shirt perfect for relaxed days."],
    ["id" => 4, "name" => "Teal Shirt", "price" => 600, "image" => "../imgs/v4B.png", "image_hover" => "../imgs/v4A.png", "description" => "A cool and comfortable teal shirt to keep you looking fresh."],
    ["id" => 5, "name" => "Blue Shirt", "price" => 600, "image" => "../imgs/v5B.png", "image_hover" => "../imgs/v5A.png", "description" => "A classic blue shirt that's ideal for both formal and casual settings."],
    ["id" => 6, "name" => "Cream Shirt", "price" => 600, "image" => "../imgs/v6B.png", "image_hover" => "../imgs/v6A.png", "description" => "An elegant cream shirt that fits any occasion, day or night."],
    ["id" => 7, "name" => "Navy Jacket", "price" => 850, "image" => "../imgs/v7B.png", "image_hover" => "../imgs/v7A.png", "description" => "A warm and stylish navy jacket for cool weather and fashionable layering."],
    ["id" => 8, "name" => "Patterned Shirt", "price" => 650, "image" => "../imgs/v8B.png", "image_hover" => "../imgs/v8A.png", "description" => "A unique patterned shirt that brings a bold look to your wardrobe."],
    ["id" => 9, "name" => "Gray Hoodie", "price" => 700, "image" => "../imgs/v9B.png", "image_hover" => "../imgs/v9A.png", "description" => "Stay cozy with this comfortable gray hoodie."],
    ["id" => 10, "name" => "Green Polo", "price" => 500, "image" => "../imgs/v10B.png", "image_hover" => "../imgs/v10A.png", "description" => "A fresh green polo shirt that's perfect for both casual and semi-formal events."],
];

// Get item ID from URL
$item_id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$item = null;

// Find item by ID
foreach ($items as $product) {
    if ($product['id'] === $item_id) {
        $item = $product;
        break;
    }
}

// If item not found, redirect to main page
if (!$item) {
    header("Location: index.php");
    exit;
}

// Calculate total item count in the cart (sum of quantities)
$cart_count = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $cart_item) {
        $cart_count += $cart_item['quantity'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $item['name']; ?> - T-SHIRT SHOP</title>
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

<!-- Product Details Section -->
<div class="container mt-5">
    <div class="row">
        <div class="col-md-5">
            <div class="product-image mb-4">
                <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="normal shadow-sm rounded">
                <img src="<?php echo $item['image_hover']; ?>" alt="<?php echo $item['name']; ?>" class="hover shadow-sm rounded">
            </div>
        </div>
        <div class="col-md-7">
            <h2 class="fw-bold"><?php echo $item['name']; ?> <span class="badge bg-primary">₱<?php echo number_format($item['price'], 2); ?></span></h2>
            <p class="text-muted mt-3"><?php echo $item['description']; ?></p>

            <form action="confirm.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                
                <h4 class="mt-4">Select Size:</h4>
                <div class="mb-3">
                    <label class="form-check-label me-2"><input type="radio" name="size" value="XS" checked> XS</label>
                    <label class="form-check-label me-2"><input type="radio" name="size" value="SM"> SM</label>
                    <label class="form-check-label me-2"><input type="radio" name="size" value="MD"> MD</label>
                    <label class="form-check-label me-2"><input type="radio" name="size" value="LG"> LG</label>
                    <label class="form-check-label"><input type="radio" name="size" value="XL"> XL</label>
                </div>

                <h4>Enter Quantity:</h4>
                <input type="number" class="form-control w-25 mb-3" name="quantity" value="1" min="1" max="99">


                <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Confirm Product Purchase</button>
                <a href="index.php" class="btn btn-outline-secondary ms-2"><i class="bi bi-arrow-left"></i> Cancel/Go Back</a>
            </form>
        </div>
    </div>
</div>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f9f9f9;
    }

    .product-image {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        cursor: pointer;
        height: 450px;
        width: 100%;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: opacity 0.5s ease, transform 0.3s ease;
    }

    .product-image img.hover {
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
    }

    .product-image:hover img.normal {
        opacity: 0;
    }

    .product-image:hover img.hover {
        opacity: 1;
    }

    .cart-badge {
        font-size: 1.2rem;
        color: #fff;
        background-color: #007bff;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        text-decoration: none;
        display: flex;
        align-items: center;
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
        padding: 2px 7px;
        margin-left: 5px;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
