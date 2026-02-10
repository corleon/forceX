<?php
/**
 * Order Received (Thank You) Page Template
 * Full page template with header and footer
 */

if (!defined('ABSPATH')) {
    exit;
}

// Set up checkout object for order received page
if (class_exists('WooCommerce')) {
    global $checkout;
    if (!isset($checkout) || !$checkout) {
        $checkout = WC()->checkout();
    }
}

get_header(); ?>

<?php
// Load the checkout template which handles order received display
$checkout_template = get_template_directory() . '/woocommerce/checkout/form-checkout.php';
if (file_exists($checkout_template)) {
    include $checkout_template;
} else {
    // Fallback to default WooCommerce thank you page
    wc_get_template('checkout/thankyou.php');
}
?>

<?php get_footer(); ?>
