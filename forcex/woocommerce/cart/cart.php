<?php
/**
 * Cart Page Template
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart'); 

// Debug CSS loading
include get_template_directory() . '/woocommerce/cart/test-css.php';
?>

<style>
/* Cart Page Styles - Force custom design */
body.woocommerce-cart {
    background: white !important;
}

/* Force Tailwind utilities to work */
.woocommerce-cart-page .container-custom {
    max-width: 1360px !important;
    margin-left: auto !important;
    margin-right: auto !important;
    padding-left: 1.5rem !important;
    padding-right: 1.5rem !important;
}

.woocommerce-cart-page .grid {
    display: grid !important;
}

.woocommerce-cart-page .lg\:grid-cols-12 {
    grid-template-columns: repeat(12, minmax(0, 1fr)) !important;
}

.woocommerce-cart-page .lg\:col-span-9 {
    grid-column: span 9 / span 9 !important;
}

.woocommerce-cart-page .lg\:col-span-3 {
    grid-column: span 3 / span 3 !important;
}

@media (min-width: 1024px) {
    .woocommerce-cart-page .lg\:grid-cols-12 {
        grid-template-columns: repeat(12, minmax(0, 1fr)) !important;
    }
    
    .woocommerce-cart-page .lg\:col-span-9 {
        grid-column: span 9 / span 9 !important;
    }
    
    .woocommerce-cart-page .lg\:col-span-3 {
        grid-column: span 3 / span 3 !important;
    }
}

.cart-summary-box .woocommerce-Price-amount,
.cart-summary-box .woocommerce-Price-amount * {
    color: #000 !important;
}

#apply-promo {
    box-shadow: none !important;
}

#apply-promo:hover {
    box-shadow: none !important;
}

/* Ensure cart items display correctly */
.cart-item {
    display: flex;
    align-items: center;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #D9E2E7;
}

.cart-item:last-child {
    border-bottom: none;
}

.cart-item-image {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 4px;
}

.cart-item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.cart-item-title {
    font-size: 22px;
    font-weight: 600;
    color: #111827;
    margin-bottom: 0.25rem;
}

.cart-item-price {
    font-size: 22px;
    font-weight: 600;
    color: #000;
}

.cart-item-attributes {
    font-size: 14px;
    color: #748394;
}

.cart-summary-box {
    background: linear-gradient(180deg, #EEF2F6 0%, #F5F9FC 100%);
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.quantity-btn {
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.quantity-btn:hover:not(.disabled) {
    background: #f3f4f6;
    border-color: #9ca3af;
}

.quantity-btn.disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.quantity-input {
    font-weight: 500;
    text-align: center;
}

/* Desktop Layout */
@media (min-width: 769px) {
    .cart-item-desktop {
        display: flex;
    }
    
    .cart-item-mobile {
        display: none;
    }
}

/* Mobile Layout */
@media (max-width: 768px) {
    .cart-item-desktop {
        display: none;
    }
    
    .cart-item-mobile {
        display: block;
    }
    
    .cart-item-image-mobile {
        width: 80px;
        height: 80px;
    }
    
    .cart-item-image-mobile img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .cart-item-title-mobile {
        font-size: 18px;
        font-weight: 600;
        line-height: 1.4;
        color: #000;
    }
    
    .cart-item-price-mobile {
        font-size: 18px;
        font-weight: 600;
        color: #000;
    }
    
    .quantity-btn-mobile {
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }
}
</style>

<div class="woocommerce-cart-page container-custom bg-white py-8" style="max-width: 1360px; margin: 0 auto; padding-left: 1.5rem; padding-right: 1.5rem;">
    <!-- Page Header -->
    <div class="mb-8 text-center">
        <nav class="mb-6">
            <div class="flex justify-center">
                <ol class="flex items-center  text-base text-gray-500 px-4 py-2 rounded-full" style="background-color: #EEF2F6;">
                    <li><a href="<?php echo home_url(); ?>" class="hover:text-primary-500">Main</a></li>
                    <li class="flex items-center">
                        <span class="mx-2 text-gray-400">/</span>
                        <span class="text-gray-900 font-medium">Cart</span>
                    </li>
                </ol>
            </div>
        </nav>
        <h1 class="title-h1">Cart</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8" style="display: grid; grid-template-columns: repeat(1, minmax(0, 1fr)); gap: 2rem;">
        <!-- Cart Items -->
        <div class="lg:col-span-9" style="grid-column: span 1 / span 1;">
            <?php if (WC()->cart->is_empty()): ?>
                <div class="card text-center py-12">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Your cart is empty</h2>
                    <p class="text-gray-600 mb-6">Looks like you haven't added any items to your cart yet.</p>
                    <a href="<?php echo esc_url(home_url('/products')); ?>" class="btn-primary">
                        Continue Shopping
                    </a>
                </div>
            <?php else: 
                $cart_count = WC()->cart->get_cart_contents_count();
            ?>
                <!-- Products Count and Delete All Button -->
                <div class="flex justify-between items-center mb-6 pb-6" style="border-bottom: 1px solid #D9E2E7;">
                    <span style="color: #748394; font-size: 18px;"><?php echo esc_html($cart_count); ?> <?php echo $cart_count === 1 ? 'product' : 'products'; ?></span>
                    <button id="delete-all-cart" class="btn-white flex items-center gap-2">
                        DELETE ALL
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/removeIcon.svg" alt="Remove" class="w-5 h-5">
                    </button>
                </div>

                <form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
                    <?php do_action('woocommerce_before_cart_table'); ?>
                    
                    <div class="space-y-6">
                        <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item): ?>
                            <?php
                            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                            
                            if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)):
                                $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                            ?>
                                <div class="cart-item flex items-center gap-8 pb-6 border-b border-gray-200 last:border-b-0">
                                    <!-- Desktop Layout -->
                                    <div class="cart-item-desktop flex items-center gap-8 w-full">
                                        <!-- Product Image -->
                                        <div class="flex-shrink-0" style="border: 1px solid #D9E2E7; border-radius: 4px; overflow: hidden;">
                                            <?php
                                            $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('woocommerce_thumbnail', array('class' => 'cart-item-image')), $cart_item, $cart_item_key);
                                            if (!$product_permalink) {
                                                echo $thumbnail;
                                            } else {
                                                printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail);
                                            }
                                            ?>
                                        </div>
                                        
                                        <!-- Product Info and Controls -->
                                        <div class="flex-1 flex items-center justify-between gap-8">
                                            <!-- Product Name and Attributes -->
                                            <div class="flex-[1.5] min-w-0">
                                                <h3 class="cart-item-title title-h3 mb-1">
                                                    <?php
                                                    if (!$product_permalink) {
                                                        echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;');
                                                    } else {
                                                        echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s" class="hover:text-primary-500">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
                                                    }
                                                    ?>
                                                </h3>
                                                
                                                <div class="cart-item-attributes text-sm text-gray-600">
                                                    <?php
                                                    do_action('woocommerce_cart_item_data', $cart_item, $cart_item_key);
                                                    
                                                    if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                                                        echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            
                                            <!-- Price, Quantity, Total, Delete -->
                                            <div class="flex items-center gap-6 flex-shrink-0">
                                                <!-- Unit Price -->
                                                <div class="cart-item-price title-h3 whitespace-nowrap">
                                                    <?php echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); ?>
                                                </div>
                                                
                                                <!-- Quantity Selector -->
                                                <div class="flex items-center gap-1">
                                                    <button type="button" class="quantity-btn decrease-btn" style="width: 56px; height: 56px; background-color: white; border: 1px solid #D9E2E7; border-radius: 8px;" data-action="decrease" data-cart-key="<?php echo esc_attr($cart_item_key); ?>">
                                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M4 10H16" stroke="#96A2AF" stroke-width="2" stroke-linecap="round"/>
                                                        </svg>
                                                    </button>
                                                    <input type="text" class="quantity-input text-center" style="width: 56px; height: 56px; background-color: #EEF2F6; border: none; border-radius: 8px;" value="<?php echo esc_attr($cart_item['quantity']); ?>" readonly data-cart-key="<?php echo esc_attr($cart_item_key); ?>">
                                                    <button type="button" class="quantity-btn increase-btn" style="width: 56px; height: 56px; background-color: white; border: 1px solid #D9E2E7; border-radius: 8px;" data-action="increase" data-cart-key="<?php echo esc_attr($cart_item_key); ?>">
                                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M4 10H16M10 4V16" stroke="#25AAE1" stroke-width="2" stroke-linecap="round"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                                
                                                <!-- Total Price -->
                                                <div class="title-h3 whitespace-nowrap min-w-[100px] text-right">
                                                    <?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); ?>
                                                </div>
                                                
                                                <!-- Delete Button -->
                                                <button type="button" class="remove-cart-item p-2 transition-colors flex-shrink-0 hover:opacity-80" data-cart-key="<?php echo esc_attr($cart_item_key); ?>" aria-label="Remove item">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/removeIcon.svg" alt="Remove" class="w-5 h-5">
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Mobile Layout -->
                                    <div class="cart-item-mobile w-full">
                                        <div class="flex items-start gap-3">
                                            <!-- Product Image -->
                                            <div class="flex-shrink-0 cart-item-image-mobile" style="border: 1px solid #D9E2E7; border-radius: 4px; overflow: hidden;">
                                                <?php
                                                $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('woocommerce_thumbnail', array('class' => 'cart-item-image')), $cart_item, $cart_item_key);
                                                if (!$product_permalink) {
                                                    echo $thumbnail;
                                                } else {
                                                    printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail);
                                                }
                                                ?>
                                            </div>
                                            
                                            <!-- Product Info -->
                                            <div class="flex-1 min-w-0">
                                                <!-- Product Name and Unit Price Row -->
                                                <div class="flex items-start justify-between gap-2 mb-1">
                                                    <h3 class="cart-item-title-mobile title-h3 flex-1">
                                                        <?php
                                                        if (!$product_permalink) {
                                                            echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;');
                                                        } else {
                                                            echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s" class="hover:text-primary-500">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
                                                        }
                                                        ?>
                                                    </h3>
                                                    <div class="cart-item-price-mobile title-h3 whitespace-nowrap flex-shrink-0">
                                                        <?php echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); ?>
                                                    </div>
                                                </div>
                                                
                                                <!-- Attributes -->
                                                <div class="cart-item-attributes-mobile text-sm mb-3" style="color: #748394;">
                                                    <?php
                                                    do_action('woocommerce_cart_item_data', $cart_item, $cart_item_key);
                                                    
                                                    if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                                                        echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
                                                    }
                                                    ?>
                                                </div>
                                                
                                                <!-- Quantity Controls and Total Price Row -->
                                                <div class="flex items-center justify-between gap-3">
                                                    <!-- Quantity Selector -->
                                                    <div class="flex items-center ">
                                                        <button type="button" class="quantity-btn-mobile decrease-btn" style="width: 40px; height: 40px; background-color: white; border: 1px solid #D9E2E7; border-radius: 8px;" data-action="decrease" data-cart-key="<?php echo esc_attr($cart_item_key); ?>">
                                                            <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M4 10H16" stroke="#96A2AF" stroke-width="2" stroke-linecap="round"/>
                                                            </svg>
                                                        </button>
                                                        <input type="text" class="quantity-input-mobile text-center" style="width: 40px; height: 40px; background-color: #EEF2F6; border: none; border-radius: 8px; font-weight: 500;" value="<?php echo esc_attr($cart_item['quantity']); ?>" readonly data-cart-key="<?php echo esc_attr($cart_item_key); ?>">
                                                        <button type="button" class="quantity-btn-mobile increase-btn" style="width: 40px; height: 40px; background-color: white; border: 1px solid #D9E2E7; border-radius: 8px;" data-action="increase" data-cart-key="<?php echo esc_attr($cart_item_key); ?>">
                                                            <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M4 10H16M10 4V16" stroke="#23A6DD" stroke-width="2" stroke-linecap="round"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    
                                                    <!-- Total Price -->
                                                    <div class="title-h3 whitespace-nowrap">
                                                        <?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); ?>
                                                    </div>
                                                    
                                                    <!-- Delete Button -->
                                                    <button type="button" class="remove-cart-item-mobile flex-shrink-0 transition-colors hover:opacity-80" data-cart-key="<?php echo esc_attr($cart_item_key); ?>" aria-label="Remove item" style="width: 40px; height: 40px; background: linear-gradient(135deg, #045894 0%, #23A6DD 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/removewhite.svg" alt="Remove" class="w-4 h-4">
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    
                    <?php do_action('woocommerce_after_cart_table'); ?>
                </form>
            <?php endif; ?>
        </div>

        <!-- Cart Summary -->
        <div class="lg:col-span-3" style="grid-column: span 1 / span 1;">
            <div class="cart-summary-box bg-gray-50 rounded-lg p-6 sticky top-8" style="max-width: calc(100% + 20px);">
                <h3 class="text-xl font-semibold text-gray-900 mb-6">Summary</h3>
                
                <div class="space-y-4 mb-6">
                    <div class="flex justify-between text-gray-700">
                        <span>Subtotal:</span>
                        <span class="cart-subtotal font-medium" style="color: #000;"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
                    </div>
                    
                    <div class="flex justify-between text-gray-700">
                        <span>Discount:</span>
                        <span class="font-medium" style="color: #000;">
                            <?php 
                            $discount_total = WC()->cart->get_cart_discount_total();
                            echo $discount_total > 0 ? '-' . wc_price($discount_total) : wc_price(0);
                            ?>
                        </span>
                    </div>
                    
                    <div class="border-t border-gray-300 pt-4 mt-4">
                        <div class="flex justify-between text-gray-700">
                            <span>Total:</span>
                            <span class="cart-total title-h3"><?php echo WC()->cart->get_total(); ?></span>
                        </div>
                    </div>
                </div>
                
                <!-- Promo Code -->
                <div class="mb-6">
                    <div class="flex gap-2 items-stretch  ">
                        <input type="text" id="promo-code" name="promo_code" placeholder="Promo code" 
                               class="flex-1 min-w-0 px-4 py-3 border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm" style="border-radius: 20px;">
                        <button type="button" id="apply-promo" class="btn-outline px-4 py-3 text-sm whitespace-nowrap flex-shrink-0" style="min-width: 100px; max-width: 120px;">
                            APPLY
                        </button>
                    </div>
                </div>
                
                <!-- Checkout Temporarily Disabled Notice -->
                <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <div class="flex-1">
                            <h3 class="font-semibold text-yellow-900 mb-1">Checkout Temporarily Unavailable</h3>
                            <p class="text-sm text-yellow-800 mb-2">
                                Our checkout system is currently being updated to serve you better. 
                            </p>
                            <p class="text-sm text-yellow-800">
                                Please <a href="<?php echo esc_url(home_url('/contact')); ?>" class="underline font-medium hover:text-yellow-900">contact us</a> to complete your purchase, and we'll be happy to assist you.
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Checkout Button - Disabled -->
                <button disabled class="w-full text-center block px-6 py-3 rounded-lg bg-gray-300 text-gray-500 cursor-not-allowed opacity-60" style="font-weight: 600; text-transform: uppercase;">
                    GO TO CHECKOUT
                </button>
            </div>
        </div>
    </div>
</div>

<?php do_action('woocommerce_after_cart'); ?>
