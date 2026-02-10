<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Host+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
</head>

<body <?php body_class('bg-gray-50 text-gray-900'); ?>>
<?php wp_body_open(); ?>

<header id="main-header" class="<?php echo is_front_page() ? 'bg-transparent backdrop-blur-sm fixed md:bg-transparent md:backdrop-blur-none' : 'bg-white  border-b border-gray-200 sticky'; ?> top-0 z-30 w-full transition-colors duration-300">
    <div class="container-custom">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.svg" alt="FORCE" class="h-8 w-auto">
                </a>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center" role="navigation" aria-label="Main navigation">
                <div id="main-nav-items" class="flex items-center space-x-8 flex-nowrap">
                    <a href="<?php echo esc_url(home_url('/products')); ?>" class="nav-item text-gray-700 hover:text-primary-500 font-medium transition-colors duration-200 uppercase tracking-wide whitespace-nowrap">
                        OUR PRODUCTS
                    </a>
                    <a href="<?php echo esc_url(home_url('/company')); ?>" class="nav-item text-gray-700 hover:text-primary-500 font-medium transition-colors duration-200 uppercase tracking-wide whitespace-nowrap">
                        COMPANY
                    </a>
                    <a href="<?php echo esc_url(home_url('/rent-forcex')); ?>" class="nav-item text-gray-700 hover:text-primary-500 font-medium transition-colors duration-200 uppercase tracking-wide whitespace-nowrap">
                        RENT FORCEX
                    </a>
                    <a href="<?php echo esc_url(home_url('/blog')); ?>" class="nav-item text-gray-700 hover:text-primary-500 font-medium transition-colors duration-200 uppercase tracking-wide whitespace-nowrap">
                        BLOG
                    </a>
 
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="nav-item text-gray-700 hover:text-primary-500 font-medium transition-colors duration-200 uppercase tracking-wide whitespace-nowrap">
                        CONTACTS
                    </a>
                </div>
                <!-- More Dropdown -->
                <div id="nav-more-dropdown" class="relative ml-4 hidden">
                    <button id="nav-more-toggle" class="text-gray-700 hover:text-primary-500 font-medium transition-colors duration-200 uppercase tracking-wide whitespace-nowrap flex items-center">
                        MORE
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="nav-more-menu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50 hidden">
                        <div id="nav-more-items" class="flex flex-col">
                            <!-- Items will be moved here dynamically -->
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Right side icons and buttons -->
            <div class="flex items-center  md:space-x-2">
                <!-- Cart Icon - Desktop only -->
                <a href="<?php echo esc_url(wc_get_cart_url()); ?>" id="mini-cart-toggle" class="hidden md:block relative p-2 text-gray-700 hover:text-primary-500 transition-colors duration-200" aria-label="Shopping cart">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/cart.svg" alt="Cart" class="w-[48px] h-[48px]">
                    <span id="cart-count" class="w-6 h-6 left-0 top-0 absolute bg-primary-500 text-white font-bold rounded-full border border-white shadow-sm md:flex md:items-center md:justify-center" style="display: <?php echo (function_exists('WC') && WC()->cart && !WC()->cart->is_empty()) ? 'block' : 'none'; ?>">
                        <?php echo (function_exists('WC') && WC()->cart) ? WC()->cart->get_cart_contents_count() : '0'; ?>
                    </span>
                </a>

                <!-- Account Icon - Desktop only -->
                <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="hidden md:block p-2 text-gray-700 hover:text-primary-500 transition-colors duration-200" aria-label="My account">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/login.svg" alt="Login" class="w-[48px] h-[48px]">
                </a>

                <!-- Get ForceX Button -->
                <a href="<?php echo esc_url(home_url('/products')); ?>" class="btn-primary hidden md:inline-flex">
                    Get ForceX
                </a>

                <!-- Mobile menu toggle - Circular blue button with two white lines -->
                <button id="mobile-menu-toggle" class="md:hidden" aria-label="Toggle mobile menu">
                    <div>
                        <span></span>
                        <span></span>
                    </div>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <nav id="mobile-menu" class="hidden md:hidden py-6 <?php echo is_front_page() ? 'mobile-menu-home border-t border-gray-200/30 bg-transparent backdrop-blur-sm' : 'border-t border-gray-200 bg-white'; ?>" role="navigation" aria-label="Mobile navigation">
            <div class="flex flex-col space-y-6">
                <a href="<?php echo esc_url(home_url('/products')); ?>" class="text-gray-700 hover:text-primary-500 font-medium transition-colors duration-200 uppercase tracking-wide py-2">
                    OUR PRODUCTS
                </a>
                <a href="<?php echo esc_url(home_url('/company')); ?>" class="text-gray-700 hover:text-primary-500 font-medium transition-colors duration-200 uppercase tracking-wide py-2">
                    COMPANY
                </a>
                <a href="<?php echo esc_url(home_url('/rent-forcex')); ?>" class="text-gray-700 hover:text-primary-500 font-medium transition-colors duration-200 uppercase tracking-wide py-2">
                    RENT FORCEX
                </a>
                <a href="<?php echo esc_url(home_url('/blog')); ?>" class="text-gray-700 hover:text-primary-500 font-medium transition-colors duration-200 uppercase tracking-wide py-2">
                    BLOG
                </a>
                <a href="<?php echo esc_url(home_url('/design-system')); ?>" class="text-gray-700 hover:text-primary-500 font-medium transition-colors duration-200 uppercase tracking-wide py-2">
                    DESIGN SYSTEM
                </a>
                <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="text-gray-700 hover:text-primary-500 font-medium transition-colors duration-200 uppercase tracking-wide py-2">
                    CONTACTS
                </a>
                
                <!-- Mobile Cart and Login -->
                <div class="pt-4 border-t border-gray-200 flex items-center gap-4">
                    <!-- Mobile Cart Icon -->
                    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" id="mobile-mini-cart-toggle" class="relative flex items-center gap-2 text-gray-700 hover:text-primary-500 transition-colors duration-200" aria-label="Shopping cart">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/cart.svg" alt="Cart" class="w-6 h-6">
                        <span class="font-medium uppercase tracking-wide">Cart</span>
                        <span id="mobile-cart-count" class="w-5 h-5 bg-primary-500 text-white text-xs font-bold rounded-full flex items-center justify-center flex-shrink-0" style="display: <?php echo (function_exists('WC') && WC()->cart && !WC()->cart->is_empty()) ? 'flex' : 'none'; ?>">
                            <?php echo (function_exists('WC') && WC()->cart) ? WC()->cart->get_cart_contents_count() : '0'; ?>
                        </span>
                    </a>
                    
                    <!-- Mobile Account Icon -->
                    <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="flex items-center gap-2 text-gray-700 hover:text-primary-500 transition-colors duration-200" aria-label="My account">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/login.svg" alt="Login" class="w-6 h-6">
                        <span class="font-medium uppercase tracking-wide">Login</span>
                    </a>
                </div>
                
                <!-- Mobile Get ForceX Button -->
                <div class="pt-4 border-t border-gray-200">
                    <a href="<?php echo esc_url(home_url('/products')); ?>" class="btn-primary w-full text-center block">
                        Get ForceX
                    </a>
                </div>
            </div>
        </nav>
    </div>
</header>

<!-- Mini Cart Drawer -->
<div id="mini-cart" class="drawer closed">
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Shopping Cart</h3>
            <button id="mini-cart-close" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <div id="mini-cart-content">
            <?php if (function_exists('WC') && WC()->cart && !WC()->cart->is_empty()): ?>
                <div class="space-y-4">
                    <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item): ?>
                        <?php
                        $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                        $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                        ?>
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <?php echo $_product->get_image('thumbnail'); ?>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-medium text-gray-900 truncate">
                                    <?php echo $_product->get_name(); ?>
                                </h4>
                                <p class="text-sm text-gray-500">
                                    <?php echo WC()->cart->get_product_price($_product); ?>
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="text-sm text-gray-900"><?php echo $cart_item['quantity']; ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex justify-between text-lg font-semibold text-gray-900 mb-4">
                        <span>Subtotal:</span>
                        <span><?php echo WC()->cart->get_cart_subtotal(); ?></span>
                    </div>
                    <div class="space-y-2">
                        <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="btn-outline w-full text-center">
                            Go to cart
                        </a>
                        <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="btn-primary w-full text-center">
                            Checkout
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="text-center py-8">
                    <p class="text-gray-500">Your cart is empty</p>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-primary mt-4">
                        Continue Shopping
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Email Gate Modal -->
<div id="email-gate-modal" class="modal hidden">
    <div class="modal-content">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">You're almost there</h2>
        <form id="email-gate-form">
            <div class="mb-6">
                <label for="email-gate-email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Address
                </label>
                <input type="email" id="email-gate-email" name="email" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                       placeholder="Enter your email address">
            </div>
            <button type="submit" id="email-gate-submit" class="btn-primary w-full">
                CONTINUE TO CHECKOUT
            </button>
        </form>
    </div>
</div>

<main id="main" class="min-h-screen">
