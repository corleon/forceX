<?php
/**
 * Single Product Template
 * Overrides: woocommerce/single-product.php
 */

defined('ABSPATH') || exit;

get_header('shop');
?>

<main id="main" class="site-main">
    <?php while (have_posts()) : the_post(); ?>
        <?php global $product; ?>
        
        <div class="container-custom lg:mt-20">
            <!-- Product Content: Two Columns (50% each) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-16">
                <!-- Left Column: Product Image + Quick Start Guide -->
                <div class="flex flex-col">
                    <!-- Thumbnail Gallery (Vertical) + Main Image -->
                    <div class="flex flex-col lg:flex-row gap-2 mb-8 items-start">
                        <!-- Main Product Image (First on Mobile, Second on Desktop) -->
                        <div class="flex-1 w-full order-1 lg:order-2 mb-4 lg:mb-0" id="main-image-container">
                            <?php 
                            $main_image_id = $product->get_image_id();
                            if ($main_image_id) {
                                echo wp_get_attachment_image($main_image_id, 'large', false, array('class' => 'w-full h-auto object-cover rounded-lg', 'id' => 'main-product-image'));
                            } else {
                                echo '<div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>';
                            }
                            ?>
                        </div>
                        
                        <!-- Thumbnail Gallery (Below Main Image on Mobile, Left Side on Desktop) -->
                        <div class="product-images-column flex-shrink-0 w-full lg:w-[95px] lg:sticky lg:top-8 lg:self-start order-2 lg:order-1">
                            <div class="flex flex-row lg:flex-col space-x-2 lg:space-x-0 lg:space-y-3 overflow-x-auto lg:overflow-y-auto thumbnail-container">
                                <?php
                                $main_image_id = $product->get_image_id();
                                $attachment_ids = $product->get_gallery_image_ids();
                                $all_images = array();
                                
                                // Add main image first if it exists
                                if ($main_image_id) {
                                    $all_images[] = $main_image_id;
                                }
                                
                                // Add gallery images, excluding the main image if it's already there
                                if ($attachment_ids) {
                                    foreach ($attachment_ids as $img_id) {
                                        // Only add if it's not the main image (to avoid duplicates)
                                        if ($img_id != $main_image_id) {
                                            $all_images[] = $img_id;
                                        }
                                    }
                                }
                                
                                if (!empty($all_images)) {
                                    foreach ($all_images as $index => $img_id) {
                                        $img_url = wp_get_attachment_image_url($img_id, 'thumbnail');
                                        $full_url = wp_get_attachment_image_url($img_id, 'large');
                                        $is_active = ($index === 0) ? 'active border-primary-500' : 'border-transparent';
                                        ?>
                                        <button class="thumbnail-btn w-full lg:w-full border-2 <?php echo esc_attr($is_active); ?> hover:border-primary-500 transition-colors p-1 bg-white rounded flex-shrink-0 overflow-hidden" 
                                                data-image-id="<?php echo esc_attr($img_id); ?>"
                                                onclick="changeMainImage('<?php echo esc_js($full_url); ?>', <?php echo esc_js($img_id); ?>)">
                                            <div class="thumbnail-img-wrapper">
                                                <?php echo wp_get_attachment_image($img_id, 'thumbnail', false, array('class' => 'thumbnail-img')); ?>
                                            </div>
                                        </button>
                                        <?php
                                    }
                                } else {
                                    // Fallback if no images
                                    echo '<div class="w-full h-20 bg-gray-200 rounded flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Start Guide & User Manual -->
                    <?php
                    $manual_url = get_post_meta($product->get_id(), '_product_manual_url', true);
                    if (empty($manual_url)) {
                        $manual_url = '#';
                    }
                    ?>
                    <div class="bg-gradient-to-r from-primary-500 to-primary-700 p-8 rounded-lg text-white">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold mb-2">Quick start Guide & User Manual</h3>
                                <p class="text-base opacity-90 mb-4">Get step-by-step instructions to set up and start using your device quickly and easily.</p>
                                <a href="<?php echo esc_url($manual_url); ?>" 
                                   class="inline-block bg-white text-primary-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                                    SEE GUIDE
                                </a>
                            </div>
                            <div class="ml-6 flex-shrink-0">
                                <svg class="w-20 h-20 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Breadcrumbs + Product Details -->
                <div class="flex flex-col">
                    <!-- Breadcrumbs at the top of right column -->
                    <nav class="mb-6">
                        <ol class="flex items-center  text-sm text-gray-500 bg-white px-3 py-1.5 md:px-4 md:py-2 rounded-full product-breadcrumbs">
                            <li><a href="<?php echo home_url(); ?>" class="hover:text-primary-500">Main</a></li>
                            <li class="flex items-center">
                                <span class="mx-1.5 md:mx-2 text-gray-400">/</span>
                                <a href="<?php echo home_url('/products'); ?>" class="hover:text-primary-500">Our products</a>
                            </li>
                            <li class="flex items-center">
                                <span class="mx-1.5 md:mx-2 text-gray-400">/</span>
                                <span class="text-gray-900 font-medium text-xs md:text-sm"><?php echo esc_html($product->get_name()); ?></span>
                            </li>
                        </ol>
                    </nav>

                    <!-- Product Details -->
                    <div class="product-details-column">
                    <!-- Product Title -->
                    <h1 class="title-h1 mb-2"><?php echo esc_html($product->get_name()); ?></h1>
                    
                    <!-- Product Subtitle/Tagline -->
                    <?php 
                    $subtitle = get_post_meta($product->get_id(), '_product_subtitle', true);
                    if (empty($subtitle)) {
                        $subtitle = $product->get_short_description();
                    }
                    if (!empty($subtitle)): ?>
                        <p class="text-xl text-gray-600 mb-6"><?php echo esc_html($subtitle); ?></p>
                    <?php endif; ?>

                    <!-- Price -->
                    <div class="mb-6">
                        <div class="text-4xl font-bold text-gray-900">
                            <?php echo $product->get_price_html(); ?>
                        </div>
                    </div>

                    <!-- Quantity and Add to Cart -->
                    <div class="flex items-center mb-8">
                        <div class="flex items-center gap-1 mr-4">
                            <button class="quantity-btn decrease-btn disabled mobile-quantity-btn" 
                                    style="width: 56px; height: 56px; background-color: white; border: 1px solid #D9E2E7; border-radius: 0;" 
                                    data-action="decrease">
                                <svg class="mobile-quantity-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 10H16" stroke="#96A2AF" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </button>
                            <input type="number" 
                                   class="quantity-input text-center mobile-quantity-input" 
                                   style="width: 56px; height: 56px; background-color: #EEF2F6; border: none; border-radius: 0; cursor: text;" 
                                   value="1" 
                                   min="1" 
                                   id="product-quantity"
                                   inputmode="numeric"
                                   pattern="[0-9]*">
                            <button class="quantity-btn increase-btn mobile-quantity-btn" 
                                    style="width: 56px; height: 56px; background-color: white; border: 1px solid #D9E2E7; border-radius: 0;" 
                                    data-action="increase">
                                <svg class="mobile-quantity-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 10H16M10 4V16" stroke="#25AAE1" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </button>
                        </div>
                        <button class="btn-gradient add-to-cart-btn flex items-center mobile-add-to-cart-btn" 
                                data-product-id="<?php echo esc_attr($product->get_id()); ?>"
                                style="padding: 16px 32px;">
                            <span>ADD TO CART</span>
                            <svg class="w-5 h-5 ml-2 mobile-cart-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Specifications -->
                    <?php
                    $attributes = $product->get_attributes();
                    if (!empty($attributes)): ?>
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold mb-4">Specifications</h2>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <?php
                            foreach ($attributes as $attribute) {
                                $attribute_name = $attribute->get_name();
                                $attribute_label = wc_attribute_label($attribute_name);
                                
                                // Check if it's a taxonomy attribute or custom attribute
                                if ($attribute->is_taxonomy()) {
                                    // Taxonomy-based attribute
                                    $terms = wc_get_product_terms($product->get_id(), $attribute_name, array('fields' => 'names'));
                                    if (!empty($terms)) {
                                        $value_display = implode(', ', array_map('esc_html', $terms));
                                    } else {
                                        continue;
                                    }
                                } else {
                                    // Custom attribute
                                    $attribute_values = $attribute->get_options();
                                    if (!empty($attribute_values)) {
                                        $value_display = implode(', ', array_map('esc_html', $attribute_values));
                                    } else {
                                        continue;
                                    }
                                }
                                
                                if (!empty($value_display)): ?>
                                    <div class="flex items-center gap-3">
                                        <div class="spec-attribute-name"><?php echo esc_html($attribute_label); ?></div>
                                        <div class="spec-attribute-value"><?php echo $value_display; ?></div>
                                    </div>
                                <?php endif;
                            }
                            ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Description -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold mb-4">Description</h2>
                        <div class="text-gray-700 leading-relaxed">
                            <?php 
                            $description = $product->get_description();
                            if (empty($description)) {
                                $description = $product->get_short_description();
                            }
                            if (empty($description)) {
                                $description = 'ForceX is an advanced therapy device designed for efficient, user-friendly recovery.';
                            }
                            echo wp_kses_post(wpautop($description)); 
                            ?>
                        </div>
                    </div>

                    <!-- Components -->
                    <?php
                    $components = get_post_meta($product->get_id(), '_product_components', true);
                    if (!empty($components)): ?>
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold mb-4">Components</h2>
                        <div class="text-gray-700 text-base" style="color: #4A4A4A;">
                            <?php echo esc_html($components); ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Types of Therapies -->
                    <?php
                    $therapy_types = get_post_meta($product->get_id(), '_product_therapy_types', true);
                    if (!empty($therapy_types) && is_array($therapy_types)): ?>
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold mb-4">Types of therapies</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <?php
                            foreach ($therapy_types as $therapy) {
                                if (!empty($therapy['name'])) {
                                    $icon_path = get_template_directory_uri() . '/assets/img/';
                                    $icons = !empty($therapy['icons']) && is_array($therapy['icons']) ? $therapy['icons'] : array();
                                    
                                    // Build icon HTML from multiple icons
                                    $icon_html = '';
                                    if (!empty($icons)) {
                                        $icon_html = '<div class="flex items-center gap-1">';
                                        foreach ($icons as $icon_type) {
                                            if ($icon_type === 'snow') {
                                                $icon_html .= '<img src="' . esc_url($icon_path . 'snow.svg') . '" alt="Cold" class="w-6 h-6" />';
                                            } elseif ($icon_type === 'fire') {
                                                $icon_html .= '<img src="' . esc_url($icon_path . 'fire.svg') . '" alt="Heat" class="w-6 h-6" />';
                                            } elseif ($icon_type === 'circle') {
                                                $icon_html .= '<img src="' . esc_url($icon_path . 'circle.svg') . '" alt="Compression" class="w-6 h-6" />';
                                            }
                                        }
                                        $icon_html .= '</div>';
                                    }
                                    ?>
                                    <div class="flex items-center ">
                                        <?php if (!empty($icon_html)): ?>
                                            <span class="flex-shrink-0"><?php echo $icon_html; ?></span>
                                        <?php endif; ?>
                                        <span class="text-gray-900 text-base" style="color: #1A1A1A;"><?php echo esc_html($therapy['name']); ?></span>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Frequently Bought Together Section -->
                    <?php
                    // Get accessories automatically based on product name
                    $current_product_name = $product->get_name();
                    $product_model = ''; // CX3, CX5, or CX9
                    
                    // Detect which model this is
                    if (stripos($current_product_name, 'CX3') !== false) {
                        $product_model = 'CX3';
                    } elseif (stripos($current_product_name, 'CX5') !== false) {
                        $product_model = 'CX5';
                    } elseif (stripos($current_product_name, 'CX9') !== false) {
                        $product_model = 'CX9';
                    }
                    
                    // Query for accessories
                    $accessories_query = new WP_Query(array(
                        'post_type' => 'product',
                        'posts_per_page' => -1,
                        'post_status' => 'publish',
                        'post__not_in' => array($product->get_id()), // Exclude current product
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field' => 'slug',
                                'terms' => array('accessoires', 'accessories', 'accessoire'),
                                'operator' => 'IN'
                            )
                        )
                    ));
                    
                    // Filter accessories based on model compatibility
                    $cross_sell_ids = array();
                    if ($accessories_query->have_posts()) {
                        while ($accessories_query->have_posts()) {
                            $accessories_query->the_post();
                            $accessory_name = get_the_title();
                            
                            // Check if accessory has a specific model in its name
                            $has_cx3 = stripos($accessory_name, 'CX3') !== false;
                            $has_cx5 = stripos($accessory_name, 'CX5') !== false;
                            $has_cx9 = stripos($accessory_name, 'CX9') !== false;
                            $has_any_model = $has_cx3 || $has_cx5 || $has_cx9;
                            
                            // Include if:
                            // 1. No model in name (universal accessory), OR
                            // 2. Matches current product model
                            if (!$has_any_model || 
                                ($product_model === 'CX3' && $has_cx3) ||
                                ($product_model === 'CX5' && $has_cx5) ||
                                ($product_model === 'CX9' && $has_cx9)) {
                                $cross_sell_ids[] = get_the_ID();
                            }
                        }
                        wp_reset_postdata();
                    }
                    
                    if (!empty($cross_sell_ids)): ?>
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold mb-6">Frequently bought together</h2>
                        <div class="bg-white p-6 rounded-lg border border-gray-200">
                            <div class="space-y-4" id="frequently-bought-together">
                                <!-- Cross-sell Products -->
                                <?php
                                foreach ($cross_sell_ids as $cross_sell_id) {
                                    $cross_sell_product = wc_get_product($cross_sell_id);
                                    if (!$cross_sell_product || !$cross_sell_product->is_purchasable()) continue;
                                    
                                    // Check if product has variations (for size/type dropdowns)
                                    $is_variable = $cross_sell_product->is_type('variable');
                                    $product_name_lower = strtolower($cross_sell_product->get_name());
                                    $has_size_options = (stripos($product_name_lower, 'wrap') !== false || 
                                                        stripos($product_name_lower, 'knee') !== false ||
                                                        stripos($product_name_lower, 'foot') !== false);
                                    ?>
                                    <div class="flex flex-col lg:flex-row items-start lg:items-center space-y-3 lg:space-y-0 lg:space-x-4 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors fbt-item">
                                        <div class="flex items-center space-x-3 w-full lg:w-auto">
                                            <input type="checkbox" 
                                                   class="fbt-checkbox w-5 h-5 text-primary-500 border-gray-300 rounded cursor-pointer flex-shrink-0" 
                                                   data-product-id="<?php echo esc_attr($cross_sell_id); ?>">
                                            <div class="flex-shrink-0">
                                                <?php 
                                                $cross_sell_thumb = $cross_sell_product->get_image_id();
                                                if ($cross_sell_thumb) {
                                                    echo wp_get_attachment_image($cross_sell_thumb, 'thumbnail', false, array('class' => 'w-20 h-20 object-cover rounded'));
                                                } else {
                                                    echo '<div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center">
                                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                    </div>';
                                                }
                                                ?>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h3 class="font-semibold text-gray-900 mb-1"><?php echo esc_html($cross_sell_product->get_name()); ?></h3>
                                                <?php if ($has_size_options || $is_variable): ?>
                                                    <select class="fbt-variation mt-2 px-3 py-1 border border-gray-300 rounded text-sm w-full lg:w-auto" 
                                                            data-product-id="<?php echo esc_attr($cross_sell_id); ?>">
                                                        <option value="">Select option</option>
                                                        <option value="s-m">S/M</option>
                                                        <option value="l-xl">L/XL</option>
                                                    </select>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-between lg:justify-start w-full lg:w-auto lg:space-x-2">
                                            <div class="flex items-center ">
                                                <input type="number" 
                                                       class="fbt-quantity text-center mobile-fbt-quantity" 
                                                       style="width: 56px; height: 56px; background-color: #EEF2F6; border: none; border-radius: 0;" 
                                                       value="1" 
                                                       min="1" 
                                                       data-product-id="<?php echo esc_attr($cross_sell_id); ?>">
                                            </div>
                                            <div class="text-lg font-bold text-gray-900 fbt-price" data-price="<?php echo esc_attr($cross_sell_product->get_price()); ?>">
                                                <?php echo $cross_sell_product->get_price_html(); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>

                            <!-- Total and Add to Cart -->
                            <div class="mt-6 flex flex-col lg:flex-row items-start lg:items-center justify-between pt-4 border-t border-gray-200 gap-4">
                                <div class="fbt-total-section">
                                    <div class="text-sm text-gray-500 mb-1">Total for <span class="fbt-item-count">0</span> items</div>
                                    <div class="text-2xl font-bold text-gray-900 fbt-total-price">$ 0,00</div>
                                </div>
                                <button class="btn-gradient add-all-fbt-btn flex items-center mobile-fbt-add-btn w-full lg:w-auto" style="padding: 16px 32px;">
                                    <span>ADD TO CART</span>
                                    <svg class="w-5 h-5 ml-2 mobile-fbt-cart-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Applications Section -->
        <section class="py-20 applications-section">
            <div class="container-custom">
                <div class="text-center mb-16">
                    <h2 class="title-h2">Applications</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        ForceX devices are designed for various body parts and applications to meet your specific recovery needs.
                    </p>
                </div>
                
         
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="py-20 bg-white">
            <div class="container-custom">
                <!-- Section Header with READ MORE button -->
                <div class="flex flex-col sm:flex-row items-center justify-center sm:justify-between relative mb-12 gap-4">
                    <h2 class="title-h2">Testimonials</h2>
                    <a href="<?php echo esc_url(get_post_type_archive_link('review') ?: home_url('/reviews')); ?>" class="btn-gradient text-sm sm:absolute sm:right-0">
                        READ MORE
                    </a>
                </div>
                
                <?php
                // Get latest 5 reviews (ordered by most recent first)
                $reviews_query = new WP_Query(array(
                    'post_type' => 'review',
                    'posts_per_page' => 5,
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'post_status' => 'publish'
                ));
                
                if ($reviews_query->have_posts()) :
                    // Group reviews into pairs for slides (2 per slide)
                    $all_reviews = array();
                    while ($reviews_query->have_posts()) : $reviews_query->the_post();
                        $reviewer_name = get_post_meta(get_the_ID(), '_reviewer_name', true);
                        $reviewer_title = get_post_meta(get_the_ID(), '_reviewer_title', true);
                        
                        $all_reviews[] = array(
                            'id' => get_the_ID(),
                            'content' => get_the_content(),
                            'reviewer_name' => $reviewer_name ?: get_the_title(),
                            'reviewer_title' => $reviewer_title,
                            'has_thumbnail' => has_post_thumbnail(),
                            'thumbnail' => has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') : null
                        );
                    endwhile;
                    wp_reset_postdata();
                    
                    // Group into pairs
                    $review_pairs = array_chunk($all_reviews, 2);
                    $total_slides = count($review_pairs);
                ?>
                    <!-- Reviews Slider -->
                    <div class="relative">
                        <div class="overflow-hidden product-reviews-slider-container" style="touch-action: pan-y;">
                            <div class="home-reviews-slider-track" id="product-reviews-slider-track">
                                <?php foreach ($review_pairs as $pair) : ?>
                                    <div class="home-reviews-slide w-full flex-shrink-0 px-2">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                            <?php foreach ($pair as $review) : ?>
                                                <div class="card" style="background: linear-gradient(180deg, #EEF2F6 0%, #F5F9FC 100%);">
                                                    <blockquote class="text-gray-700 mb-6 leading-relaxed text-justify xl:min-h-[120px]" style="text-align: justify;">
                                                        <?php echo wp_kses_post($review['content']); ?>
                                                    </blockquote>
                                                    <div class="border-t border-solid mb-6" style="border-color: #D9E2E7;"></div>
                                                    <div class="flex items-center">
                                                        <?php if ($review['has_thumbnail'] && $review['thumbnail']) : ?>
                                                            <div class="w-12 h-12 rounded-full overflow-hidden mr-4 flex-shrink-0">
                                                                <img src="<?php echo esc_url($review['thumbnail']); ?>" alt="<?php echo esc_attr($review['reviewer_name']); ?>" class="w-full h-full object-cover">
                                                            </div>
                                                        <?php else : ?>
                                                            <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                                </svg>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div>
                                                            <div class="font-semibold text-gray-900"><?php echo esc_html($review['reviewer_name']); ?></div>
                                                            <?php if ($review['reviewer_title']) : ?>
                                                                <div class="text-sm text-gray-600 mt-1">
                                                                    <span class="inline-block bg-white px-3 py-1 rounded-full text-xs" style="color: #748394;"><?php echo esc_html($review['reviewer_title']); ?></span>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <!-- Slider Navigation -->
                        <div class="flex items-center justify-center mt-8 gap-4">
                            <button type="button" id="product-reviews-slider-prev" class="home-reviews-slider-btn" aria-label="Previous reviews">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/blueleftarrow.png" alt="Previous" class="h-6 w-auto pointer-events-none">
                            </button>
                            
                            <span id="product-reviews-slider-counter" class="text-gray-700 font-medium px-4">1 / <?php echo $total_slides; ?></span>
                            
                            <button type="button" id="product-reviews-slider-next" class="home-reviews-slider-btn" aria-label="Next reviews">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/bluerightarrow.svg" alt="Next" class="h-6 w-auto pointer-events-none">
                            </button>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="text-center py-12">
                        <p class="text-gray-500">No reviews found.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Other Products Section -->
        <?php
        // Get upsells from WooCommerce
        $upsell_ids = $product->get_upsell_ids();
        if (!empty($upsell_ids)) :
        ?>
        <section class="py-20 products-section">
            <div class="container-custom">
                <div class="text-center mb-16">
                    <h2 class="title-h1 title-white">Other products</h2>
                </div>
                
                <div class="products-grid">
                    <?php
                    foreach ($upsell_ids as $upsell_id) {
                        $upsell_product = wc_get_product($upsell_id);
                        if (!$upsell_product || !$upsell_product->is_purchasable()) continue;
                    ?>
                        <div class="product-card">
                            <div class="relative">
                                <a href="<?php echo esc_url($upsell_product->get_permalink()); ?>" class="block">
                                    <?php if ($upsell_product->get_image()): ?>
                                        <?php echo $upsell_product->get_image('large', array('class' => 'w-full h-64 object-cover rounded-lg')); ?>
                                    <?php else: ?>
                                        <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    <?php endif; ?>
                                </a>
                                
                                <?php if ($upsell_product->is_on_sale()): ?>
                                    <span class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                        Sale
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <h3 class="title-h3 mb-2 mt-4">
                                <a href="<?php echo esc_url($upsell_product->get_permalink()); ?>" class="hover:text-primary-500 transition-colors">
                                    <?php echo $upsell_product->get_name(); ?>
                                </a>
                            </h3>
                            
                            <p class="mb-4" style="color: #303E4E; font-size: 22px;">
                                <?php 
                                $description = $upsell_product->get_short_description();
                                if (empty($description)) {
                                    $description = $upsell_product->get_description();
                                }
                                if (empty($description)) {
                                    $description = get_the_excerpt($upsell_product->get_id());
                                }
                                if (empty($description)) {
                                    $description = 'Advanced therapy technology for optimal recovery and performance.';
                                }
                                echo wp_trim_words(wp_strip_all_tags($description), 15); 
                                ?>
                            </p>
                            
                            <div class="mb-4" style="font-size: 36px; font-weight: bold; color: black;">
                                <?php echo $upsell_product->get_price_html(); ?>
                            </div>
                            
                            <div class="flex items-center justify-between gap-1">
                                <div class="flex items-center gap-1">
                                    <button class="quantity-btn disabled" style="width: 56px; height: 56px; background-color: white; border: 1px solid #D9E2E7;" data-action="decrease">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4 10H16" stroke="#96A2AF" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                    </button>
                                    <input type="text" class="quantity-input text-center" style="width: 56px; height: 56px; background-color: #EEF2F6; border: none; border-radius: 8px;" value="1" data-product-id="<?php echo esc_attr($upsell_product->get_id()); ?>">
                                    <button class="quantity-btn" style="width: 56px; height: 56px; background-color: white; border: 1px solid #D9E2E7;" data-action="increase">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4 10H16M10 4V16" stroke="#25AAE1" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                    </button>
                                </div>
                                <button class="btn-gradient upsell-add-to-cart-btn" data-product-id="<?php echo esc_attr($upsell_product->get_id()); ?>">
                                    <span>PURCHASE</span>
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </section>
        <?php endif; ?>
    </div>

    <?php endwhile; ?>
</main>

<style>
/* Quantity Input Styling */
#product-quantity {
    -moz-appearance: textfield;
    appearance: textfield;
    cursor: text;
}

#product-quantity::-webkit-outer-spin-button,
#product-quantity::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

#product-quantity:focus {
    outline: 2px solid #25AAE1;
    outline-offset: 2px;
    background-color: #ffffff !important;
    border: 1px solid #25AAE1 !important;
}

.quantity-btn.disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.quantity-btn:not(.disabled):hover {
    background-color: #f0f0f0;
}

.thumbnail-btn.active {
    border-color: #25AAE1 !important;
}

.product-images-column {
    align-self: flex-start;
}

@media (min-width: 1024px) {
    .product-images-column {
        position: sticky;
        top: 2rem;
        align-self: flex-start;
        max-height: calc(100vh - 4rem);
    }
}

.thumbnail-btn {
    box-sizing: border-box;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 4px;
    overflow: hidden;
    max-height: 65px;
}

@media (min-width: 1024px) {
    .thumbnail-btn {
        max-height: 65px;
    }
}

.thumbnail-btn .thumbnail-img-wrapper {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.thumbnail-btn .thumbnail-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    border-radius: 0.25rem;
    max-width: 100%;
    max-height: 100%;
}

.thumbnail-container {
    scrollbar-width: thin;
    scrollbar-color: #cbd5e1 transparent;
    overflow-y: auto !important;
}

.product-images-column .flex.flex-col {
    scrollbar-width: thin;
    scrollbar-color: #cbd5e1 transparent;
    overflow-y: auto !important;
}

.product-images-column .flex.flex-col::-webkit-scrollbar {
    width: 6px;
}

.product-images-column .flex.flex-col::-webkit-scrollbar-track {
    background: transparent;
}

.product-images-column .flex.flex-col::-webkit-scrollbar-thumb {
    background-color: #cbd5e1;
    border-radius: 3px;
}

.product-images-column .flex.flex-col::-webkit-scrollbar-thumb:hover {
    background-color: #94a3b8;
}

.fbt-checkbox:checked + div {
    background-color: #f0f9ff;
}

/* Specifications Styles */
.spec-attribute-name {
    font-family: 'Manrope', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    font-weight: 400;
    font-size: 16px;
    line-height: 1.5;
    color: #748394;
}

.spec-attribute-value {
    font-family: 'Manrope', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    font-weight: 400;
    font-size: 16px;
    line-height: 1.5;
    color: #1A1A1A;
    background-color: white;
    border-radius: 32px;
    padding: 4px 12px;
    border: none;
    display: inline-block;
}

/* Mobile Responsive Styles */
@media (max-width: 1023px) {
    /* Breadcrumbs Mobile Styles */
    .product-breadcrumbs {
        border: 1px solid #D9E2E7 !important;
        font-size: 12px !important;
        padding: 8px 12px !important;
    }
    
    .product-breadcrumbs li {
        font-size: 12px !important;
    }
    
    .product-breadcrumbs a,
    .product-breadcrumbs span {
        font-size: 12px !important;
    }
    
    /* Thumbnail Gallery - Horizontal on Mobile, Under Main Image */
    .product-images-column {
        width: 100% !important;
        position: relative !important;
        align-self: stretch !important;
        margin-top: 0;
    }
    
    #main-image-container {
        width: 100% !important;
        order: 1;
        margin-bottom: 16px;
    }
    
    /* Center thumbnails horizontally on mobile */
    .thumbnail-container {
        justify-content: flex-start;
        align-items: center;
    }
    
    .thumbnail-container {
        flex-direction: row !important;
        overflow-x: auto !important;
        overflow-y: hidden !important;
        padding: 8px 0;
        gap: 8px;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 transparent;
        width: 100%;
    }
    
    .thumbnail-container::-webkit-scrollbar {
        height: 4px;
    }
    
    .thumbnail-container::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .thumbnail-container::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        border-radius: 2px;
    }
    
    .thumbnail-container::-webkit-scrollbar-thumb:hover {
        background-color: #94a3b8;
    }
    
    .thumbnail-btn {
        min-width: 80px !important;
        width: 80px !important;
        height: 80px !important;
        max-height: 80px !important;
        max-width: 80px !important;
        flex-shrink: 0;
    }
    
    .product-images-column .thumbnail-img-wrapper {
        width: 100% !important;
        height: 100% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    
    .product-images-column .thumbnail-img {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
    }
    
    /* Reduce Quantity Button Sizes on Mobile */
    .mobile-quantity-btn {
        width: 40px !important;
        height: 40px !important;
    }
    
    .mobile-quantity-icon {
        width: 16px !important;
        height: 16px !important;
    }
    
    .mobile-quantity-input {
        width: 40px !important;
        height: 40px !important;
        font-size: 14px !important;
    }
    
    /* Reduce Add to Cart Button Size on Mobile */
    .mobile-add-to-cart-btn {
        padding: 12px 20px !important;
        font-size: 14px !important;
    }
    
    .mobile-cart-icon {
        width: 16px !important;
        height: 16px !important;
    }
    
    /* Frequently Bought Together - Mobile Friendly */
    .fbt-item {
        padding: 12px !important;
    }
    
    .mobile-fbt-quantity {
        width: 40px !important;
        height: 40px !important;
        font-size: 14px !important;
    }
    
    .mobile-fbt-add-btn {
        padding: 12px 20px !important;
        font-size: 14px !important;
        width: 100% !important;
        justify-content: center !important;
    }
    
    .mobile-fbt-cart-icon {
        width: 16px !important;
        height: 16px !important;
    }
    
    .fbt-price {
        font-size: 16px !important;
    }
}

/* Keep Desktop Styles Intact */
@media (min-width: 1024px) {
    .product-images-column {
        width: 95px;
        position: sticky;
        top: 2rem;
        align-self: flex-start;
        max-height: calc(100vh - 4rem);
    }
    
    .thumbnail-container {
        flex-direction: column;
        overflow-y: auto;
        overflow-x: hidden;
    }
    
    .mobile-quantity-btn,
    .mobile-quantity-input,
    .mobile-add-to-cart-btn,
    .mobile-fbt-quantity,
    .mobile-fbt-add-btn {
        /* Reset to original sizes on desktop */
    }
}
</style>

<script>
// Change main image when thumbnail is clicked
function changeMainImage(imageUrl, imageId) {
    const mainImg = document.getElementById('main-product-image');
    const mainImgMobile = document.getElementById('main-product-image-mobile');
    
    if (mainImg) {
        mainImg.src = imageUrl;
        mainImg.srcset = '';
        // Re-sync heights after image loads
        mainImg.addEventListener('load', syncThumbnailHeight, { once: true });
    }
    if (mainImgMobile) {
        mainImgMobile.src = imageUrl;
        mainImgMobile.srcset = '';
    }
    
    // Update active thumbnail
    document.querySelectorAll('.thumbnail-btn').forEach(btn => {
        btn.classList.remove('active', 'border-primary-500');
        btn.classList.add('border-transparent');
    });
    const activeBtn = document.querySelector(`[data-image-id="${imageId}"]`);
    if (activeBtn) {
        activeBtn.classList.add('active', 'border-primary-500');
        activeBtn.classList.remove('border-transparent');
    }
}

// Sync thumbnail column height with main image (desktop only)
function syncThumbnailHeight() {
    // Skip on mobile - thumbnails are horizontal
    if (window.innerWidth < 1024) {
        return;
    }
    
    const mainImageContainer = document.getElementById('main-image-container');
    const thumbnailColumn = document.querySelector('.product-images-column');
    
    if (!mainImageContainer || !thumbnailColumn) {
        return;
    }
    
    const mainImage = document.getElementById('main-product-image');
    if (mainImage) {
        // Wait for image to load and render
        if (mainImage.complete && mainImage.naturalHeight > 0) {
            // Use requestAnimationFrame to ensure image is fully rendered
            requestAnimationFrame(() => {
                setTimeout(updateThumbnailHeight, 50);
            });
        } else {
            mainImage.addEventListener('load', function() {
                requestAnimationFrame(() => {
                    setTimeout(updateThumbnailHeight, 50);
                });
            }, { once: true });
        }
    } else {
        // If no image, use container height
        setTimeout(updateThumbnailHeight, 100);
    }
    
    function updateThumbnailHeight() {
        // Skip on mobile
        if (window.innerWidth < 1024) {
            return;
        }
        
        const mainImageContainer = document.getElementById('main-image-container');
        const thumbnailColumn = document.querySelector('.product-images-column');
        // Use the thumbnail-container class or fallback to flex-col
        const thumbnailContainer = thumbnailColumn?.querySelector('.thumbnail-container') ||
                                   thumbnailColumn?.querySelector('.flex.flex-col');
        
        if (!mainImageContainer || !thumbnailColumn || !thumbnailContainer) {
            return;
        }
        
        // Get the actual height of the main image (not just container)
        const mainImage = document.getElementById('main-product-image');
        let mainHeight = 0;
        
        if (mainImage && mainImage.offsetHeight > 0) {
            mainHeight = mainImage.offsetHeight;
        } else {
            mainHeight = mainImageContainer.offsetHeight;
        }
        
        if (mainHeight > 0) {
            // Set max height on inner container to enable scrolling (don't set on sticky element)
            // Limit to viewport height minus offset for sticky positioning
            const maxStickyHeight = Math.min(mainHeight, window.innerHeight - 64);
            thumbnailContainer.style.maxHeight = maxStickyHeight + 'px';
            thumbnailContainer.style.height = maxStickyHeight + 'px';
            thumbnailContainer.style.overflowY = 'auto';
            
            // Calculate thumbnail height for 5 images (accounting for gaps)
            // space-y-3 = 0.75rem = 12px per gap, so 4 gaps = 48px
            const gapTotal = 48; // 4 gaps * 12px
            const calculatedHeight = (maxStickyHeight - gapTotal) / 5;
            const thumbnailHeight = Math.min(calculatedHeight, 65); // Maximum 65px
            
            // Set each thumbnail height
            const thumbnails = thumbnailContainer.querySelectorAll('.thumbnail-btn');
            thumbnails.forEach(thumb => {
                thumb.style.height = thumbnailHeight + 'px';
                thumb.style.minHeight = thumbnailHeight + 'px';
                thumb.style.maxHeight = '65px';
            });
        }
    }
}

// Quantity controls
document.addEventListener('DOMContentLoaded', function() {
    // Sync thumbnail heights
    syncThumbnailHeight();
    
    // Re-sync on window resize
    window.addEventListener('resize', syncThumbnailHeight);
    
    // Quantity buttons are handled globally in main.js
    // No need for duplicate event listeners here
    const quantityInput = document.getElementById('product-quantity');
    
    // Add to cart
    const addToCartBtn = document.querySelector('.add-to-cart-btn');
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const quantity = parseInt(quantityInput.value) || 1;
            
            if (typeof forcex_ajax === 'undefined') {
                console.error('AJAX not available');
                return;
            }
            
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
                        const cartCount = document.getElementById('cart-count');
                        if (cartCount) {
                            cartCount.textContent = data.data.cart_count;
                            cartCount.style.display = 'flex';
                        }
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
    }
    
    // Calculate total price for FBT
    function calculateFBTTotal() {
        const checkedProducts = document.querySelectorAll('.fbt-checkbox:checked');
        let total = 0;
        let itemCount = 0;
        
        checkedProducts.forEach(checkbox => {
            const productRow = checkbox.closest('.fbt-item');
            const quantityInput = productRow.querySelector('.fbt-quantity');
            const priceElement = productRow.querySelector('.fbt-price');
            
            if (priceElement && quantityInput) {
                const quantity = parseInt(quantityInput.value) || 1;
                const price = parseFloat(priceElement.getAttribute('data-price')) || 0;
                total += price * quantity;
                itemCount += quantity;
            }
        });
        
        // Update total display
        const totalElement = document.querySelector('.fbt-total-price');
        const countElement = document.querySelector('.fbt-item-count');
        
        if (totalElement) {
            // Format total with space as thousands separator and comma as decimal
            const formattedTotal = total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ' ').replace('.', ',');
            totalElement.textContent = '$ ' + formattedTotal;
        }
        
        if (countElement) {
            countElement.textContent = itemCount;
        }
        
        // Always keep button enabled
        const addAllFbtBtn = document.querySelector('.add-all-fbt-btn');
        if (addAllFbtBtn) {
            addAllFbtBtn.disabled = false;
            addAllFbtBtn.style.opacity = '1';
            addAllFbtBtn.style.cursor = 'pointer';
        }
    }
    
    // Update total when checkboxes or quantities change
    const fbtContainer = document.getElementById('frequently-bought-together');
    if (fbtContainer) {
        // Listen for checkbox changes
        fbtContainer.addEventListener('change', function(e) {
            if (e.target.classList.contains('fbt-checkbox') || e.target.classList.contains('fbt-quantity')) {
                calculateFBTTotal();
            }
        });
        
        // Calculate initial total
        calculateFBTTotal();
    }
    
    // Add all FBT to cart
    const addAllFbtBtn = document.querySelector('.add-all-fbt-btn');
    if (addAllFbtBtn) {
        addAllFbtBtn.addEventListener('click', function() {
            const checkedProducts = document.querySelectorAll('.fbt-checkbox:checked');
            const productsToAdd = [];
            
            checkedProducts.forEach(checkbox => {
                const productId = parseInt(checkbox.getAttribute('data-product-id'));
                const productRow = checkbox.closest('.fbt-item');
                const quantityInput = productRow.querySelector('.fbt-quantity');
                const variationSelect = productRow.querySelector('.fbt-variation');
                const quantity = quantityInput ? parseInt(quantityInput.value) || 1 : 1;
                const variationId = variationSelect ? variationSelect.value : null;
                
                productsToAdd.push({ 
                    id: productId, 
                    quantity: quantity,
                    variation_id: variationId
                });
            });
            
            if (typeof forcex_ajax === 'undefined') {
                console.error('AJAX not available');
                return;
            }
            
            // Disable button during processing
            addAllFbtBtn.disabled = true;
            const originalText = addAllFbtBtn.innerHTML;
            addAllFbtBtn.innerHTML = '<span>Adding...</span>';
            
            // Add products sequentially to avoid race conditions
            async function addProductsSequentially() {
                const errors = [];
                let lastCartCount = null;
                
                for (let i = 0; i < productsToAdd.length; i++) {
                    const product = productsToAdd[i];
                    const params = {
                        action: 'forcex_add_to_cart',
                        product_id: product.id,
                        quantity: product.quantity,
                        nonce: forcex_ajax.nonce
                    };
                    
                    if (product.variation_id) {
                        params.variation_id = product.variation_id;
                    }
                    
                    try {
                        const response = await fetch(forcex_ajax.ajax_url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: new URLSearchParams(params)
                        });
                        
                        const data = await response.json();
                        
                        if (!data.success) {
                            errors.push(data.data || 'Failed to add product');
                        } else {
                            // Store the latest cart count
                            if (data.data && data.data.cart_count) {
                                lastCartCount = data.data.cart_count;
                            }
                        }
                    } catch (error) {
                        console.error('Error adding product:', error);
                        errors.push('Network error for product ID: ' + product.id);
                    }
                }
                
                // Update cart count
                const cartCount = document.getElementById('cart-count');
                if (cartCount && lastCartCount !== null) {
                    cartCount.textContent = lastCartCount;
                    cartCount.style.display = 'flex';
                }
                
                // Re-enable button
                addAllFbtBtn.disabled = false;
                addAllFbtBtn.innerHTML = originalText;
                
                // Show result message
                if (errors.length > 0) {
                    showNotification('Some products could not be added: ' + errors.join(', '), 'error');
                } else {
                    showNotification('All selected products added to cart!', 'success');
                }
            }
            
            // Start adding products
            addProductsSequentially();
        });
    }
    
    // Initialize Product Reviews Slider (Testimonials)
    const productReviewsSliderTrack = document.getElementById('product-reviews-slider-track');
    const productReviewsSliderPrev = document.getElementById('product-reviews-slider-prev');
    const productReviewsSliderNext = document.getElementById('product-reviews-slider-next');
    const productReviewsSliderCounter = document.getElementById('product-reviews-slider-counter');
    
    if (productReviewsSliderTrack && productReviewsSliderPrev && productReviewsSliderNext && productReviewsSliderCounter) {
        let currentSlide = 0;
        const slides = productReviewsSliderTrack.querySelectorAll('.home-reviews-slide');
        const totalSlides = slides.length;
        
        if (totalSlides > 0 && totalSlides > 1) {
            // Update slider position
            function updateProductReviewsSlider() {
                const translateX = -currentSlide * 100;
                productReviewsSliderTrack.style.transform = `translateX(${translateX}%)`;
                productReviewsSliderTrack.style.webkitTransform = `translateX(${translateX}%)`;
                productReviewsSliderCounter.textContent = `${currentSlide + 1} / ${totalSlides}`;
            }
            
            // Previous button
            productReviewsSliderPrev.addEventListener('click', function() {
                if (currentSlide > 0) {
                    currentSlide--;
                } else {
                    currentSlide = totalSlides - 1;
                }
                updateProductReviewsSlider();
            });
            
            // Next button
            productReviewsSliderNext.addEventListener('click', function() {
                if (currentSlide < totalSlides - 1) {
                    currentSlide++;
                } else {
                    currentSlide = 0;
                }
                updateProductReviewsSlider();
            });
            
            // Touch/swipe support for mobile (desktop unchanged)
            const productReviewsContainer = document.querySelector('.product-reviews-slider-container');
            if (productReviewsContainer) {
                let touchStartX = 0, touchEndX = 0;
                productReviewsContainer.addEventListener('touchstart', function(e) {
                    touchStartX = e.changedTouches[0].screenX;
                }, { passive: true });
                productReviewsContainer.addEventListener('touchend', function(e) {
                    touchEndX = e.changedTouches[0].screenX;
                    const diff = touchStartX - touchEndX;
                    if (Math.abs(diff) > 50) {
                        if (diff > 0) {
                            currentSlide = currentSlide < totalSlides - 1 ? currentSlide + 1 : 0;
                        } else {
                            currentSlide = currentSlide > 0 ? currentSlide - 1 : totalSlides - 1;
                        }
                        updateProductReviewsSlider();
                    }
                }, { passive: true });
            }
            
            // Initialize
            updateProductReviewsSlider();
        } else if (totalSlides === 1) {
            // Hide navigation if only one slide
            productReviewsSliderPrev.style.display = 'none';
            productReviewsSliderNext.style.display = 'none';
            productReviewsSliderCounter.textContent = '1 / 1';
        }
    }
    
    // Upsell Products Quantity Controls and Add to Cart
    const upsellProducts = document.querySelectorAll('.product-card');
    upsellProducts.forEach(card => {
        const quantityInput = card.querySelector('.quantity-input[data-product-id]');
        const decreaseBtn = card.querySelector('.quantity-btn[data-action="decrease"]');
        const increaseBtn = card.querySelector('.quantity-btn[data-action="increase"]');
        const addToCartBtn = card.querySelector('.upsell-add-to-cart-btn');
        
        // Quantity buttons are handled globally in main.js
        // No need for duplicate event listeners here
        
        // Add to cart button
        if (addToCartBtn && quantityInput) {
            addToCartBtn.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                const quantity = parseInt(quantityInput.value) || 1;
                
                if (typeof forcex_ajax === 'undefined') {
                    console.error('AJAX not available');
                    return;
                }
                
                // Disable button during processing
                this.disabled = true;
                const originalHTML = this.innerHTML;
                this.innerHTML = '<span>Adding...</span>';
                
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
                        const cartCount = document.getElementById('cart-count');
                        if (cartCount && data.data && data.data.cart_count) {
                            cartCount.textContent = data.data.cart_count;
                            cartCount.style.display = 'flex';
                        }
                        const productName = data.data.product_name || 'Product';
                        showNotification(productName + ' added to cart!', 'success');
                    } else {
                        showNotification('Error: ' + (data.data || 'Failed to add product'), 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                })
                .finally(() => {
                    this.disabled = false;
                    this.innerHTML = originalHTML;
                });
            });
        }
    });
});
</script>

<?php get_footer('shop'); ?>

