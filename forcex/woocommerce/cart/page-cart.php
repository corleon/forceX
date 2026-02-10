<?php
/**
 * Cart Page Template
 * Full page template with header and footer
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<?php
// Load the cart template
$cart_template = get_template_directory() . '/woocommerce/cart/cart.php';
if (file_exists($cart_template)) {
    include $cart_template;
} else {
    // Fallback to default WooCommerce cart
    wc_get_template('cart/cart.php');
}
?>

<?php get_footer(); ?>
