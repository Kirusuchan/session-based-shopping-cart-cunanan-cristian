<?php
session_start();
include 'cart_helper.php';

// Get the cart count
$cart_count = get_cart_count();

// Check if item ID is provided
$item_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : null;
$item = null;

// Check if the item exists in the cart
if ($item_id && isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $cart_item) {
        if ($cart_item['id'] == $item_id) {
            $item = $cart_item;
            break;
        }
    }
}

// Redirect back to cart if the item is not found in the cart
if (!$item) {
    header("Location: cart.php");
    exit;
}

// Function to find the item details (assuming a global product array)
function getItemDetails($id) {
    $products = [
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

    foreach ($products as $product) {
        if ($product['id'] == $id) {
            return $product;
        }
    }
    return null;
}

// Get the detailed product information
$product_details = getItemDetails($item_id);

// Handle if product details are not found
if (!$product_details) {
    echo "<div class='alert alert-danger'>Product details not found. Please go back and try again.</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove Confirmation - Learn IT Easy Online Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header with cart badge -->
    <header class="header bg-light py-3 mb-4 shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h4 m-0">T-SHIRT SHOP</h1>
            <a href="cart.php" class="cart-badge">
                <i class="bi bi-cart"></i> Cart
                <span class="cart-count"><?php echo $cart_count; ?></span>
            </a>
        </div>
    </header>

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="product-image-container">
                            <img src="<?php echo htmlspecialchars($product_details['image']); ?>" alt="<?php echo htmlspecialchars($product_details['name']); ?>" class="img-fluid rounded shadow-sm normal-image">
                            <img src="<?php echo htmlspecialchars($product_details['image_hover']); ?>" alt="<?php echo htmlspecialchars($product_details['name']); ?> (hover)" class="img-fluid rounded shadow-sm hover-image">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h3><?php echo htmlspecialchars($product_details['name']); ?> <span class="badge bg-primary">₱<?php echo number_format($product_details['price'], 2); ?></span></h3>
                        <p class="mt-3"><?php echo htmlspecialchars($product_details['description']); ?></p>
                        <p><strong>Size:</strong> <?php echo htmlspecialchars($item['size']); ?></p>
                        <p><strong>Quantity:</strong> <?php echo (int)$item['quantity']; ?></p>
                        <div class="mt-4">
                            <a href="remove_item.php?id=<?php echo $item['id']; ?>" class="btn btn-dark me-2">
                                <i class="bi bi-trash"></i> Confirm Product Removal
                            </a>
                            <a href="cart.php" class="btn btn-danger">
                                <i class="bi bi-x-circle"></i> Cancel/Go Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        .product-image-container {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
        }
        .product-image-container img {
            width: 100%;
            height: auto;
            transition: opacity 0.5s ease-in-out;
        }
        .product-image-container .hover-image {
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
        }
        .product-image-container:hover .normal-image {
            opacity: 0;
        }
        .product-image-container:hover .hover-image {
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
            cursor: pointer;
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
