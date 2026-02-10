<?php
/**
 * Template Name: Products Page
 * Description: Products page with filters (All, Devices, Accessoires)
 */

defined('ABSPATH') || exit;

get_header();
?>

<main id="main" class="site-main relative">
    <div class="absolute inset-0" style=" background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/bgform.png'); background-position: center bottom; background-repeat: no-repeat; background-size: contain; z-index: 0;"></div>
    <div class="absolute inset-0" style="  pointer-events: none; z-index: 1;"></div>
    <div class="relative z-10">
    <!-- Breadcrumbs -->
    <div class="container-custom pt-12 pb-0 max-w-[1200px]">
        <nav class="mb-0">
            <div class="flex justify-center">
                <ol class="flex items-center  text-base text-gray-500 bg-white px-4 py-2 rounded-full">
                    <li><a href="<?php echo home_url(); ?>" class="hover:text-primary-500">Main</a></li>
                    <li class="flex items-center">
                        <span class="mx-2 text-gray-400">/</span>
                        <span class="text-gray-900 font-medium">Our products</span>
                    </li>
                </ol>
            </div>
        </nav>
    </div>

    <!-- Page Header -->
    <div class="container-custom pt-2 pb-8 max-w-[1200px]">
        <div class="text-center mb-8">
            <h1 class="title-h1 mb-6">Our products</h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto leading-relaxed" style="font-size: 22px;">
                ForceX powered by CDC Tech is the first system to deliver dynamic positive compression with intelligent heat and cold cycling.
            </p>
        </div>

        <!-- Filter Buttons -->
        <div class="flex justify-center mb-2">
            <div class="flex flex-wrap justify-center gap-1" style="background-color: #EEF2F6; border-radius: 32px; padding: 3px;">
                <button class="product-filter-btn active" data-filter="all">
                    All
                </button>
                <button class="product-filter-btn" data-filter="devices">
                    Devices
                </button>
                <button class="product-filter-btn" data-filter="accessoires">
                    Accessoires
                </button>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <section class="pt-2 pb-12">
        <div class="container-custom max-w-[1200px]">
            <div class="products-grid" id="products-grid">
                <?php
                // Get all products
                $products_query = forcex_get_all_products();
                
                if ($products_query->have_posts()):
                    while ($products_query->have_posts()): $products_query->the_post();
                        global $product;
                        
                        // Get product categories for filtering
                        $categories = wp_get_post_terms(get_the_ID(), 'product_cat', array('fields' => 'slugs'));
                        $category_class = ' filter-all'; // All products should show in "All"
                        $is_device = false;
                        $is_accessory = false;
                        
                        // Check for specific category slugs first
                        foreach ($categories as $cat_slug) {
                            $cat_slug_lower = strtolower($cat_slug);
                            // Check for devices category
                            if ($cat_slug_lower === 'devices' || $cat_slug_lower === 'device' || 
                                stripos($cat_slug_lower, 'device') !== false || 
                                stripos($cat_slug_lower, 'machine') !== false || 
                                stripos($cat_slug_lower, 'cx') !== false) {
                                $is_device = true;
                                $category_class .= ' filter-devices';
                            }
                            // Check for accessories category
                            if ($cat_slug_lower === 'accessoires' || $cat_slug_lower === 'accessories' || 
                                $cat_slug_lower === 'accessoire' || 
                                stripos($cat_slug_lower, 'accessor') !== false || 
                                stripos($cat_slug_lower, 'wrap') !== false) {
                                $is_accessory = true;
                                $category_class .= ' filter-accessoires';
                            }
                        }
                        
                        // If no specific category found, check product name as fallback
                        if (!$is_device && !$is_accessory) {
                            $product_name = strtolower($product->get_name());
                            if (stripos($product_name, 'wrap') !== false || 
                                stripos($product_name, 'ankle') !== false || 
                                stripos($product_name, 'knee') !== false || 
                                stripos($product_name, 'shoulder') !== false) {
                                $is_accessory = true;
                                $category_class .= ' filter-accessoires';
                            } else {
                                // Default to device if it's a therapy machine
                                $is_device = true;
                                $category_class .= ' filter-devices';
                            }
                        }
                ?>
                    <div class="product-card product-item<?php echo esc_attr($category_class); ?>">
                        <div class="relative">
                            <?php if (!$is_accessory): // Only show link for devices ?>
                                <a href="<?php echo esc_url($product->get_permalink()); ?>" class="block">
                            <?php else: ?>
                                <div class="block">
                            <?php endif; ?>
                                <?php if ($product->get_image()): ?>
                                    <?php echo $product->get_image('large', array('class' => 'w-full h-64 object-cover')); ?>
                                <?php else: ?>
                                    <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                <?php endif; ?>
                            <?php if (!$is_accessory): ?>
                                </a>
                            <?php else: ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($product->is_on_sale()): ?>
                                <span class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    Sale
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-4 mt-4" style="height: 1px; background-color: #D9E2E7; margin-left: -1.5rem; margin-right: -1.5rem; width: calc(100% + 3rem);"></div>
                        
                        <h3 class="title-h3 mb-2">
                            <?php if (!$is_accessory): // Only show link for devices ?>
                                <a href="<?php echo esc_url($product->get_permalink()); ?>" class="hover:text-primary-500 transition-colors">
                                    <?php echo $product->get_name(); ?>
                                </a>
                            <?php else: // No link for accessories ?>
                                <span class="text-gray-900">
                                    <?php echo $product->get_name(); ?>
                                </span>
                            <?php endif; ?>
                        </h3>
                        
                        <p class="mb-4" style="color: #303E4E; font-size: 22px;">
                            <?php 
                            $description = $product->get_short_description();
                            if (empty($description)) {
                                $description = $product->get_description();
                            }
                            if (empty($description)) {
                                $description = get_the_excerpt($product->get_id());
                            }
                            if (empty($description)) {
                                $description = 'Advanced therapy technology for optimal recovery and performance.';
                            }
                            echo wp_trim_words(wp_strip_all_tags($description), 15); 
                            ?>
                        </p>
                        
                        <?php if ($product->get_price()): ?>
                            <div class="mb-4" style="font-size: 36px; font-weight: bold; color: black;">
                                <?php echo $product->get_price_html(); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="flex items-center">
                            <div class="flex items-center tw-gap-0.5">
                                <button class="quantity-btn decrease-btn disabled" style="width: 56px; height: 56px; background-color: white; border: 1px solid #D9E2E7; border-radius: 0;" data-action="decrease">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4 10H16" stroke="#96A2AF" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </button>
                                <input type="text" class="quantity-input text-center" style="width: 56px; height: 56px; background-color: #EEF2F6; border: none; border-radius: 0;" value="1" data-product-id="<?php echo $product->get_id(); ?>">
                                <button class="quantity-btn increase-btn" style="width: 56px; height: 56px; background-color: white; border: 1px solid #D9E2E7; border-radius: 0;" data-action="increase">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4 10H16M10 4V16" stroke="#25AAE1" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </button>
                            </div>
                            <button class="btn-gradient purchase-btn ml-1" data-product-id="<?php echo $product->get_id(); ?>" style="display: inline-flex; align-items: center;">
                                <span>PURCHASE</span>
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else:
                ?>
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 text-lg">No products found.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Technology Section -->
    <section class="relative pt-20 pb-8">
        <div class="container-custom max-w-[1200px]">
            <div class="text-center mb-12">
                <h2 class="title-h2 mb-6">Technology</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto leading-relaxed" style="font-size: 18px;">
                    At ForceX™, we are redefining recovery through innovation. Our advanced therapy systems combine Cryothermic Dynamic Compression (CDC Tech™) with intelligent temperature control to deliver clinically effective heat and cold treatments – without the need for ice or bulky equipment.
                </p>
            </div>

            <!-- Feature Buttons -->
            <div class="flex flex-wrap justify-center gap-4 mb-32 pb-12" style="max-width: 700px; margin: 0 auto;">
                <div class="flex items-center gap-2" style="background-color: #FFFFFF; border-radius: 9999px; padding: 4px;">
                    <div class="flex items-center justify-center" style="width: 32px; height: 32px; background-color: #F0F2F5; border-radius: 50%;">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/21.svg" alt="Handle structure" style="width: 20px; height: 20px;">
                    </div>
                    <span style="font-size: 18px; color: #000000; font-weight: 500;">Handle structure</span>
                </div>
                <div class="flex items-center gap-2" style="background-color: #FFFFFF; border-radius: 9999px; padding: 4px;">
                    <div class="flex items-center justify-center" style="width: 32px; height: 32px; background-color: #F0F2F5; border-radius: 50%;">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/22.svg" alt="Iceless technology" style="width: 20px; height: 20px;">
                    </div>
                    <span style="font-size: 18px; color: #000000; font-weight: 500;">Iceless technology</span>
                </div>
                <div class="flex items-center gap-2" style="background-color: #FFFFFF; border-radius: 9999px; padding: 4px;">
                    <div class="flex items-center justify-center" style="width: 32px; height: 32px; background-color: #F0F2F5; border-radius: 50%;">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/23.svg" alt="Smart touchscreen" style="width: 20px; height: 20px;">
                    </div>
                    <span style="font-size: 18px; color: #000000; font-weight: 500;">Smart touchscreen</span>
                </div>
                <div class="flex items-center gap-2" style="background-color: #FFFFFF; border-radius: 9999px; padding: 4px;">
                    <div class="flex items-center justify-center" style="width: 32px; height: 32px; background-color: #F0F2F5; border-radius: 50%;">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/24.svg" alt="Program memory" style="width: 20px; height: 20px;">
                    </div>
                    <span style="font-size: 18px; color: #000000; font-weight: 500;">Program memory</span>
                </div>
                <div class="flex items-center gap-2" style="background-color: #FFFFFF; border-radius: 9999px; padding: 4px;">
                    <div class="flex items-center justify-center" style="width: 32px; height: 32px; background-color: #F0F2F5; border-radius: 50%;">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/25.svg" alt="Intuitive controls" style="width: 20px; height: 20px;">
                    </div>
                    <span style="font-size: 18px; color: #000000; font-weight: 500;">Intuitive controls</span>
                </div>
            </div>

            <!-- LEARN MORE Button -->
            <div class="text-center">
                <a href="<?php echo esc_url(home_url('/technology')); ?>" class="btn-gradient">
                    LEARN MORE
                </a>
            </div>
        </div>
    </section>

    <!-- Become a Distributor Section -->
    <section class="relative pt-8 pb-12 md:pb-24">
        <div class="container-custom" style="max-width: 900px; margin: 0 auto;">
            <!-- Form Section -->
            <div class="w-full bg-white p-8 md:p-12">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Become a distributor</h2>
                    <p class="text-gray-600">
                        Complete the form below, and our team will contact you with more information on distribution opportunities, pricing, and support.
                    </p>
                </div>

                <form id="products-distributor-form" class="forcex-contact-form" data-form-source="distributors">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="products_distributor_first_name" class="block text-sm font-medium text-gray-700 mb-2 pl-4">
                                First name *
                            </label>
                            <input type="text" id="products_distributor_first_name" name="first_name" required
                                   class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
                                   style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
                                   placeholder="Your name">
                        </div>
                        <div>
                            <label for="products_distributor_last_name" class="block text-sm font-medium text-gray-700 mb-2 pl-4">
                                Last name *
                            </label>
                            <input type="text" id="products_distributor_last_name" name="last_name" required
                                   class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
                                   style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
                                   placeholder="Your name">
                        </div>
                        <div>
                            <label for="products_distributor_email" class="block text-sm font-medium text-gray-700 mb-2 pl-4">
                                Email *
                            </label>
                            <input type="email" id="products_distributor_email" name="email" required
                                   class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
                                   style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
                                   placeholder="Email">
                        </div>
                        <div>
                            <label for="products_distributor_phone" class="block text-sm font-medium text-gray-700 mb-2 pl-4">
                                Phone number *
                            </label>
                            <input type="tel" id="products_distributor_phone" name="phone" required
                                   class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
                                   style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
                                   placeholder="Phone number">
                        </div>
                    </div>

                    <div id="products-distributor-form-message" class="mb-6 hidden"></div>

                    <div class="text-center">
                        <button type="submit" class="btn-gradient">
                            SUBMIT
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    </div>
</main>

<style>
.forcex-contact-form input::placeholder {
    color: #748394;
}

/* Background image covers whole page - handled inline in main tag */

/* Remove shadow and rounded corners from product cards */
body.page-products .product-card {
    box-shadow: none !important;
    border-radius: 0 !important;
    -webkit-box-shadow: none !important;
}

body.page-products .product-card img {
    border-radius: 0 !important;
}

/* Remove border radius from quantity controls */
body.page-products .quantity-btn,
body.page-products .quantity-input {
    border-radius: 0 !important;
}

.product-filter-btn {
    padding: 12px 24px;
    border-radius: 32px;
    font-weight: 600;
    transition: all 0.2s ease;
    background: white;
    border: none;
    color: #374151;
    cursor: pointer;
}

.product-filter-btn:not(.active) {
    background: white;
    color: #374151;
}

.product-filter-btn:not(.active):hover {
    background: white;
}

.product-filter-btn.active {
    background: linear-gradient(135deg, #25AAE1 0%, #004F8C 100%);
    color: white;
    border: none;
}

/* Add gap between quantity controls and purchase button */
body.page-products .product-card .flex.items-center {
    gap: 0.5rem;
}

.product-item {
    display: block;
}

.product-item.hidden {
    display: none;
}

/* Make accessories non-clickable (no pointer cursor) */
.product-item.filter-accessoires .relative > div.block {
    cursor: default;
}

.product-item.filter-accessoires h3 span {
    cursor: default;
}

/* Mobile-only styles - does not affect desktop */
@media (max-width: 768px) {
    /* Page Header Container - Mobile - Remove bottom padding */
    body.page-products .container-custom.pt-2.pb-8 {
        padding-bottom: 0 !important;
    }
    
    /* Page Header - Mobile */
    body.page-products .container-custom .text-center h1.title-h1 {
        font-size: clamp(28px, 8vw, 40px);
        margin-bottom: 1rem;
    }
    
    body.page-products .container-custom .text-center p {
        font-size: 16px !important;
        line-height: 1.5;
        padding: 0 1rem;
    }
    
    /* Filter Buttons - Mobile */
    body.page-products .product-filter-btn {
        padding: 10px 16px;
        font-size: 14px;
        font-weight: 600;
    }
    
    /* Reduce space between filters and products on mobile */
    body.page-products .flex.justify-center.mb-12 {
        margin-bottom: 1.5rem !important;
    }
    
    body.page-products section.py-12 {
        padding-top: 1.5rem !important;
    }
    
    /* Products Grid - Mobile */
    body.page-products .products-grid {
        gap: 1.5rem !important;
    }
    
    /* Product Cards - Mobile */
    body.page-products .product-card {
        padding: 1rem !important;
    }
    
    body.page-products .product-card img {
        height: 200px !important;
        object-fit: cover;
    }
    
    /* Product Title - Mobile */
    body.page-products .product-card .title-h3 {
        font-size: 18px !important;
        line-height: 1.3;
        margin-bottom: 0.75rem;
    }
    
    /* Product Description - Mobile */
    body.page-products .product-card p {
        font-size: 14px !important;
        line-height: 1.5;
        margin-bottom: 0.75rem;
        color: #303E4E;
    }
    
    /* Product Price - Mobile */
    body.page-products .product-card div[style*="font-size: 36px"] {
        font-size: 24px !important;
        margin-bottom: 1rem;
    }
    
 
    
    /* Keep quantity controls (plus/minus buttons and input) in one line */
    body.page-products .product-card .flex.items-center {
        gap: 0.5rem;
    }
    
    body.page-products .product-card .flex.items-center > div:first-child {
        width: auto;
        display: flex;
        justify-content: flex-start;
        flex-shrink: 0;
    }
    
    body.page-products .product-card .purchase-btn {
        width: 100%;
        justify-content: center;
        padding: 14px 24px;
        font-size: 14px;
        margin-left: 0 !important;
    }
    
    /* Quantity Buttons - Mobile */
    body.page-products .quantity-btn {
        width: 48px !important;
        height: 48px !important;
    }
    
    body.page-products .quantity-input {
        width: 48px !important;
        height: 48px !important;
        font-size: 16px;
    }
    
    /* Technology Section - Mobile */
    body.page-products section .flex.flex-wrap.justify-center.gap-4 {
        gap: 0.75rem !important;
        padding: 0 1rem;
    }
    
    body.page-products section .flex.items-center.gap-2 {
        padding: 6px 12px !important;
        font-size: 14px !important;
    }
    
    body.page-products section .flex.items-center.gap-2 > div:first-child {
        width: 28px !important;
        height: 28px !important;
    }
    
    body.page-products section .flex.items-center.gap-2 > div:first-child img {
        width: 16px !important;
        height: 16px !important;
    }
    
    /* Technology Section Text - Mobile */
    body.page-products section .text-center.mb-12 h2.title-h2 {
        font-size: clamp(24px, 6vw, 32px);
        margin-bottom: 1rem;
    }
    
    body.page-products section .text-center.mb-12 p {
        font-size: 16px !important;
        padding: 0 1rem;
        line-height: 1.6;
    }
    
    /* Form Section - Mobile */
    body.page-products section .bg-white {
        padding: 1.5rem !important;
    }
    
    body.page-products section .bg-white h2 {
        font-size: 24px !important;
        margin-bottom: 0.75rem;
    }
    
    body.page-products section .bg-white p {
        font-size: 14px !important;
        margin-bottom: 1.5rem;
    }
    
    body.page-products section .grid.grid-cols-1 {
        gap: 1rem !important;
    }
    
    /* Breadcrumbs - Mobile */
    body.page-products nav .flex.items-center {
        font-size: 12px;
        padding: 0.5rem 0.75rem;
    }
    
    /* Container Padding - Mobile */
    body.page-products .container-custom {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    /* Section Padding - Mobile */
    body.page-products section {
        padding-top: 1rem !important;
        padding-bottom: 1rem !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.product-filter-btn');
    const productItems = document.querySelectorAll('.product-item');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            // Update active state
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Filter products
            productItems.forEach(item => {
                if (filter === 'all') {
                    item.classList.remove('hidden');
                } else {
                    if (item.classList.contains('filter-' + filter)) {
                        item.classList.remove('hidden');
                    } else {
                        item.classList.add('hidden');
                    }
                }
            });
        });
    });
    
    // Quantity buttons are handled globally in main.js
    // No need for duplicate event listeners here
    
    // Purchase buttons
    const purchaseBtns = document.querySelectorAll('.purchase-btn');
    purchaseBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const quantityInput = this.parentElement.querySelector('.quantity-input');
            const quantity = parseInt(quantityInput.value) || 1;
            
            if (typeof forcex_ajax === 'undefined') {
                console.error('AJAX not available');
                return;
            }
            
            // Add to cart via AJAX
            fetch(forcex_ajax.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'forcex_add_to_cart',
                    product_id: productId,
                    quantity: quantity,
                    nonce: forcex_ajax.nonce
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update cart count
                    const cartCount = document.getElementById('cart-count');
                    if (cartCount) {
                        cartCount.textContent = data.data.cart_count;
                        cartCount.style.display = 'flex';
                    }
                    // Show success notification
                    const productName = data.data.product_name || 'Product';
                    showNotification(productName + ' added to cart!', 'success');
                } else {
                    showNotification('Error: ' + data.data, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred. Please try again.', 'error');
            });
        });
    });
});
</script>

<?php get_footer(); ?>

