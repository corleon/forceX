<?php
/**
 * Checkout Form Template
 */

defined('ABSPATH') || exit;

// Ensure checkout object exists
if (!$checkout) {
    echo '<div class="container-custom py-8"><div class="card text-center"><h2>Checkout Error</h2><p>Unable to load checkout. Please try again.</p></div></div>';
    return;
}

do_action('woocommerce_before_checkout_form', $checkout);

if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
    return;
}
?>

<style>
    .checkout-form input::placeholder,
    .checkout-form select::placeholder {
        color: #748394;
    }
    body.woocommerce-checkout {
        background-color: white !important;
    }
    
    body.woocommerce-checkout .container-custom,
    .woocommerce-checkout-page .container-custom {
        max-width: 1360px !important;
        margin-left: auto !important;
        margin-right: auto !important;
        padding-left: 1.5rem !important;
        padding-right: 1.5rem !important;
    }
    
    /* Force Tailwind grid to work */
    .woocommerce-checkout-page .grid {
        display: grid !important;
    }
    
    .woocommerce-checkout-page .lg\:grid-cols-2 {
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
    }
    
    @media (min-width: 1024px) {
        .woocommerce-checkout-page .lg\:grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        }
        
        .woocommerce-checkout-page .grid[style*="grid-template-columns"] {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        }
    }
    
    /* Shipping method radio buttons */
    .checkout-form input[type="radio"].shipping_method,
    .checkout-form input[type="radio"][name^="shipping_method"] {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        margin-right: 12px;
        cursor: pointer;
        position: relative;
        background-color: white;
    }
    .checkout-form input[type="radio"].shipping_method:not(:checked),
    .checkout-form input[type="radio"][name^="shipping_method"]:not(:checked) {
        border: 1px solid #BCCBD2;
    }
    .checkout-form input[type="radio"].shipping_method:checked,
    .checkout-form input[type="radio"][name^="shipping_method"]:checked {
        border: 5px solid #25AAE1;
    }
    
    /* Payment method radio buttons - same styling as delivery day */
    .checkout-form input[type="radio"][name="payment_method"] {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        margin-right: 12px;
        cursor: pointer;
        position: relative;
        background-color: white;
        outline: none;
        border: none;
    }
    .checkout-form input[type="radio"][name="payment_method"]:not(:checked) {
        border: 1px solid #BCCBD2 !important;
    }
    .checkout-form input[type="radio"][name="payment_method"]:checked {
        border: 5px solid #25AAE1 !important;
    }
    .checkout-form input[type="radio"][name="payment_method"]:focus {
        outline: none;
        box-shadow: none;
    }
    
    /* Privacy policy checkbox */
    .checkout-form input[type="checkbox"][name="privacy_policy"] {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        width: 20px;
        height: 20px;
        border: 1px solid #D9E2E7;
        border-radius: 4px;
        cursor: pointer;
        position: relative;
        background-color: white;
        outline: none;
    }
    .checkout-form input[type="checkbox"][name="privacy_policy"]:checked {
        background-color: #25AAE1;
        border-color: #25AAE1;
    }
    .checkout-form input[type="checkbox"][name="privacy_policy"]:checked::after {
        content: '✓';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-size: 14px;
        font-weight: bold;
    }
    .checkout-form input[type="checkbox"][name="privacy_policy"]:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(37, 170, 225, 0.2);
    }
</style>

<div class="woocommerce-checkout-page container-custom py-8" style="background-color: white; max-width: 1360px; margin: 0 auto; padding-left: 1.5rem; padding-right: 1.5rem;">
    <!-- Checkout Stepper -->
    <?php
    global $wp;
    $is_order_received = isset($wp->query_vars['order-received']);
    $active_step = $is_order_received ? 4 : 1;
    ?>
    <nav id="checkout-stepper" class="checkout-stepper mb-6" role="navigation" aria-label="Checkout progress">
        <div class="step <?php echo $active_step >= 1 ? 'active' : ''; ?>" data-step="1" role="button" tabindex="0" aria-label="Step 1: Personal information" aria-current="<?php echo $active_step === 1 ? 'true' : 'false'; ?>">
            <span class="step-number" aria-hidden="true">1</span>
            <span class="step-text">Personal information</span>
        </div>
        <span class="divider" aria-hidden="true">/</span>
        <div class="step <?php echo $active_step >= 2 ? 'active' : ''; ?>" data-step="2" role="button" tabindex="0" aria-label="Step 2: Delivery information" aria-current="<?php echo $active_step === 2 ? 'true' : 'false'; ?>">
            <span class="step-number" aria-hidden="true">2</span>
            <span class="step-text">Delivery</span>
        </div>
        <span class="divider" aria-hidden="true">/</span>
        <div class="step <?php echo $active_step >= 3 ? 'active' : ''; ?>" data-step="3" role="button" tabindex="0" aria-label="Step 3: Payment method" aria-current="<?php echo $active_step === 3 ? 'true' : 'false'; ?>">
            <span class="step-number" aria-hidden="true">3</span>
            <span class="step-text">Payment</span>
        </div>
        <span class="divider" aria-hidden="true">/</span>
        <div class="step <?php echo $active_step >= 4 ? 'active' : ''; ?>" data-step="4" role="button" tabindex="0" aria-label="Step 4: Order complete" aria-current="<?php echo $active_step === 4 ? 'true' : 'false'; ?>">
            <span class="step-number" aria-hidden="true">4</span>
            <span class="step-text">Complete</span>
        </div>
    </nav>

    <!-- Page Title -->
    <div class="mb-8 text-center">
        <h1 id="step-title" class="title-h1"><?php echo $is_order_received ? __('Order Complete', 'woocommerce') : __('Personal information', 'woocommerce'); ?></h1>
    </div>

    <form name="checkout" method="post" class="checkout woocommerce-checkout checkout-form" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8" style="display: grid; grid-template-columns: repeat(1, minmax(0, 1fr)); gap: 2rem;">
            <!-- Checkout Form -->
            <div id="checkout-form-column" style="border: 1px solid #D9E2E7;">
                <!-- Step 1: Personal Information -->
                <div id="step-1" class="step-content" role="tabpanel" aria-labelledby="step-1" aria-hidden="false">
                    <div class="bg-white p-8 md:p-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Fill in your personal information</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-row">
                                <label for="billing_first_name" class="block text-sm font-medium text-gray-700 mb-2 pl-4">
                                    First name *
                                </label>
                                <input type="text" id="billing_first_name" name="billing_first_name" required
                                       class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
                                       style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
                                       value="<?php echo esc_attr($checkout->get_value('billing_first_name')); ?>"
                                       placeholder="First name">
                            </div>
                            
                            <div class="form-row">
                                <label for="billing_last_name" class="block text-sm font-medium text-gray-700 mb-2 pl-4">
                                    Last name *
                                </label>
                                <input type="text" id="billing_last_name" name="billing_last_name" required
                                       class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
                                       style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
                                       value="<?php echo esc_attr($checkout->get_value('billing_last_name')); ?>"
                                       placeholder="Last name">
                            </div>
                            
                            <?php if (!is_user_logged_in()) : ?>
                            <div class="form-row">
                                <label for="billing_email" class="block text-sm font-medium text-gray-700 mb-2 pl-4">
                                    Email *
                                </label>
                                <input type="email" id="billing_email" name="billing_email" required
                                       class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
                                       style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
                                       value="<?php echo esc_attr($checkout->get_value('billing_email')); ?>"
                                       placeholder="Email">
                            </div>
                            <?php else : ?>
                            <?php 
                            // For logged-in users, email is already known - hide the field but include it as hidden
                            $current_user = wp_get_current_user();
                            $user_email = $current_user->user_email;
                            ?>
                            <input type="hidden" id="billing_email" name="billing_email" value="<?php echo esc_attr($user_email); ?>">
                            <?php endif; ?>
                            
                            <div class="form-row">
                                <label for="billing_phone" class="block text-sm font-medium text-gray-700 mb-2 pl-4">
                                    Phone *
                                </label>
                                <input type="tel" id="billing_phone" name="billing_phone" required
                                       class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
                                       style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
                                       value="<?php echo esc_attr($checkout->get_value('billing_phone')); ?>"
                                       placeholder="Phone">
                            </div>
                            
                            <div class="form-row">
                                <label for="billing_company" class="block text-sm font-medium text-gray-700 mb-2 pl-4">
                                    Company
                                </label>
                                <input type="text" id="billing_company" name="billing_company"
                                       class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
                                       style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
                                       value="<?php echo esc_attr($checkout->get_value('billing_company')); ?>"
                                       placeholder="Company">
                            </div>
                        </div>
                        
                        <div class="flex gap-4 mt-8">
                            <button type="button" id="prev-step-1" class="btn-outline" style="display: none;">
                                RETURN
                            </button>
                            <button type="button" id="next-step-1" class="btn-gradient">
                                SUBMIT
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Delivery -->
                <div id="step-2" class="step-content hidden" role="tabpanel" aria-labelledby="step-2" aria-hidden="true">
                    <div class="bg-white p-8 md:p-12">
                        <h3 class="mb-6" style="font-size: clamp(20px, 3vw, 28px); font-weight: 500; color: #111827;">Fill in the delivery address</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-row">
                                <label for="billing_country" class="block text-sm font-medium text-gray-700 mb-2 pl-4">
                                    Country/Region *
                                </label>
                                <select id="billing_country" name="billing_country" required
                                        class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
                                        style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none; appearance: none; background-image: url('data:image/svg+xml;charset=UTF-8,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"6 9 12 15 18 9\"></polyline></svg>'); background-repeat: no-repeat; background-position: right 16px center; background-size: 16px; padding-right: 40px;">
                                    <option value="">Choose your country</option>
                                    <?php
                                    $countries = WC()->countries->get_countries();
                                    foreach ($countries as $code => $name) {
                                        echo '<option value="' . esc_attr($code) . '" ' . selected($checkout->get_value('billing_country'), $code, false) . '>' . esc_html($name) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="form-row">
                                <label for="billing_state" class="block text-sm font-medium text-gray-700 mb-2 pl-4">
                                    State *
                                </label>
                                <input type="text" id="billing_state" name="billing_state" required
                                       class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
                                       style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
                                       value="<?php echo esc_attr($checkout->get_value('billing_state')); ?>"
                                       placeholder="State">
                            </div>
                            
                            <div class="form-row">
                                <label for="billing_city" class="block text-sm font-medium text-gray-700 mb-2 pl-4">
                                    City *
                                </label>
                                <input type="text" id="billing_city" name="billing_city" required
                                       class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
                                       style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
                                       value="<?php echo esc_attr($checkout->get_value('billing_city')); ?>"
                                       placeholder="City">
                            </div>
                            
                            <div class="form-row">
                                <label for="billing_postcode" class="block text-sm font-medium text-gray-700 mb-2 pl-4">
                                    Postal or zip code *
                                </label>
                                <input type="text" id="billing_postcode" name="billing_postcode" required
                                       class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
                                       style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
                                       value="<?php echo esc_attr($checkout->get_value('billing_postcode')); ?>"
                                       placeholder="Postal code">
                            </div>
                            
                            <div class="form-row md:col-span-2">
                                <label for="billing_address_1" class="block text-sm font-medium text-gray-700 mb-2 pl-4">
                                    Address *
                                </label>
                                <input type="text" id="billing_address_1" name="billing_address_1" required
                                       class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
                                       style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
                                       value="<?php echo esc_attr($checkout->get_value('billing_address_1')); ?>"
                                       placeholder="Address">
                            </div>
                        </div>
                        
                        <!-- Shipping Methods Selection -->
                        <div class="mt-8" id="shipping-methods-container">
                            <h3 class="mb-4" style="font-size: clamp(20px, 3vw, 28px); font-weight: 500; color: #111827;"><?php _e('Shipping method', 'woocommerce'); ?></h3>
                            <div class="p-4 rounded-lg" style="background-color: #EEF2F6;" id="shipping-methods-wrapper">
                                <?php
                                if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) {
                                    // Try to calculate shipping with current address if available
                                    $country = $checkout->get_value('billing_country');
                                    if ($country) {
                                        WC()->customer->set_billing_country($country);
                                        WC()->customer->set_shipping_country($country);
                                        if ($checkout->get_value('billing_state')) {
                                            WC()->customer->set_billing_state($checkout->get_value('billing_state'));
                                            WC()->customer->set_shipping_state($checkout->get_value('billing_state'));
                                        }
                                        if ($checkout->get_value('billing_postcode')) {
                                            WC()->customer->set_billing_postcode($checkout->get_value('billing_postcode'));
                                            WC()->customer->set_shipping_postcode($checkout->get_value('billing_postcode'));
                                        }
                                        WC()->cart->calculate_shipping();
                                    }
                                    
                                    $packages = WC()->shipping()->get_packages();
                                    $chosen_method = WC()->session->get('chosen_shipping_methods');
                                    
                                    if (!empty($packages)) {
                                        $has_methods = false;
                                        foreach ($packages as $i => $package) {
                                            $available_methods = $package['rates'];
                                            $method_count = count($available_methods);
                                            
                                            if ($method_count > 0) {
                                                $has_methods = true;
                                                $index = 0;
                                                foreach ($available_methods as $method_id => $method) {
                                                    $checked = (isset($chosen_method[$i]) && $chosen_method[$i] === $method_id) || ($index === 0 && !isset($chosen_method[$i]));
                                                    $method_label = $method->get_label();
                                                    $method_cost = $method->get_cost();
                                                    $method_cost_display = $method_cost > 0 ? wc_price($method_cost) : __('Free', 'woocommerce');
                                                    ?>
                                                    <label class="flex items-center justify-between bg-white p-4 rounded-lg cursor-pointer <?php echo $index < $method_count - 1 ? 'mb-3' : ''; ?>" style="background-color: white;">
                                                        <div class="flex items-center">
                                                            <input type="radio" name="shipping_method[<?php echo $i; ?>]" value="<?php echo esc_attr($method_id); ?>" id="shipping_method_<?php echo $i; ?>_<?php echo esc_attr(sanitize_title($method_id)); ?>" <?php checked($checked, true); ?> class="shipping_method">
                                                            <span class="text-gray-900 ml-3"><?php echo esc_html($method_label); ?></span>
                                                        </div>
                                                        <span class="text-gray-600"><?php echo $method_cost_display; ?></span>
                                                    </label>
                                                    <?php
                                                    $index++;
                                                }
                                            }
                                        }
                                        
                                        if (!$has_methods) {
                                            echo '<p class="text-gray-600" id="shipping-methods-message">' . __('Please enter your address above to see available shipping methods.', 'woocommerce') . '</p>';
                                        }
                                    } else {
                                        echo '<p class="text-gray-600" id="shipping-methods-message">' . __('Please enter your address above to see available shipping methods.', 'woocommerce') . '</p>';
                                    }
                                } else {
                                    echo '<p class="text-gray-600">' . __('Shipping is not required for this order.', 'woocommerce') . '</p>';
                                }
                                ?>
                            </div>
                        </div>
                        
                        <div class="flex gap-4 mt-8">
                            <button type="button" id="prev-step-2" class="btn-outline">
                                RETURN
                            </button>
                            <button type="button" id="next-step-2" class="btn-gradient">
                                SUBMIT
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Payment -->
                <div id="step-3" class="step-content hidden" role="tabpanel" aria-labelledby="step-3" aria-hidden="true">
                    <div class="bg-white p-8 md:p-12">
                        <h3 class="mb-6" style="font-size: clamp(20px, 3vw, 28px); font-weight: 500; color: #111827;">Choose the payment method</h3>
                        
                        <?php
                        // Get available payment gateways
                        $available_gateways = WC()->payment_gateways()->get_available_payment_gateways();
                        $chosen_payment_method = WC()->session->get('chosen_payment_method');
                        
                        // Helper function to get payment gateway icons
                        function forcex_get_payment_gateway_icons($gateway_id) {
                            $template_dir = get_template_directory();
                            $template_uri = get_template_directory_uri();
                            $icons = array();
                            
                            // Map gateway IDs to icons
                            $icon_map = array(
                                'paypal' => array('pypal.svg'),
                                'ppec_paypal' => array('pypal.svg'),
                                'bacs' => array('visa.svg', 'master.svg', 'amrxpres.svg', 'jcb.svg'),
                                'cheque' => array(),
                                'cod' => array(),
                                'stripe' => array('visa.svg', 'master.svg', 'amrxpres.svg', 'jcb.svg'),
                                'square' => array('visa.svg', 'master.svg', 'amrxpres.svg', 'jcb.svg'),
                                'authorize_net_cim' => array('visa.svg', 'master.svg', 'amrxpres.svg', 'jcb.svg'),
                                'authorize_net' => array('visa.svg', 'master.svg', 'amrxpres.svg', 'jcb.svg'),
                            );
                            
                            // Check if we have a specific mapping
                            if (isset($icon_map[$gateway_id])) {
                                foreach ($icon_map[$gateway_id] as $icon) {
                                    if (file_exists($template_dir . '/assets/img/' . $icon)) {
                                        $icons[] = $template_uri . '/assets/img/' . $icon;
                                    }
                                }
                            } else {
                                // Default: show credit card icons for any gateway that might accept cards
                                $default_icons = array('visa.svg', 'master.svg', 'amrxpres.svg', 'jcb.svg');
                                foreach ($default_icons as $icon) {
                                    if (file_exists($template_dir . '/assets/img/' . $icon)) {
                                        $icons[] = $template_uri . '/assets/img/' . $icon;
                                    }
                                }
                            }
                            
                            return $icons;
                        }
                        
                        if (!empty($available_gateways)) :
                            $first_gateway = true;
                        ?>
                            <div class="space-y-3">
                                <?php foreach ($available_gateways as $gateway_id => $gateway) : 
                                    $is_checked = ($first_gateway && !$chosen_payment_method) || $chosen_payment_method === $gateway_id;
                                    $gateway_icons = forcex_get_payment_gateway_icons($gateway_id);
                                ?>
                                    <label class="flex items-center justify-between p-4 rounded-lg cursor-pointer payment-method-option" style="background-color: #EEF2F6;" data-gateway-id="<?php echo esc_attr($gateway_id); ?>">
                                        <div class="flex items-center">
                                            <input type="radio" name="payment_method" value="<?php echo esc_attr($gateway_id); ?>" id="payment_method_<?php echo esc_attr($gateway_id); ?>" <?php checked($is_checked, true); ?>>
                                            <span class="text-gray-900 ml-3"><?php echo esc_html($gateway->get_title()); ?></span>
                                        </div>
                                        <?php if (!empty($gateway_icons)) : ?>
                                            <div class="flex items-center gap-2">
                                                <?php foreach ($gateway_icons as $icon_url) : ?>
                                                    <img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($gateway->get_title()); ?>" class="h-6">
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </label>
                                    
                                    <?php
                                    // Display payment gateway payment fields if available
                                    if ($gateway->has_fields() || $gateway->get_description()) {
                                        echo '<div class="payment_box payment_method_' . esc_attr($gateway_id) . '" style="display: ' . ($is_checked ? 'block' : 'none') . '; margin-top: 12px; padding: 16px; background-color: #F5F9FC; border-radius: 8px;">';
                                        if ($gateway->get_description()) {
                                            echo '<p class="text-sm text-gray-600 mb-2">' . wp_kses_post($gateway->get_description()) . '</p>';
                                        }
                                        // Output payment fields
                                        ob_start();
                                        $gateway->payment_fields();
                                        $payment_fields = ob_get_clean();
                                        echo $payment_fields;
                                        echo '</div>';
                                    }
                                    ?>
                                    
                                    <?php $first_gateway = false; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php else : ?>
                            <div class="p-4 rounded-lg" style="background-color: #FEE2E2; border: 1px solid #FECACA;">
                                <p class="text-red-600"><?php esc_html_e('Sorry, it seems that there are no available payment methods for your location. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce'); ?></p>
                            </div>
                        <?php endif; ?>
                        
                        <div class="mt-6">
                            <?php
                            // Use WooCommerce's built-in terms and conditions/privacy policy checkbox
                            if (wc_get_page_id('terms') > 0 && apply_filters('woocommerce_checkout_show_terms', true)) {
                                $terms_page_id = wc_terms_and_conditions_page_id();
                                if ($terms_page_id) {
                                    $terms_page = get_post($terms_page_id);
                                    if ($terms_page) {
                                        ?>
                                        <label class="flex items-center cursor-pointer">
                                            <input type="checkbox" name="terms" required class="mr-3 focus:ring-primary-500" style="width: 20px; height: 20px; border: 1px solid #D9E2E7; accent-color: #25AAE1; outline: none;" <?php checked(apply_filters('woocommerce_terms_is_checked_default', isset($_POST['terms'])), true); ?>>
                                            <span class="text-sm text-gray-700">
                                                <?php
                                                printf(
                                                    __('I have read and agree to the website %s', 'woocommerce'),
                                                    '<a href="' . esc_url(get_permalink($terms_page_id)) . '" class="woocommerce-terms-and-conditions-link" target="_blank">' . esc_html($terms_page->post_title) . '</a>'
                                                );
                                                ?>
                                            </span>
                                        </label>
                                        <?php
                                    }
                                }
                            }
                            
                            // Privacy policy checkbox
                            if (wc_get_page_id('privacy') > 0) {
                                $privacy_page_id = wc_privacy_policy_page_id();
                                if ($privacy_page_id) {
                                    $privacy_page = get_post($privacy_page_id);
                                    if ($privacy_page) {
                                        ?>
                                        <label class="flex items-center cursor-pointer mt-3">
                                            <input type="checkbox" name="privacy_policy" required class="mr-3 focus:ring-primary-500" style="width: 20px; height: 20px; border: 1px solid #D9E2E7; accent-color: #25AAE1; outline: none;" <?php checked(isset($_POST['privacy_policy']), true); ?>>
                                            <span class="text-sm text-gray-700">
                                                <?php
                                                printf(
                                                    __('I agree to the processing of my personal data as outlined in the %s', 'woocommerce'),
                                                    '<a href="' . esc_url(get_permalink($privacy_page_id)) . '" class="woocommerce-privacy-policy-link" target="_blank">' . esc_html($privacy_page->post_title) . '</a>'
                                                );
                                                ?>
                                            </span>
                                        </label>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </div>
                        
                        <div class="flex gap-4 mt-8">
                            <button type="button" id="prev-step-3" class="btn-outline">
                                RETURN
                            </button>
                            <button type="submit" id="pay-now" class="btn-gradient">
                                PAY NOW
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 4: Complete (This will be shown after order is placed via redirect) -->
                <?php
                // Check if we're on the order received page
                global $wp;
                $is_order_received = isset($wp->query_vars['order-received']);
                $step4_class = $is_order_received ? 'step-content' : 'step-content hidden';
                ?>
                <div id="step-4" class="<?php echo esc_attr($step4_class); ?>" role="tabpanel" aria-labelledby="step-4" aria-hidden="<?php echo $is_order_received ? 'false' : 'true'; ?>">
                    <div class="text-center">
                        <?php
                        // Check if we're on the order received page
                        global $wp;
                        if (isset($wp->query_vars['order-received'])) {
                            $order_id = absint($wp->query_vars['order-received']);
                            $order = wc_get_order($order_id);
                            
                            if ($order) {
                                ?>
                                <div class="px-6 py-3 mb-6 mx-auto inline-block" style="background-color: #EEF2F6; border-radius: 32px;">
                                    <p style="font-size: 20px; color: #25AAE1; font-weight: 500;"><?php printf(__('ORDER #%s', 'woocommerce'), $order->get_order_number()); ?></p>
                                </div>
                                <p class="mb-8 max-w-2xl mx-auto" style="font-size: 16px; font-weight: 400; color: #283440;">
                                    <?php echo apply_filters('woocommerce_thankyou_order_received_text', __('Thank you. Your order has been received.', 'woocommerce'), $order); ?>
                                </p>
                                <?php
                            }
                        } else {
                            // Fallback if order data not available
                            ?>
                            <div class="px-6 py-3 mb-6 mx-auto inline-block" style="background-color: #EEF2F6; border-radius: 32px;">
                                <p style="font-size: 20px; color: #25AAE1; font-weight: 500;"><?php _e('ORDER PLACED', 'woocommerce'); ?></p>
                            </div>
                            <p class="mb-8 max-w-2xl mx-auto" style="font-size: 16px; font-weight: 400; color: #283440;">
                                <?php _e('Thank you for your purchase! Your order is being processed. You\'ll receive shipping details soon.', 'woocommerce'); ?>
                            </p>
                            <?php
                        }
                        ?>
                        <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="btn-gradient">
                            <?php _e('CHECK MY ORDERS', 'woocommerce'); ?>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div id="order-summary-section">
                <div class="p-8 md:p-12 sticky top-8" style="background: linear-gradient(135deg, #EEF2F6 0%, #F5F9FC 100%);">
                    <h3 class="mb-6" style="font-size: clamp(20px, 3vw, 28px); font-weight: 500; color: #111827;">Summary</h3>
                    
                    <!-- Product List Card -->
                    <div class="bg-white rounded-lg p-4 mb-6">
                        <div class="space-y-0">
                            <?php 
                            $cart_items = WC()->cart->get_cart();
                            $item_count = count($cart_items);
                            $index = 0;
                            foreach ($cart_items as $cart_item_key => $cart_item): 
                                $index++;
                                $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                                $product_name = $_product->get_name();
                                $variation_data = '';
                                if ($_product->is_type('variation')) {
                                    $variation_attributes = $_product->get_variation_attributes();
                                    if (!empty($variation_attributes)) {
                                        $variation_data = implode(', ', array_values($variation_attributes));
                                    }
                                }
                                ?>
                                <div class="flex items-start space-x-3 pb-4 <?php echo $index < $item_count ? 'mb-4 border-b' : ''; ?>" style="<?php echo $index < $item_count ? 'border-color: #D9E2E7;' : ''; ?>">
                                    <div class="flex-shrink-0">
                                        <?php echo $_product->get_image('thumbnail', array('class' => 'w-16 h-16 object-cover', 'style' => 'border: 1px solid #D9E2E7 !important; border-radius: 4px;')); ?>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2">
                                            <h4 class="font-medium" style="font-size: 22px; color: #111827;">
                                                <?php echo esc_html($product_name); ?>
                                            </h4>
                                            <span style="font-size: 18px; color: #748394;">
                                                x<?php echo $cart_item['quantity']; ?>
                                            </span>
                                        </div>
                                        <?php if ($variation_data): ?>
                                            <p class="text-xs text-gray-500 mt-1"><?php echo esc_html($variation_data); ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="font-semibold" style="font-size: 22px; color: #1A1A1A;">
                                        <?php echo WC()->cart->get_product_subtotal($_product, $cart_item['quantity']); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4 space-y-3">
                        <div class="flex justify-between">
                            <span style="font-size: 22px; font-weight: 400; color: #283440;">Subtotal:</span>
                            <span style="font-size: 22px; font-weight: 400; color: #283440;"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
                        </div>
                        
                        <!-- Discount Code -->
                        <?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
                        <div class="flex justify-between items-center">
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-600"><?php echo esc_html($code); ?></span>
                                    <button type="button" class="remove-coupon text-primary-500 hover:text-primary-700" data-coupon="<?php echo esc_attr($code); ?>">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <span style="font-size: 22px; font-weight: 400; color: #283440;"><?php echo '-' . wc_price(WC()->cart->get_coupon_discount_amount($code)); ?></span>
                        </div>
                        <?php endforeach; ?>
                        
                        <?php if (WC()->cart->has_discount()) : ?>
                        <div class="flex justify-between items-center">
                            <span style="font-size: 22px; font-weight: 400; color: #283440;"><?php _e('Discount:', 'woocommerce'); ?></span>
                            <span style="font-size: 22px; font-weight: 400; color: #283440;" id="discount-amount"><?php echo '-' . WC()->cart->get_discount_total(); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Shipping Cost (shown on step 2 and 3) -->
                        <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
                        <div id="delivery-cost-row" class="hidden flex justify-between">
                            <span style="font-size: 22px; font-weight: 400; color: #283440;"><?php _e('Shipping:', 'woocommerce'); ?></span>
                            <span id="delivery-cost" class="woocommerce-shipping-total" style="font-size: 22px; font-weight: 400; color: #283440;"><?php echo WC()->cart->get_cart_shipping_total(); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Tax (if applicable) -->
                        <?php if (wc_tax_enabled() && !WC()->cart->display_prices_including_tax()) : ?>
                        <div id="tax-row" class="hidden flex justify-between">
                            <span style="font-size: 22px; font-weight: 400; color: #283440;"><?php _e('Tax:', 'woocommerce'); ?></span>
                            <span id="tax-amount" class="woocommerce-tax-total" style="font-size: 22px; font-weight: 400; color: #283440;"><?php echo WC()->cart->get_cart_tax(); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <div class="flex justify-between font-semibold text-gray-900 border-t border-gray-200 pt-3">
                            <span style="font-size: 22px; font-weight: 400; color: #283440;"><?php _e('Total:', 'woocommerce'); ?></span>
                            <span id="checkout-total" class="woocommerce-order-total" style="font-size: 28px; color: #1A1A1A;"><?php echo WC()->cart->get_total(); ?></span>
                        </div>
                    </div>
                    
                    <!-- Promo Code Section -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex gap-2">
                            <input type="text" id="promo-code" placeholder="Promo code" 
                                   class="flex-1 px-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                                   style="background-color: white; border-radius: 32px; height: 48px; border: 1px solid #E5E7EB;">
                            <button type="button" id="apply-promo" class="btn-outline" style="min-width: 100px; height: 48px;">
                                APPLY
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php do_action('woocommerce_checkout_after_customer_details'); ?>
        <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>
        <?php do_action('woocommerce_checkout_before_order_review'); ?>
        <?php do_action('woocommerce_checkout_after_order_review'); ?>
        
        <?php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce'); ?>
    </form>
</div>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>
