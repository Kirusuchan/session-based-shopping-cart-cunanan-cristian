<?php
// Check if session is not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!function_exists('get_cart_count')) {
    function get_cart_count() {
        if (!isset($_SESSION['cart'])) {
            return 0;
        }
        
        $cart_count = 0;
        foreach ($_SESSION['cart'] as $cart_item) {
            $cart_count += $cart_item['quantity'];
        }
        
        return $cart_count;
    }
}


?>
