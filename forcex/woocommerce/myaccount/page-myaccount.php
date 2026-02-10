<?php
/**
 * My Account Page Template
 * Full page template with header and footer
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<?php
// Load the my account template
$account_template = get_template_directory() . '/woocommerce/myaccount/my-account.php';
if (file_exists($account_template)) {
    include $account_template;
} else {
    // Fallback to default WooCommerce my account
    wc_get_template('myaccount/my-account.php');
}
?>

<?php get_footer(); ?>
