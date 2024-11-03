<?php
session_start();

if (isset($_POST['quantity'])) {
    foreach ($_POST['quantity'] as $id => $quantity) {
        foreach ($_SESSION['cart'] as &$cart_item) {
            if ($cart_item['id'] == $id) {
                // Limit the quantity to a maximum of 99 and ensure it's at least 1
                $cart_item['quantity'] = min(max(1, (int)$quantity), 99);
            }
        }
    }
}

header("Location: cart.php");
exit;
?>
