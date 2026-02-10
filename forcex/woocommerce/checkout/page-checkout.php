<?php
/**
 * Checkout Page Template
 * Full page template with header and footer
 */

if (!defined('ABSPATH')) {
    exit;
}

// Set up checkout object
if (class_exists('WooCommerce')) {
    global $checkout;
    if (!isset($checkout) || !$checkout) {
        $checkout = WC()->checkout();
    }
}

get_header(); ?>

<?php
// Load the checkout form template
$checkout_template = get_template_directory() . '/woocommerce/checkout/form-checkout.php';
if (file_exists($checkout_template)) {
    include $checkout_template;
} else {
    // Fallback to default WooCommerce checkout
    wc_get_template('checkout/form-checkout.php');
}
?>

<?php get_footer(); ?>
