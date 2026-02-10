<?php get_header(); ?>

<?php
// Note: WooCommerce cart, checkout, and account pages are now handled by 
// template_include filter in functions.php which loads proper page templates
// with header and footer. This code below is kept for backward compatibility
// but should not execute for WooCommerce pages.

// Check if this is a WooCommerce cart page
if (function_exists('is_cart') && is_cart()) {
    // This should not execute as template_include filter handles it
    // But keeping for fallback
    return;
}

// Check if this is a WooCommerce checkout page
if (function_exists('is_checkout') && is_checkout()) {
    // This should not execute as template_include filter handles it
    // But keeping for fallback
    return;
}

// Check if this is a WooCommerce account page
if (function_exists('is_account_page') && is_account_page()) {
    // This should not execute as template_include filter handles it
    // But keeping for fallback
    return;
}

// Check if this is a regular WordPress page (not home, not archive, not single post)
if (is_page() && !is_front_page() && !is_home()) {
    // Load the default page template
    $page_template = locate_template('page.php');
    if ($page_template) {
        include $page_template;
        return;
    }
}
?>

<!-- Hero Section -->
<section class="hero-section relative py-20 flex items-center">
    <div class="hero-background absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/hero_home_bg.png');"></div>
     
    <div class="container-custom relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="animate-fade-in lg:col-span-8 hero-content-mobile">
                <h1 class="text-4xl lg:text-6xl font-bold mb-6 hero-title-mobile">
                    Heat & Cold therapy and compression technology
                </h1>
                <p class="text-xl mb-8 leading-relaxed hero-description-desktop">
                    Advanced recovery solutions for athletes and active individuals. Experience the power of cutting-edge technology designed to optimize your performance and accelerate healing.
                </p>
                <p class="text-xl mb-8 leading-relaxed hero-description-mobile hidden">
                    Designed for rehabilitation, post-operative recovery and improvement of athletic performance
                </p>
                <a href="<?php echo esc_url(home_url('/products')); ?>" class="btn-gradient text-lg hero-button-mobile">
                    <span class="hero-button-text-desktop">Explore products</span>
                    <span class="hero-button-text-mobile hidden">EXPLORE PRODUCTS</span>
                </a>
            </div>
            <div class="animate-slide-up lg:col-span-4 mt-10">
                <div class="max-w-[330px] mx-auto">
                    <!-- White Product Card with Custom Border Radius -->
                    <div class="bg-white bg-opacity-95 backdrop-blur-sm shadow-2xl overflow-hidden hero-product-card">
                        <!-- Product Slider -->
                        <div class="hero-product-slider relative">
                            <div class="slider-container overflow-hidden">
                                <div class="slider-track flex transition-transform duration-300 ease-in-out" id="hero-slider-track">
                                    <?php
                                    // Get featured products from devices category only
                                    $hero_args = array(
                                        'post_type' => 'product',
                                        'posts_per_page' => 3,
                                        'post_status' => 'publish',
                                        'tax_query' => array(
                                            array(
                                                'taxonomy' => 'product_cat',
                                                'field' => 'slug',
                                                'terms' => array('devices', 'device'),
                                                'operator' => 'IN'
                                            )
                                        ),
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
                                        'meta_key' => '_price',
                                        'orderby' => 'meta_value_num',
                                        'order' => 'DESC'
                                    );
                                    
                                    // If no featured devices found, get regular devices
                                    $hero_products = new WP_Query($hero_args);
                                    if (!$hero_products->have_posts()) {
                                        $hero_args = array(
                                            'post_type' => 'product',
                                            'posts_per_page' => 3,
                                            'post_status' => 'publish',
                                            'tax_query' => array(
                                                array(
                                                    'taxonomy' => 'product_cat',
                                                    'field' => 'slug',
                                                    'terms' => array('devices', 'device'),
                                                    'operator' => 'IN'
                                                )
                                            ),
                                            'meta_key' => '_price',
                                            'orderby' => 'meta_value_num',
                                            'order' => 'DESC'
                                        );
                                        $hero_products = new WP_Query($hero_args);
                                    }
                                    
                                    if ($hero_products->have_posts()):
                                        $slide_count = 0;
                                        while ($hero_products->have_posts()): $hero_products->the_post();
                                            global $product;
                                            $slide_count++;
                                    ?>
                                        <div class="slider-slide w-full flex-shrink-0 p-8 text-center pt-2 slider-slide-content">
                                        <div class="slider-slide-inner flex flex-col lg:flex-row lg:items-center lg:gap-6">
                                        <!-- Product Image -->
                                        <div class="w-48 h-48 mx-auto mb-6 lg:mx-0 lg:mb-0 lg:w-80 lg:h-40 flex-shrink-0 slider-slide-image">
                                                <a href="<?php echo esc_url($product->get_permalink()); ?>" class="block">
                                                    <?php if ($product->get_image()): ?>
                                                        <?php echo $product->get_image('small', array('class' => 'w-full  object-cover rounded-2xl')); ?>
                                                    <?php else: ?>
                                                        <div class="w-full h-full bg-gradient-to-br from-primary-100 to-primary-200 rounded-2xl flex items-center justify-center">
                                                            <svg class="w-24 h-24 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                            </svg>
                                                        </div>
                                                    <?php endif; ?>
                                                </a>
                                            </div>
                                            
                                        <!-- Vertical Divider Line (Mobile) -->
                                        <div class="w-0.5 h-full bg-[#D9E2E7] mx-4 lg:hidden slider-slide-divider-vertical flex-shrink-0"></div>
                                        
                                        <!-- Horizontal Divider Line (Desktop) -->
                                        <div class="w-full h-0.5 bg-gray-300 lg:block hidden slider-slide-divider-horizontal" style="margin-left: -2rem; margin-right: -2rem; margin-top: 1rem;"></div>
                                        
                                        <!-- Product Text Content -->
                                        <div class="slider-slide-text flex-1 text-left px-4 py-2">
                                        <!-- Product Title -->
                                        <h2 class="mb-1 title-h3">
                                            <a href="<?php echo esc_url($product->get_permalink()); ?>" class="hover:text-primary-500 transition-colors">
                                                <?php echo $product->get_name(); ?>
                                            </a>
                                        </h2>
                                        
                                        <!-- Product Description -->
                                        <p class="text-gray-600 text-sm">
                                            <?php 
                                            $description = $product->get_short_description();
                                            if (empty($description)) {
                                                $description = $product->get_description();
                                            }
                                            if (empty($description)) {
                                                $description = get_the_excerpt();
                                            }
                                            if (empty($description)) {
                                                $description = 'Advanced therapy technology for optimal recovery and performance.';
                                            }
                                            echo wp_trim_words($description, 8);
                                            ?>
                                        </p>
                                        </div>
                                        </div>
                                        </div>
                                    <?php
                                        endwhile;
                                        wp_reset_postdata();
                                    else:
                                        // Fallback products
                                        for ($i = 1; $i <= 3; $i++):
                                            $slide_count++;
                                    ?>
                                        <div class="slider-slide w-full flex-shrink-0 p-8 text-center slider-slide-content">
                                            <div class="slider-slide-inner flex flex-col lg:flex-row lg:items-center lg:gap-6">
                                            <div class="w-96 h-48 mx-auto mb-6 lg:mx-0 lg:mb-0 lg:w-80 lg:h-32 flex-shrink-0 slider-slide-image">
                                                <div class="w-full h-full bg-gradient-to-br from-primary-100 to-primary-200 rounded-2xl flex items-center justify-center">
                                                    <svg class="w-24 h-24 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <!-- Vertical Divider Line (Mobile) -->
                                            <div class="w-0.5 h-full bg-[#D9E2E7] mx-4 lg:hidden slider-slide-divider-vertical flex-shrink-0"></div>
                                            <!-- Horizontal Divider Line (Desktop) -->
                                            <div class="w-full h-0.5 bg-gray-300 mb-4 lg:block hidden slider-slide-divider-horizontal" style="margin-left: -2rem; margin-right: -2rem; width: calc(100% + 4rem);"></div>
                                            <div class="slider-slide-text flex-1 text-left">
                                            <h3 class="text-2xl font-bold text-gray-900 mb-2">ForceX Product <?php echo $i; ?></h3>
                                            <p class="text-gray-600 text-sm">Advanced therapy technology for optimal recovery and performance.</p>
                                            </div>
                                            </div>
                                        </div>
                                    <?php 
                                        endfor;
                                    endif;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Slider Navigation - Below the white card -->
                    <div class="relative flex items-center justify-between mt-5 hero-slider-navigation">
                        <!-- Desktop: Arrows and Counter -->
                        <button class="slider-prev-btn hero-slider-arrow-desktop" id="hero-slider-prev">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/left_slider_arrow.svg" alt="Previous" class="w-16">
                        </button>
                        
                        <!-- Desktop Counter -->
                        <span class="text-white font-medium hero-slider-counter-desktop" id="hero-slider-counter">
                            <span class="slider-counter-number text-[40px]">1</span> / <?php echo isset($slide_count) ? $slide_count : 3; ?>
                        </span>
                        
                        <!-- Mobile Indicators - Just horizontal bars -->
                        <div class="hero-slider-indicators-mobile flex items-center gap-2 w-full" id="hero-slider-indicators">
                            <?php 
                            $indicator_count = isset($slide_count) ? $slide_count : 3;
                            for ($i = 0; $i < $indicator_count; $i++): 
                            ?>
                                <div class="hero-slider-indicator <?php echo $i === 0 ? 'active' : ''; ?>" data-slide="<?php echo $i; ?>"></div>
                            <?php endfor; ?>
                        </div>
                        
                        <button class="slider-next-btn hero-slider-arrow-desktop" id="hero-slider-next">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/right_slider_arrow.svg" alt="Next" class="w-16">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ForceX Technology Section -->
<section class="py-20 bg-white">
    <div class="container-custom">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
            <!-- Left Column -->
            <div>
                <h2 class="title-h2">
                    ForceX technology
                </h2>
                <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                    ForceX powered by CDC Tech is the first system to deliver dynamic positive compression with intelligent heat and cold cycling.
                </p>
                <a href="<?php echo esc_url(home_url('/company/')); ?>" class="btn-gradient-dark">
                    MORE ABOUT US
                </a>
            </div>
            
            <!-- Right Column - Feature Blocks -->
            <div class="tech-widget-container">
                <!-- Desktop: Regular stacked layout -->
                <div class="tech-widget-desktop space-y-6">
                    <!-- Block 1: Effective pain relief -->
                    <div class="rounded-xl p-6 shadow-sm" style="background-color: #EEF2F6;">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pp1.png" alt="Effective pain relief" class="object-contain" style="width: 240px; height: 240px;">
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 mb-2" style="font-size: 28px;">Effective pain relief</h3>
                                <p class="text-gray-600 leading-relaxed" style="font-size: 18px;">
                                    Promote faster recovery from injury, surgery, or strenuous activity by reducing inflammation and managing pain without the need for ice.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Block 2: Intelligent temperature regulation -->
                    <div class="rounded-xl p-6 shadow-sm" style="background-color: #EEF2F6;">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pp2.png" alt="Intelligent temperature regulation" class="object-contain" style="width: 240px; height: 240px;">
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 mb-2" style="font-size: 28px;">Intelligent temperature regulation</h3>
                                <p class="text-gray-600 leading-relaxed" style="font-size: 18px;">
                                    Advanced Cryothermic Modulation to alternate between heat and cold therapy, precisely cycling temperatures for optimal healing.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Block 3: Universal & Portable -->
                    <div class="rounded-xl p-6 shadow-sm" style="background-color: #EEF2F6;">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pp3.png" alt="Universal & Portable" class="object-contain" style="width: 240px; height: 240px;">
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 mb-2" style="font-size: 28px;">Universal & Portable</h3>
                                <p class="text-gray-600 leading-relaxed" style="font-size: 18px;">
                                    A single adaptable system fits multiple body regions and features a portable handle structure for ease of use in clinical or home settings.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Mobile: Slider layout -->
                <div class="tech-widget-mobile">
                    <div class="tech-widget-slider-container overflow-hidden">
                        <div class="tech-widget-slider-track flex transition-transform duration-300 ease-in-out" id="tech-widget-slider-track-home">
                            <!-- Block 1: Effective pain relief -->
                            <div class="tech-widget-slide w-full flex-shrink-0 px-2">
                                <div class="rounded-xl p-6 shadow-sm" style="background-color: #EEF2F6;">
                                    <div class="flex flex-col items-center gap-4 text-center">
                                        <div class="flex-shrink-0">
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pp1.png" alt="Effective pain relief" class="object-contain mx-auto" style="width: 150px; height: 150px;">
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-gray-900 mb-2" style="font-size: 22px;">Effective pain relief</h3>
                                            <p class="text-gray-600 leading-relaxed" style="font-size: 16px;">
                                                Promote faster recovery from injury, surgery, or strenuous activity by reducing inflammation and managing pain without the need for ice.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Block 2: Intelligent temperature regulation -->
                            <div class="tech-widget-slide w-full flex-shrink-0 px-2">
                                <div class="rounded-xl p-6 shadow-sm" style="background-color: #EEF2F6;">
                                    <div class="flex flex-col items-center gap-4 text-center">
                                        <div class="flex-shrink-0">
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pp2.png" alt="Intelligent temperature regulation" class="object-contain mx-auto" style="width: 150px; height: 150px;">
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-gray-900 mb-2" style="font-size: 22px;">Intelligent temperature regulation</h3>
                                            <p class="text-gray-600 leading-relaxed" style="font-size: 16px;">
                                                Advanced Cryothermic Modulation to alternate between heat and cold therapy, precisely cycling temperatures for optimal healing.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Block 3: Universal & Portable -->
                            <div class="tech-widget-slide w-full flex-shrink-0 px-2">
                                <div class="rounded-xl p-6 shadow-sm" style="background-color: #EEF2F6;">
                                    <div class="flex flex-col items-center gap-4 text-center">
                                        <div class="flex-shrink-0">
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pp3.png" alt="Universal & Portable" class="object-contain mx-auto" style="width: 150px; height: 150px;">
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-gray-900 mb-2" style="font-size: 22px;">Universal & Portable</h3>
                                            <p class="text-gray-600 leading-relaxed" style="font-size: 16px;">
                                                A single adaptable system fits multiple body regions and features a portable handle structure for ease of use in clinical or home settings.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mobile Slider Navigation -->
                    <div class="tech-widget-navigation flex items-center justify-between mt-5">
                        <button class="tech-widget-prev" data-slider="home">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/left_slider_arrow.svg" alt="Previous" class="w-12 h-12">
                        </button>
                        
                        <!-- Indicators -->
                        <div class="tech-widget-indicators flex items-center gap-2 flex-1 justify-center" data-slider="home">
                            <div class="tech-widget-indicator active" data-slide="0"></div>
                            <div class="tech-widget-indicator" data-slide="1"></div>
                            <div class="tech-widget-indicator" data-slide="2"></div>
                        </div>
                        
                        <button class="tech-widget-next" data-slider="home">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/right_slider_arrow.svg" alt="Next" class="w-12 h-12">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Products Section -->
<section class="py-20 products-section">
    <div class="container-custom">
        <div class="text-center mb-16">
            <h2 class="title-h1 title-white">Our products</h2>
        </div>
        
        <div class="products-container">
            <!-- Desktop: Grid layout -->
            <div class="products-grid products-desktop">
                <?php
                // Get featured products from devices category only
                $featured_args = array(
                    'post_type' => 'product',
                    'posts_per_page' => 3,
                    'post_status' => 'publish',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field' => 'slug',
                            'terms' => array('devices', 'device'),
                            'operator' => 'IN'
                        )
                    ),
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
                    'meta_key' => '_price',
                    'orderby' => 'meta_value_num',
                    'order' => 'DESC'
                );
                
                // If no featured devices found, get regular devices
                $featured_products = new WP_Query($featured_args);
                if (!$featured_products->have_posts()) {
                    $featured_args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 3,
                        'post_status' => 'publish',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field' => 'slug',
                                'terms' => array('devices', 'device'),
                                'operator' => 'IN'
                            )
                        ),
                        'meta_key' => '_price',
                        'orderby' => 'meta_value_num',
                        'order' => 'DESC'
                    );
                    $featured_products = new WP_Query($featured_args);
                }
                $product_count = 0;
                if ($featured_products->have_posts()):
                    while ($featured_products->have_posts()): $featured_products->the_post();
                        global $product;
                        $product_count++;
                ?>
                    <div class="product-card">
                    <div class="relative">
                        <a href="<?php echo esc_url($product->get_permalink()); ?>" class="block">
                            <?php if ($product->get_image()): ?>
                                <?php echo $product->get_image('large', array('class' => 'w-full h-64 object-cover rounded-lg')); ?>
                            <?php else: ?>
                                <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </a>
                        
                        <?php if ($product->is_on_sale()): ?>
                            <span class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                Sale
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <h3 class="title-h3 mb-2 mt-4">
                        <a href="<?php echo esc_url($product->get_permalink()); ?>" class="hover:text-primary-500 transition-colors">
                            <?php echo $product->get_name(); ?>
                        </a>
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
                    
                    <div class="mb-4" style="font-size: 36px; font-weight: bold; color: black;">
                        <?php echo $product->get_price_html(); ?>
                    </div>
                    
                    <div class="flex items-center justify-between gap-1">
                        <div class="flex items-center gap-1">
                            <button class="quantity-btn disabled" style="width: 56px; height: 56px; background-color: white; border: 1px solid #D9E2E7;" data-action="decrease">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 10H16" stroke="#96A2AF" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </button>
                            <input type="text" class="quantity-input text-center" style="width: 56px; height: 56px; background-color: #EEF2F6; border: none; border-radius: 8px;" value="1">
                            <button class="quantity-btn" style="width: 56px; height: 56px; background-color: white; border: 1px solid #D9E2E7;" data-action="increase">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 10H16M10 4V16" stroke="#25AAE1" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </button>
                        </div>
                        <button class="btn-gradient" data-product-id="<?php echo $product->get_id(); ?>">
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
                <!-- Fallback products if no featured products exist -->
                <?php for ($i = 1; $i <= 3; $i++): ?>
                    <div class="product-card">
                        <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="title-h3 mb-2">ForceX Product <?php echo $i; ?></h3>
                        <p class="text-gray-600 mb-4 text-sm">Advanced therapy technology for optimal recovery and performance.</p>
                        <div class="mb-4" style="font-size: 36px; font-weight: bold; color: black;">$299.00</div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center ">
                                <button class="quantity-btn disabled" style="width: 56px; height: 56px; background-color: white; border: 1px solid #D9E2E7;" data-action="decrease">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4 10H16" stroke="#96A2AF" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </button>
                                <input type="text" class="quantity-input text-center" style="width: 56px; height: 56px; background-color: #EEF2F6; border: none; border-radius: 8px;" value="1">
                                <button class="quantity-btn" style="width: 56px; height: 56px; background-color: white; border: 1px solid #D9E2E7;" data-action="increase">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4 10H16M10 4V16" stroke="#25AAE1" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </button>
                            </div>
                            <button class="btn-gradient" data-product-id="<?php echo $i; ?>">
                                <span>PURCHASE</span>
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                <?php 
                    endfor;
                    $product_count = 3;
                endif; 
                ?>
            </div>
            
            <!-- Mobile: Slider layout -->
            <div class="products-mobile">
                <div class="products-slider-container overflow-hidden">
                    <div class="products-slider-track flex transition-transform duration-300 ease-in-out" id="products-slider-track">
                        <?php
                        // Get featured products from devices category only for mobile
                        $featured_mobile_args = array(
                            'post_type' => 'product',
                            'posts_per_page' => 3,
                            'post_status' => 'publish',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_cat',
                                    'field' => 'slug',
                                    'terms' => array('devices', 'device'),
                                    'operator' => 'IN'
                                )
                            ),
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
                            'meta_key' => '_price',
                            'orderby' => 'meta_value_num',
                            'order' => 'DESC'
                        );
                        
                        // If no featured devices found, get regular devices
                        $featured_products_mobile = new WP_Query($featured_mobile_args);
                        if (!$featured_products_mobile->have_posts()) {
                            $featured_mobile_args = array(
                                'post_type' => 'product',
                                'posts_per_page' => 3,
                                'post_status' => 'publish',
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'product_cat',
                                        'field' => 'slug',
                                        'terms' => array('devices', 'device'),
                                        'operator' => 'IN'
                                    )
                                ),
                                'meta_key' => '_price',
                                'orderby' => 'meta_value_num',
                                'order' => 'DESC'
                            );
                            $featured_products_mobile = new WP_Query($featured_mobile_args);
                        }
                        if ($featured_products_mobile->have_posts()):
                            while ($featured_products_mobile->have_posts()): $featured_products_mobile->the_post();
                                global $product;
                        ?>
                            <div class="products-slide w-full flex-shrink-0 px-2">
                                <div class="product-card">
                                    <div class="relative">
                                        <a href="<?php echo esc_url($product->get_permalink()); ?>" class="block">
                                            <?php if ($product->get_image()): ?>
                                                <?php echo $product->get_image('large', array('class' => 'w-full h-64 object-cover rounded-lg')); ?>
                                            <?php else: ?>
                                                <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            <?php endif; ?>
                                        </a>
                                        
                                        <?php if ($product->is_on_sale()): ?>
                                            <span class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                                Sale
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <h3 class="title-h3 mb-2 mt-4">
                                        <a href="<?php echo esc_url($product->get_permalink()); ?>" class="hover:text-primary-500 transition-colors">
                                            <?php echo $product->get_name(); ?>
                                        </a>
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
                                    
                                    <div class="mb-4" style="font-size: 36px; font-weight: bold; color: black;">
                                        <?php echo $product->get_price_html(); ?>
                                    </div>
                                    
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center ">
                                            <button class="quantity-btn disabled" style="width: 56px; height: 56px; background-color: white; border: 1px solid #D9E2E7;" data-action="decrease">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4 10H16" stroke="#96A2AF" stroke-width="2" stroke-linecap="round"/>
                                                </svg>
                                            </button>
                                            <input type="text" class="quantity-input text-center" style="width: 56px; height: 56px; background-color: #EEF2F6; border: none; border-radius: 8px;" value="1">
                                            <button class="quantity-btn" style="width: 56px; height: 56px; background-color: white; border: 1px solid #D9E2E7;" data-action="increase">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4 10H16M10 4V16" stroke="#25AAE1" stroke-width="2" stroke-linecap="round"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <button class="btn-gradient" data-product-id="<?php echo $product->get_id(); ?>">
                                            <span>PURCHASE</span>
                                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php
                            endwhile;
                            wp_reset_postdata();
                        else:
                            // Fallback products
                            for ($i = 1; $i <= 3; $i++):
                        ?>
                            <div class="products-slide w-full flex-shrink-0 px-2">
                                <div class="product-card">
                                    <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center mb-4">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="title-h3 mb-2">ForceX Product <?php echo $i; ?></h3>
                                    <p class="text-gray-600 mb-4 text-sm">Advanced therapy technology for optimal recovery and performance.</p>
                                    <div class="mb-4" style="font-size: 36px; font-weight: bold; color: black;">$299.00</div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center ">
                                            <button class="quantity-btn disabled" style="width: 56px; height: 56px; background-color: white; border: 1px solid #D9E2E7;" data-action="decrease">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4 10H16" stroke="#96A2AF" stroke-width="2" stroke-linecap="round"/>
                                                </svg>
                                            </button>
                                            <input type="text" class="quantity-input text-center" style="width: 56px; height: 56px; background-color: #EEF2F6; border: none; border-radius: 8px;" value="1">
                                            <button class="quantity-btn" style="width: 56px; height: 56px; background-color: white; border: 1px solid #D9E2E7;" data-action="increase">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4 10H16M10 4V16" stroke="#25AAE1" stroke-width="2" stroke-linecap="round"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <button class="btn-gradient" data-product-id="<?php echo $i; ?>">
                                            <span>PURCHASE</span>
                                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php 
                            endfor;
                        endif;
                        ?>
                    </div>
                </div>
                
                <!-- Mobile Slider Navigation -->
                <div class="products-navigation flex items-center justify-center mt-5">
                    <!-- Indicators -->
                    <div class="products-indicators flex items-center gap-2" id="products-indicators">
                        <?php 
                        $indicator_count = isset($product_count) ? $product_count : 3;
                        for ($i = 0; $i < $indicator_count; $i++): 
                        ?>
                            <div class="products-indicator <?php echo $i === 0 ? 'active' : ''; ?>" data-slide="<?php echo $i; ?>"></div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Applications Section -->
<section class="py-20 applications-section">
    <div class="container-custom">
        <div class="text-center mb-16  mt-16">
            <h2 class="title-h2">Applications</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                ForceX devices are designed for various body parts and applications to meet your specific recovery needs.
            </p>
        </div>
        
        <div class="relative max-w-4xl mx-auto applications-image-container">
            <!-- Human silhouette image as background -->
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-20 bg-white">
    <div class="container-custom">
        <!-- Section Header with READ MORE button -->
        <div class="flex items-center justify-center relative mb-12 testimonials-header">
            <h2 class="title-h2">Testimonials</h2>
            <a href="<?php echo esc_url(get_post_type_archive_link('review') ?: home_url('/reviews')); ?>" class="btn-gradient text-sm absolute right-0 testimonials-read-more-desktop">
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
            
            // Group into pairs for desktop, individual for mobile
            $review_pairs = array_chunk($all_reviews, 2);
            $total_slides_desktop = count($review_pairs);
            $total_slides_mobile = count($all_reviews);
        ?>
            <!-- Reviews Slider -->
            <div class="relative">
                <!-- Desktop: Pairs layout -->
                <div class="home-reviews-desktop overflow-hidden">
                    <div class="home-reviews-slider-track-desktop flex transition-transform duration-300 ease-in-out" id="home-reviews-slider-track-desktop">
                        <?php foreach ($review_pairs as $pair) : ?>
                            <div class="home-reviews-slide-desktop w-full flex-shrink-0 px-2">
                                <div class="grid grid-cols-2 gap-8">
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
                
                <!-- Mobile: Individual reviews as slides -->
                <div class="home-reviews-mobile overflow-hidden">
                    <div class="home-reviews-slider-track flex transition-transform duration-300 ease-in-out" id="home-reviews-slider-track">
                        <?php foreach ($all_reviews as $review) : ?>
                            <div class="home-reviews-slide w-full flex-shrink-0 px-2">
                                <div class="card" style="background: linear-gradient(180deg, #EEF2F6 0%, #F5F9FC 100%);">
                                    <blockquote class="text-gray-700 mb-6 leading-relaxed text-justify" style="text-align: justify;">
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
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Slider Navigation -->
                <div class="flex items-center justify-center mt-8 gap-4 home-reviews-navigation">
                    <button type="button" id="home-reviews-slider-prev" class="home-reviews-slider-btn home-reviews-nav-btn" aria-label="Previous reviews">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/blueleftarrow.png" alt="Previous" class="h-6 w-auto pointer-events-none">
                    </button>
                    
                    <span id="home-reviews-slider-counter" class="text-gray-700 font-medium px-4 home-reviews-counter">1 / <?php echo $total_slides_desktop; ?></span>
                    
                    <!-- Mobile Indicators -->
                    <div class="home-reviews-indicators flex items-center gap-2" id="home-reviews-indicators">
                        <?php 
                        for ($i = 0; $i < $total_slides_mobile; $i++): 
                        ?>
                            <div class="home-reviews-indicator <?php echo $i === 0 ? 'active' : ''; ?>" data-slide="<?php echo $i; ?>"></div>
                        <?php endfor; ?>
                    </div>
                    
                    <button type="button" id="home-reviews-slider-next" class="home-reviews-slider-btn home-reviews-nav-btn" aria-label="Next reviews">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/bluerightarrow.svg" alt="Next" class="h-6 w-auto pointer-events-none">
                    </button>
                </div>
                
                <!-- Mobile READ MORE button -->
                <div class="text-center mt-6 testimonials-read-more-mobile">
                    <a href="<?php echo esc_url(get_post_type_archive_link('review') ?: home_url('/reviews')); ?>" class="btn-gradient text-sm">
                        READ MORE
                    </a>
                </div>
            </div>
        <?php else : ?>
            <div class="text-center py-12">
                <p class="text-gray-500">No reviews found.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Articles & Press Releases Section -->
<?php
// Get latest 5 articles (query before section to use in counter)
$articles_query = new WP_Query(array(
    'post_type' => 'article',
    'posts_per_page' => 5,
    'orderby' => 'date',
    'order' => 'DESC',
    'post_status' => 'publish'
));
$total_articles = $articles_query->found_posts;
$display_count = min(5, $total_articles);
// Calculate total pages: 2 cards per slide on desktop, 1 on mobile (JS will handle dynamic update)
$cards_per_slide_desktop = 2;
$total_pages = ceil($display_count / $cards_per_slide_desktop);
?>
<section class="articles-slider-section py-20 relative">
    <div class="articles-section-bg absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/articlesbg.png');"></div>
    
    <div class="container-custom relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start lg:items-stretch">
            <!-- Left Side: Title, Controls, and Button -->
            <div class="lg:col-span-4 flex flex-col lg:h-full">
                <h2 class="text-4xl lg:text-5xl font-bold text-white mb-8 leading-tight" style="font-family: 'Host Grotesk', sans-serif;">
                    Articles &<br>Press Releases
                </h2>
                
                <!-- Slider Navigation Controls -->
                <div class="flex items-center gap-4 mb-6">
                    <button class="articles-slider-prev-btn" id="articles-slider-prev" type="button" aria-label="Previous articles">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/left_slider_arrow.svg" alt="Previous" class="w-12 h-12">
                    </button>
                    
                    <span class="text-white font-medium text-xl" id="articles-slider-counter">
                        <span class="articles-slider-counter-number text-3xl">1</span> / <span id="articles-total-count"><?php echo $total_pages; ?></span>
                    </span>
                    
                    <button class="articles-slider-next-btn" id="articles-slider-next" type="button" aria-label="Next articles">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/right_slider_arrow.svg" alt="Next" class="w-12 h-12">
                    </button>
                </div>
                
                <!-- SEE MORE Button -->
                <a href="<?php echo esc_url(get_post_type_archive_link('article') ?: home_url('/blog')); ?>" class="btn-white text-sm inline-block lg:mt-auto lg:self-start">
                    SEE MORE
                </a>
            </div>
            
            <!-- Right Side: Articles Slider -->
            <div class="lg:col-span-8">
                <?php if ($articles_query->have_posts()) : ?>
                    <div class="articles-slider-container overflow-hidden">
                        <div class="articles-slider-track flex transition-transform duration-300 ease-in-out" id="articles-slider-track">
                            <?php 
                            $article_count = 0;
                            while ($articles_query->have_posts()) : $articles_query->the_post();
                                $article_count++;
                                $terms = wp_get_post_terms(get_the_ID(), 'article_type', array('fields' => 'slugs'));
                                $badge_type = in_array('press-release', $terms) ? 'press-release' : 'article';
                                $badge_label = $badge_type === 'press-release' ? 'PRESS RELEASE' : 'ARTICLE';
                                $badge_class = $badge_type === 'press-release' ? 'bg-primary-500 text-white' : 'bg-gray-800 text-white';
                                $date_format = get_the_date('F j / Y');
                            ?>
                                <div class="articles-slider-slide w-full flex-shrink-0 px-3">
                                    <article class="articles-card bg-white rounded  shadow-lg overflow-hidden h-full">
                                        <div class="relative">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <?php the_post_thumbnail('large', array('class' => 'w-full h-64 object-cover')); ?>
                                            <?php else : ?>
                                                <div class="w-full h-64 bg-gray-200"></div>
                                            <?php endif; ?>
                                            
                                            <!-- Badge overlay -->
                                            <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide <?php echo esc_attr($badge_class); ?>">
                                                <?php echo esc_html($badge_label); ?>
                                            </span>
                                        </div>
                                        
                                        <div class="p-6">
                                            <h3 class="text-xl font-bold text-gray-900 mb-3 leading-tight" style="font-family: 'Host Grotesk', sans-serif;">
                                                <a href="<?php the_permalink(); ?>" class="hover:text-primary-500 transition-colors title-h3">
                                                    <?php the_title(); ?>
                                                </a>
                                            </h3>
                                            <time class="text-sm text-gray-500"><?php echo esc_html($date_format); ?></time>
                                        </div>
                                    </article>
                                </div>
                            <?php 
                            endwhile;
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="text-white text-center py-12">
                        <p>No articles found.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
