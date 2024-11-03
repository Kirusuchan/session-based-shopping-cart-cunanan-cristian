<?php
session_start();

// Check if item ID is provided
$item_id = isset($_GET['id']) ? (int)$_GET['id'] : null;

if ($item_id && isset($_SESSION['cart'])) {
    // Loop through the cart and remove the item if it matches the ID
    foreach ($_SESSION['cart'] as $key => $cart_item) {
        if ($cart_item['id'] == $item_id) {
            unset($_SESSION['cart'][$key]);
            // Re-index the array after unsetting an element
            $_SESSION['cart'] = array_values($_SESSION['cart']);
            break;
        }
    }
}

// Redirect back to the cart page after removal
header("Location: cart.php");
exit;
?>
