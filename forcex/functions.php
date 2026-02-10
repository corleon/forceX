<?php
/**
 * ForceX Theme Functions
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Let WooCommerce load its own functions and cart/session lifecycle.

// Theme setup
function forcex_setup() {
    // Add theme support
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // WooCommerce support
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'forcex'),
        'footer' => __('Footer Menu', 'forcex'),
    ));
}
add_action('after_setup_theme', 'forcex_setup');

// Enqueue scripts and styles
function forcex_scripts() {
    $is_dev = defined('WP_ENV') && WP_ENV === 'development';
    
    // Force production mode if no dev server is running
    if ($is_dev && !file_exists(get_template_directory() . '/dist/.vite/manifest.json')) {
        $is_dev = false;
    }
    
    // Ensure our styles load AFTER WooCommerce styles but with higher priority
    $style_dependencies = array();
    if (class_exists('WooCommerce')) {
        $style_dependencies[] = 'woocommerce-general';
        $style_dependencies[] = 'woocommerce-layout';
        $style_dependencies[] = 'woocommerce-smallscreen';
    }
    
    if ($is_dev) {
        // Development mode with Vite HMR
        wp_enqueue_script('forcex-vite', 'http://localhost:5173/@vite/client', array(), null, true);
        wp_enqueue_script('forcex-main', 'http://localhost:5173/src/main.js', array(), null, true);
        // In development, Vite injects CSS via JavaScript, but we need to ensure it's loaded
        wp_enqueue_style('forcex-dev', 'http://localhost:5173/src/main.css', $style_dependencies, null, 'all');
    } else {
        // Production mode with hashed assets
        $manifest_path = get_template_directory() . '/dist/.vite/manifest.json';
        if (file_exists($manifest_path)) {
            $manifest = json_decode(file_get_contents($manifest_path), true);
            
            if (isset($manifest['src/main.js'])) {
                // Enqueue CSS files FIRST (before JS) to ensure proper loading order
                // Load AFTER WooCommerce styles but with higher specificity
                if (isset($manifest['src/main.js']['css']) && is_array($manifest['src/main.js']['css'])) {
                    $css_index = 0;
                    foreach ($manifest['src/main.js']['css'] as $css_file) {
                        $css_handle = 'forcex-main' . ($css_index > 0 ? '-' . $css_index : '');
                        wp_enqueue_style($css_handle, get_template_directory_uri() . '/dist/' . $css_file, $style_dependencies, '1.0.0', 'all');
                        $css_index++;
                    }
                }
                
                // Then enqueue JS
                wp_enqueue_script('forcex-main', get_template_directory_uri() . '/dist/' . $manifest['src/main.js']['file'], array(), '1.0.0', true);
            }
        } else {
            // Fallback: try to load built files directly
            $css_file = get_template_directory() . '/dist/main.*.css';
            $js_file = get_template_directory() . '/dist/main.*.js';
            
            $css_files = glob($css_file);
            $js_files = glob($js_file);
            
            if (!empty($css_files)) {
                wp_enqueue_style('forcex-main', get_template_directory_uri() . '/dist/' . basename($css_files[0]), $style_dependencies, '1.0.0', 'all');
            }
            if (!empty($js_files)) {
                wp_enqueue_script('forcex-main', get_template_directory_uri() . '/dist/' . basename($js_files[0]), array(), '1.0.0', true);
            }
        }
    }
    
    // Localize script for AJAX
    wp_localize_script('forcex-main', 'forcex_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('forcex_nonce'),
        'email_gate_passed' => isset($_COOKIE['forcex_email_gate_passed']) && $_COOKIE['forcex_email_gate_passed'] === '1',
        'is_logged_in' => is_user_logged_in(),
    ));

    // Inline JS temporarily disabled due to PHP syntax issues on some environments
    // If needed later, move this script to a separate JS asset and enqueue it.
}
// Load styles with high priority to ensure they load after WooCommerce
add_action('wp_enqueue_scripts', 'forcex_scripts', 20);

// Debug: Add inline style check for cart/checkout pages
add_action('wp_head', 'forcex_debug_css_loading', 999);
function forcex_debug_css_loading() {
    if (is_cart() || is_checkout()) {
        $manifest_path = get_template_directory() . '/dist/.vite/manifest.json';
        if (file_exists($manifest_path)) {
            $manifest = json_decode(file_get_contents($manifest_path), true);
            if (isset($manifest['src/main.js']['css'])) {
                $css_file = $manifest['src/main.js']['css'][0];
                $css_url = get_template_directory_uri() . '/dist/' . $css_file;
                echo '<!-- ForceX CSS: ' . esc_url($css_url) . ' -->' . "\n";
            }
        }
    }
}

// Honor ?redirect param during WooCommerce login
add_filter('woocommerce_login_redirect', function($redirect, $user){
    if (!empty($_REQUEST['redirect'])) {
        $target = esc_url_raw($_REQUEST['redirect']);
        return $target;
    }
    return $redirect;
}, 10, 2);

// Honor ?redirect param during WooCommerce registration
add_filter('woocommerce_registration_redirect', function($redirect){
    if (!empty($_REQUEST['redirect'])) {
        $target = esc_url_raw($_REQUEST['redirect']);
        return $target;
    }
    // Default to my-account page after registration
    return wc_get_page_permalink('myaccount');
}, 10, 1);

// Enable registration on myaccount page when coming from email gate (has email param)
add_filter('woocommerce_customer_registration_enabled', function($enabled) {
    // If user is coming from email gate with email parameter, enable registration
    if (!empty($_GET['email'])) {
        return true;
    }
    return $enabled;
}, 10, 1);

// Fix: Ensure password is properly saved during WooCommerce registration
// Hook into user registration BEFORE WooCommerce processes it
add_action('woocommerce_register_post', 'forcex_save_registration_password_before', 5, 3);
function forcex_save_registration_password_before($username, $email, $validation_errors) {
    // Store password in a transient so we can use it after user is created
    if (isset($_POST['password']) && !empty($_POST['password'])) {
        $password = sanitize_text_field($_POST['password']);
        if (!empty(trim($password))) {
            // Store password temporarily (will be used in woocommerce_created_customer hook)
            set_transient('forcex_temp_password_' . md5($email), $password, 300); // 5 minutes
        }
    }
    return $validation_errors;
}

// Fix: Intercept user creation to ensure password is saved correctly
// This hook fires when a new user is registered via WordPress
add_filter('pre_insert_user_data', 'forcex_preserve_password_on_user_creation', 10, 3);
function forcex_preserve_password_on_user_creation($data, $update, $user_id) {
    // Only process for new users (not updates)
    if ($update || $user_id) {
        return $data;
    }
    
    // Check if password is being provided in POST (from registration form)
    if (isset($_POST['password']) && !empty($_POST['password'])) {
        $password = sanitize_text_field($_POST['password']);
        if (!empty(trim($password))) {
            // Store password hash in user_pass field
            // WordPress will hash it automatically, but we want to ensure it's set
            $data['user_pass'] = $password; // WordPress will hash this
        }
    }
    
    return $data;
}

// Fix: Ensure password is properly saved during WooCommerce registration
// This hook fires after a customer is created during registration
add_action('woocommerce_created_customer', 'forcex_save_registration_password', 10, 3);
function forcex_save_registration_password($customer_id, $new_customer_data, $password_generated) {
    if (!$customer_id) {
        return;
    }
    
    // Get user email to retrieve stored password
    $user = get_userdata($customer_id);
    if (!$user || !$user->user_email) {
        return;
    }
    
    // Try to get password from POST first (most reliable)
    $password = null;
    if (isset($_POST['password']) && !empty($_POST['password'])) {
        $password = sanitize_text_field($_POST['password']);
    } else {
        // Fallback: get from transient
        $transient_key = 'forcex_temp_password_' . md5($user->user_email);
        $password = get_transient($transient_key);
        if ($password) {
            delete_transient($transient_key);
        }
    }
    
    // Always set password if it was provided, regardless of password_generated flag
    // This ensures password is saved even if WooCommerce tries to auto-generate it
    if ($password && !empty(trim($password))) {
        // Set the password for the user
        wp_set_password($password, $customer_id);
        
        // Clear any cached user data
        clean_user_cache($customer_id);
        
        // Log the user in automatically after registration if not already logged in
        if (!is_user_logged_in()) {
            wp_set_current_user($customer_id);
            wp_set_auth_cookie($customer_id);
        }
    }
}

// Fix: Prevent password from being overwritten during checkout
// Hook into checkout process to ensure existing user passwords are preserved
add_action('woocommerce_checkout_process', 'forcex_preserve_existing_password', 5);
function forcex_preserve_existing_password() {
    // If user is logged in, don't allow password changes during checkout
    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        if ($current_user && $current_user->ID) {
            // Store current password hash to prevent overwriting
            $user_data = get_userdata($current_user->ID);
            if ($user_data && !empty($user_data->user_pass)) {
                // Store password hash temporarily to prevent overwriting
                set_transient('forcex_preserve_password_' . $current_user->ID, $user_data->user_pass, 600); // 10 minutes
            }
        }
    }
}

// Fix: Ensure password is saved when account is created during checkout
add_action('woocommerce_checkout_order_processed', 'forcex_save_checkout_password', 10, 3);
function forcex_save_checkout_password($order_id, $posted_data, $order) {
    if (!$order_id || !$order) {
        return;
    }
    
    // Check if account was created during checkout
    $customer_id = $order->get_customer_id();
    
    if ($customer_id) {
        // Check if user already existed (has preserved password)
        $preserved_password = get_transient('forcex_preserve_password_' . $customer_id);
        if ($preserved_password) {
            // User already existed, don't overwrite password
            delete_transient('forcex_preserve_password_' . $customer_id);
            return;
        }
        
        // Check if password was provided in checkout form
        // WooCommerce may use different field names
        $password = null;
        if (isset($_POST['account_password']) && !empty($_POST['account_password'])) {
            $password = sanitize_text_field($_POST['account_password']);
        } elseif (isset($_POST['password']) && !empty($_POST['password'])) {
            $password = sanitize_text_field($_POST['password']);
        }
        
        // Only update password if it was provided and user was just created
        if ($password && !empty(trim($password))) {
            // Check if user was created recently (within last minute) to avoid overwriting existing passwords
            $user = get_userdata($customer_id);
            if ($user) {
                $user_registered = strtotime($user->user_registered);
                $time_diff = time() - $user_registered;
                
                // Only update if user was created within last 2 minutes (likely during this checkout)
                if ($time_diff < 120) {
                    wp_set_password($password, $customer_id);
                    clean_user_cache($customer_id);
                }
            }
        }
    }
}

// Fix: Ensure registration form processes password correctly
// Hook into WooCommerce registration form processing
add_action('woocommerce_register_post', 'forcex_validate_registration_password', 10, 3);
function forcex_validate_registration_password($username, $email, $validation_errors) {
    // Check if password field is shown and required
    $password_generated = get_option('woocommerce_registration_generate_password') === 'yes';
    $has_email_param = !empty($_GET['email']);
    
    // If password field should be shown (not auto-generated or coming from checkout)
    if (!$password_generated || $has_email_param) {
        if (empty($_POST['password'])) {
            $validation_errors->add('password_required', __('Password is required.', 'woocommerce'));
        } elseif (strlen($_POST['password']) < 6) {
            $validation_errors->add('password_too_short', __('Password must be at least 6 characters long.', 'woocommerce'));
        }
    }
    
    return $validation_errors;
}

// WooCommerce AJAX add to cart
function forcex_add_to_cart() {
    // Verify nonce
    if (!check_ajax_referer('forcex_nonce', 'nonce', false)) {
        wp_send_json_error(__('Security check failed', 'forcex'));
        return;
    }
    
    // Ensure WooCommerce is active
    if (!class_exists('WooCommerce')) {
        wp_send_json_error(__('WooCommerce is not active', 'forcex'));
        return;
    }
    
    // Initialize WooCommerce cart if not already done
    if (!WC()->cart) {
        WC()->cart = new WC_Cart();
    }
    
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    
    // Validate product ID
    if (!$product_id || $product_id <= 0) {
        wp_send_json_error(__('Invalid product ID', 'forcex'));
        return;
    }
    
    // Validate quantity
    if (!$quantity || $quantity <= 0) {
        $quantity = 1;
    }
    
    // Check if product exists and is purchasable
    $product = wc_get_product($product_id);
    if (!$product) {
        wp_send_json_error(__('Product not found', 'forcex'));
        return;
    }
    
    if (!$product->is_purchasable()) {
        wp_send_json_error(__('Product is not available for purchase', 'forcex'));
        return;
    }
    
    // Check stock availability
    if (!$product->is_in_stock()) {
        wp_send_json_error(__('Product is out of stock', 'forcex'));
        return;
    }
    
    // Check if quantity exceeds stock
    if ($product->managing_stock() && $product->get_stock_quantity() < $quantity) {
        wp_send_json_error(__('Not enough stock available', 'forcex'));
        return;
    }
    
    // Add to cart
    $cart_item_key = WC()->cart->add_to_cart($product_id, $quantity);
    
    if ($cart_item_key) {
        // Calculate totals to ensure cart is updated
        WC()->cart->calculate_totals();
        
        wp_send_json_success(array(
            'message' => __('Product added to cart', 'forcex'),
            'cart_count' => WC()->cart->get_cart_contents_count(),
            'cart_total' => WC()->cart->get_cart_total(),
            'product_name' => $product->get_name(),
        ));
    } else {
        // Get more detailed error information
        $errors = wc_get_notices('error');
        $error_message = !empty($errors) ? $errors[0]['notice'] : __('Failed to add product to cart', 'forcex');
        wp_send_json_error($error_message);
    }
}
add_action('wp_ajax_forcex_add_to_cart', 'forcex_add_to_cart');
add_action('wp_ajax_nopriv_forcex_add_to_cart', 'forcex_add_to_cart');

// WooCommerce AJAX update cart quantity
function forcex_update_cart_quantity() {
    // Verify nonce
    if (!check_ajax_referer('forcex_nonce', 'nonce', false)) {
        wp_send_json_error(__('Security check failed', 'forcex'));
        return;
    }
    
    // Ensure WooCommerce is active
    if (!class_exists('WooCommerce')) {
        wp_send_json_error(__('WooCommerce is not active', 'forcex'));
        return;
    }
    
    $cart_item_key = sanitize_text_field($_POST['cart_item_key']);
    $quantity = intval($_POST['quantity']);
    
    // Validate inputs
    if (empty($cart_item_key) || $quantity < 0) {
        wp_send_json_error(__('Invalid cart item or quantity', 'forcex'));
        return;
    }
    
    // Update cart quantity
    if ($quantity === 0) {
        // Remove item if quantity is 0
        WC()->cart->remove_cart_item($cart_item_key);
    } else {
        // Update quantity
        WC()->cart->set_quantity($cart_item_key, $quantity);
    }
    
    // Calculate totals
    WC()->cart->calculate_totals();
    
    wp_send_json_success(array(
        'message' => __('Cart updated', 'forcex'),
        'cart_count' => WC()->cart->get_cart_contents_count(),
        'cart_total' => WC()->cart->get_cart_total(),
        'cart_subtotal' => WC()->cart->get_cart_subtotal(),
    ));
}
add_action('wp_ajax_forcex_update_cart_quantity', 'forcex_update_cart_quantity');
add_action('wp_ajax_nopriv_forcex_update_cart_quantity', 'forcex_update_cart_quantity');

// WooCommerce AJAX remove cart item
function forcex_remove_cart_item() {
    // Verify nonce
    if (!check_ajax_referer('forcex_nonce', 'nonce', false)) {
        wp_send_json_error(__('Security check failed', 'forcex'));
        return;
    }
    
    // Ensure WooCommerce is active
    if (!class_exists('WooCommerce')) {
        wp_send_json_error(__('WooCommerce is not active', 'forcex'));
        return;
    }
    
    $cart_item_key = sanitize_text_field($_POST['cart_item_key']);
    
    // Validate cart item key
    if (empty($cart_item_key)) {
        wp_send_json_error(__('Invalid cart item', 'forcex'));
        return;
    }
    
    // Remove item from cart
    $removed = WC()->cart->remove_cart_item($cart_item_key);
    
    if ($removed) {
        // Calculate totals
        WC()->cart->calculate_totals();
        
        wp_send_json_success(array(
            'message' => __('Item removed from cart', 'forcex'),
            'cart_count' => WC()->cart->get_cart_contents_count(),
            'cart_total' => WC()->cart->get_cart_total(),
            'cart_subtotal' => WC()->cart->get_cart_subtotal(),
        ));
    } else {
        wp_send_json_error(__('Failed to remove item from cart', 'forcex'));
    }
}
add_action('wp_ajax_forcex_remove_cart_item', 'forcex_remove_cart_item');
add_action('wp_ajax_nopriv_forcex_remove_cart_item', 'forcex_remove_cart_item');

// WooCommerce AJAX clear cart
function forcex_clear_cart() {
    // Verify nonce
    if (!check_ajax_referer('forcex_nonce', 'nonce', false)) {
        wp_send_json_error(__('Security check failed', 'forcex'));
        return;
    }
    
    // Ensure WooCommerce is active
    if (!class_exists('WooCommerce')) {
        wp_send_json_error(__('WooCommerce is not active', 'forcex'));
        return;
    }
    
    // Clear all items from cart
    WC()->cart->empty_cart();
    
    wp_send_json_success(array(
        'message' => __('Cart cleared', 'forcex'),
        'cart_count' => 0,
        'cart_total' => wc_price(0),
        'cart_subtotal' => wc_price(0),
    ));
}
add_action('wp_ajax_forcex_clear_cart', 'forcex_clear_cart');
add_action('wp_ajax_nopriv_forcex_clear_cart', 'forcex_clear_cart');

// Removed starting native PHP sessions globally to avoid conflicts/memory overhead

// Ensure WooCommerce cart is properly initialized
// Removed manual WooCommerce cart/session bootstrapping to avoid early initialization
// which caused: "get_cart should not be called before the wp_loaded action" and memory spikes.

// Additional WooCommerce compatibility fixes
// Removed admin cart/session forcing; Woo handles admin context as needed

// Early WooCommerce initialization to prevent missing function errors
// Removed early init on wp_loaded; avoid touching WC()->cart/session explicitly

// Add debugging information for cart issues
function forcex_debug_cart_info() {
    if (current_user_can('manage_options') && isset($_GET['debug_cart'])) {
        echo '<pre>';
        echo "WooCommerce Active: " . (class_exists('WooCommerce') ? 'Yes' : 'No') . "\n";
        echo "Cart Object: " . (WC()->cart ? 'Exists' : 'Missing') . "\n";
        echo "Session Object: " . (WC()->session ? 'Exists' : 'Missing') . "\n";
        echo "Cart Contents Count: " . (WC()->cart ? WC()->cart->get_cart_contents_count() : 'N/A') . "\n";
        echo "Products in Database: " . wp_count_posts('product')->publish . "\n";
        echo "Cart URL: " . wc_get_cart_url() . "\n";
        echo "Checkout URL: " . wc_get_checkout_url() . "\n";
        echo '</pre>';
    }
}
add_action('wp_footer', 'forcex_debug_cart_info');

// WooCommerce cart functions are loaded early via plugins_loaded hook above

// Add missing WooCommerce functions for backward compatibility
// Note: wc_get_cart_item_data_hash() is now available in WooCommerce core
// Note: wc_get_cart_contents_hash() is now available in WooCommerce core

// WooCommerce notice functions are now handled by the core plugin

// WooCommerce URL functions are now handled by the core plugin

// Ensure WooCommerce is properly loaded before our functions
add_action('woocommerce_loaded', function() {
    // Additional compatibility fixes can go here
});

// Enable basic payment methods
function forcex_enable_payment_methods() {
    // Enable Bank Transfer (BACS) payment method
    update_option('woocommerce_bacs_settings', array(
        'enabled' => 'yes',
        'title' => 'Direct Bank Transfer',
        'description' => 'Make your payment directly into our bank account.',
        'instructions' => 'Please use your Order ID as the payment reference.',
        'account_details' => '',
        'account_name' => '',
        'account_number' => '',
        'bank_name' => '',
        'sort_code' => '',
        'iban' => '',
        'bic' => ''
    ));
    
    // Enable Check payments
    update_option('woocommerce_cheque_settings', array(
        'enabled' => 'yes',
        'title' => 'Check Payments',
        'description' => 'Please send a check to Store Name, Store Street, Store Town, Store State / County, Store Postcode.',
        'instructions' => 'Please send your check to the store address.',
        'enable_for_methods' => array(),
        'enable_for_virtual' => 'yes'
    ));
}
// Run only in admin to avoid repeated option updates on frontend requests
add_action('admin_init', 'forcex_enable_payment_methods');

// Auto-complete BACS (Direct Bank Transfer) orders for testing
// This makes orders go directly to success page without manual payment confirmation
add_filter('woocommerce_payment_complete_order_status', function($status, $order_id, $order) {
    // Check if payment method is BACS (Direct Bank Transfer)
    if ($order && $order->get_payment_method() === 'bacs') {
        // Set to 'processing' so order goes to success page immediately
        // Change to 'completed' if you want orders to be fully completed
        return 'processing';
    }
    return $status;
}, 10, 3);

// Also mark BACS orders as paid automatically
add_action('woocommerce_checkout_order_processed', function($order_id, $posted_data, $order) {
    if ($order && $order->get_payment_method() === 'bacs') {
        // Mark order as paid and set to processing status
        $order->payment_complete();
        $order->update_status('processing', __('Payment automatically processed for testing.', 'woocommerce'));
    }
}, 20, 3);

// Handle email gate submission
function forcex_handle_email_gate() {
    check_ajax_referer('forcex_nonce', 'nonce');
    
    $email = sanitize_email($_POST['email']);
    
    if (!is_email($email)) {
        wp_send_json_error(__('Please enter a valid email address', 'forcex'));
        return;
    }

    // Mark that the gate was passed using a short-lived cookie
    setcookie('forcex_email_gate_passed', '1', time() + HOUR_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true);

    $checkout_url = wc_get_checkout_url();
    $checkout_step1_url = add_query_arg('step', '1', $checkout_url);
    $checkout_step2_url = add_query_arg('step', '2', $checkout_url);

    // Check if the email belongs to an existing account
    $user_id = email_exists($email);
    
    if ($user_id) {
        // Existing user - check if already logged in with this email
        if (is_user_logged_in()) {
            $current_user = wp_get_current_user();
            if ($current_user->user_email === $email) {
                // User is logged in with this email - go directly to step 2
                wp_send_json_success(array(
                    'exists' => true,
                    'requires_login' => false,
                    'checkout_url' => $checkout_step2_url,
                ));
            }
        }
        
        // Existing user but not logged in (or different account) - redirect to login, then to step 2
        $login_page = wc_get_page_permalink('myaccount');
        // WooCommerce login form uses "redirect" param
        // After login, land on checkout step 2 (Delivery)
        $login_url = add_query_arg('redirect', urlencode($checkout_step2_url), $login_page);

        wp_send_json_success(array(
            'exists' => true,
            'requires_login' => true,
            'login_url' => $login_url,
            'checkout_url' => $checkout_step2_url,
        ));
    }

    // New email (no account) – redirect to registration page with email pre-filled
    // After registration, redirect to checkout step 1
    $login_page = wc_get_page_permalink('myaccount');
    $registration_url = add_query_arg(array(
        'email' => urlencode($email),
        'redirect' => urlencode($checkout_step1_url)
    ), $login_page);

    wp_send_json_success(array(
        'exists' => false,
        'requires_login' => false,
        'requires_registration' => true,
        'registration_url' => $registration_url,
        'checkout_url' => $checkout_step1_url,
    ));
}
add_action('wp_ajax_forcex_email_gate', 'forcex_handle_email_gate');
add_action('wp_ajax_nopriv_forcex_email_gate', 'forcex_handle_email_gate');

// Custom checkout fields
function forcex_add_checkout_fields($fields) {
    $fields['billing']['company'] = array(
        'label' => __('Company', 'forcex'),
        'placeholder' => _x('Company name', 'placeholder', 'forcex'),
        'required' => false,
        'class' => array('form-row-wide'),
        'clear' => true,
    );
    
    return $fields;
}
add_filter('woocommerce_checkout_fields', 'forcex_add_checkout_fields');

// Custom shipping method for delivery day selection
function forcex_add_delivery_day_field($checkout) {
    echo '<div id="delivery-day-field">';
    woocommerce_form_field('delivery_day', array(
        'type' => 'select',
        'class' => array('form-row-wide'),
        'label' => __('Choose the delivery day', 'forcex'),
        'options' => array(
            '' => __('Select delivery option', 'forcex'),
            'next_day' => __('UPS Ground Delivery (Next day)', 'forcex'),
            'second_day' => __('UPS Ground Delivery (Second day)', 'forcex'),
        ),
    ), $checkout->get_value('delivery_day'));
    echo '</div>';
}
add_action('woocommerce_after_checkout_billing_form', 'forcex_add_delivery_day_field');

// Save custom checkout field
function forcex_save_delivery_day($order_id) {
    if (!empty($_POST['delivery_day'])) {
        update_post_meta($order_id, 'delivery_day', sanitize_text_field($_POST['delivery_day']));
    }
}
add_action('woocommerce_checkout_update_order_meta', 'forcex_save_delivery_day');

// Handle coupon application
function forcex_apply_coupon() {
    check_ajax_referer('forcex_nonce', 'nonce');
    
    $coupon_code = sanitize_text_field($_POST['coupon_code']);
    
    if (empty($coupon_code)) {
        wp_send_json_error(__('Please enter a coupon code', 'forcex'));
        return;
    }
    
    // Check if coupon exists and is valid
    $coupon = new WC_Coupon($coupon_code);
    
    if (!$coupon->is_valid()) {
        wp_send_json_error(__('Invalid coupon code', 'forcex'));
        return;
    }
    
    // Apply coupon to cart
    $applied = WC()->cart->apply_coupon($coupon_code);
    
    if ($applied) {
        wp_send_json_success(__('Coupon applied successfully!', 'forcex'));
    } else {
        wp_send_json_error(__('Failed to apply coupon', 'forcex'));
    }
}
add_action('wp_ajax_forcex_apply_coupon', 'forcex_apply_coupon');
add_action('wp_ajax_nopriv_forcex_apply_coupon', 'forcex_apply_coupon');

// Handle coupon removal
function forcex_remove_coupon() {
    check_ajax_referer('forcex_nonce', 'nonce');
    
    $coupon_code = sanitize_text_field($_POST['coupon_code']);
    
    if (empty($coupon_code)) {
        wp_send_json_error(__('Please provide a coupon code', 'forcex'));
        return;
    }
    
    // Remove coupon from cart
    $removed = WC()->cart->remove_coupon($coupon_code);
    
    if ($removed) {
        wp_send_json_success(__('Coupon removed successfully!', 'forcex'));
    } else {
        wp_send_json_error(__('Failed to remove coupon', 'forcex'));
    }
}
add_action('wp_ajax_forcex_remove_coupon', 'forcex_remove_coupon');
add_action('wp_ajax_nopriv_forcex_remove_coupon', 'forcex_remove_coupon');

// Handle shipping method update when address changes
function forcex_update_shipping_method() {
    check_ajax_referer('forcex_nonce', 'nonce');
    
    $country = sanitize_text_field($_POST['country']);
    $state = sanitize_text_field($_POST['state']);
    $postcode = sanitize_text_field($_POST['postcode']);
    $city = sanitize_text_field($_POST['city']);
    
    if (empty($country)) {
        wp_send_json_error(__('Country is required', 'forcex'));
        return;
    }
    
    // Update customer location
    WC()->customer->set_billing_country($country);
    WC()->customer->set_shipping_country($country);
    
    if ($state) {
        WC()->customer->set_billing_state($state);
        WC()->customer->set_shipping_state($state);
    }
    if ($postcode) {
        WC()->customer->set_billing_postcode($postcode);
        WC()->customer->set_shipping_postcode($postcode);
    }
    if ($city) {
        WC()->customer->set_billing_city($city);
        WC()->customer->set_shipping_city($city);
    }
    
    // Calculate shipping
    WC()->cart->calculate_shipping();
    
    wp_send_json_success(__('Shipping methods updated', 'forcex'));
}
add_action('wp_ajax_woocommerce_update_shipping_method', 'forcex_update_shipping_method');
add_action('wp_ajax_nopriv_woocommerce_update_shipping_method', 'forcex_update_shipping_method');

// Get checkout totals for AJAX update
function forcex_get_checkout_totals() {
    check_ajax_referer('forcex_nonce', 'nonce');
    
    // Recalculate cart totals
    WC()->cart->calculate_totals();
    
    // Get formatted prices (these return HTML with proper formatting)
    $shipping_total = WC()->cart->get_cart_shipping_total();
    $tax_total = WC()->cart->get_cart_tax();
    $order_total = WC()->cart->get_total();
    
    $data = array(
        'subtotal' => WC()->cart->get_subtotal(),
        'shipping_total' => $shipping_total,
        'tax_total' => $tax_total,
        'discount_total' => WC()->cart->get_discount_total(),
        'order_total' => $order_total,
        'formatted_shipping_total' => $shipping_total, // Already formatted HTML from WooCommerce
        'formatted_tax_total' => $tax_total, // Already formatted HTML from WooCommerce
        'formatted_order_total' => $order_total, // Already formatted HTML from WooCommerce
    );
    
    wp_send_json_success($data);
}
add_action('wp_ajax_forcex_get_checkout_totals', 'forcex_get_checkout_totals');
add_action('wp_ajax_nopriv_forcex_get_checkout_totals', 'forcex_get_checkout_totals');

// Update shipping method selection
function forcex_update_shipping_selection() {
    check_ajax_referer('forcex_nonce', 'nonce');
    
    $shipping_method = sanitize_text_field($_POST['shipping_method']);
    $package_index = isset($_POST['package_index']) ? intval($_POST['package_index']) : 0;
    
    if (empty($shipping_method)) {
        wp_send_json_error(__('Shipping method is required', 'forcex'));
        return;
    }
    
    // Get current chosen shipping methods
    $chosen_methods = WC()->session->get('chosen_shipping_methods', array());
    
    // Update the selected method
    $chosen_methods[$package_index] = $shipping_method;
    
    // Save to session
    WC()->session->set('chosen_shipping_methods', $chosen_methods);
    
    // Clear shipping cache
    WC()->session->set('shipping_for_package_' . $package_index, null);
    
    // Recalculate shipping first (this is important!)
    WC()->cart->calculate_shipping();
    
    // Then recalculate all totals (this includes shipping in the total)
    WC()->cart->calculate_totals();
    
    // Get formatted totals
    $shipping_total = WC()->cart->get_cart_shipping_total();
    $tax_total = WC()->cart->get_cart_tax();
    $order_total = WC()->cart->get_total();
    
    wp_send_json_success(array(
        'shipping_total' => $shipping_total,
        'formatted_shipping_total' => $shipping_total,
        'tax_total' => $tax_total,
        'formatted_tax_total' => $tax_total,
        'order_total' => $order_total,
        'formatted_order_total' => $order_total,
        'subtotal' => WC()->cart->get_cart_subtotal(),
    ));
}
add_action('wp_ajax_forcex_update_shipping_selection', 'forcex_update_shipping_selection');
add_action('wp_ajax_nopriv_forcex_update_shipping_selection', 'forcex_update_shipping_selection');

// Prevent WooCommerce from resetting shipping method during checkout update
add_filter('woocommerce_shipping_chosen_method', 'forcex_preserve_shipping_method', 10, 2);
function forcex_preserve_shipping_method($method, $available_methods) {
    // Get the chosen shipping methods from session
    $chosen_methods = WC()->session->get('chosen_shipping_methods', array());
    
    // If we have a chosen method in session, use it
    if (!empty($chosen_methods)) {
        foreach ($chosen_methods as $package_index => $chosen_method) {
            if (isset($available_methods[$chosen_method])) {
                return $chosen_method;
            }
        }
    }
    
    // Otherwise, use WooCommerce's default behavior
    return $method;
}

// Ensure shipping method is preserved when address changes
add_action('woocommerce_checkout_update_order_review', 'forcex_preserve_shipping_on_address_change', 10, 1);
function forcex_preserve_shipping_on_address_change($post_data) {
    // Parse the posted data
    parse_str($post_data, $data);
    
    // If shipping method is in the posted data, save it
    if (isset($data['shipping_method']) && is_array($data['shipping_method'])) {
        WC()->session->set('chosen_shipping_methods', $data['shipping_method']);
    }
    
    // If payment method is in the posted data, save it
    if (isset($data['payment_method']) && !empty($data['payment_method'])) {
        WC()->session->set('chosen_payment_method', $data['payment_method']);
    }
}

// Update payment method selection via AJAX
function forcex_update_payment_method() {
    check_ajax_referer('forcex_nonce', 'nonce');
    
    $payment_method = sanitize_text_field($_POST['payment_method']);
    
    if (empty($payment_method)) {
        wp_send_json_error(__('Payment method is required', 'forcex'));
        return;
    }
    
    // Ensure WooCommerce session is initialized
    if (!WC()->session) {
        WC()->initialize_session();
    }
    
    // Save payment method to session
    WC()->session->set('chosen_payment_method', $payment_method);
    
    // Recalculate totals to ensure everything is up to date
    WC()->cart->calculate_totals();
    
    wp_send_json_success(array(
        'message' => __('Payment method updated', 'forcex'),
        'payment_method' => $payment_method
    ));
}
add_action('wp_ajax_forcex_update_payment_method', 'forcex_update_payment_method');
add_action('wp_ajax_nopriv_forcex_update_payment_method', 'forcex_update_payment_method');

// Ensure WooCommerce session is maintained during checkout
add_action('woocommerce_checkout_process', 'forcex_ensure_checkout_session', 5);
function forcex_ensure_checkout_session() {
    // Don't run on order received page
    if (forcex_is_order_received_page()) {
        return;
    }
    
    // Ensure session is initialized
    if (!WC()->session) {
        WC()->initialize_session();
    }
    
    // Ensure cart is not empty (only check during processing, not after order creation)
    if (WC()->cart && WC()->cart->is_empty() && !forcex_is_order_received_page()) {
        // This shouldn't happen, but if it does, redirect to cart
        wc_add_notice(__('Your cart is empty. Please add items to your cart before checkout.', 'woocommerce'), 'error');
        wp_safe_redirect(wc_get_cart_url());
        exit;
    }
    
    // Ensure payment method is set if not already set
    if (empty(WC()->session->get('chosen_payment_method')) && !empty($_POST['payment_method'])) {
        WC()->session->set('chosen_payment_method', sanitize_text_field($_POST['payment_method']));
    }
}

// Prevent cart validation errors on order received page - also run on thankyou hook as backup
add_action('woocommerce_thankyou', 'forcex_clear_errors_on_thankyou', 1);
function forcex_clear_errors_on_thankyou($order_id) {
    if (!$order_id) {
        return;
    }
    
    // Clear any cart-related error notices on order received page
    $all_notices = wc_get_notices();
    wc_clear_notices();
    
    // Re-add only notices that are NOT session/cart related
    foreach ($all_notices as $notice_type => $notices) {
        foreach ($notices as $notice) {
            $notice_text = isset($notice['notice']) ? strtolower($notice['notice']) : '';
            // Skip session expired and cart empty errors
            if (strpos($notice_text, 'session has expired') === false && 
                strpos($notice_text, 'cart is empty') === false &&
                strpos($notice_text, 'return to shop') === false) {
                wc_add_notice($notice['notice'], $notice_type);
            }
        }
    }
}

// Prevent session/cart errors from being added on order received page - filter notices before they're added
add_filter('woocommerce_add_error', 'forcex_prevent_session_error_on_thankyou_filter', 10, 2);
function forcex_prevent_session_error_on_thankyou_filter($message, $notice_type = 'error') {
    // Check if we're on order received page
    if (forcex_is_order_received_page()) {
        $message_lower = strtolower($message);
        // Block session expired and cart empty errors
        if (strpos($message_lower, 'session has expired') !== false || 
            strpos($message_lower, 'cart is empty') !== false ||
            strpos($message_lower, 'return to shop') !== false) {
            return ''; // Return empty string to prevent notice from being added
        }
    }
    return $message;
}

// Helper function to check if we're on order received page
function forcex_is_order_received_page() {
    global $wp;
    
    // Method 1: Check query vars
    if (isset($wp->query_vars['order-received'])) {
        return true;
    }
    
    // Method 2: Check GET parameter
    if (isset($_GET['order-received'])) {
        return true;
    }
    
    // Method 3: Check if is_wc_endpoint_url works
    if (function_exists('is_wc_endpoint_url') && is_wc_endpoint_url('order-received')) {
        return true;
    }
    
    // Method 4: Check current URL
    if (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], 'order-received') !== false) {
        return true;
    }
    
    return false;
}

// Clear notices and prevent validation on order received page - run early
add_action('template_redirect', 'forcex_prevent_session_error_on_thankyou', 1);
function forcex_prevent_session_error_on_thankyou() {
    if (!forcex_is_order_received_page()) {
        return;
    }
    
    // Remove validation action completely
    remove_action('woocommerce_before_checkout_process', 'forcex_validate_checkout_session', 1);
    remove_action('woocommerce_checkout_process', 'forcex_ensure_checkout_session', 5);
    
    // Clear all error notices immediately
    $all_notices = wc_get_notices();
    wc_clear_notices();
    
    // Re-add only notices that are NOT session/cart related
    foreach ($all_notices as $notice_type => $notices) {
        foreach ($notices as $notice) {
            $notice_text = isset($notice['notice']) ? strtolower($notice['notice']) : '';
            // Skip session expired and cart empty errors
            if (strpos($notice_text, 'session has expired') === false && 
                strpos($notice_text, 'cart is empty') === false &&
                strpos($notice_text, 'return to shop') === false) {
                wc_add_notice($notice['notice'], $notice_type);
            }
        }
    }
}

// Also clear notices on init hook (very early)
add_action('init', 'forcex_clear_session_errors_early', 1);
function forcex_clear_session_errors_early() {
    if (!forcex_is_order_received_page()) {
        return;
    }
    
    // Clear session/cart related errors immediately
    $all_notices = wc_get_notices();
    wc_clear_notices();
    
    foreach ($all_notices as $notice_type => $notices) {
        foreach ($notices as $notice) {
            $notice_text = isset($notice['notice']) ? strtolower($notice['notice']) : '';
            if (strpos($notice_text, 'session has expired') === false && 
                strpos($notice_text, 'cart is empty') === false &&
                strpos($notice_text, 'return to shop') === false) {
                wc_add_notice($notice['notice'], $notice_type);
            }
        }
    }
}

// Prevent session expiration error by ensuring session is valid before checkout
add_action('woocommerce_before_checkout_process', 'forcex_validate_checkout_session', 1);
function forcex_validate_checkout_session() {
    // Ensure WooCommerce is loaded
    if (!function_exists('WC')) {
        return;
    }
    
    // Don't validate on order received page - cart will be empty after order creation
    if (forcex_is_order_received_page()) {
        return;
    }
    
    // Ensure session exists
    if (!WC()->session) {
        WC()->initialize_session();
    }
    
    // Ensure cart exists and is not empty (only check before processing, not after)
    if (!WC()->cart || WC()->cart->is_empty()) {
        // Only show error if we're actually on checkout page, not order received
        if (is_checkout() && !forcex_is_order_received_page()) {
            wc_add_notice(__('Your session has expired or your cart is empty. Please return to shop.', 'woocommerce'), 'error');
            wp_safe_redirect(wc_get_cart_url());
            exit;
        }
    }
    
    // Refresh session to prevent expiration
    if (WC()->session) {
        WC()->session->set_customer_session_cookie(true);
    }
}

// Force WooCommerce to allow empty cart on order received page
add_filter('woocommerce_checkout_order_received', 'forcex_allow_empty_cart_on_order_received', 10, 2);
function forcex_allow_empty_cart_on_order_received($order_id, $order) {
    // This filter runs when order received page loads
    // Clear any session-related errors
    if ($order_id && forcex_is_order_received_page()) {
        // Clear all error notices
        $all_notices = wc_get_notices();
        wc_clear_notices();
        
        // Only re-add success/info notices, skip errors
        foreach ($all_notices as $notice_type => $notices) {
            if ($notice_type !== 'error') {
                foreach ($notices as $notice) {
                    wc_add_notice($notice['notice'], $notice_type);
                }
            }
        }
    }
    return $order_id;
}

// Extend WooCommerce session lifetime to prevent expiration during checkout
add_filter('wc_session_expiring', 'forcex_extend_session_lifetime', 10, 1);
function forcex_extend_session_lifetime($expiring) {
    // Extend session expiration time - add 24 hours to the expiring time
    return $expiring + (24 * HOUR_IN_SECONDS);
}

add_filter('wc_session_expiration', 'forcex_set_session_expiration', 10, 1);
function forcex_set_session_expiration($expiration) {
    // Set session expiration to 48 hours (in seconds)
    return 48 * HOUR_IN_SECONDS;
}

// Display delivery day in admin
function forcex_display_delivery_day($order) {
    $delivery_day = get_post_meta($order->get_id(), 'delivery_day', true);
    if ($delivery_day) {
        echo '<p><strong>' . __('Delivery Day:', 'forcex') . '</strong> ' . esc_html($delivery_day) . '</p>';
    }
}
add_action('woocommerce_admin_order_data_after_billing_address', 'forcex_display_delivery_day');

// Get cart count for header
function forcex_get_cart_count() {
    return WC()->cart->get_cart_contents_count();
}

// Get featured products
function forcex_get_featured_products($limit = 3) {
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => '_featured',
                'value' => 'yes',
                'compare' => '='
            ),
            array(
                'key' => '_featured',
                'value' => '1',
                'compare' => '='
            )
        ),
        'orderby' => 'menu_order',
        'order' => 'ASC'
    );
    
    // If no featured products found, get regular products
    $query = new WP_Query($args);
    if (!$query->have_posts()) {
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => $limit,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC'
        );
        $query = new WP_Query($args);
    }
    
    return $query;
}

// Add body classes
function forcex_body_classes($classes) {
    if (is_woocommerce() || is_cart() || is_checkout() || is_account_page()) {
        $classes[] = 'woocommerce-page';
    }
    
    return $classes;
}
add_filter('body_class', 'forcex_body_classes');

// Skip link for accessibility
function forcex_skip_link() {
    echo '<a class="skip-link screen-reader-text" href="#main">' . __('Skip to content', 'forcex') . '</a>';
}
add_action('wp_body_open', 'forcex_skip_link');

// Remove WooCommerce default coupon toggle
function forcex_remove_coupon_toggle() {
    remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
}
add_action('init', 'forcex_remove_coupon_toggle');

// Register Events Custom Post Type
function forcex_register_events_post_type() {
    $labels = array(
        'name' => 'Events',
        'singular_name' => 'Event',
        'menu_name' => 'Events',
        'add_new' => 'Add New Event',
        'add_new_item' => 'Add New Event',
        'edit_item' => 'Edit Event',
        'new_item' => 'New Event',
        'view_item' => 'View Event',
        'search_items' => 'Search Events',
        'not_found' => 'No events found',
        'not_found_in_trash' => 'No events found in trash',
        'all_items' => 'All Events',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'events'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-calendar-alt',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest' => true,
    );

    register_post_type('event', $args);
}
add_action('init', 'forcex_register_events_post_type');

// Add custom meta boxes for events
function forcex_add_event_meta_boxes() {
    add_meta_box(
        'event_details',
        'Event Details',
        'forcex_event_details_callback',
        'event',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'forcex_add_event_meta_boxes');

// Event details meta box callback
function forcex_event_details_callback($post) {
    wp_nonce_field('forcex_event_details_nonce', 'forcex_event_details_nonce');
    
    $event_type = get_post_meta($post->ID, '_event_type', true);
    $event_location = get_post_meta($post->ID, '_event_location', true);
    $event_date = get_post_meta($post->ID, '_event_date', true);
    $event_speakers = get_post_meta($post->ID, '_event_speakers', true);
    $event_register_url = get_post_meta($post->ID, '_event_register_url', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th><label for="event_type">Event Type</label></th>
            <td>
                <select name="event_type" id="event_type" style="width: 100%;">
                    <option value="">Select Event Type</option>
                    <option value="exhibitions" <?php selected($event_type, 'exhibitions'); ?>>Exhibitions</option>
                    <option value="conferences" <?php selected($event_type, 'conferences'); ?>>Conferences</option>
                    <option value="trade-shows" <?php selected($event_type, 'trade-shows'); ?>>Trade Shows</option>
                    <option value="webinars" <?php selected($event_type, 'webinars'); ?>>Webinars</option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="event_location">Location</label></th>
            <td>
                <input type="text" name="event_location" id="event_location" value="<?php echo esc_attr($event_location); ?>" style="width: 100%;" />
            </td>
        </tr>
        <tr>
            <th><label for="event_date">Event Date</label></th>
            <td>
                <input type="date" name="event_date" id="event_date" value="<?php echo esc_attr($event_date); ?>" style="width: 100%;" />
            </td>
        </tr>
        <tr>
            <th><label for="event_speakers">Speakers/Attendees</label></th>
            <td>
                <textarea name="event_speakers" id="event_speakers" rows="3" style="width: 100%;" placeholder="Enter speaker names separated by commas"><?php echo esc_textarea($event_speakers); ?></textarea>
                <p class="description">Enter speaker names separated by commas (e.g., John Doe, Jane Smith, Mike Johnson)</p>
            </td>
        </tr>
        <tr>
            <th><label for="event_register_url">Registration URL</label></th>
            <td>
                <input type="url" name="event_register_url" id="event_register_url" value="<?php echo esc_attr($event_register_url); ?>" style="width: 100%;" placeholder="https://example.com/register" />
            </td>
        </tr>
    </table>
    <?php
}

// Save event meta data
function forcex_save_event_meta($post_id) {
    if (!isset($_POST['forcex_event_details_nonce']) || !wp_verify_nonce($_POST['forcex_event_details_nonce'], 'forcex_event_details_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = array('event_type', 'event_location', 'event_date', 'event_speakers', 'event_register_url');
    
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post', 'forcex_save_event_meta');

// Add custom columns to events admin list
function forcex_events_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['event_type'] = 'Event Type';
    $new_columns['event_location'] = 'Location';
    $new_columns['event_date'] = 'Date';
    $new_columns['date'] = $columns['date'];
    
    return $new_columns;
}
add_filter('manage_event_posts_columns', 'forcex_events_columns');

// Populate custom columns
function forcex_events_column_content($column, $post_id) {
    switch ($column) {
        case 'event_type':
            $event_type = get_post_meta($post_id, '_event_type', true);
            echo ucfirst(str_replace('-', ' ', $event_type));
            break;
        case 'event_location':
            echo get_post_meta($post_id, '_event_location', true);
            break;
        case 'event_date':
            $event_date = get_post_meta($post_id, '_event_date', true);
            if ($event_date) {
                echo date('M j, Y', strtotime($event_date));
            }
            break;
    }
}
add_action('manage_event_posts_custom_column', 'forcex_events_column_content', 10, 2);

// Make columns sortable
function forcex_events_sortable_columns($columns) {
    $columns['event_type'] = 'event_type';
    $columns['event_location'] = 'event_location';
    $columns['event_date'] = 'event_date';
    return $columns;
}
add_filter('manage_edit-event_sortable_columns', 'forcex_events_sortable_columns');

// Handle sorting
function forcex_events_orderby($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    $orderby = $query->get('orderby');
    
    if ('event_type' == $orderby) {
        $query->set('meta_key', '_event_type');
        $query->set('orderby', 'meta_value');
    } elseif ('event_location' == $orderby) {
        $query->set('meta_key', '_event_location');
        $query->set('orderby', 'meta_value');
    } elseif ('event_date' == $orderby) {
        $query->set('meta_key', '_event_date');
        $query->set('orderby', 'meta_value');
    }
}
add_action('pre_get_posts', 'forcex_events_orderby');

// Flush rewrite rules on theme activation
function forcex_flush_rewrite_rules() {
    forcex_register_events_post_type();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'forcex_flush_rewrite_rules');

// Register Articles custom post type and taxonomy
function forcex_register_articles_cpt() {
	$labels = array(
		'name' => 'Articles',
		'singular_name' => 'Article',
		'menu_name' => 'Articles',
		'add_new' => 'Add New',
		'add_new_item' => 'Add New Article',
		'edit_item' => 'Edit Article',
		'new_item' => 'New Article',
		'view_item' => 'View Article',
		'search_items' => 'Search Articles',
		'not_found' => 'No articles found',
		'not_found_in_trash' => 'No articles found in trash',
		'all_items' => 'All Articles',
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'blog'),
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => 6,
		'menu_icon' => 'dashicons-media-text',
		'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
		'show_in_rest' => true,
	);

	register_post_type('article', $args);

	// Taxonomy to distinguish Article vs Press Release
	$tax_labels = array(
		'name' => 'Article Types',
		'singular_name' => 'Article Type',
	);

	register_taxonomy('article_type', array('article'), array(
		'labels' => $tax_labels,
		'public' => true,
		'hierarchical' => false,
		'show_ui' => true,
		'show_in_rest' => true,
		'rewrite' => array('slug' => 'article-type'),
	));

	// Ensure default terms exist
	$default_terms = array('article', 'press-release');
	foreach ($default_terms as $term_slug) {
		if (!term_exists($term_slug, 'article_type')) {
			wp_insert_term(ucfirst(str_replace('-', ' ', $term_slug)), 'article_type', array('slug' => $term_slug));
		}
	}
}
add_action('init', 'forcex_register_articles_cpt');

// Flush rewrites when this CPT/tax first appears
function forcex_articles_rewrite_activation() {
	forcex_register_articles_cpt();
	flush_rewrite_rules();
}
add_action('after_switch_theme', 'forcex_articles_rewrite_activation');

// Register Reviews Custom Post Type
function forcex_register_reviews_post_type() {
    $labels = array(
        'name' => 'Reviews',
        'singular_name' => 'Review',
        'menu_name' => 'Reviews',
        'add_new' => 'Add New Review',
        'add_new_item' => 'Add New Review',
        'edit_item' => 'Edit Review',
        'new_item' => 'New Review',
        'view_item' => 'View Review',
        'search_items' => 'Search Reviews',
        'not_found' => 'No reviews found',
        'not_found_in_trash' => 'No reviews found in trash',
        'all_items' => 'All Reviews',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'reviews'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 7,
        'menu_icon' => 'dashicons-star-filled',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest' => true,
    );

    register_post_type('review', $args);
}
add_action('init', 'forcex_register_reviews_post_type');

// Add custom meta boxes for reviews
function forcex_add_review_meta_boxes() {
    add_meta_box(
        'review_details',
        'Review Details',
        'forcex_review_details_callback',
        'review',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'forcex_add_review_meta_boxes');

// Review details meta box callback
function forcex_review_details_callback($post) {
    wp_nonce_field('forcex_review_details_nonce', 'forcex_review_details_nonce');
    
    $reviewer_name = get_post_meta($post->ID, '_reviewer_name', true);
    $reviewer_title = get_post_meta($post->ID, '_reviewer_title', true);
    $is_highlighted = get_post_meta($post->ID, '_is_highlighted', true);
    $is_in_slider = get_post_meta($post->ID, '_is_in_slider', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th><label for="reviewer_name">Reviewer Name</label></th>
            <td>
                <input type="text" name="reviewer_name" id="reviewer_name" value="<?php echo esc_attr($reviewer_name); ?>" style="width: 100%;" placeholder="e.g., Michael Reynolds" />
                <p class="description">The name of the person who wrote the review</p>
            </td>
        </tr>
        <tr>
            <th><label for="reviewer_title">Reviewer Title/Position</label></th>
            <td>
                <input type="text" name="reviewer_title" id="reviewer_title" value="<?php echo esc_attr($reviewer_title); ?>" style="width: 100%;" placeholder="e.g., Patient (ACL Surgery Recovery)" />
                <p class="description">The reviewer's title, profession, or position</p>
            </td>
        </tr>
        <tr>
            <th><label for="is_highlighted">Highlighted Review</label></th>
            <td>
                <label>
                    <input type="checkbox" name="is_highlighted" id="is_highlighted" value="1" <?php checked($is_highlighted, '1'); ?> />
                    Show in top highlighted section (2 reviews max)
                </label>
                <p class="description">If checked, this review will appear in the top 2 highlighted reviews section. Only 2 reviews should be marked as highlighted.</p>
            </td>
        </tr>
        <tr>
            <th><label for="is_in_slider">Include in Slider</label></th>
            <td>
                <label>
                    <input type="checkbox" name="is_in_slider" id="is_in_slider" value="1" <?php checked($is_in_slider, '1'); ?> />
                    Show in slider section
                </label>
                <p class="description">If checked, this review will appear in the slider section between highlighted reviews and the grid.</p>
            </td>
        </tr>
        <tr>
            <th><label>Review Quote/Content</label></th>
            <td>
                <p class="description">Use the main content editor above to enter the review quote/testimonial text.</p>
            </td>
        </tr>
    </table>
    <?php
}

// Save review meta data
function forcex_save_review_meta($post_id) {
    if (!isset($_POST['forcex_review_details_nonce']) || !wp_verify_nonce($_POST['forcex_review_details_nonce'], 'forcex_review_details_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save reviewer name
    if (isset($_POST['reviewer_name'])) {
        update_post_meta($post_id, '_reviewer_name', sanitize_text_field($_POST['reviewer_name']));
    }
    
    // Save reviewer title
    if (isset($_POST['reviewer_title'])) {
        update_post_meta($post_id, '_reviewer_title', sanitize_text_field($_POST['reviewer_title']));
    }
    
    // Save highlighted status
    $is_highlighted = isset($_POST['is_highlighted']) ? '1' : '0';
    update_post_meta($post_id, '_is_highlighted', $is_highlighted);
    
    // Save slider status
    $is_in_slider = isset($_POST['is_in_slider']) ? '1' : '0';
    update_post_meta($post_id, '_is_in_slider', $is_in_slider);
}
add_action('save_post', 'forcex_save_review_meta');

// Add custom columns to reviews admin list
function forcex_reviews_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['reviewer_name'] = 'Reviewer';
    $new_columns['reviewer_title'] = 'Title';
    $new_columns['is_highlighted'] = 'Highlighted';
    $new_columns['is_in_slider'] = 'In Slider';
    $new_columns['date'] = $columns['date'];
    
    return $new_columns;
}
add_filter('manage_review_posts_columns', 'forcex_reviews_columns');

// Populate custom columns
function forcex_reviews_column_content($column, $post_id) {
    switch ($column) {
        case 'reviewer_name':
            echo esc_html(get_post_meta($post_id, '_reviewer_name', true));
            break;
        case 'reviewer_title':
            echo esc_html(get_post_meta($post_id, '_reviewer_title', true));
            break;
        case 'is_highlighted':
            $is_highlighted = get_post_meta($post_id, '_is_highlighted', true);
            echo $is_highlighted === '1' ? '<span style="color: green;">✓ Yes</span>' : '<span style="color: gray;">No</span>';
            break;
        case 'is_in_slider':
            $is_in_slider = get_post_meta($post_id, '_is_in_slider', true);
            echo $is_in_slider === '1' ? '<span style="color: green;">✓ Yes</span>' : '<span style="color: gray;">No</span>';
            break;
    }
}
add_action('manage_review_posts_custom_column', 'forcex_reviews_column_content', 10, 2);

// Flush rewrite rules on theme activation for reviews
function forcex_reviews_rewrite_activation() {
    forcex_register_reviews_post_type();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'forcex_reviews_rewrite_activation');

// Flush rewrite rules when reviews post type is registered for the first time
function forcex_maybe_flush_reviews_rewrite_rules() {
    $reviews_flushed = get_option('forcex_reviews_rewrite_flushed', false);
    if (!$reviews_flushed) {
        flush_rewrite_rules();
        update_option('forcex_reviews_rewrite_flushed', true);
    }
}
add_action('init', 'forcex_maybe_flush_reviews_rewrite_rules', 999);

// AJAX: Get order details HTML for modal
function forcex_get_order_details() {
    if (!check_ajax_referer('forcex_nonce', 'nonce', false)) {
        wp_send_json_error('Invalid nonce');
    }

    if (!is_user_logged_in()) {
        wp_send_json_error('Unauthorized');
    }

    $order_id = isset($_POST['order_id']) ? absint($_POST['order_id']) : 0;
    if (!$order_id) {
        wp_send_json_error('Missing order id');
    }

    $order = wc_get_order($order_id);
    if (!$order || $order->get_user_id() !== get_current_user_id()) {
        wp_send_json_error('Order not found');
    }

    ob_start();
    ?>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h3 class="text-2xl font-semibold text-gray-900">Order #<?php echo esc_html($order->get_order_number()); ?></h3>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?php echo $order->has_status('completed') ? 'bg-green-100 text-green-800' : ($order->has_status('processing') ? 'bg-primary-100 text-primary-800' : 'bg-gray-100 text-gray-800'); ?>">
                <?php echo esc_html(wc_get_order_status_name($order->get_status())); ?>
            </span>
        </div>

        <div class="divide-y divide-gray-200">
            <?php foreach ($order->get_items() as $item_id => $item) :
                $product = $item->get_product();
                $thumb = $product ? $product->get_image('thumbnail') : '';
            ?>
                <div class="py-4 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 flex items-center justify-center bg-gray-50 rounded-md overflow-hidden"><?php echo $thumb ?: ''; ?></div>
                        <div>
                            <div class="text-gray-900 font-medium"><?php echo esc_html($item->get_name()); ?></div>
                            <div class="text-xs text-gray-500">x <?php echo intval($item->get_quantity()); ?></div>
                        </div>
                    </div>
                    <div class="text-gray-900 font-semibold"><?php echo wc_price($item->get_total() + $item->get_total_tax(), array('currency' => $order->get_currency())); ?></div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="border-t border-gray-200 pt-4 space-y-2">
            <div class="flex justify-between text-gray-700"><span>Subtotal</span><span><?php echo wp_kses_post($order->get_subtotal_to_display()); ?></span></div>
            <div class="flex justify-between text-gray-700"><span>Shipping</span><span><?php echo wp_kses_post($order->get_shipping_to_display()); ?></span></div>
            <div class="flex justify-between text-gray-700"><span>Discount</span><span><?php echo wc_price($order->get_discount_total(), array('currency' => $order->get_currency())); ?></span></div>
            <div class="flex justify-between text-lg font-semibold text-gray-900 border-t border-gray-200 pt-2"><span>Total</span><span><?php echo wp_kses_post($order->get_formatted_order_total()); ?></span></div>
        </div>

        <div class="border-t border-gray-200 pt-4">
            <div class="text-sm text-gray-600">
                <?php $address = $order->get_formatted_billing_address(); if ($address) { echo wp_kses_post($address); } ?>
            </div>
        </div>
    </div>
    <?php
    $html = ob_get_clean();
    wp_send_json_success($html);
}
add_action('wp_ajax_forcex_get_order_details', 'forcex_get_order_details');
add_action('wp_ajax_nopriv_forcex_get_order_details', 'forcex_get_order_details');

// Handle contact form submissions (Distributors, Clinic, Prescribers, Patients)
function forcex_handle_contact_form() {
    // Verify nonce
    if (!check_ajax_referer('forcex_nonce', 'nonce', false)) {
        wp_send_json_error(__('Security check failed', 'forcex'));
        return;
    }

    // Get form source (which page the form came from)
    $form_source = isset($_POST['form_source']) ? sanitize_text_field($_POST['form_source']) : 'unknown';
    
    // Handle contact form differently (has name, email, message instead of first_name, last_name, phone)
    if ($form_source === 'contact') {
        $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
        $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
        $message = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';
        $privacy_policy = isset($_POST['privacy_policy']) ? true : false;
        
        // Validation for contact form
        if (empty($name) || empty($email) || empty($message)) {
            wp_send_json_error(__('Please fill in all required fields', 'forcex'));
            return;
        }
        
        if (!is_email($email)) {
            wp_send_json_error(__('Please enter a valid email address', 'forcex'));
            return;
        }
        
        if (!$privacy_policy) {
            wp_send_json_error(__('You must agree to the Privacy Policy', 'forcex'));
            return;
        }
        
        // Build email message for contact form
        $form_title = 'Contact Form Submission';
        $email_message = "New Contact Form Submission\n\n";
        $email_message .= "Name: {$name}\n";
        $email_message .= "Email: {$email}\n";
        $email_message .= "Message:\n{$message}\n\n";
        $email_message .= "Submitted: " . current_time('mysql') . "\n";
        $email_message .= "IP Address: " . $_SERVER['REMOTE_ADDR'] . "\n";
        
        // Get admin email
        $admin_email = get_option('admin_email');
        $site_name = get_bloginfo('name');
        
        // Email headers
        $headers = array(
            'Content-Type: text/plain; charset=UTF-8',
            'From: ' . $site_name . ' <' . $admin_email . '>',
            'Reply-To: ' . $name . ' <' . $email . '>'
        );
        
        // Send email to admin
        $subject = "[{$site_name}] Contact Form Submission from {$name}";
        $email_sent = wp_mail($admin_email, $subject, $email_message, $headers);
        
        // Send confirmation email to user
        $user_subject = "Thank you for contacting us";
        $user_message = "Dear {$name},\n\n";
        $user_message .= "Thank you for contacting ForceX™. We have received your message and our team will contact you shortly.\n\n";
        $user_message .= "Best regards,\n";
        $user_message .= "The ForceX™ Team";
        
        $user_email_sent = wp_mail($email, $user_subject, $user_message, $headers);
        
        if ($email_sent) {
            wp_send_json_success(array(
                'message' => __('Thank you! Your message has been sent successfully. We will contact you soon.', 'forcex')
            ));
        } else {
            wp_send_json_error(__('There was an error sending your message. Please try again later.', 'forcex'));
        }
        return;
    }
    
    // Validate required fields for other forms
    $first_name = isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : '';
    $last_name = isset($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : '';
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
    
    // Optional fields
    $email_secondary = isset($_POST['email_secondary']) ? sanitize_email($_POST['email_secondary']) : '';
    $physician_location = isset($_POST['physician_location']) ? sanitize_text_field($_POST['physician_location']) : '';
    $privacy_policy = isset($_POST['privacy_policy']) ? true : false;

    // Validation
    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone)) {
        wp_send_json_error(__('Please fill in all required fields', 'forcex'));
        return;
    }

    if (!is_email($email)) {
        wp_send_json_error(__('Please enter a valid email address', 'forcex'));
        return;
    }

    // For patients form, check required fields
    if ($form_source === 'patients') {
        if (empty($physician_location)) {
            wp_send_json_error(__('Please select a physician location', 'forcex'));
            return;
        }
        if (!$privacy_policy) {
            wp_send_json_error(__('You must agree to the Privacy Policy', 'forcex'));
            return;
        }
    }
    
    // For clinical-resources form, check privacy policy
    if ($form_source === 'clinical-resources') {
        if (!$privacy_policy) {
            wp_send_json_error(__('You must agree to the Privacy Policy', 'forcex'));
            return;
        }
    }

    // Prepare email content
    $form_titles = array(
        'distributors' => 'Distributor Application',
        'clinic' => 'Clinic Rental Request',
        'prescribers' => 'Prescriber Rental Request',
        'patients' => 'Patient Rental Request',
        'clinical-resources' => 'Clinical Resources Contact Request',
        'medical-professionals' => 'Medical Professionals Contact Request'
    );
    
    $form_title = isset($form_titles[$form_source]) ? $form_titles[$form_source] : 'Contact Form Submission';
    
    // Build email message
    $message = "New {$form_title}\n\n";
    $message .= "Form Source: " . ucfirst($form_source) . "\n\n";
    $message .= "Contact Information:\n";
    $message .= "First Name: {$first_name}\n";
    $message .= "Last Name: {$last_name}\n";
    $message .= "Email: {$email}\n";
    $message .= "Phone: {$phone}\n\n";
    
    if (!empty($email_secondary)) {
        $message .= "Secondary Email: {$email_secondary}\n";
    }
    
    if (!empty($physician_location)) {
        $message .= "Physician Location: {$physician_location}\n";
    }
    
    $message .= "\nSubmitted: " . current_time('mysql') . "\n";
    $message .= "IP Address: " . $_SERVER['REMOTE_ADDR'] . "\n";

    // Get admin email
    $admin_email = get_option('admin_email');
    $site_name = get_bloginfo('name');
    
    // Email headers
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $site_name . ' <' . $admin_email . '>',
        'Reply-To: ' . $first_name . ' ' . $last_name . ' <' . $email . '>'
    );

    // Send email to admin
    $subject = "[{$site_name}] {$form_title} from {$first_name} {$last_name}";
    $email_sent = wp_mail($admin_email, $subject, $message, $headers);

    // Optionally send confirmation email to user
    $user_subject = "Thank you for your {$form_title}";
    $user_message = "Dear {$first_name} {$last_name},\n\n";
    $user_message .= "Thank you for your interest in ForceX™. We have received your {$form_title} and our team will contact you shortly with more information.\n\n";
    $user_message .= "Best regards,\n";
    $user_message .= "The ForceX™ Team";
    
    $user_email_sent = wp_mail($email, $user_subject, $user_message, $headers);

    if ($email_sent) {
        wp_send_json_success(array(
            'message' => __('Thank you! Your form has been submitted successfully. We will contact you soon.', 'forcex')
        ));
    } else {
        wp_send_json_error(__('There was an error sending your message. Please try again later.', 'forcex'));
    }
}
add_action('wp_ajax_forcex_contact_form', 'forcex_handle_contact_form');
add_action('wp_ajax_nopriv_forcex_contact_form', 'forcex_handle_contact_form');

// Handle /products URL routing
function forcex_products_page_template() {
    // Skip if in admin or AJAX
    if (is_admin() || wp_doing_ajax()) {
        return;
    }
    
    // Get the current URL path using multiple methods for compatibility
    $request_uri = isset($_SERVER['REQUEST_URI']) ? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) : '';
    
    // Remove WordPress installation path if site is in subdirectory
    $home_path = parse_url(home_url(), PHP_URL_PATH);
    if ($home_path && $home_path !== '/') {
        $request_uri = str_replace($home_path, '', $request_uri);
    }
    
    // Clean up the path
    $request_uri = trim($request_uri, '/');
    
    // Also check using WordPress's request path
    $wp_request = trim($_SERVER['REQUEST_URI'] ?? '', '/');
    if ($home_path && $home_path !== '/') {
        $wp_request = str_replace(trim($home_path, '/'), '', $wp_request);
        $wp_request = trim($wp_request, '/');
    }
    
    // Get the current page path using WordPress functions
    global $wp;
    $current_path = trim($wp->request ?? '', '/');
    
    // Check query var from rewrite rule
    $query_var = get_query_var('forcex_products_page');
    
    // Check if we're on /products URL (handle various formats)
    $is_products_page = (
        $query_var === '1' ||
        $request_uri === 'products' || 
        rtrim($request_uri, '/') === 'products' ||
        $wp_request === 'products' ||
        rtrim($wp_request, '/') === 'products' ||
        $current_path === 'products' ||
        (isset($_SERVER['REQUEST_URI']) && preg_match('#/products/?(\?|$)#', $_SERVER['REQUEST_URI'])) ||
        (isset($_SERVER['REQUEST_URI']) && preg_match('#/products/?$#', $_SERVER['REQUEST_URI']))
    );
    
    if ($is_products_page) {
        // Load our custom template
        $template = locate_template('page-products.php');
        if ($template) {
            // Set up WordPress query vars to avoid 404 and warnings
            global $wp_query, $post;
            
            // Create a dummy post object to prevent null errors
            $post_data = array(
                'ID' => 0,
                'post_author' => 1,
                'post_date' => current_time('mysql'),
                'post_date_gmt' => current_time('mysql', 1),
                'post_content' => '',
                'post_title' => 'Our products',
                'post_excerpt' => '',
                'post_status' => 'publish',
                'comment_status' => 'closed',
                'ping_status' => 'closed',
                'post_password' => '',
                'post_name' => 'products',
                'to_ping' => '',
                'pinged' => '',
                'post_modified' => current_time('mysql'),
                'post_modified_gmt' => current_time('mysql', 1),
                'post_content_filtered' => '',
                'post_parent' => 0,
                'guid' => home_url('/products'),
                'menu_order' => 0,
                'post_type' => 'page',
                'post_mime_type' => '',
                'comment_count' => 0,
                'filter' => 'raw'
            );
            
            // Convert to WP_Post object
            $post = new WP_Post((object) $post_data);
            
            // Set up query vars
            $wp_query->is_page = true;
            $wp_query->is_singular = true;
            $wp_query->is_404 = false;
            $wp_query->is_home = false;
            $wp_query->is_archive = false;
            $wp_query->is_search = false;
            $wp_query->posts = array($post);
            $wp_query->post_count = 1;
            $wp_query->found_posts = 1;
            $wp_query->max_num_pages = 1;
            $wp_query->queried_object = $post;
            $wp_query->queried_object_id = 0;
            
            // Add body class for styling
            add_filter('body_class', function($classes) {
                $classes[] = 'page-products';
                return $classes;
            });
            
            // Set up global post
            setup_postdata($post);
            
            load_template($template);
            exit;
        }
    }
}
// Add rewrite rule for /products page
function forcex_add_products_rewrite_rule() {
    add_rewrite_rule('^products/?$', 'index.php?forcex_products_page=1', 'top');
}
add_action('init', 'forcex_add_products_rewrite_rule');

// Register query var
function forcex_register_products_query_var($vars) {
    $vars[] = 'forcex_products_page';
    return $vars;
}
add_filter('query_vars', 'forcex_register_products_query_var');

add_action('template_redirect', 'forcex_products_page_template', 1);

// Redirect /articles-press-releases/ to /blog
function forcex_redirect_articles_to_blog() {
    // Skip if in admin or AJAX
    if (is_admin() || wp_doing_ajax()) {
        return;
    }
    
    // Get the current URL path
    $request_uri = isset($_SERVER['REQUEST_URI']) ? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) : '';
    
    // Remove WordPress installation path if site is in subdirectory
    $home_path = parse_url(home_url(), PHP_URL_PATH);
    if ($home_path && $home_path !== '/') {
        $request_uri = str_replace($home_path, '', $request_uri);
    }
    
    // Clean up the path
    $request_uri = trim($request_uri, '/');
    
    // Check if we're on /articles-press-releases URL
    if ($request_uri === 'articles-press-releases' || 
        rtrim($request_uri, '/') === 'articles-press-releases' ||
        (isset($_SERVER['REQUEST_URI']) && preg_match('#/articles-press-releases/?(\?|$)#', $_SERVER['REQUEST_URI']))) {
        
        // Get the blog archive URL
        $blog_url = get_post_type_archive_link('article') ?: home_url('/blog');
        
        // Preserve query parameters if any
        $query_string = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
        if ($query_string) {
            $blog_url = add_query_arg($query_string, $blog_url);
        }
        
        // Perform 301 permanent redirect
        wp_redirect($blog_url, 301);
        exit;
    }
}
add_action('template_redirect', 'forcex_redirect_articles_to_blog', 1);

// Add rewrite rule for /blog page to ensure it works
function forcex_add_blog_rewrite_rule() {
    add_rewrite_rule('^blog/?$', 'index.php?post_type=article', 'top');
}
add_action('init', 'forcex_add_blog_rewrite_rule');

// Handle /blog URL routing to ensure archive template loads
function forcex_blog_archive_template() {
    // Skip if in admin or AJAX
    if (is_admin() || wp_doing_ajax()) {
        return;
    }
    
    // Get the current URL path
    $request_uri = isset($_SERVER['REQUEST_URI']) ? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) : '';
    
    // Remove WordPress installation path if site is in subdirectory
    $home_path = parse_url(home_url(), PHP_URL_PATH);
    if ($home_path && $home_path !== '/') {
        $request_uri = str_replace($home_path, '', $request_uri);
    }
    
    // Clean up the path
    $request_uri = trim($request_uri, '/');
    
    // Check if we're on /blog URL
    if ($request_uri === 'blog' || 
        rtrim($request_uri, '/') === 'blog' ||
        (isset($_SERVER['REQUEST_URI']) && preg_match('#/blog/?(\?|$)#', $_SERVER['REQUEST_URI']))) {
        
        // Set up query to show article post type archive
        global $wp_query;
        
        // Set query vars for article archive
        $wp_query->set('post_type', 'article');
        $wp_query->set('posts_per_page', get_option('posts_per_page', 10));
        
        // Set query flags
        $wp_query->is_archive = true;
        $wp_query->is_post_type_archive = true;
        $wp_query->is_home = false;
        $wp_query->is_404 = false;
        
        // Execute the query
        $wp_query->get_posts();
        
        // Load the archive template
        $template = locate_template('archive-article.php');
        if ($template) {
            load_template($template);
            exit;
        }
    }
}
add_action('template_redirect', 'forcex_blog_archive_template', 2);

// Ensure default product categories exist for filtering
function forcex_create_default_product_categories() {
    if (!taxonomy_exists('product_cat')) {
        return; // WooCommerce not active
    }
    
    // Create "Devices" category
    if (!term_exists('devices', 'product_cat')) {
        wp_insert_term(
            'Devices',
            'product_cat',
            array(
                'slug' => 'devices',
                'description' => 'ForceX therapy machines and devices'
            )
        );
    }
    
    // Create "Accessoires" category
    if (!term_exists('accessoires', 'product_cat')) {
        wp_insert_term(
            'Accessoires',
            'product_cat',
            array(
                'slug' => 'accessoires',
                'description' => 'ForceX accessories and wraps'
            )
        );
    }
    
    // Also create "Accessories" (English version) if it doesn't exist
    if (!term_exists('accessories', 'product_cat')) {
        wp_insert_term(
            'Accessories',
            'product_cat',
            array(
                'slug' => 'accessories',
                'description' => 'ForceX accessories and wraps'
            )
        );
    }
}
add_action('init', 'forcex_create_default_product_categories', 20);

// Get all products for products page
function forcex_get_all_products($category = '') {
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'orderby' => 'menu_order',
        'order' => 'ASC'
    );
    
    // Filter by category if specified
    if (!empty($category)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => $category
            )
        );
    }
    
    return new WP_Query($args);
}

// Add custom meta boxes for products
function forcex_add_product_meta_boxes() {
    add_meta_box(
        'product_components',
        'Product Components',
        'forcex_product_components_callback',
        'product',
        'normal',
        'high'
    );
    
    add_meta_box(
        'product_therapy_types',
        'Types of Therapies',
        'forcex_product_therapy_types_callback',
        'product',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'forcex_add_product_meta_boxes');

// Product Components meta box callback
function forcex_product_components_callback($post) {
    wp_nonce_field('forcex_product_components_nonce', 'forcex_product_components_nonce');
    
    $components = get_post_meta($post->ID, '_product_components', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="product_components">Components</label></th>
            <td>
                <textarea name="product_components" id="product_components" rows="5" style="width: 100%;" placeholder="e.g., Host (including air pump), connecting pipe, power adapter, sleeves, trolley case"><?php echo esc_textarea($components); ?></textarea>
                <p class="description">Enter the product components as plain text. This will be displayed on the product page.</p>
            </td>
        </tr>
    </table>
    <?php
}

// Product Therapy Types meta box callback
function forcex_product_therapy_types_callback($post) {
    wp_nonce_field('forcex_product_therapy_types_nonce', 'forcex_product_therapy_types_nonce');
    
    $therapy_types = get_post_meta($post->ID, '_product_therapy_types', true);
    if (!is_array($therapy_types)) {
        $therapy_types = array();
    }
    
    $icon_options = array(
        'snow' => 'Snow (Cold)',
        'fire' => 'Fire (Heat)',
        'circle' => 'Circle (Compression)'
    );
    ?>
    <div id="therapy-types-container">
        <p class="description">Add therapy types with icons. Click "Add Therapy Type" to add more.</p>
        <div id="therapy-types-list">
            <?php
            if (!empty($therapy_types)) {
                foreach ($therapy_types as $index => $therapy) {
                    ?>
                    <div class="therapy-type-item" style="margin-bottom: 15px; padding: 15px; border: 1px solid #ddd; background: #f9f9f9;">
                        <table class="form-table" style="margin: 0;">
                            <tr>
                                <th style="width: 150px;"><label>Therapy Name</label></th>
                                <td>
                                    <input type="text" name="therapy_types[<?php echo $index; ?>][name]" value="<?php echo esc_attr($therapy['name']); ?>" style="width: 100%;" placeholder="e.g., Cold Therapy" />
                                </td>
                            </tr>
                            <tr>
                                <th><label>Icons (max 3)</label></th>
                                <td>
                                    <div class="icon-selection" style="display: flex; flex-wrap: wrap; gap: 10px;">
                                        <?php
                                        $selected_icons = !empty($therapy['icons']) && is_array($therapy['icons']) ? $therapy['icons'] : array();
                                        foreach ($icon_options as $value => $label) {
                                            $checked = in_array($value, $selected_icons) ? 'checked' : '';
                                            echo '<label style="display: flex; align-items: center; gap: 5px; cursor: pointer;">';
                                            echo '<input type="checkbox" name="therapy_types[' . $index . '][icons][]" value="' . esc_attr($value) . '" class="therapy-icon-checkbox" ' . $checked . ' />';
                                            echo '<span>' . esc_html($label) . '</span>';
                                            echo '</label>';
                                        }
                                        ?>
                                    </div>
                                    <p class="description" style="margin-top: 5px;">Select up to 3 icons. Selected: <span class="icon-count"><?php echo count($selected_icons); ?></span>/3</p>
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <td>
                                    <button type="button" class="button remove-therapy-type" style="color: #dc3232;">Remove</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <button type="button" id="add-therapy-type" class="button">Add Therapy Type</button>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var therapyIndex = <?php echo count($therapy_types); ?>;
        var iconOptions = <?php echo json_encode($icon_options); ?>;
        
        // Function to update icon count
        function updateIconCount(container) {
            var checked = container.find('.therapy-icon-checkbox:checked').length;
            container.closest('.therapy-type-item').find('.icon-count').text(checked);
        }
        
        // Limit icon selection to 3
        $(document).on('change', '.therapy-icon-checkbox', function() {
            var container = $(this).closest('.therapy-type-item');
            var checked = container.find('.therapy-icon-checkbox:checked').length;
            
            if (checked > 3) {
                $(this).prop('checked', false);
                alert('You can only select up to 3 icons per therapy type.');
            }
            
            updateIconCount(container);
        });
        
        $('#add-therapy-type').on('click', function() {
            var html = '<div class="therapy-type-item" style="margin-bottom: 15px; padding: 15px; border: 1px solid #ddd; background: #f9f9f9;">';
            html += '<table class="form-table" style="margin: 0;">';
            html += '<tr><th style="width: 150px;"><label>Therapy Name</label></th>';
            html += '<td><input type="text" name="therapy_types[' + therapyIndex + '][name]" value="" style="width: 100%;" placeholder="e.g., Cold Therapy" /></td></tr>';
            html += '<tr><th><label>Icons (max 3)</label></th>';
            html += '<td><div class="icon-selection" style="display: flex; flex-wrap: wrap; gap: 10px;">';
            
            for (var key in iconOptions) {
                html += '<label style="display: flex; align-items: center; gap: 5px; cursor: pointer;">';
                html += '<input type="checkbox" name="therapy_types[' + therapyIndex + '][icons][]" value="' + key + '" class="therapy-icon-checkbox" />';
                html += '<span>' + iconOptions[key] + '</span>';
                html += '</label>';
            }
            
            html += '</div>';
            html += '<p class="description" style="margin-top: 5px;">Select up to 3 icons. Selected: <span class="icon-count">0</span>/3</p>';
            html += '</td></tr>';
            html += '<tr><th></th><td><button type="button" class="button remove-therapy-type" style="color: #dc3232;">Remove</button></td></tr>';
            html += '</table></div>';
            
            $('#therapy-types-list').append(html);
            therapyIndex++;
        });
        
        $(document).on('click', '.remove-therapy-type', function() {
            $(this).closest('.therapy-type-item').remove();
        });
        
        // Initialize icon counts for existing items
        $('.therapy-type-item').each(function() {
            updateIconCount($(this));
        });
    });
    </script>
    <?php
}

// Save product meta data
function forcex_save_product_meta($post_id) {
    // Check nonces
    if (!isset($_POST['forcex_product_components_nonce']) || !wp_verify_nonce($_POST['forcex_product_components_nonce'], 'forcex_product_components_nonce')) {
        return;
    }
    
    if (!isset($_POST['forcex_product_therapy_types_nonce']) || !wp_verify_nonce($_POST['forcex_product_therapy_types_nonce'], 'forcex_product_therapy_types_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save components
    if (isset($_POST['product_components'])) {
        update_post_meta($post_id, '_product_components', sanitize_textarea_field($_POST['product_components']));
    }
    
    // Save therapy types
    if (isset($_POST['therapy_types']) && is_array($_POST['therapy_types'])) {
        $therapy_types = array();
        foreach ($_POST['therapy_types'] as $therapy) {
            if (!empty($therapy['name'])) {
                // Get icons array and limit to 3
                $icons = array();
                if (!empty($therapy['icons']) && is_array($therapy['icons'])) {
                    $icons = array_slice(array_map('sanitize_text_field', $therapy['icons']), 0, 3);
                }
                
                $therapy_types[] = array(
                    'name' => sanitize_text_field($therapy['name']),
                    'icons' => $icons
                );
            }
        }
        update_post_meta($post_id, '_product_therapy_types', $therapy_types);
    } else {
        // If no therapy types submitted, clear the meta
        delete_post_meta($post_id, '_product_therapy_types');
    }
}
add_action('save_post', 'forcex_save_product_meta');

// ============================================
// Who Rents ForceX Admin Settings
// ============================================

// Add meta box for Who Rents section (only on Rent ForceX template pages)
function forcex_add_who_rents_meta_box() {
    global $post;
    if (!$post) return;
    
    $template = get_page_template_slug($post->ID);
    if ($template !== 'page-rent-forcex.php') {
        return; // Don't show meta box for other templates
    }
    
    add_meta_box(
        'forcex_who_rents',
        'Who Rents ForceX™ Section',
        'forcex_who_rents_meta_box_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'forcex_add_who_rents_meta_box');

// Meta box callback
function forcex_who_rents_meta_box_callback($post) {
    // Check if this page uses the Rent ForceX template
    $template = get_page_template_slug($post->ID);
    if ($template !== 'page-rent-forcex.php') {
        echo '<p><strong>Note:</strong> This meta box is only active for pages using the "Rent ForceX" template. To use it, go to Page Attributes and select "Rent ForceX" as the template.</p>';
        return;
    }
    
    wp_nonce_field('forcex_who_rents_meta_box', 'forcex_who_rents_meta_box_nonce');
    wp_enqueue_media();
    
    // Get saved items
    $rent_items = get_post_meta($post->ID, '_forcex_who_rents_items', true);
    if (!is_array($rent_items)) {
        $rent_items = array();
    }
    
    // Default items if empty
    if (empty($rent_items)) {
        $rent_items = array(
            array(
                'tab_label' => 'Patients',
                'title' => 'Patients',
                'benefits' => array('Pain reduction', 'Circulation improving'),
                'description' => 'Individuals recovering from orthopedic surgeries, joint replacements, or injuries who need an advanced, easy-to-use therapy system for home recovery.',
                'bg_image_id' => 0,
                'bg_position' => 'center right',
                'gradient_direction' => 'to left',
                'order' => 0
            ),
            array(
                'tab_label' => 'Medical professionals',
                'title' => 'Medical professionals',
                'benefits' => array('Healing acceleration'),
                'description' => 'Doctors, physical therapists use the ForceX for its precision in reducing swelling, and accelerating recovery for their patients.',
                'bg_image_id' => 0,
                'bg_position' => 'center left',
                'gradient_direction' => 'to right',
                'order' => 1
            ),
            array(
                'tab_label' => 'Clinics & Rehabilitation centers',
                'title' => 'Clinics & Rehabilitation centers',
                'benefits' => array('Professional therapy equipment', 'Multiple patient support'),
                'description' => 'Healthcare facilities that provide comprehensive rehabilitation services and need reliable, professional-grade therapy equipment for multiple patients.',
                'bg_image_id' => 0,
                'bg_position' => 'center right',
                'gradient_direction' => 'to left',
                'order' => 2
            ),
            array(
                'tab_label' => 'Athletes & Fitness enthusiasts',
                'title' => 'Athletes & Fitness enthusiasts',
                'benefits' => array('Faster recovery', 'Performance optimization'),
                'description' => 'Competitive athletes and fitness enthusiasts who need rapid recovery solutions to maintain peak performance and reduce downtime between training sessions.',
                'bg_image_id' => 0,
                'bg_position' => 'center left',
                'gradient_direction' => 'to right',
                'order' => 3
            )
        );
    }

    ?>
    <p>Manage the "Who rents the ForceX™" section. Add, edit, or remove items and configure their content. Changes will be saved when you update the page.</p>
    
    <div id="rent-items-container">
        <div id="rent-items-list">
            <?php foreach ($rent_items as $index => $item): ?>
                <div class="rent-item" style="margin-bottom: 30px; padding: 20px; border: 1px solid #ddd; background: #f9f9f9; position: relative;">
                    <h3 style="margin-top: 0;">Item <?php echo $index + 1; ?></h3>
                    
                    <table class="form-table">
                        <tr>
                            <th style="width: 200px;"><label>Tab Label</label></th>
                            <td>
                                <input type="text" name="forcex_rent_items[<?php echo $index; ?>][tab_label]" value="<?php echo esc_attr($item['tab_label']); ?>" style="width: 100%;" placeholder="e.g., Patients" required />
                                <p class="description">The text that appears on the navigation button</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Slide Title</label></th>
                            <td>
                                <input type="text" name="forcex_rent_items[<?php echo $index; ?>][title]" value="<?php echo esc_attr($item['title']); ?>" style="width: 100%;" placeholder="e.g., Patients" required />
                                <p class="description">The main title displayed on the slide</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Benefits</label></th>
                            <td>
                                <div class="benefits-list" style="margin-bottom: 10px;">
                                    <?php if (!empty($item['benefits'])): ?>
                                        <?php foreach ($item['benefits'] as $benefit_index => $benefit): ?>
                                            <div class="benefit-item" style="margin-bottom: 8px; display: flex; gap: 8px; align-items: center;">
                                                <input type="text" name="forcex_rent_items[<?php echo $index; ?>][benefits][]" value="<?php echo esc_attr($benefit); ?>" style="flex: 1;" placeholder="e.g., Pain reduction" />
                                                <button type="button" class="button remove-benefit" style="color: #dc3232;">Remove</button>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <button type="button" class="button add-benefit" data-index="<?php echo $index; ?>">Add Benefit</button>
                                <p class="description">List of benefits that will appear with checkmark icons</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Description</label></th>
                            <td>
                                <textarea name="forcex_rent_items[<?php echo $index; ?>][description]" rows="4" style="width: 100%;" placeholder="Enter description text"><?php echo esc_textarea($item['description']); ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Background Image</label></th>
                            <td>
                                <div class="bg-image-preview" style="margin-bottom: 10px;">
                                    <?php 
                                    $bg_image_id = !empty($item['bg_image_id']) ? intval($item['bg_image_id']) : 0;
                                    if ($bg_image_id) {
                                        $bg_image_url = wp_get_attachment_image_url($bg_image_id, 'medium');
                                        if ($bg_image_url) {
                                            echo '<img src="' . esc_url($bg_image_url) . '" style="max-width: 300px; height: auto; border: 1px solid #ddd;" />';
                                        }
                                    }
                                    ?>
                                </div>
                                <input type="hidden" name="forcex_rent_items[<?php echo $index; ?>][bg_image_id]" class="bg-image-id" value="<?php echo esc_attr($bg_image_id); ?>" />
                                <button type="button" class="button select-bg-image" data-index="<?php echo $index; ?>">Select Image</button>
                                <button type="button" class="button remove-bg-image" data-index="<?php echo $index; ?>" style="<?php echo $bg_image_id ? '' : 'display: none;'; ?>">Remove Image</button>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Background Position</label></th>
                            <td>
                                <select name="forcex_rent_items[<?php echo $index; ?>][bg_position]" style="width: 200px;">
                                    <option value="center right" <?php selected($item['bg_position'], 'center right'); ?>>Center Right</option>
                                    <option value="center left" <?php selected($item['bg_position'], 'center left'); ?>>Center Left</option>
                                    <option value="center center" <?php selected($item['bg_position'], 'center center'); ?>>Center</option>
                                    <option value="top right" <?php selected($item['bg_position'], 'top right'); ?>>Top Right</option>
                                    <option value="top left" <?php selected($item['bg_position'], 'top left'); ?>>Top Left</option>
                                    <option value="bottom right" <?php selected($item['bg_position'], 'bottom right'); ?>>Bottom Right</option>
                                    <option value="bottom left" <?php selected($item['bg_position'], 'bottom left'); ?>>Bottom Left</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Gradient Direction</label></th>
                            <td>
                                <select name="forcex_rent_items[<?php echo $index; ?>][gradient_direction]" style="width: 200px;">
                                    <option value="to left" <?php selected($item['gradient_direction'], 'to left'); ?>>To Left</option>
                                    <option value="to right" <?php selected($item['gradient_direction'], 'to right'); ?>>To Right</option>
                                    <option value="to top" <?php selected($item['gradient_direction'], 'to top'); ?>>To Top</option>
                                    <option value="to bottom" <?php selected($item['gradient_direction'], 'to bottom'); ?>>To Bottom</option>
                                </select>
                                <p class="description">Direction of the blue gradient overlay</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Order</label></th>
                            <td>
                                <input type="number" name="forcex_rent_items[<?php echo $index; ?>][order]" value="<?php echo esc_attr($item['order']); ?>" min="0" style="width: 100px;" />
                                <p class="description">Display order (lower numbers appear first)</p>
                            </td>
                        </tr>
                        <tr>
                            <th></th>
                            <td>
                                <button type="button" class="button remove-rent-item" style="color: #dc3232;">Remove Item</button>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php endforeach; ?>
        </div>
        
        <button type="button" id="add-rent-item" class="button button-primary">Add New Item</button>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var rentItemIndex = <?php echo count($rent_items); ?>;
        
        // Add benefit
        $(document).on('click', '.add-benefit', function() {
            var index = $(this).data('index');
            var html = '<div class="benefit-item" style="margin-bottom: 8px; display: flex; gap: 8px; align-items: center;">';
            html += '<input type="text" name="forcex_rent_items[' + index + '][benefits][]" value="" style="flex: 1;" placeholder="e.g., Pain reduction" />';
            html += '<button type="button" class="button remove-benefit" style="color: #dc3232;">Remove</button>';
            html += '</div>';
            $(this).siblings('.benefits-list').append(html);
        });
        
        // Remove benefit
        $(document).on('click', '.remove-benefit', function() {
            $(this).closest('.benefit-item').remove();
        });
        
        // Add rent item
        $('#add-rent-item').on('click', function() {
            var html = '<div class="rent-item" style="margin-bottom: 30px; padding: 20px; border: 1px solid #ddd; background: #f9f9f9; position: relative;">';
            html += '<h3 style="margin-top: 0;">Item ' + (rentItemIndex + 1) + '</h3>';
            html += '<table class="form-table">';
            html += '<tr><th style="width: 200px;"><label>Tab Label</label></th>';
            html += '<td><input type="text" name="forcex_rent_items[' + rentItemIndex + '][tab_label]" value="" style="width: 100%;" placeholder="e.g., Patients" required /></td></tr>';
            html += '<tr><th><label>Slide Title</label></th>';
            html += '<td><input type="text" name="forcex_rent_items[' + rentItemIndex + '][title]" value="" style="width: 100%;" placeholder="e.g., Patients" required /></td></tr>';
            html += '<tr><th><label>Benefits</label></th>';
            html += '<td><div class="benefits-list" style="margin-bottom: 10px;"></div>';
            html += '<button type="button" class="button add-benefit" data-index="' + rentItemIndex + '">Add Benefit</button></td></tr>';
            html += '<tr><th><label>Description</label></th>';
            html += '<td><textarea name="forcex_rent_items[' + rentItemIndex + '][description]" rows="4" style="width: 100%;"></textarea></td></tr>';
            html += '<tr><th><label>Background Image</label></th>';
            html += '<td><div class="bg-image-preview" style="margin-bottom: 10px;"></div>';
            html += '<input type="hidden" name="forcex_rent_items[' + rentItemIndex + '][bg_image_id]" class="bg-image-id" value="0" />';
            html += '<button type="button" class="button select-bg-image" data-index="' + rentItemIndex + '">Select Image</button>';
            html += '<button type="button" class="button remove-bg-image" data-index="' + rentItemIndex + '" style="display: none;">Remove Image</button></td></tr>';
            html += '<tr><th><label>Background Position</label></th>';
            html += '<td><select name="forcex_rent_items[' + rentItemIndex + '][bg_position]" style="width: 200px;">';
            html += '<option value="center right">Center Right</option>';
            html += '<option value="center left">Center Left</option>';
            html += '<option value="center center">Center</option>';
            html += '<option value="top right">Top Right</option>';
            html += '<option value="top left">Top Left</option>';
            html += '<option value="bottom right">Bottom Right</option>';
            html += '<option value="bottom left">Bottom Left</option>';
            html += '</select></td></tr>';
            html += '<tr><th><label>Gradient Direction</label></th>';
            html += '<td><select name="forcex_rent_items[' + rentItemIndex + '][gradient_direction]" style="width: 200px;">';
            html += '<option value="to left">To Left</option>';
            html += '<option value="to right">To Right</option>';
            html += '<option value="to top">To Top</option>';
            html += '<option value="to bottom">To Bottom</option>';
            html += '</select></td></tr>';
            html += '<tr><th><label>Order</label></th>';
            html += '<td><input type="number" name="forcex_rent_items[' + rentItemIndex + '][order]" value="' + rentItemIndex + '" min="0" style="width: 100px;" /></td></tr>';
            html += '<tr><th></th><td><button type="button" class="button remove-rent-item" style="color: #dc3232;">Remove Item</button></td></tr>';
            html += '</table></div>';
            
            $('#rent-items-list').append(html);
            rentItemIndex++;
        });
        
        // Remove rent item
        $(document).on('click', '.remove-rent-item', function() {
            if (confirm('Are you sure you want to remove this item?')) {
                $(this).closest('.rent-item').remove();
            }
        });
        
        // Media uploader for background images
        var mediaFrame;
        var currentButton = null;
        
        $(document).on('click', '.select-bg-image', function(e) {
            e.preventDefault();
            var button = $(this);
            var index = button.data('index');
            currentButton = button; // Store the current button reference
            
            // If mediaFrame exists, remove old event listeners and update
            if (mediaFrame) {
                mediaFrame.off('select'); // Remove old event listeners
            } else {
                // Create new media frame
                mediaFrame = wp.media({
                    title: 'Select Background Image',
                    button: {
                        text: 'Use this image'
                    },
                    multiple: false
                });
            }
            
            // Add event listener for this specific button
            mediaFrame.on('select', function() {
                if (!currentButton) return;
                
                var attachment = mediaFrame.state().get('selection').first().toJSON();
                var rentItem = currentButton.closest('.rent-item');
                var preview = rentItem.find('.bg-image-preview');
                var imageIdInput = rentItem.find('.bg-image-id');
                var removeBtn = rentItem.find('.remove-bg-image');
                
                preview.html('<img src="' + attachment.url + '" style="max-width: 300px; height: auto; border: 1px solid #ddd;" />');
                imageIdInput.val(attachment.id);
                removeBtn.show();
                
                currentButton = null; // Reset after use
            });
            
            mediaFrame.open();
        });
        
        // Remove background image
        $(document).on('click', '.remove-bg-image', function() {
            var button = $(this);
            var index = button.data('index');
            var preview = button.siblings('.bg-image-preview');
            var imageIdInput = button.siblings('.bg-image-id');
            
            preview.html('');
            imageIdInput.val(0);
            button.hide();
        });
    });
    </script>
    <?php
}

// Save Who Rents meta data
function forcex_save_who_rents_meta($post_id) {
    // Check nonce
    if (!isset($_POST['forcex_who_rents_meta_box_nonce']) || !wp_verify_nonce($_POST['forcex_who_rents_meta_box_nonce'], 'forcex_who_rents_meta_box')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Check if this page uses the Rent ForceX template
    $template = get_page_template_slug($post_id);
    if ($template !== 'page-rent-forcex.php') {
        return;
    }
    
    // Save rent items
    $rent_items = array();
    if (isset($_POST['forcex_rent_items']) && is_array($_POST['forcex_rent_items'])) {
        foreach ($_POST['forcex_rent_items'] as $index => $item) {
            if (!empty($item['tab_label']) && !empty($item['title'])) {
                // Get benefits array
                $benefits = array();
                if (!empty($item['benefits']) && is_array($item['benefits'])) {
                    foreach ($item['benefits'] as $benefit) {
                        if (!empty(trim($benefit))) {
                            $benefits[] = sanitize_text_field($benefit);
                        }
                    }
                }
                
                $rent_items[] = array(
                    'tab_label' => sanitize_text_field($item['tab_label']),
                    'title' => sanitize_text_field($item['title']),
                    'benefits' => $benefits,
                    'description' => sanitize_textarea_field($item['description']),
                    'bg_image_id' => !empty($item['bg_image_id']) ? intval($item['bg_image_id']) : 0,
                    'bg_position' => !empty($item['bg_position']) ? sanitize_text_field($item['bg_position']) : 'center right',
                    'gradient_direction' => !empty($item['gradient_direction']) ? sanitize_text_field($item['gradient_direction']) : 'to left',
                    'order' => !empty($item['order']) ? intval($item['order']) : $index
                );
            }
        }
    }
    
    // Sort by order
    usort($rent_items, function($a, $b) {
        return $a['order'] - $b['order'];
    });
    
    update_post_meta($post_id, '_forcex_who_rents_items', $rent_items);
}
add_action('save_post', 'forcex_save_who_rents_meta');

// Helper function to get Who Rents items
function forcex_get_who_rents_items($post_id = null) {
    if ($post_id === null) {
        global $post;
        $post_id = $post ? $post->ID : 0;
    }
    
    if (!$post_id) {
        return array();
    }
    
    $items = get_post_meta($post_id, '_forcex_who_rents_items', true);
    
    if (!is_array($items)) {
        return array();
    }
    
    // Sort by order
    usort($items, function($a, $b) {
        $order_a = isset($a['order']) ? intval($a['order']) : 999;
        $order_b = isset($b['order']) ? intval($b['order']) : 999;
        return $order_a - $order_b;
    });
    
    return $items;
}

// ============================================
// Who We Serve Section Admin Settings (Nordic Health Systems)
// ============================================

// Add meta box for Who We Serve section (only on Nordic Health Systems template pages)
function forcex_add_who_we_serve_meta_box() {
    global $post;
    if (!$post) return;
    
    $template = get_page_template_slug($post->ID);
    if ($template !== 'page-nordic-health-systems.php') {
        return; // Don't show meta box for other templates
    }
    
    add_meta_box(
        'forcex_who_we_serve',
        'Who We Serve Section',
        'forcex_who_we_serve_meta_box_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'forcex_add_who_we_serve_meta_box');

// Meta box callback
function forcex_who_we_serve_meta_box_callback($post) {
    // Check if this page uses the Nordic Health Systems template
    $template = get_page_template_slug($post->ID);
    if ($template !== 'page-nordic-health-systems.php') {
        echo '<p><strong>Note:</strong> This meta box is only active for pages using the "Nordic Health Systems" template. To use it, go to Page Attributes and select "Nordic Health Systems" as the template.</p>';
        return;
    }
    
    wp_nonce_field('forcex_who_we_serve_meta_box', 'forcex_who_we_serve_meta_box_nonce');
    wp_enqueue_media();
    
    // Get saved items
    $who_serve_items = get_post_meta($post->ID, '_forcex_who_we_serve_items', true);
    if (!is_array($who_serve_items)) {
        $who_serve_items = array();
    }
    
    // Default items if empty
    if (empty($who_serve_items)) {
        $who_serve_items = array(
            array(
                'tab_label' => 'Patients',
                'title' => 'Patients',
                'description' => 'Speeds up healing, reduces pain and swelling, and improves mobility at home.',
                'bg_image_id' => 0,
                'bg_position' => 'center right',
                'gradient_direction' => 'to left',
                'order' => 0
            ),
            array(
                'tab_label' => 'Medical professionals',
                'title' => 'Medical professionals',
                'description' => 'Provides precise, reliable therapy to enhance patient outcomes and streamline recovery protocols.',
                'bg_image_id' => 0,
                'bg_position' => 'center left',
                'gradient_direction' => 'to right',
                'order' => 1
            ),
            array(
                'tab_label' => 'Athletes & Fitness enthusiasts',
                'title' => 'Athletes & Fitness enthusiasts',
                'description' => 'Offers a versatile, clinically proven tool that supports efficient treatment and better patient results.',
                'bg_image_id' => 0,
                'bg_position' => 'center right',
                'gradient_direction' => 'to left',
                'order' => 2
            ),
            array(
                'tab_label' => 'Clinics & Rehabilitation centers',
                'title' => 'Clinics & Rehabilitation centers',
                'description' => 'Accelerates muscle recovery, reduces inflammation, and helps maintain peak performance.',
                'bg_image_id' => 0,
                'bg_position' => 'center left',
                'gradient_direction' => 'to right',
                'order' => 3
            )
        );
    }

    ?>
    <p>Manage the "Who we serve" section. Add, edit, or remove items and configure their content. Changes will be saved when you update the page.</p>
    
    <div id="who-serve-items-container">
        <div id="who-serve-items-list">
            <?php foreach ($who_serve_items as $index => $item): ?>
                <div class="who-serve-item" style="margin-bottom: 30px; padding: 20px; border: 1px solid #ddd; background: #f9f9f9; position: relative;">
                    <h3 style="margin-top: 0;">Item <?php echo $index + 1; ?></h3>
                    
                    <table class="form-table">
                        <tr>
                            <th style="width: 200px;"><label>Tab Label</label></th>
                            <td>
                                <input type="text" name="forcex_who_serve_items[<?php echo $index; ?>][tab_label]" value="<?php echo esc_attr($item['tab_label']); ?>" style="width: 100%;" placeholder="e.g., Patients" required />
                                <p class="description">The text that appears on the navigation button</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Slide Title</label></th>
                            <td>
                                <input type="text" name="forcex_who_serve_items[<?php echo $index; ?>][title]" value="<?php echo esc_attr($item['title']); ?>" style="width: 100%;" placeholder="e.g., Patients" required />
                                <p class="description">The main title displayed on the slide</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Description</label></th>
                            <td>
                                <textarea name="forcex_who_serve_items[<?php echo $index; ?>][description]" rows="4" style="width: 100%;" placeholder="Enter description text"><?php echo esc_textarea($item['description']); ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Background Image</label></th>
                            <td>
                                <div class="bg-image-preview" style="margin-bottom: 10px;">
                                    <?php 
                                    $bg_image_id = !empty($item['bg_image_id']) ? intval($item['bg_image_id']) : 0;
                                    if ($bg_image_id) {
                                        $bg_image_url = wp_get_attachment_image_url($bg_image_id, 'medium');
                                        if ($bg_image_url) {
                                            echo '<img src="' . esc_url($bg_image_url) . '" style="max-width: 300px; height: auto; border: 1px solid #ddd;" />';
                                        }
                                    }
                                    ?>
                                </div>
                                <input type="hidden" name="forcex_who_serve_items[<?php echo $index; ?>][bg_image_id]" class="bg-image-id" value="<?php echo esc_attr($bg_image_id); ?>" />
                                <button type="button" class="button select-bg-image" data-index="<?php echo $index; ?>">Select Image</button>
                                <button type="button" class="button remove-bg-image" data-index="<?php echo $index; ?>" style="<?php echo $bg_image_id ? '' : 'display: none;'; ?>">Remove Image</button>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Background Position</label></th>
                            <td>
                                <select name="forcex_who_serve_items[<?php echo $index; ?>][bg_position]" style="width: 200px;">
                                    <option value="center right" <?php selected($item['bg_position'], 'center right'); ?>>Center Right</option>
                                    <option value="center left" <?php selected($item['bg_position'], 'center left'); ?>>Center Left</option>
                                    <option value="center center" <?php selected($item['bg_position'], 'center center'); ?>>Center</option>
                                    <option value="top right" <?php selected($item['bg_position'], 'top right'); ?>>Top Right</option>
                                    <option value="top left" <?php selected($item['bg_position'], 'top left'); ?>>Top Left</option>
                                    <option value="bottom right" <?php selected($item['bg_position'], 'bottom right'); ?>>Bottom Right</option>
                                    <option value="bottom left" <?php selected($item['bg_position'], 'bottom left'); ?>>Bottom Left</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Gradient Direction</label></th>
                            <td>
                                <select name="forcex_who_serve_items[<?php echo $index; ?>][gradient_direction]" style="width: 200px;">
                                    <option value="to left" <?php selected($item['gradient_direction'], 'to left'); ?>>To Left</option>
                                    <option value="to right" <?php selected($item['gradient_direction'], 'to right'); ?>>To Right</option>
                                    <option value="to top" <?php selected($item['gradient_direction'], 'to top'); ?>>To Top</option>
                                    <option value="to bottom" <?php selected($item['gradient_direction'], 'to bottom'); ?>>To Bottom</option>
                                </select>
                                <p class="description">Direction of the blue gradient overlay</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Order</label></th>
                            <td>
                                <input type="number" name="forcex_who_serve_items[<?php echo $index; ?>][order]" value="<?php echo esc_attr($item['order']); ?>" min="0" style="width: 100px;" />
                                <p class="description">Display order (lower numbers appear first)</p>
                            </td>
                        </tr>
                        <tr>
                            <th></th>
                            <td>
                                <button type="button" class="button remove-who-serve-item" style="color: #dc3232;">Remove Item</button>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php endforeach; ?>
        </div>
        
        <button type="button" id="add-who-serve-item" class="button button-primary">Add New Item</button>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var whoServeItemIndex = <?php echo count($who_serve_items); ?>;
        
        // Add who serve item
        $('#add-who-serve-item').on('click', function() {
            var html = '<div class="who-serve-item" style="margin-bottom: 30px; padding: 20px; border: 1px solid #ddd; background: #f9f9f9; position: relative;">';
            html += '<h3 style="margin-top: 0;">Item ' + (whoServeItemIndex + 1) + '</h3>';
            html += '<table class="form-table">';
            html += '<tr><th style="width: 200px;"><label>Tab Label</label></th>';
            html += '<td><input type="text" name="forcex_who_serve_items[' + whoServeItemIndex + '][tab_label]" value="" style="width: 100%;" placeholder="e.g., Patients" required /></td></tr>';
            html += '<tr><th><label>Slide Title</label></th>';
            html += '<td><input type="text" name="forcex_who_serve_items[' + whoServeItemIndex + '][title]" value="" style="width: 100%;" placeholder="e.g., Patients" required /></td></tr>';
            html += '<tr><th><label>Description</label></th>';
            html += '<td><textarea name="forcex_who_serve_items[' + whoServeItemIndex + '][description]" rows="4" style="width: 100%;" placeholder="Enter description text"></textarea></td></tr>';
            html += '<tr><th><label>Background Image</label></th>';
            html += '<td><div class="bg-image-preview" style="margin-bottom: 10px;"></div>';
            html += '<input type="hidden" name="forcex_who_serve_items[' + whoServeItemIndex + '][bg_image_id]" class="bg-image-id" value="0" />';
            html += '<button type="button" class="button select-bg-image" data-index="' + whoServeItemIndex + '">Select Image</button>';
            html += '<button type="button" class="button remove-bg-image" data-index="' + whoServeItemIndex + '" style="display: none;">Remove Image</button></td></tr>';
            html += '<tr><th><label>Background Position</label></th>';
            html += '<td><select name="forcex_who_serve_items[' + whoServeItemIndex + '][bg_position]" style="width: 200px;">';
            html += '<option value="center right">Center Right</option>';
            html += '<option value="center left">Center Left</option>';
            html += '<option value="center center">Center</option>';
            html += '<option value="top right">Top Right</option>';
            html += '<option value="top left">Top Left</option>';
            html += '<option value="bottom right">Bottom Right</option>';
            html += '<option value="bottom left">Bottom Left</option>';
            html += '</select></td></tr>';
            html += '<tr><th><label>Gradient Direction</label></th>';
            html += '<td><select name="forcex_who_serve_items[' + whoServeItemIndex + '][gradient_direction]" style="width: 200px;">';
            html += '<option value="to left">To Left</option>';
            html += '<option value="to right">To Right</option>';
            html += '<option value="to top">To Top</option>';
            html += '<option value="to bottom">To Bottom</option>';
            html += '</select></td></tr>';
            html += '<tr><th><label>Order</label></th>';
            html += '<td><input type="number" name="forcex_who_serve_items[' + whoServeItemIndex + '][order]" value="' + whoServeItemIndex + '" min="0" style="width: 100px;" /></td></tr>';
            html += '<tr><th></th><td><button type="button" class="button remove-who-serve-item" style="color: #dc3232;">Remove Item</button></td></tr>';
            html += '</table></div>';
            $('#who-serve-items-list').append(html);
            whoServeItemIndex++;
        });
        
        // Remove who serve item
        $(document).on('click', '.remove-who-serve-item', function() {
            if (confirm('Are you sure you want to remove this item?')) {
                $(this).closest('.who-serve-item').remove();
            }
        });
        
        // Select background image
        $(document).on('click', '.select-bg-image', function() {
            var button = $(this);
            var index = button.data('index');
            var imageIdInput = button.siblings('.bg-image-id');
            var preview = button.siblings('.bg-image-preview');
            var removeBtn = button.siblings('.remove-bg-image');
            
            var frame = wp.media({
                title: 'Select Background Image',
                button: { text: 'Use this image' },
                multiple: false
            });
            
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                imageIdInput.val(attachment.id);
                preview.html('<img src="' + attachment.url + '" style="max-width: 300px; height: auto; border: 1px solid #ddd;" />');
                removeBtn.show();
            });
            
            frame.open();
        });
        
        // Remove background image
        $(document).on('click', '.remove-bg-image', function() {
            var button = $(this);
            var index = button.data('index');
            var imageIdInput = button.siblings('.bg-image-id');
            var preview = button.siblings('.bg-image-preview');
            
            imageIdInput.val(0);
            preview.html('');
            button.hide();
        });
    });
    </script>
    <?php
}

// Save Who We Serve meta data
function forcex_save_who_we_serve_meta($post_id) {
    // Check nonce
    if (!isset($_POST['forcex_who_we_serve_meta_box_nonce']) || !wp_verify_nonce($_POST['forcex_who_we_serve_meta_box_nonce'], 'forcex_who_we_serve_meta_box')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Check if this page uses the Nordic Health Systems template
    $template = get_page_template_slug($post_id);
    if ($template !== 'page-nordic-health-systems.php') {
        return;
    }
    
    // Save who serve items
    $who_serve_items = array();
    if (isset($_POST['forcex_who_serve_items']) && is_array($_POST['forcex_who_serve_items'])) {
        foreach ($_POST['forcex_who_serve_items'] as $index => $item) {
            if (!empty($item['tab_label']) && !empty($item['title'])) {
                $who_serve_items[] = array(
                    'tab_label' => sanitize_text_field($item['tab_label']),
                    'title' => sanitize_text_field($item['title']),
                    'description' => sanitize_textarea_field($item['description']),
                    'bg_image_id' => !empty($item['bg_image_id']) ? intval($item['bg_image_id']) : 0,
                    'bg_position' => !empty($item['bg_position']) ? sanitize_text_field($item['bg_position']) : 'center right',
                    'gradient_direction' => !empty($item['gradient_direction']) ? sanitize_text_field($item['gradient_direction']) : 'to left',
                    'order' => !empty($item['order']) ? intval($item['order']) : $index
                );
            }
        }
    }
    
    // Sort by order
    usort($who_serve_items, function($a, $b) {
        return $a['order'] - $b['order'];
    });
    
    update_post_meta($post_id, '_forcex_who_we_serve_items', $who_serve_items);
}
add_action('save_post', 'forcex_save_who_we_serve_meta');

// Helper function to get Who We Serve items
function forcex_get_who_we_serve_items($post_id = null) {
    if ($post_id === null) {
        global $post;
        $post_id = $post ? $post->ID : 0;
    }
    
    if (!$post_id) {
        return array();
    }
    
    $items = get_post_meta($post_id, '_forcex_who_we_serve_items', true);
    
    if (!is_array($items)) {
        return array();
    }
    
    // Sort by order
    usort($items, function($a, $b) {
        $order_a = isset($a['order']) ? intval($a['order']) : 999;
        $order_b = isset($b['order']) ? intval($b['order']) : 999;
        return $order_a - $order_b;
    });
    
    return $items;
}

// ============================================
// Key Products Section Admin Settings (Nordic Health Systems)
// ============================================

// Add meta box for Key Products section (only on Nordic Health Systems template pages)
function forcex_add_key_products_meta_box() {
    global $post;
    if (!$post) return;
    
    $template = get_page_template_slug($post->ID);
    if ($template !== 'page-nordic-health-systems.php') {
        return;
    }
    
    add_meta_box(
        'forcex_key_products',
        'Key Products Section',
        'forcex_key_products_meta_box_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'forcex_add_key_products_meta_box');

// Meta box callback
function forcex_key_products_meta_box_callback($post) {
    $template = get_page_template_slug($post->ID);
    if ($template !== 'page-nordic-health-systems.php') {
        echo '<p><strong>Note:</strong> This meta box is only active for pages using the "Nordic Health Systems" template.</p>';
        return;
    }
    
    wp_nonce_field('forcex_key_products_meta_box', 'forcex_key_products_meta_box_nonce');
    
    // Get saved product IDs
    $product_ids = get_post_meta($post->ID, '_forcex_key_products', true);
    if (!is_array($product_ids)) {
        $product_ids = array();
    }
    
    ?>
    <p>Select products to display in the "Key products" slider. You can select multiple products.</p>
    
    <div style="margin-bottom: 20px;">
        <label for="key_products_search" style="display: block; margin-bottom: 10px; font-weight: bold;">Search Products:</label>
        <input type="text" id="key_products_search" placeholder="Type to search products..." style="width: 100%; padding: 8px;" />
    </div>
    
    <div id="key-products-list" style="max-height: 400px; overflow-y: auto; border: 1px solid #ddd; padding: 10px;">
        <?php
        $all_products = wc_get_products(array('limit' => -1, 'status' => 'publish'));
        foreach ($all_products as $product):
            $checked = in_array($product->get_id(), $product_ids) ? 'checked' : '';
        ?>
            <label style="display: block; padding: 8px; border-bottom: 1px solid #eee;">
                <input type="checkbox" name="forcex_key_products[]" value="<?php echo esc_attr($product->get_id()); ?>" <?php echo $checked; ?> />
                <?php echo esc_html($product->get_name()); ?> (<?php echo $product->get_price_html(); ?>)
            </label>
        <?php endforeach; ?>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        $('#key_products_search').on('keyup', function() {
            var search = $(this).val().toLowerCase();
            $('#key-products-list label').each(function() {
                var text = $(this).text().toLowerCase();
                if (text.indexOf(search) !== -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
    </script>
    <?php
}

// Save Key Products meta data
function forcex_save_key_products_meta($post_id) {
    if (!isset($_POST['forcex_key_products_meta_box_nonce']) || !wp_verify_nonce($_POST['forcex_key_products_meta_box_nonce'], 'forcex_key_products_meta_box')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    $template = get_page_template_slug($post_id);
    if ($template !== 'page-nordic-health-systems.php') {
        return;
    }
    
    // Save product IDs
    $product_ids = array();
    if (isset($_POST['forcex_key_products']) && is_array($_POST['forcex_key_products'])) {
        foreach ($_POST['forcex_key_products'] as $product_id) {
            $product_ids[] = intval($product_id);
        }
    }
    
    update_post_meta($post_id, '_forcex_key_products', $product_ids);
}
add_action('save_post', 'forcex_save_key_products_meta');

// Helper function to get Key Products
function forcex_get_key_products($post_id = null) {
    if ($post_id === null) {
        global $post;
        $post_id = $post ? $post->ID : 0;
    }
    
    if (!$post_id) {
        return array();
    }
    
    $product_ids = get_post_meta($post_id, '_forcex_key_products', true);
    
    if (!is_array($product_ids)) {
        return array();
    }
    
    return $product_ids;
}

// ============================================
// FAQ Section Admin Settings
// ============================================

// Add meta box for FAQ section (only on Rent ForceX template pages)
function forcex_add_faq_meta_box() {
    global $post;
    if (!$post) return;
    
    $template = get_page_template_slug($post->ID);
    if ($template !== 'page-rent-forcex.php') {
        return; // Don't show meta box for other templates
    }
    
    add_meta_box(
        'forcex_faq',
        'Frequently Asked Questions Section',
        'forcex_faq_meta_box_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'forcex_add_faq_meta_box');

// Meta box callback
function forcex_faq_meta_box_callback($post) {
    // Check if this page uses the Rent ForceX template
    $template = get_page_template_slug($post->ID);
    if ($template !== 'page-rent-forcex.php') {
        echo '<p><strong>Note:</strong> This meta box is only active for pages using the "Rent ForceX" template. To use it, go to Page Attributes and select "Rent ForceX" as the template.</p>';
        return;
    }
    
    wp_nonce_field('forcex_faq_meta_box', 'forcex_faq_meta_box_nonce');
    
    // Get saved items
    $faq_items = get_post_meta($post->ID, '_forcex_faq_items', true);
    if (!is_array($faq_items)) {
        $faq_items = array();
    }
    
    // Default items if empty
    if (empty($faq_items)) {
        $faq_items = array(
            array(
                'question' => 'How long can I rent the ForceX™?',
                'answer' => 'Rental periods vary based on your needs. Please contact us for specific rental duration options.',
                'order' => 0
            ),
            array(
                'question' => 'Do I need a prescription to rent the ForceX™?',
                'answer' => 'A prescription may be required depending on your location and insurance coverage. Please check with your healthcare provider.',
                'order' => 1
            ),
            array(
                'question' => 'Can I use the ForceX™ at home?',
                'answer' => 'Yes, the ForceX™ is designed for home use. Advanced Cryothermic Modulation alternates between heat and cold therapy, precisely cycling temperatures for optimal healing.',
                'order' => 2
            ),
            array(
                'question' => 'Can I purchase the ForceX™ after renting it?',
                'answer' => 'Yes, rental-to-own options may be available. Please contact our sales team for more information.',
                'order' => 3
            ),
            array(
                'question' => 'What happens if I have technical issues with the ForceX™ during the rental period?',
                'answer' => 'We provide full technical support during your rental period. Contact our support team for assistance with any issues.',
                'order' => 4
            )
        );
    }
    
    ?>
    <p>Manage the "Frequently asked questions" section. Add, edit, or remove FAQ items. Changes will be saved when you update the page.</p>
    
    <div id="faq-items-container">
        <div id="faq-items-list">
            <?php foreach ($faq_items as $index => $item): ?>
                <div class="faq-item" style="margin-bottom: 30px; padding: 20px; border: 1px solid #ddd; background: #f9f9f9; position: relative;">
                    <h3 style="margin-top: 0;">FAQ Item <?php echo $index + 1; ?></h3>
                    <button type="button" class="button remove-faq-item" style="position: absolute; top: 20px; right: 20px; background: #dc3232; color: white; border: none; padding: 5px 10px; cursor: pointer;">Remove</button>
                    
                    <table class="form-table">
                        <tr>
                            <th style="width: 200px;"><label>Question</label></th>
                            <td>
                                <input type="text" name="forcex_faq_items[<?php echo $index; ?>][question]" value="<?php echo esc_attr($item['question']); ?>" style="width: 100%;" placeholder="e.g., How long can I rent the ForceX™?" required />
                                <p class="description">The question text displayed in the FAQ item</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Answer</label></th>
                            <td>
                                <textarea name="forcex_faq_items[<?php echo $index; ?>][answer]" rows="4" style="width: 100%;" placeholder="Enter the answer text..." required><?php echo esc_textarea($item['answer']); ?></textarea>
                                <p class="description">The answer text displayed when the FAQ item is expanded</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Order</label></th>
                            <td>
                                <input type="number" name="forcex_faq_items[<?php echo $index; ?>][order]" value="<?php echo esc_attr($item['order']); ?>" style="width: 100px;" min="0" />
                                <p class="description">Display order (lower numbers appear first)</p>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php endforeach; ?>
        </div>
        
        <p>
            <button type="button" id="add-faq-item" class="button button-primary">Add New FAQ Item</button>
        </p>
    </div>
    
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        var faqItemIndex = <?php echo count($faq_items); ?>;
        
        // Add new FAQ item
        $('#add-faq-item').on('click', function() {
            var newItem = $('<div class="faq-item" style="margin-bottom: 30px; padding: 20px; border: 1px solid #ddd; background: #f9f9f9; position: relative;">' +
                '<h3 style="margin-top: 0;">FAQ Item ' + (faqItemIndex + 1) + '</h3>' +
                '<button type="button" class="button remove-faq-item" style="position: absolute; top: 20px; right: 20px; background: #dc3232; color: white; border: none; padding: 5px 10px; cursor: pointer;">Remove</button>' +
                '<table class="form-table">' +
                    '<tr>' +
                        '<th style="width: 200px;"><label>Question</label></th>' +
                        '<td>' +
                            '<input type="text" name="forcex_faq_items[' + faqItemIndex + '][question]" value="" style="width: 100%;" placeholder="e.g., How long can I rent the ForceX™?" required />' +
                            '<p class="description">The question text displayed in the FAQ item</p>' +
                        '</td>' +
                    '</tr>' +
                    '<tr>' +
                        '<th><label>Answer</label></th>' +
                        '<td>' +
                            '<textarea name="forcex_faq_items[' + faqItemIndex + '][answer]" rows="4" style="width: 100%;" placeholder="Enter the answer text..." required></textarea>' +
                            '<p class="description">The answer text displayed when the FAQ item is expanded</p>' +
                        '</td>' +
                    '</tr>' +
                    '<tr>' +
                        '<th><label>Order</label></th>' +
                        '<td>' +
                            '<input type="number" name="forcex_faq_items[' + faqItemIndex + '][order]" value="' + faqItemIndex + '" style="width: 100px;" min="0" />' +
                            '<p class="description">Display order (lower numbers appear first)</p>' +
                        '</td>' +
                    '</tr>' +
                '</table>' +
            '</div>');
            
            $('#faq-items-list').append(newItem);
            faqItemIndex++;
        });
        
        // Remove FAQ item
        $(document).on('click', '.remove-faq-item', function() {
            if (confirm('Are you sure you want to remove this FAQ item?')) {
                $(this).closest('.faq-item').remove();
            }
        });
    });
    </script>
    <?php
}

// Save FAQ meta data
function forcex_save_faq_meta($post_id) {
    // Check nonce
    if (!isset($_POST['forcex_faq_meta_box_nonce']) || !wp_verify_nonce($_POST['forcex_faq_meta_box_nonce'], 'forcex_faq_meta_box')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Check if this page uses the Rent ForceX template
    $template = get_page_template_slug($post_id);
    if ($template !== 'page-rent-forcex.php') {
        return;
    }
    
    // Save FAQ items
    $faq_items = array();
    if (isset($_POST['forcex_faq_items']) && is_array($_POST['forcex_faq_items'])) {
        foreach ($_POST['forcex_faq_items'] as $index => $item) {
            if (!empty($item['question']) && !empty($item['answer'])) {
                $faq_items[] = array(
                    'question' => sanitize_text_field($item['question']),
                    'answer' => wp_kses_post($item['answer']),
                    'order' => !empty($item['order']) ? intval($item['order']) : $index
                );
            }
        }
    }
    
    // Sort by order
    usort($faq_items, function($a, $b) {
        return $a['order'] - $b['order'];
    });
    
    update_post_meta($post_id, '_forcex_faq_items', $faq_items);
}
add_action('save_post', 'forcex_save_faq_meta');

// Helper function to get FAQ items
function forcex_get_faq_items($post_id = null) {
    if ($post_id === null) {
        global $post;
        $post_id = $post ? $post->ID : 0;
    }
    
    if (!$post_id) {
        return array();
    }
    
    $items = get_post_meta($post_id, '_forcex_faq_items', true);
    
    if (!is_array($items)) {
        return array();
    }
    
    // Sort by order
    usort($items, function($a, $b) {
        $order_a = isset($a['order']) ? intval($a['order']) : 999;
        $order_b = isset($b['order']) ? intval($b['order']) : 999;
        return $order_a - $order_b;
    });
    
    return $items;
}

// ============================================
// Clinically Proven Benefits Section Admin Settings
// ============================================

// Add meta box for Clinically Proven Benefits section (only on Clinical Resources template pages)
function forcex_add_clinical_benefits_meta_box() {
    global $post;
    if (!$post) return;
    
    $template = get_page_template_slug($post->ID);
    if ($template !== 'page-clinical-resources.php') {
        return; // Don't show meta box for other templates
    }
    
    add_meta_box(
        'forcex_clinical_benefits',
        'Clinically Proven Benefits Section',
        'forcex_clinical_benefits_meta_box_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'forcex_add_clinical_benefits_meta_box');

// Meta box callback
function forcex_clinical_benefits_meta_box_callback($post) {
    // Check if this page uses the Clinical Resources template
    $template = get_page_template_slug($post->ID);
    if ($template !== 'page-clinical-resources.php') {
        echo '<p><strong>Note:</strong> This meta box is only active for pages using the "Clinical Resources" template. To use it, go to Page Attributes and select "Clinical Resources" as the template.</p>';
        return;
    }
    
    wp_nonce_field('forcex_clinical_benefits_meta_box', 'forcex_clinical_benefits_meta_box_nonce');
    wp_enqueue_media();
    
    // Get saved items
    $benefits_items = get_post_meta($post->ID, '_forcex_clinical_benefits_items', true);
    if (!is_array($benefits_items)) {
        $benefits_items = array();
    }
    
    // Default items if empty
    if (empty($benefits_items)) {
        $benefits_items = array(
            array(
                'tab_label' => 'Orthopedic recovery',
                'title' => 'Orthopedic recovery',
                'benefits' => array('Pain reduction', 'Circulation improving'),
                'description' => 'ForceX™ accelerates recovery from orthopedic surgeries by reducing swelling, pain, and improving circulation with precise temperature and compression therapy.',
                'bg_image_id' => 0,
                'bg_position' => 'center right',
                'gradient_direction' => 'to left',
                'order' => 0
            ),
            array(
                'tab_label' => 'Injury rehabilitation',
                'title' => 'Injury rehabilitation',
                'benefits' => array('Healing acceleration'),
                'description' => 'Ideal for injury rehabilitation, dynamic compression to recover faster from sports injuries, sprains, and strains.',
                'bg_image_id' => 0,
                'bg_position' => 'center left',
                'gradient_direction' => 'to right',
                'order' => 1
            ),
            array(
                'tab_label' => 'Sports medicine',
                'title' => 'Sports medicine',
                'benefits' => array('Performance recovery', 'Injury prevention'),
                'description' => 'Professional athletes and sports medicine practitioners use ForceX™ for rapid recovery and optimal performance maintenance.',
                'bg_image_id' => 0,
                'bg_position' => 'center right',
                'gradient_direction' => 'to left',
                'order' => 2
            )
        );
    }

    ?>
    <p>Manage the "Clinically proven benefits" section. Add, edit, or remove items and configure their content. Changes will be saved when you update the page.</p>
    
    <div id="clinical-benefits-items-container">
        <div id="clinical-benefits-items-list">
            <?php foreach ($benefits_items as $index => $item): ?>
                <div class="clinical-benefits-item" style="margin-bottom: 30px; padding: 20px; border: 1px solid #ddd; background: #f9f9f9; position: relative;">
                    <h3 style="margin-top: 0;">Item <?php echo $index + 1; ?></h3>
                    
                    <table class="form-table">
                        <tr>
                            <th style="width: 200px;"><label>Tab Label</label></th>
                            <td>
                                <input type="text" name="forcex_clinical_benefits_items[<?php echo $index; ?>][tab_label]" value="<?php echo esc_attr($item['tab_label']); ?>" style="width: 100%;" placeholder="e.g., Orthopedic recovery" required />
                                <p class="description">The text that appears on the navigation button</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Slide Title</label></th>
                            <td>
                                <input type="text" name="forcex_clinical_benefits_items[<?php echo $index; ?>][title]" value="<?php echo esc_attr($item['title']); ?>" style="width: 100%;" placeholder="e.g., Orthopedic recovery" required />
                                <p class="description">The main title displayed on the slide</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Benefits</label></th>
                            <td>
                                <div class="benefits-list" style="margin-bottom: 10px;">
                                    <?php if (!empty($item['benefits'])): ?>
                                        <?php foreach ($item['benefits'] as $benefit_index => $benefit): ?>
                                            <div class="benefit-item" style="margin-bottom: 8px; display: flex; gap: 8px; align-items: center;">
                                                <input type="text" name="forcex_clinical_benefits_items[<?php echo $index; ?>][benefits][]" value="<?php echo esc_attr($benefit); ?>" style="flex: 1;" placeholder="e.g., Pain reduction" />
                                                <button type="button" class="button remove-benefit" style="color: #dc3232;">Remove</button>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <button type="button" class="button add-benefit-clinical" data-index="<?php echo $index; ?>">Add Benefit</button>
                                <p class="description">List of benefits that will appear with checkmark icons</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Description</label></th>
                            <td>
                                <textarea name="forcex_clinical_benefits_items[<?php echo $index; ?>][description]" rows="4" style="width: 100%;" placeholder="Enter description text"><?php echo esc_textarea($item['description']); ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Background Image</label></th>
                            <td>
                                <div class="bg-image-preview" style="margin-bottom: 10px;">
                                    <?php 
                                    $bg_image_id = !empty($item['bg_image_id']) ? intval($item['bg_image_id']) : 0;
                                    if ($bg_image_id) {
                                        $bg_image_url = wp_get_attachment_image_url($bg_image_id, 'medium');
                                        if ($bg_image_url) {
                                            echo '<img src="' . esc_url($bg_image_url) . '" style="max-width: 300px; height: auto; border: 1px solid #ddd;" />';
                                        }
                                    }
                                    ?>
                                </div>
                                <input type="hidden" name="forcex_clinical_benefits_items[<?php echo $index; ?>][bg_image_id]" class="bg-image-id" value="<?php echo esc_attr($bg_image_id); ?>" />
                                <button type="button" class="button select-bg-image-clinical" data-index="<?php echo $index; ?>">Select Image</button>
                                <button type="button" class="button remove-bg-image-clinical" data-index="<?php echo $index; ?>" style="<?php echo $bg_image_id ? '' : 'display: none;'; ?>">Remove Image</button>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Background Position</label></th>
                            <td>
                                <select name="forcex_clinical_benefits_items[<?php echo $index; ?>][bg_position]" style="width: 200px;">
                                    <option value="center right" <?php selected($item['bg_position'], 'center right'); ?>>Center Right</option>
                                    <option value="center left" <?php selected($item['bg_position'], 'center left'); ?>>Center Left</option>
                                    <option value="center center" <?php selected($item['bg_position'], 'center center'); ?>>Center</option>
                                    <option value="top right" <?php selected($item['bg_position'], 'top right'); ?>>Top Right</option>
                                    <option value="top left" <?php selected($item['bg_position'], 'top left'); ?>>Top Left</option>
                                    <option value="bottom right" <?php selected($item['bg_position'], 'bottom right'); ?>>Bottom Right</option>
                                    <option value="bottom left" <?php selected($item['bg_position'], 'bottom left'); ?>>Bottom Left</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Gradient Direction</label></th>
                            <td>
                                <select name="forcex_clinical_benefits_items[<?php echo $index; ?>][gradient_direction]" style="width: 200px;">
                                    <option value="to left" <?php selected($item['gradient_direction'], 'to left'); ?>>To Left</option>
                                    <option value="to right" <?php selected($item['gradient_direction'], 'to right'); ?>>To Right</option>
                                    <option value="to top" <?php selected($item['gradient_direction'], 'to top'); ?>>To Top</option>
                                    <option value="to bottom" <?php selected($item['gradient_direction'], 'to bottom'); ?>>To Bottom</option>
                                </select>
                                <p class="description">Direction of the blue gradient overlay</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Order</label></th>
                            <td>
                                <input type="number" name="forcex_clinical_benefits_items[<?php echo $index; ?>][order]" value="<?php echo esc_attr($item['order']); ?>" min="0" style="width: 100px;" />
                                <p class="description">Display order (lower numbers appear first)</p>
                            </td>
                        </tr>
                        <tr>
                            <th></th>
                            <td>
                                <button type="button" class="button remove-clinical-benefits-item" style="color: #dc3232;">Remove Item</button>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php endforeach; ?>
        </div>
        
        <button type="button" id="add-clinical-benefits-item" class="button button-primary">Add New Item</button>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var clinicalBenefitsItemIndex = <?php echo count($benefits_items); ?>;
        
        // Add benefit
        $(document).on('click', '.add-benefit-clinical', function() {
            var index = $(this).data('index');
            var html = '<div class="benefit-item" style="margin-bottom: 8px; display: flex; gap: 8px; align-items: center;">';
            html += '<input type="text" name="forcex_clinical_benefits_items[' + index + '][benefits][]" value="" style="flex: 1;" placeholder="e.g., Pain reduction" />';
            html += '<button type="button" class="button remove-benefit" style="color: #dc3232;">Remove</button>';
            html += '</div>';
            $(this).siblings('.benefits-list').append(html);
        });
        
        // Remove benefit
        $(document).on('click', '.clinical-benefits-item .remove-benefit', function() {
            $(this).closest('.benefit-item').remove();
        });
        
        // Add clinical benefits item
        $('#add-clinical-benefits-item').on('click', function() {
            var html = '<div class="clinical-benefits-item" style="margin-bottom: 30px; padding: 20px; border: 1px solid #ddd; background: #f9f9f9; position: relative;">';
            html += '<h3 style="margin-top: 0;">Item ' + (clinicalBenefitsItemIndex + 1) + '</h3>';
            html += '<table class="form-table">';
            html += '<tr><th style="width: 200px;"><label>Tab Label</label></th>';
            html += '<td><input type="text" name="forcex_clinical_benefits_items[' + clinicalBenefitsItemIndex + '][tab_label]" value="" style="width: 100%;" placeholder="e.g., Orthopedic recovery" required /></td></tr>';
            html += '<tr><th><label>Slide Title</label></th>';
            html += '<td><input type="text" name="forcex_clinical_benefits_items[' + clinicalBenefitsItemIndex + '][title]" value="" style="width: 100%;" placeholder="e.g., Orthopedic recovery" required /></td></tr>';
            html += '<tr><th><label>Benefits</label></th>';
            html += '<td><div class="benefits-list" style="margin-bottom: 10px;"></div>';
            html += '<button type="button" class="button add-benefit-clinical" data-index="' + clinicalBenefitsItemIndex + '">Add Benefit</button></td></tr>';
            html += '<tr><th><label>Description</label></th>';
            html += '<td><textarea name="forcex_clinical_benefits_items[' + clinicalBenefitsItemIndex + '][description]" rows="4" style="width: 100%;"></textarea></td></tr>';
            html += '<tr><th><label>Background Image</label></th>';
            html += '<td><div class="bg-image-preview" style="margin-bottom: 10px;"></div>';
            html += '<input type="hidden" name="forcex_clinical_benefits_items[' + clinicalBenefitsItemIndex + '][bg_image_id]" class="bg-image-id" value="0" />';
            html += '<button type="button" class="button select-bg-image-clinical" data-index="' + clinicalBenefitsItemIndex + '">Select Image</button>';
            html += '<button type="button" class="button remove-bg-image-clinical" data-index="' + clinicalBenefitsItemIndex + '" style="display: none;">Remove Image</button></td></tr>';
            html += '<tr><th><label>Background Position</label></th>';
            html += '<td><select name="forcex_clinical_benefits_items[' + clinicalBenefitsItemIndex + '][bg_position]" style="width: 200px;">';
            html += '<option value="center right">Center Right</option>';
            html += '<option value="center left">Center Left</option>';
            html += '<option value="center center">Center</option>';
            html += '<option value="top right">Top Right</option>';
            html += '<option value="top left">Top Left</option>';
            html += '<option value="bottom right">Bottom Right</option>';
            html += '<option value="bottom left">Bottom Left</option>';
            html += '</select></td></tr>';
            html += '<tr><th><label>Gradient Direction</label></th>';
            html += '<td><select name="forcex_clinical_benefits_items[' + clinicalBenefitsItemIndex + '][gradient_direction]" style="width: 200px;">';
            html += '<option value="to left">To Left</option>';
            html += '<option value="to right">To Right</option>';
            html += '<option value="to top">To Top</option>';
            html += '<option value="to bottom">To Bottom</option>';
            html += '</select></td></tr>';
            html += '<tr><th><label>Order</label></th>';
            html += '<td><input type="number" name="forcex_clinical_benefits_items[' + clinicalBenefitsItemIndex + '][order]" value="' + clinicalBenefitsItemIndex + '" min="0" style="width: 100px;" /></td></tr>';
            html += '<tr><th></th><td><button type="button" class="button remove-clinical-benefits-item" style="color: #dc3232;">Remove Item</button></td></tr>';
            html += '</table></div>';
            
            $('#clinical-benefits-items-list').append(html);
            clinicalBenefitsItemIndex++;
        });
        
        // Remove clinical benefits item
        $(document).on('click', '.remove-clinical-benefits-item', function() {
            if (confirm('Are you sure you want to remove this item?')) {
                $(this).closest('.clinical-benefits-item').remove();
            }
        });
        
        // Media uploader for background images
        var mediaFrameClinical;
        var currentButtonClinical = null;
        
        $(document).on('click', '.select-bg-image-clinical', function(e) {
            e.preventDefault();
            var button = $(this);
            var index = button.data('index');
            currentButtonClinical = button;
            
            if (mediaFrameClinical) {
                mediaFrameClinical.off('select');
            } else {
                mediaFrameClinical = wp.media({
                    title: 'Select Background Image',
                    button: {
                        text: 'Use this image'
                    },
                    multiple: false
                });
            }
            
            mediaFrameClinical.on('select', function() {
                if (!currentButtonClinical) return;
                
                var attachment = mediaFrameClinical.state().get('selection').first().toJSON();
                var clinicalItem = currentButtonClinical.closest('.clinical-benefits-item');
                var preview = clinicalItem.find('.bg-image-preview');
                var imageIdInput = clinicalItem.find('.bg-image-id');
                var removeBtn = clinicalItem.find('.remove-bg-image-clinical');
                
                preview.html('<img src="' + attachment.url + '" style="max-width: 300px; height: auto; border: 1px solid #ddd;" />');
                imageIdInput.val(attachment.id);
                removeBtn.show();
                
                currentButtonClinical = null;
            });
            
            mediaFrameClinical.open();
        });
        
        // Remove background image
        $(document).on('click', '.remove-bg-image-clinical', function() {
            var button = $(this);
            var preview = button.siblings('.bg-image-preview');
            var imageIdInput = button.siblings('.bg-image-id');
            
            preview.html('');
            imageIdInput.val(0);
            button.hide();
        });
    });
    </script>
    <?php
}

// Save Clinically Proven Benefits meta data
function forcex_save_clinical_benefits_meta($post_id) {
    // Check nonce
    if (!isset($_POST['forcex_clinical_benefits_meta_box_nonce']) || !wp_verify_nonce($_POST['forcex_clinical_benefits_meta_box_nonce'], 'forcex_clinical_benefits_meta_box')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Check if this page uses the Clinical Resources template
    $template = get_page_template_slug($post_id);
    if ($template !== 'page-clinical-resources.php') {
        return;
    }
    
    // Save clinical benefits items
    $benefits_items = array();
    if (isset($_POST['forcex_clinical_benefits_items']) && is_array($_POST['forcex_clinical_benefits_items'])) {
        foreach ($_POST['forcex_clinical_benefits_items'] as $index => $item) {
            if (!empty($item['tab_label']) && !empty($item['title'])) {
                // Get benefits array
                $benefits = array();
                if (!empty($item['benefits']) && is_array($item['benefits'])) {
                    foreach ($item['benefits'] as $benefit) {
                        if (!empty(trim($benefit))) {
                            $benefits[] = sanitize_text_field($benefit);
                        }
                    }
                }
                
                $benefits_items[] = array(
                    'tab_label' => sanitize_text_field($item['tab_label']),
                    'title' => sanitize_text_field($item['title']),
                    'benefits' => $benefits,
                    'description' => sanitize_textarea_field($item['description']),
                    'bg_image_id' => !empty($item['bg_image_id']) ? intval($item['bg_image_id']) : 0,
                    'bg_position' => !empty($item['bg_position']) ? sanitize_text_field($item['bg_position']) : 'center right',
                    'gradient_direction' => !empty($item['gradient_direction']) ? sanitize_text_field($item['gradient_direction']) : 'to left',
                    'order' => !empty($item['order']) ? intval($item['order']) : $index
                );
            }
        }
    }
    
    // Sort by order
    usort($benefits_items, function($a, $b) {
        return $a['order'] - $b['order'];
    });
    
    update_post_meta($post_id, '_forcex_clinical_benefits_items', $benefits_items);
}
add_action('save_post', 'forcex_save_clinical_benefits_meta');

// Helper function to get Clinically Proven Benefits items
function forcex_get_clinical_benefits_items($post_id = null) {
    if ($post_id === null) {
        global $post;
        $post_id = $post ? $post->ID : 0;
    }
    
    if (!$post_id) {
        return array();
    }
    
    $items = get_post_meta($post_id, '_forcex_clinical_benefits_items', true);
    
    if (!is_array($items)) {
        return array();
    }
    
    // Sort by order
    usort($items, function($a, $b) {
        $order_a = isset($a['order']) ? intval($a['order']) : 999;
        $order_b = isset($b['order']) ? intval($b['order']) : 999;
        return $order_a - $order_b;
    });
    
    return $items;
}

// ============================================
// Clinical Research Section Admin Settings
// ============================================

// Add meta box for Clinical Research section (only on Clinical Resources template pages)
function forcex_add_clinical_research_meta_box() {
    add_meta_box(
        'forcex_clinical_research',
        'Clinical Research Section',
        'forcex_clinical_research_meta_box_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'forcex_add_clinical_research_meta_box');

// Meta box callback
function forcex_clinical_research_meta_box_callback($post) {
    // Check if this page uses the Clinical Resources template
    $template = get_page_template_slug($post->ID);
    if ($template !== 'page-clinical-resources.php') {
        echo '<p><strong>Note:</strong> This meta box is only active for pages using the "Clinical Resources" template. To use it, go to Page Attributes and select "Clinical Resources" as the template.</p>';
        return;
    }
    
    wp_nonce_field('forcex_clinical_research_meta_box', 'forcex_clinical_research_meta_box_nonce');
    
    // Get saved items
    $research_items = get_post_meta($post->ID, '_forcex_clinical_research_items', true);
    if (!is_array($research_items)) {
        $research_items = array();
    }
    
    // Default items if empty
    if (empty($research_items)) {
        $research_items = array(
            array(
                'title' => 'Assessing the impact of ForceX™ on post-surgical recovery',
                'download_url' => '',
                'order' => 0
            ),
            array(
                'title' => 'Efficacy of ForceX™ technology in accelerating injury rehabilitation',
                'download_url' => '',
                'order' => 1
            ),
            array(
                'title' => 'The role of ForceX™ in reducing swelling and pain in post-operative patients',
                'download_url' => '',
                'order' => 2
            )
        );
    }

    ?>
    <p>Manage the "Clinical research supporting ForceX™" section. Add, edit, or remove research items with titles and download links. Changes will be saved when you update the page.</p>
    
    <div id="clinical-research-items-container">
        <div id="clinical-research-items-list">
            <?php foreach ($research_items as $index => $item): ?>
                <div class="clinical-research-item" style="margin-bottom: 30px; padding: 20px; border: 1px solid #ddd; background: #f9f9f9; position: relative;">
                    <h3 style="margin-top: 0;">Item <?php echo $index + 1; ?></h3>
                    
                    <table class="form-table">
                        <tr>
                            <th style="width: 200px;"><label>Research Title</label></th>
                            <td>
                                <input type="text" name="forcex_clinical_research_items[<?php echo $index; ?>][title]" value="<?php echo esc_attr($item['title']); ?>" style="width: 100%;" placeholder="e.g., Assessing the impact of ForceX™ on post-surgical recovery" required />
                                <p class="description">The title of the research study</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Download URL</label></th>
                            <td>
                                <input type="url" name="forcex_clinical_research_items[<?php echo $index; ?>][download_url]" value="<?php echo esc_url($item['download_url']); ?>" style="width: 100%;" placeholder="https://example.com/research.pdf" />
                                <p class="description">URL to the research document (PDF, link, etc.)</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Order</label></th>
                            <td>
                                <input type="number" name="forcex_clinical_research_items[<?php echo $index; ?>][order]" value="<?php echo esc_attr($item['order']); ?>" min="0" style="width: 100px;" />
                                <p class="description">Display order (lower numbers appear first)</p>
                            </td>
                        </tr>
                        <tr>
                            <th></th>
                            <td>
                                <button type="button" class="button remove-clinical-research-item" style="color: #dc3232;">Remove Item</button>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php endforeach; ?>
        </div>
        
        <button type="button" id="add-clinical-research-item" class="button button-primary">Add New Item</button>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var clinicalResearchItemIndex = <?php echo count($research_items); ?>;
        
        // Add clinical research item
        $('#add-clinical-research-item').on('click', function() {
            var html = '<div class="clinical-research-item" style="margin-bottom: 30px; padding: 20px; border: 1px solid #ddd; background: #f9f9f9; position: relative;">';
            html += '<h3 style="margin-top: 0;">Item ' + (clinicalResearchItemIndex + 1) + '</h3>';
            html += '<table class="form-table">';
            html += '<tr><th style="width: 200px;"><label>Research Title</label></th>';
            html += '<td><input type="text" name="forcex_clinical_research_items[' + clinicalResearchItemIndex + '][title]" value="" style="width: 100%;" placeholder="e.g., Assessing the impact of ForceX™ on post-surgical recovery" required /></td></tr>';
            html += '<tr><th><label>Download URL</label></th>';
            html += '<td><input type="url" name="forcex_clinical_research_items[' + clinicalResearchItemIndex + '][download_url]" value="" style="width: 100%;" placeholder="https://example.com/research.pdf" /></td></tr>';
            html += '<tr><th><label>Order</label></th>';
            html += '<td><input type="number" name="forcex_clinical_research_items[' + clinicalResearchItemIndex + '][order]" value="' + clinicalResearchItemIndex + '" min="0" style="width: 100px;" /></td></tr>';
            html += '<tr><th></th><td><button type="button" class="button remove-clinical-research-item" style="color: #dc3232;">Remove Item</button></td></tr>';
            html += '</table></div>';
            
            $('#clinical-research-items-list').append(html);
            clinicalResearchItemIndex++;
        });
        
        // Remove clinical research item
        $(document).on('click', '.remove-clinical-research-item', function() {
            if (confirm('Are you sure you want to remove this item?')) {
                $(this).closest('.clinical-research-item').remove();
            }
        });
    });
    </script>
    <?php
}

// Save Clinical Research meta data
function forcex_save_clinical_research_meta($post_id) {
    // Check nonce
    if (!isset($_POST['forcex_clinical_research_meta_box_nonce']) || !wp_verify_nonce($_POST['forcex_clinical_research_meta_box_nonce'], 'forcex_clinical_research_meta_box')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Check if this page uses the Clinical Resources template
    $template = get_page_template_slug($post_id);
    if ($template !== 'page-clinical-resources.php') {
        return;
    }
    
    // Save clinical research items
    $research_items = array();
    if (isset($_POST['forcex_clinical_research_items']) && is_array($_POST['forcex_clinical_research_items'])) {
        foreach ($_POST['forcex_clinical_research_items'] as $index => $item) {
            if (!empty($item['title'])) {
                $research_items[] = array(
                    'title' => sanitize_text_field($item['title']),
                    'download_url' => !empty($item['download_url']) ? esc_url_raw($item['download_url']) : '',
                    'order' => !empty($item['order']) ? intval($item['order']) : $index
                );
            }
        }
    }
    
    // Sort by order
    usort($research_items, function($a, $b) {
        return $a['order'] - $b['order'];
    });
    
    update_post_meta($post_id, '_forcex_clinical_research_items', $research_items);
}
add_action('save_post', 'forcex_save_clinical_research_meta');

// Helper function to get Clinical Research items
function forcex_get_clinical_research_items($post_id = null) {
    if ($post_id === null) {
        global $post;
        $post_id = $post ? $post->ID : 0;
    }
    
    if (!$post_id) {
        return array();
    }
    
    $items = get_post_meta($post_id, '_forcex_clinical_research_items', true);
    
    if (!is_array($items)) {
        return array();
    }
    
    // Sort by order
    usort($items, function($a, $b) {
        $order_a = isset($a['order']) ? intval($a['order']) : 999;
        $order_b = isset($b['order']) ? intval($b['order']) : 999;
        return $order_a - $order_b;
    });
    
    return $items;
}

// ============================================
// Key Benefits Slider Section Admin Settings
// ============================================

// Add meta box for Key Benefits slider (only on Medical Professionals template pages)
function forcex_add_key_benefits_meta_box() {
    add_meta_box(
        'forcex_key_benefits',
        'Key Benefits Slider Section',
        'forcex_key_benefits_meta_box_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'forcex_add_key_benefits_meta_box');

// Meta box callback
function forcex_key_benefits_meta_box_callback($post) {
    $template = get_page_template_slug($post->ID);
    if ($template !== 'page-medical-professionals.php') {
        echo '<p><strong>Note:</strong> This meta box is only active for pages using the "For Medical Professionals" template. To use it, go to Page Attributes and select "For Medical Professionals" as the template.</p>';
    }
    
    wp_nonce_field('forcex_key_benefits_meta_box', 'forcex_key_benefits_meta_box_nonce');
    
    // Enqueue media uploader
    wp_enqueue_media();
    
    // Get saved items
    $benefits_items = get_post_meta($post->ID, '_forcex_key_benefits_items', true);
    if (!is_array($benefits_items)) {
        $benefits_items = array();
    }
    
    // Default items if empty (hardcoded 6 images)
    if (empty($benefits_items)) {
        for ($i = 1; $i <= 6; $i++) {
            $benefits_items[] = array(
                'image_id' => '',
                'image_url' => get_template_directory_uri() . '/assets/img/ss' . $i . '.png',
                'order' => $i - 1
            );
        }
    }

    ?>
    <p>Manage the "Key benefits of ForceX™ technology" slider. Upload images for each slide. Changes will be saved when you update the page.</p>
    
    <div id="key-benefits-items-container">
        <div id="key-benefits-items-list">
            <?php foreach ($benefits_items as $index => $item): ?>
                <div class="key-benefits-item" style="margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; background: #f9f9f9; position: relative;">
                    <h3 style="margin-top: 0;">Slide <?php echo $index + 1; ?></h3>
                    
                    <table class="form-table">
                        <tr>
                            <th style="width: 150px;"><label>Image</label></th>
                            <td>
                                <div class="key-benefits-image-preview" style="margin-bottom: 10px;">
                                    <?php if (!empty($item['image_url'])): ?>
                                        <img src="<?php echo esc_url($item['image_url']); ?>" style="max-width: 300px; height: auto; border: 1px solid #ddd;" />
                                    <?php endif; ?>
                                </div>
                                <input type="hidden" name="forcex_key_benefits_items[<?php echo $index; ?>][image_id]" class="key-benefits-image-id" value="<?php echo esc_attr($item['image_id']); ?>" />
                                <input type="hidden" name="forcex_key_benefits_items[<?php echo $index; ?>][image_url]" class="key-benefits-image-url" value="<?php echo esc_url($item['image_url']); ?>" />
                                <button type="button" class="button key-benefits-upload-image" data-index="<?php echo $index; ?>">Select Image</button>
                                <button type="button" class="button key-benefits-remove-image" data-index="<?php echo $index; ?>" style="margin-left: 10px; color: #dc3232;">Remove Image</button>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Order</label></th>
                            <td>
                                <input type="number" name="forcex_key_benefits_items[<?php echo $index; ?>][order]" value="<?php echo esc_attr($item['order']); ?>" min="0" style="width: 80px;" />
                                <p class="description">Display order (lower numbers appear first)</p>
                            </td>
                        </tr>
                        <tr>
                            <th></th>
                            <td>
                                <button type="button" class="button remove-key-benefits-item" style="color: #dc3232;">Remove Slide</button>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php endforeach; ?>
        </div>
        
        <button type="button" id="add-key-benefits-item" class="button button-primary">Add New Slide</button>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var keyBenefitsItemIndex = <?php echo count($benefits_items); ?>;
        
        // Add key benefits item
        $('#add-key-benefits-item').on('click', function() {
            var html = '<div class="key-benefits-item" style="margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; background: #f9f9f9; position: relative;">';
            html += '<h3 style="margin-top: 0;">Slide ' + (keyBenefitsItemIndex + 1) + '</h3>';
            html += '<table class="form-table">';
            html += '<tr><th style="width: 150px;"><label>Image</label></th>';
            html += '<td><div class="key-benefits-image-preview" style="margin-bottom: 10px;"></div>';
            html += '<input type="hidden" name="forcex_key_benefits_items[' + keyBenefitsItemIndex + '][image_id]" class="key-benefits-image-id" value="" />';
            html += '<input type="hidden" name="forcex_key_benefits_items[' + keyBenefitsItemIndex + '][image_url]" class="key-benefits-image-url" value="" />';
            html += '<button type="button" class="button key-benefits-upload-image" data-index="' + keyBenefitsItemIndex + '">Select Image</button>';
            html += '<button type="button" class="button key-benefits-remove-image" data-index="' + keyBenefitsItemIndex + '" style="margin-left: 10px; color: #dc3232;">Remove Image</button></td></tr>';
            html += '<tr><th><label>Order</label></th>';
            html += '<td><input type="number" name="forcex_key_benefits_items[' + keyBenefitsItemIndex + '][order]" value="' + keyBenefitsItemIndex + '" min="0" style="width: 80px;" /></td></tr>';
            html += '<tr><th></th><td><button type="button" class="button remove-key-benefits-item" style="color: #dc3232;">Remove Slide</button></td></tr>';
            html += '</table></div>';
            
            $('#key-benefits-items-list').append(html);
            keyBenefitsItemIndex++;
        });
        
        // Remove key benefits item
        $(document).on('click', '.remove-key-benefits-item', function() {
            if (confirm('Are you sure you want to remove this slide?')) {
                $(this).closest('.key-benefits-item').remove();
            }
        });
        
        // Upload image
        $(document).on('click', '.key-benefits-upload-image', function(e) {
            e.preventDefault();
            var button = $(this);
            var index = button.data('index');
            var item = button.closest('.key-benefits-item');
            
            var frame = wp.media({
                title: 'Select Image',
                button: {
                    text: 'Use this image'
                },
                multiple: false
            });
            
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                item.find('.key-benefits-image-id').val(attachment.id);
                item.find('.key-benefits-image-url').val(attachment.url);
                item.find('.key-benefits-image-preview').html('<img src="' + attachment.url + '" style="max-width: 300px; height: auto; border: 1px solid #ddd;" />');
            });
            
            frame.open();
        });
        
        // Remove image
        $(document).on('click', '.key-benefits-remove-image', function() {
            var item = $(this).closest('.key-benefits-item');
            item.find('.key-benefits-image-id').val('');
            item.find('.key-benefits-image-url').val('');
            item.find('.key-benefits-image-preview').html('');
        });
    });
    </script>
    <?php
}

// Save Key Benefits meta data
function forcex_save_key_benefits_meta($post_id) {
    // Check nonce
    if (!isset($_POST['forcex_key_benefits_meta_box_nonce']) || !wp_verify_nonce($_POST['forcex_key_benefits_meta_box_nonce'], 'forcex_key_benefits_meta_box')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save key benefits items
    $benefits_items = array();
    if (isset($_POST['forcex_key_benefits_items']) && is_array($_POST['forcex_key_benefits_items'])) {
        foreach ($_POST['forcex_key_benefits_items'] as $index => $item) {
            if (!empty($item['image_url'])) {
                $benefits_items[] = array(
                    'image_id' => !empty($item['image_id']) ? intval($item['image_id']) : '',
                    'image_url' => esc_url_raw($item['image_url']),
                    'order' => !empty($item['order']) ? intval($item['order']) : $index
                );
            }
        }
    }
    
    // Sort by order
    usort($benefits_items, function($a, $b) {
        return $a['order'] - $b['order'];
    });
    
    update_post_meta($post_id, '_forcex_key_benefits_items', $benefits_items);
}
add_action('save_post', 'forcex_save_key_benefits_meta');

// Helper function to get Key Benefits items
function forcex_get_key_benefits_items($post_id = null) {
    if ($post_id === null) {
        global $post;
        $post_id = $post ? $post->ID : 0;
    }
    
    if (!$post_id) {
        return array();
    }
    
    $items = get_post_meta($post_id, '_forcex_key_benefits_items', true);
    
    if (!is_array($items)) {
        return array();
    }
    
    // Sort by order
    usort($items, function($a, $b) {
        $order_a = isset($a['order']) ? intval($a['order']) : 999;
        $order_b = isset($b['order']) ? intval($b['order']) : 999;
        return $order_a - $order_b;
    });
    
    // Replace hardcoded local URLs with current site URL
    $site_url = site_url();
    $local_domains = array('http://forcex.local', 'https://forcex.local', 'http://www.forcex.local', 'https://www.forcex.local');
    
    foreach ($items as &$item) {
        if (!empty($item['image_url'])) {
            // Check if URL contains local domain and replace with current site URL
            foreach ($local_domains as $local_domain) {
                if (strpos($item['image_url'], $local_domain) === 0) {
                    // Replace local domain with current site URL
                    $item['image_url'] = str_replace($local_domain, $site_url, $item['image_url']);
                    break;
                }
            }
        }
    }
    unset($item); // Unset reference
    
    return $items;
}

// ============================================
// Targeted Recovery Solutions Section Admin Settings
// ============================================

// Add meta box for Targeted Recovery Solutions (only on Medical Professionals template pages)
function forcex_add_targeted_recovery_meta_box() {
    add_meta_box(
        'forcex_targeted_recovery',
        'Targeted Recovery Solutions Section',
        'forcex_targeted_recovery_meta_box_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'forcex_add_targeted_recovery_meta_box');

// Meta box callback
function forcex_targeted_recovery_meta_box_callback($post) {
    $template = get_page_template_slug($post->ID);
    if ($template !== 'page-medical-professionals.php') {
        echo '<p><strong>Note:</strong> This meta box is only active for pages using the "For Medical Professionals" template. To use it, go to Page Attributes and select "For Medical Professionals" as the template.</p>';
    }
    
    wp_nonce_field('forcex_targeted_recovery_meta_box', 'forcex_targeted_recovery_meta_box_nonce');
    wp_enqueue_media();
    
    // Get saved items
    $recovery_items = get_post_meta($post->ID, '_forcex_targeted_recovery_items', true);
    if (!is_array($recovery_items)) {
        $recovery_items = array();
    }
    
    // Default items if empty
    if (empty($recovery_items)) {
        $recovery_items = array(
            array(
                'tab_label' => 'Orthopedic recovery',
                'title' => 'Orthopedic recovery',
                'benefits' => array(),
                'description' => 'ForceX™ accelerates recovery from orthopedic surgeries by reducing swelling, pain, and improving circulation with precise temperature and compression therapy.',
                'bg_image_id' => 0,
                'bg_position' => 'center right',
                'gradient_direction' => 'to left',
                'order' => 0
            ),
            array(
                'tab_label' => 'Injury rehabilitation',
                'title' => 'Injury rehabilitation',
                'benefits' => array(),
                'description' => 'Effective therapy solutions for injury rehabilitation, helping patients recover faster with targeted heat, cold, and compression treatment.',
                'bg_image_id' => 0,
                'bg_position' => 'center left',
                'gradient_direction' => 'to right',
                'order' => 1
            ),
            array(
                'tab_label' => 'Sports medicine',
                'title' => 'Sports medicine',
                'benefits' => array(),
                'description' => 'Advanced recovery technology for athletes and sports professionals, optimizing performance and reducing recovery time between training sessions.',
                'bg_image_id' => 0,
                'bg_position' => 'center right',
                'gradient_direction' => 'to left',
                'order' => 2
            )
        );
    }

    ?>
    <p>Manage the "Targeted recovery solutions" section. Add, edit, or remove items and configure their content. Changes will be saved when you update the page.</p>
    
    <div id="targeted-recovery-items-container">
        <div id="targeted-recovery-items-list">
            <?php foreach ($recovery_items as $index => $item): ?>
                <div class="targeted-recovery-item" style="margin-bottom: 30px; padding: 20px; border: 1px solid #ddd; background: #f9f9f9; position: relative;">
                    <h3 style="margin-top: 0;">Item <?php echo $index + 1; ?></h3>
                    
                    <table class="form-table">
                        <tr>
                            <th style="width: 200px;"><label>Tab Label</label></th>
                            <td>
                                <input type="text" name="forcex_targeted_recovery_items[<?php echo $index; ?>][tab_label]" value="<?php echo esc_attr($item['tab_label']); ?>" style="width: 100%;" placeholder="e.g., Orthopedic recovery" required />
                                <p class="description">The text that appears on the navigation button</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Slide Title</label></th>
                            <td>
                                <input type="text" name="forcex_targeted_recovery_items[<?php echo $index; ?>][title]" value="<?php echo esc_attr($item['title']); ?>" style="width: 100%;" placeholder="e.g., Orthopedic recovery" required />
                                <p class="description">The main title displayed on the slide</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Benefits</label></th>
                            <td>
                                <div class="benefits-list" style="margin-bottom: 10px;">
                                    <?php if (!empty($item['benefits'])): ?>
                                        <?php foreach ($item['benefits'] as $benefit_index => $benefit): ?>
                                            <div class="benefit-item" style="margin-bottom: 8px; display: flex; gap: 8px; align-items: center;">
                                                <input type="text" name="forcex_targeted_recovery_items[<?php echo $index; ?>][benefits][]" value="<?php echo esc_attr($benefit); ?>" style="flex: 1;" placeholder="e.g., Pain reduction" />
                                                <button type="button" class="button remove-benefit" style="color: #dc3232;">Remove</button>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <button type="button" class="button add-benefit" data-index="<?php echo $index; ?>">Add Benefit</button>
                                <p class="description">List of benefits that will appear with checkmark icons (optional)</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Description</label></th>
                            <td>
                                <textarea name="forcex_targeted_recovery_items[<?php echo $index; ?>][description]" rows="4" style="width: 100%;" placeholder="Enter description text"><?php echo esc_textarea($item['description']); ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Background Image</label></th>
                            <td>
                                <div class="bg-image-preview" style="margin-bottom: 10px;">
                                    <?php 
                                    $bg_image_id = !empty($item['bg_image_id']) ? intval($item['bg_image_id']) : 0;
                                    if ($bg_image_id) {
                                        $bg_image_url = wp_get_attachment_image_url($bg_image_id, 'medium');
                                        if ($bg_image_url) {
                                            echo '<img src="' . esc_url($bg_image_url) . '" style="max-width: 300px; height: auto; border: 1px solid #ddd;" />';
                                        }
                                    }
                                    ?>
                                </div>
                                <input type="hidden" name="forcex_targeted_recovery_items[<?php echo $index; ?>][bg_image_id]" class="bg-image-id" value="<?php echo esc_attr($bg_image_id); ?>" />
                                <button type="button" class="button select-bg-image" data-index="<?php echo $index; ?>">Select Image</button>
                                <button type="button" class="button remove-bg-image" data-index="<?php echo $index; ?>" style="<?php echo $bg_image_id ? '' : 'display: none;'; ?>">Remove Image</button>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Background Position</label></th>
                            <td>
                                <select name="forcex_targeted_recovery_items[<?php echo $index; ?>][bg_position]" style="width: 200px;">
                                    <option value="center right" <?php selected($item['bg_position'], 'center right'); ?>>Center Right</option>
                                    <option value="center left" <?php selected($item['bg_position'], 'center left'); ?>>Center Left</option>
                                    <option value="center center" <?php selected($item['bg_position'], 'center center'); ?>>Center</option>
                                    <option value="top right" <?php selected($item['bg_position'], 'top right'); ?>>Top Right</option>
                                    <option value="top left" <?php selected($item['bg_position'], 'top left'); ?>>Top Left</option>
                                    <option value="bottom right" <?php selected($item['bg_position'], 'bottom right'); ?>>Bottom Right</option>
                                    <option value="bottom left" <?php selected($item['bg_position'], 'bottom left'); ?>>Bottom Left</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Gradient Direction</label></th>
                            <td>
                                <select name="forcex_targeted_recovery_items[<?php echo $index; ?>][gradient_direction]" style="width: 200px;">
                                    <option value="to left" <?php selected($item['gradient_direction'], 'to left'); ?>>To Left</option>
                                    <option value="to right" <?php selected($item['gradient_direction'], 'to right'); ?>>To Right</option>
                                    <option value="to top" <?php selected($item['gradient_direction'], 'to top'); ?>>To Top</option>
                                    <option value="to bottom" <?php selected($item['gradient_direction'], 'to bottom'); ?>>To Bottom</option>
                                </select>
                                <p class="description">Direction of the blue gradient overlay</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Order</label></th>
                            <td>
                                <input type="number" name="forcex_targeted_recovery_items[<?php echo $index; ?>][order]" value="<?php echo esc_attr($item['order']); ?>" min="0" style="width: 100px;" />
                                <p class="description">Display order (lower numbers appear first)</p>
                            </td>
                        </tr>
                        <tr>
                            <th></th>
                            <td>
                                <button type="button" class="button remove-targeted-recovery-item" style="color: #dc3232;">Remove Item</button>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php endforeach; ?>
        </div>
        
        <button type="button" id="add-targeted-recovery-item" class="button button-primary">Add New Item</button>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var targetedRecoveryItemIndex = <?php echo count($recovery_items); ?>;
        
        // Add targeted recovery item
        $('#add-targeted-recovery-item').on('click', function() {
            var html = '<div class="targeted-recovery-item" style="margin-bottom: 30px; padding: 20px; border: 1px solid #ddd; background: #f9f9f9; position: relative;">';
            html += '<h3 style="margin-top: 0;">Item ' + (targetedRecoveryItemIndex + 1) + '</h3>';
            html += '<table class="form-table">';
            html += '<tr><th style="width: 200px;"><label>Tab Label</label></th>';
            html += '<td><input type="text" name="forcex_targeted_recovery_items[' + targetedRecoveryItemIndex + '][tab_label]" value="" style="width: 100%;" placeholder="e.g., Orthopedic recovery" required /></td></tr>';
            html += '<tr><th><label>Slide Title</label></th>';
            html += '<td><input type="text" name="forcex_targeted_recovery_items[' + targetedRecoveryItemIndex + '][title]" value="" style="width: 100%;" placeholder="e.g., Orthopedic recovery" required /></td></tr>';
            html += '<tr><th><label>Benefits</label></th>';
            html += '<td><div class="benefits-list" style="margin-bottom: 10px;"></div>';
            html += '<button type="button" class="button add-benefit" data-index="' + targetedRecoveryItemIndex + '">Add Benefit</button></td></tr>';
            html += '<tr><th><label>Description</label></th>';
            html += '<td><textarea name="forcex_targeted_recovery_items[' + targetedRecoveryItemIndex + '][description]" rows="4" style="width: 100%;" placeholder="Enter description text"></textarea></td></tr>';
            html += '<tr><th><label>Background Image</label></th>';
            html += '<td><div class="bg-image-preview" style="margin-bottom: 10px;"></div>';
            html += '<input type="hidden" name="forcex_targeted_recovery_items[' + targetedRecoveryItemIndex + '][bg_image_id]" class="bg-image-id" value="0" />';
            html += '<button type="button" class="button select-bg-image" data-index="' + targetedRecoveryItemIndex + '">Select Image</button>';
            html += '<button type="button" class="button remove-bg-image" data-index="' + targetedRecoveryItemIndex + '" style="display: none;">Remove Image</button></td></tr>';
            html += '<tr><th><label>Background Position</label></th>';
            html += '<td><select name="forcex_targeted_recovery_items[' + targetedRecoveryItemIndex + '][bg_position]" style="width: 200px;">';
            html += '<option value="center right" selected>Center Right</option>';
            html += '<option value="center left">Center Left</option>';
            html += '<option value="center center">Center</option>';
            html += '<option value="top right">Top Right</option>';
            html += '<option value="top left">Top Left</option>';
            html += '<option value="bottom right">Bottom Right</option>';
            html += '<option value="bottom left">Bottom Left</option>';
            html += '</select></td></tr>';
            html += '<tr><th><label>Gradient Direction</label></th>';
            html += '<td><select name="forcex_targeted_recovery_items[' + targetedRecoveryItemIndex + '][gradient_direction]" style="width: 200px;">';
            html += '<option value="to left" selected>To Left</option>';
            html += '<option value="to right">To Right</option>';
            html += '<option value="to top">To Top</option>';
            html += '<option value="to bottom">To Bottom</option>';
            html += '</select></td></tr>';
            html += '<tr><th><label>Order</label></th>';
            html += '<td><input type="number" name="forcex_targeted_recovery_items[' + targetedRecoveryItemIndex + '][order]" value="' + targetedRecoveryItemIndex + '" min="0" style="width: 100px;" /></td></tr>';
            html += '<tr><th></th><td><button type="button" class="button remove-targeted-recovery-item" style="color: #dc3232;">Remove Item</button></td></tr>';
            html += '</table></div>';
            
            $('#targeted-recovery-items-list').append(html);
            targetedRecoveryItemIndex++;
        });
        
        // Remove targeted recovery item
        $(document).on('click', '.remove-targeted-recovery-item', function() {
            if (confirm('Are you sure you want to remove this item?')) {
                $(this).closest('.targeted-recovery-item').remove();
            }
        });
        
        // Add benefit
        $(document).on('click', '.add-benefit', function() {
            var index = $(this).data('index');
            var benefitsList = $(this).siblings('.benefits-list');
            var html = '<div class="benefit-item" style="margin-bottom: 8px; display: flex; gap: 8px; align-items: center;">';
            html += '<input type="text" name="forcex_targeted_recovery_items[' + index + '][benefits][]" value="" style="flex: 1;" placeholder="e.g., Pain reduction" />';
            html += '<button type="button" class="button remove-benefit" style="color: #dc3232;">Remove</button>';
            html += '</div>';
            benefitsList.append(html);
        });
        
        // Remove benefit
        $(document).on('click', '.remove-benefit', function() {
            $(this).closest('.benefit-item').remove();
        });
        
        // Select background image
        $(document).on('click', '.select-bg-image', function(e) {
            e.preventDefault();
            var button = $(this);
            var index = button.data('index');
            var item = button.closest('.targeted-recovery-item');
            
            var frame = wp.media({
                title: 'Select Background Image',
                button: {
                    text: 'Use this image'
                },
                multiple: false
            });
            
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                item.find('.bg-image-id').val(attachment.id);
                item.find('.bg-image-preview').html('<img src="' + attachment.url + '" style="max-width: 300px; height: auto; border: 1px solid #ddd;" />');
                item.find('.remove-bg-image').show();
            });
            
            frame.open();
        });
        
        // Remove background image
        $(document).on('click', '.remove-bg-image', function() {
            var item = $(this).closest('.targeted-recovery-item');
            item.find('.bg-image-id').val(0);
            item.find('.bg-image-preview').html('');
            $(this).hide();
        });
    });
    </script>
    <?php
}

// Save Targeted Recovery Solutions meta data
function forcex_save_targeted_recovery_meta($post_id) {
    // Check nonce
    if (!isset($_POST['forcex_targeted_recovery_meta_box_nonce']) || !wp_verify_nonce($_POST['forcex_targeted_recovery_meta_box_nonce'], 'forcex_targeted_recovery_meta_box')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save targeted recovery items
    $recovery_items = array();
    if (isset($_POST['forcex_targeted_recovery_items']) && is_array($_POST['forcex_targeted_recovery_items'])) {
        foreach ($_POST['forcex_targeted_recovery_items'] as $index => $item) {
            if (!empty($item['tab_label']) && !empty($item['title'])) {
                $benefits = array();
                if (!empty($item['benefits']) && is_array($item['benefits'])) {
                    foreach ($item['benefits'] as $benefit) {
                        if (!empty(trim($benefit))) {
                            $benefits[] = sanitize_text_field($benefit);
                        }
                    }
                }
                
                $recovery_items[] = array(
                    'tab_label' => sanitize_text_field($item['tab_label']),
                    'title' => sanitize_text_field($item['title']),
                    'benefits' => $benefits,
                    'description' => sanitize_textarea_field($item['description']),
                    'bg_image_id' => !empty($item['bg_image_id']) ? intval($item['bg_image_id']) : 0,
                    'bg_position' => !empty($item['bg_position']) ? sanitize_text_field($item['bg_position']) : 'center right',
                    'gradient_direction' => !empty($item['gradient_direction']) ? sanitize_text_field($item['gradient_direction']) : 'to left',
                    'order' => !empty($item['order']) ? intval($item['order']) : $index
                );
            }
        }
    }
    
    // Sort by order
    usort($recovery_items, function($a, $b) {
        return $a['order'] - $b['order'];
    });
    
    update_post_meta($post_id, '_forcex_targeted_recovery_items', $recovery_items);
}
add_action('save_post', 'forcex_save_targeted_recovery_meta');

// Helper function to get Targeted Recovery Solutions items
function forcex_get_targeted_recovery_items($post_id = null) {
    if ($post_id === null) {
        global $post;
        $post_id = $post ? $post->ID : 0;
    }
    
    if (!$post_id) {
        return array();
    }
    
    $items = get_post_meta($post_id, '_forcex_targeted_recovery_items', true);
    
    if (!is_array($items)) {
        return array();
    }
    
    // Sort by order
    usort($items, function($a, $b) {
        $order_a = isset($a['order']) ? intval($a['order']) : 999;
        $order_b = isset($b['order']) ? intval($b['order']) : 999;
        return $order_a - $order_b;
    });
    
    return $items;
}

// ============================================
// Contact Page Map Coordinates Admin Settings
// ============================================

// Add meta box for Contact page map coordinates (only on Contact template pages)
function forcex_add_contact_coordinates_meta_box() {
    add_meta_box(
        'forcex_contact_coordinates',
        'Contact Page Map Coordinates',
        'forcex_contact_coordinates_meta_box_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'forcex_add_contact_coordinates_meta_box');

// Meta box callback
function forcex_contact_coordinates_meta_box_callback($post) {
    wp_nonce_field('forcex_contact_coordinates_meta_box', 'forcex_contact_coordinates_meta_box_nonce');
    
    // Get saved coordinates
    $latitude = get_post_meta($post->ID, '_forcex_contact_latitude', true);
    $longitude = get_post_meta($post->ID, '_forcex_contact_longitude', true);
    $zoom = get_post_meta($post->ID, '_forcex_contact_map_zoom', true);
    $api_key = get_post_meta($post->ID, '_forcex_contact_map_api_key', true);
    
    // Default values (Cleveland, OH location)
    if (empty($latitude)) {
        $latitude = '41.408903';
    }
    if (empty($longitude)) {
        $longitude = '-81.865354';
    }
    if (empty($zoom)) {
        $zoom = '15';
    }
    
    // Check if this page uses the Contact template
    $template = get_page_template_slug($post->ID);
    if ($template !== 'page-contact.php') {
        echo '<p><strong>Note:</strong> This meta box is only active for pages using the "Contact" template. To use it, go to Page Attributes and select "Contact" as the template.</p>';
    }
    ?>
    <p>Set the map coordinates for the contact page. You can find coordinates using <a href="https://www.google.com/maps" target="_blank">Google Maps</a> - right-click on a location and select the coordinates.</p>
    
    <table class="form-table">
        <tr>
            <th style="width: 200px;"><label for="forcex_contact_latitude">Latitude *</label></th>
            <td>
                <input type="text" id="forcex_contact_latitude" name="forcex_contact_latitude" value="<?php echo esc_attr($latitude); ?>" style="width: 100%; max-width: 300px;" placeholder="41.408903" required />
                <p class="description">Map latitude coordinate (e.g., 41.408903)</p>
            </td>
        </tr>
        <tr>
            <th><label for="forcex_contact_longitude">Longitude *</label></th>
            <td>
                <input type="text" id="forcex_contact_longitude" name="forcex_contact_longitude" value="<?php echo esc_attr($longitude); ?>" style="width: 100%; max-width: 300px;" placeholder="-81.865354" required />
                <p class="description">Map longitude coordinate (e.g., -81.865354)</p>
            </td>
        </tr>
        <tr>
            <th><label for="forcex_contact_map_zoom">Zoom Level</label></th>
            <td>
                <input type="number" id="forcex_contact_map_zoom" name="forcex_contact_map_zoom" value="<?php echo esc_attr($zoom); ?>" min="1" max="20" style="width: 100px;" />
                <p class="description">Map zoom level (1-20, default: 15)</p>
            </td>
        </tr>
        <tr>
            <th><label for="forcex_contact_map_api_key">Google Maps API Key</label></th>
            <td>
                <input type="text" id="forcex_contact_map_api_key" name="forcex_contact_map_api_key" value="<?php echo esc_attr($api_key); ?>" style="width: 100%; max-width: 400px;" placeholder="AIza..." />
                <p class="description">Optional: Google Maps JavaScript API key. <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">Get API key</a>. If not provided, the map may show a warning but will still work.</p>
            </td>
        </tr>
    </table>
    <?php
}

// Save Contact Coordinates meta data
function forcex_save_contact_coordinates_meta($post_id) {
    // Check nonce
    if (!isset($_POST['forcex_contact_coordinates_meta_box_nonce']) || !wp_verify_nonce($_POST['forcex_contact_coordinates_meta_box_nonce'], 'forcex_contact_coordinates_meta_box')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Check if this page uses the Contact template
    $template = get_page_template_slug($post_id);
    if ($template !== 'page-contact.php') {
        return;
    }
    
    // Save coordinates
    if (isset($_POST['forcex_contact_latitude'])) {
        update_post_meta($post_id, '_forcex_contact_latitude', sanitize_text_field($_POST['forcex_contact_latitude']));
    }
    
    if (isset($_POST['forcex_contact_longitude'])) {
        update_post_meta($post_id, '_forcex_contact_longitude', sanitize_text_field($_POST['forcex_contact_longitude']));
    }
    
    if (isset($_POST['forcex_contact_map_zoom'])) {
        $zoom = intval($_POST['forcex_contact_map_zoom']);
        if ($zoom >= 1 && $zoom <= 20) {
            update_post_meta($post_id, '_forcex_contact_map_zoom', $zoom);
        }
    }
    
    if (isset($_POST['forcex_contact_map_api_key'])) {
        update_post_meta($post_id, '_forcex_contact_map_api_key', sanitize_text_field($_POST['forcex_contact_map_api_key']));
    }
}
add_action('save_post', 'forcex_save_contact_coordinates_meta');

// Helper function to get Contact coordinates
function forcex_get_contact_coordinates($post_id = null) {
    if ($post_id === null) {
        global $post;
        $post_id = $post ? $post->ID : 0;
    }
    
    if (!$post_id) {
        return array(
            'latitude' => '41.408903',
            'longitude' => '-81.865354',
            'zoom' => '15'
        );
    }
    
    $latitude = get_post_meta($post_id, '_forcex_contact_latitude', true);
    $longitude = get_post_meta($post_id, '_forcex_contact_longitude', true);
    $zoom = get_post_meta($post_id, '_forcex_contact_map_zoom', true);
    $api_key = get_post_meta($post_id, '_forcex_contact_map_api_key', true);
    
    return array(
        'latitude' => !empty($latitude) ? $latitude : '41.408903',
        'longitude' => !empty($longitude) ? $longitude : '-81.865354',
        'zoom' => !empty($zoom) ? $zoom : '15',
        'api_key' => !empty($api_key) ? $api_key : ''
    );
}

// Force WooCommerce to use custom templates - this intercepts wc_get_template() calls
add_filter('woocommerce_locate_template', 'forcex_woocommerce_locate_template', 10, 3);
function forcex_woocommerce_locate_template($template, $template_name, $template_path) {
    // Only override checkout and cart templates
    $custom_templates = array(
        'checkout/form-checkout.php' => 'woocommerce/checkout/form-checkout.php',
        'cart/cart.php' => 'woocommerce/cart/cart.php',
    );
    
    // Check if this is a template we want to override
    if (isset($custom_templates[$template_name])) {
        $custom_template = get_template_directory() . '/' . $custom_templates[$template_name];
        
        // If custom template exists, use it
        if (file_exists($custom_template)) {
            return $custom_template;
        }
    }
    
    // Otherwise, use default WooCommerce template location
    return $template;
}

// Override page template for WooCommerce pages - this intercepts template_include
add_filter('template_include', 'forcex_override_woocommerce_page_templates', 99);
function forcex_override_woocommerce_page_templates($template) {
    // Handle checkout pages
    if (function_exists('is_checkout') && is_checkout()) {
        // Check if we're on order received page using helper function
        if (function_exists('forcex_is_order_received_page') && forcex_is_order_received_page()) {
            // Order received (thank you) page - use special template
            $thankyou_template = get_template_directory() . '/woocommerce/checkout/page-thankyou.php';
            if (file_exists($thankyou_template)) {
                return $thankyou_template;
            }
            // Fallback: use checkout template which handles order received
            $wrapper_template = get_template_directory() . '/woocommerce/checkout/page-checkout.php';
            if (file_exists($wrapper_template)) {
                if (class_exists('WooCommerce')) {
                    global $checkout;
                    if (!isset($checkout) || !$checkout) {
                        $checkout = WC()->checkout();
                    }
                }
                return $wrapper_template;
            }
        } else {
            // Regular checkout page
            $wrapper_template = get_template_directory() . '/woocommerce/checkout/page-checkout.php';
            if (file_exists($wrapper_template)) {
                // Set up checkout object as global so template can access it
                if (class_exists('WooCommerce')) {
                    global $checkout;
                    if (!isset($checkout) || !$checkout) {
                        $checkout = WC()->checkout();
                    }
                }
                return $wrapper_template;
            }
        }
    }
    
    // Handle cart page
    if (function_exists('is_cart') && is_cart()) {
        $wrapper_template = get_template_directory() . '/woocommerce/cart/page-cart.php';
        if (file_exists($wrapper_template)) {
            return $wrapper_template;
        }
    }
    
    // Handle my account page
    if (function_exists('is_account_page') && is_account_page()) {
        $account_template = get_template_directory() . '/woocommerce/myaccount/page-myaccount.php';
        if (file_exists($account_template)) {
            return $account_template;
        }
    }
    
    return $template;
}