<?php
session_start();
include 'cart_helper.php';
// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// List of items
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

// Calculate total item count in the cart (sum of quantities)
$cart_count = 0;
foreach ($_SESSION['cart'] as $cart_item) {
    $cart_count += $cart_item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>T-SHIRT SHOP</title>
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

<main class="container mt-4">
    <div class="row g-4">
        <?php foreach ($items as $item): ?>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card product-card shadow-sm border-0" onclick="window.location.href='details.php?id=<?php echo $item['id']; ?>'">
                <div class="card-img-top position-relative">
                    <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="img-fluid normal">
                    <img src="<?php echo $item['image_hover']; ?>" alt="<?php echo $item['name']; ?>" class="img-fluid hover position-absolute top-0 start-0">
                </div>
                    <div class="card-body">
                        <p class="card-title fw-bold"><?php echo $item['name']; ?></p>
                        <p class="card-text text-muted mb-4 price-highlight">₱<span><?php echo number_format($item['price'], 2); ?></span></p>
                        <div class="add-to-cart-overlay">
                            <i class="bi bi-cart"></i> Add to Cart
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<style>
    .product-card {
        position: relative;
        overflow: hidden;
        border: 1px solid #ddd;
        border-radius: 5px;
        cursor: pointer;
        transition: transform 0.2s ease;
    }

    .product-card:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .product-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: opacity 0.5s ease;
    }

    .product-card img.hover {
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
    }

    .product-card:hover img.normal {
        opacity: 0;
    }

    .product-card:hover img.hover {
        opacity: 1;
    }

    .price-highlight span {
        font-size: 1.2rem;
        font-weight: bold;
        color: #d9534f;
    }


    .add-to-cart-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: rgba(0, 0, 0, 0.8);
        color: white;
        text-align: center;
        padding: 10px;
        font-size: 16px;
        transform: translateY(100%);
        transition: transform 0.3s ease;
        cursor: pointer;
    }

    .product-card:hover .add-to-cart-overlay {
        transform: translateY(0); 
    }

    .card-body {
        text-align: center;
    }

    .card-title {
        margin: 0;
        padding: 5px 0;
        font-size: 1.1rem;
    }

    .card-text {
        margin: 0;
        padding: 5px 0;
    }

    /* Cart badge styling */
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
</body>
</html>
