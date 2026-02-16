<?php
/**
 * Template Name: Nordic Health Systems
 * Description: Nordic Health Systems company page
 */

defined('ABSPATH') || exit;

get_header(); ?>

<?php
// Start the loop
while (have_posts()) : the_post();
?>

<main id="main" class="site-main relative min-h-screen nordic-hero-section" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/rentbg.png'); background-position: top; background-repeat: no-repeat; background-size: contain;">
    <div class="relative z-10 nordic-top-section">
        <!-- Breadcrumbs -->
        <div class="container-custom py-12 max-w-[1200px]">
            <nav class="mb-6">
                <div class="flex justify-center">
                    <ol class="flex items-center  text-base text-gray-500 bg-white px-4 py-2 rounded-full">
                        <li><a href="<?php echo home_url(); ?>" class="hover:text-primary-500">Main</a></li>
                        <li class="flex items-center">
                            <span class="mx-2 text-gray-400">/</span>
                            <span class="text-gray-900 font-medium">Company</span>
                        </li>
                    </ol>
                </div>
            </nav>
        </div>

        <!-- Company Name -->
        <div class="container-custom py-8 max-w-[1200px]">
            <div class="text-center">
                <h1 class="title-h1 text-white  ">Nordic Health Systems</h1>
            </div>
        </div>

        <!-- Company Tagline -->
        <div class="container-custom max-w-[1200px] mb-8">
            <div class="text-white text-center text-lg md:text-xl" style="max-width: 800px; margin: 0 auto;">
                <p>
                    Nordic Health Systems is a medical device company dedicated to advancing recovery solutions through innovative therapy technologies.
                </p>
            </div>
        </div>

        <!-- Mission Statement -->
        <div class="container-custom max-w-[1200px] mb-8">
            <div class="text-white text-center" style="max-width: 900px; margin: 0 auto;">
                <p style="font-size: 36px; line-height: 40px; font-weight: 400; letter-spacing: 0%;">
                    For more than two decades, our leadership has been at the forefront of energy-based rehabilitation and performance medicine, pioneering innovations that have shaped modern physical therapy.
                </p>
            </div>
        </div>

    </div>

    <!-- Products Showcase Section -->
    <section class="py-20 relative w-full" style="overflow-x: hidden; overflow-y: visible;">
        <!-- Products Scrolling Container -->
        <div class="nordic-products-scroll-container w-full" style="overflow-x: hidden; overflow-y: visible; padding-top: 40px; padding-bottom: 40px;">
            <div class="nordic-products-track flex gap-12 px-6" id="nordic-products-track">
                    <?php
                    // Product data
                    $products = array(
                        array(
                            'image' => '1.jpg',
                            'title' => 'ForceX CX-3',
                            'description' => 'Compact and powerful compression therapy system for targeted treatment.'
                        ),
                        array(
                            'image' => '1.jpg',
                            'title' => 'ForceX CX-5',
                            'description' => 'Advanced compression therapy with enhanced features for professional use.'
                        ),
                        array(
                            'image' => '2.jpg',
                            'title' => 'ForceX CX-9',
                            'description' => 'Premium compression therapy system with maximum power and versatility.'
                        ),
                    );
                    
                    // Duplicate items for seamless loop (3 sets for smooth animation)
                    $duplicated_products = array_merge($products, $products, $products);
                    
                    $index = 0;
                    foreach ($duplicated_products as $product):
                        // Alternate between up and down positions
                        $is_up = ($index % 2 === 0);
                        $transform = $is_up ? 'translateY(-30px)' : 'translateY(30px)';
                        $index++;
                    ?>
                        <div class="nordic-product-card flex-shrink-0 bg-white p-6 flex items-center gap-6" style="width: 500px; min-width: 500px; transform: <?php echo $transform; ?>;">
                            <!-- Image on the left -->
                            <div class="flex-shrink-0">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/<?php echo esc_attr($product['image']); ?>" alt="<?php echo esc_attr($product['title']); ?>" class="w-40 h-32 object-contain">
                            </div>
                            <!-- Text on the right -->
                            <div class="flex flex-col justify-center">
                                <h3 class="text-2xl md:text-3xl  text-gray-900 mb-3"><?php echo esc_html($product['title']); ?></h3>
                                <p class="text-gray-600 text-base leading-relaxed"><?php echo esc_html($product['description']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
            </div>
        </div>
        <!-- Additional Text -->
        <div class="container-custom max-w-[1200px] mt-20">
            <div class="text-center" style="max-width: 900px; margin: 0 auto;">
                <p style="font-size: 22px; line-height: 32px; font-weight: 400; letter-spacing: 0%; color: #333;">
                    From the compact ForceX CX-3 to the powerful CX-9, our compression therapy systems deliver science-driven results. Our innovative approach has redefined how clinicians restore function, relieve pain, and accelerate recovery.
                </p>
            </div>
        </div>
 
    </section>

    <!-- ForceX Technology Section -->
    <section class="py-20 relative" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/nordic_blue_background.png'); background-position: center; background-repeat: no-repeat; background-size: cover;">
        <div class="container-custom max-w-[1400px] mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center bg-white p-6" style="border-top-left-radius: 80px; border-bottom-right-radius: 80px;">
                <!-- Left Column - Content -->
                <div>
                    <h2 class="title-h2 text-white mb-6">ForceX™ technology</h2>
                    
                    <!-- Features List -->
                    <div class="flex flex-wrap gap-4 mb-8">
                        <div class="flex items-center gap-2" style="background-color: #FFFFFF; border-radius: 9999px; padding: 4px;">
                            <div class="flex items-center justify-center" style="width: 32px; height: 32px; background-color: #F0F2F5; border-radius: 50%;">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/23.svg" alt="Smart touchscreen" style="width: 20px; height: 20px;">
                            </div>
                            <span style="font-size: 18px; color: #000000; font-weight: 500;">Smart touchscreen</span>
                        </div>
                        <div class="flex items-center gap-2" style="background-color: #FFFFFF; border-radius: 9999px; padding: 4px;">
                            <div class="flex items-center justify-center" style="width: 32px; height: 32px; background-color: #F0F2F5; border-radius: 50%;">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/22.svg" alt="Iceless technology" style="width: 20px; height: 20px;">
                            </div>
                            <span style="font-size: 18px; color: #000000; font-weight: 500;">Iceless technology</span>
                        </div>
                        <div class="flex items-center gap-2" style="background-color: #FFFFFF; border-radius: 9999px; padding: 4px;">
                            <div class="flex items-center justify-center" style="width: 32px; height: 32px; background-color: #F0F2F5; border-radius: 50%;">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/25.svg" alt="Intuitive controls" style="width: 20px; height: 20px;">
                            </div>
                            <span style="font-size: 18px; color: #000000; font-weight: 500;">Intuitive controls</span>
                        </div>
                        <div class="flex items-center gap-2" style="background-color: #FFFFFF; border-radius: 9999px; padding: 4px;">
                            <div class="flex items-center justify-center" style="width: 32px; height: 32px; background-color: #F0F2F5; border-radius: 50%;">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/24.svg" alt="Program memory" style="width: 20px; height: 20px;">
                            </div>
                            <span style="font-size: 18px; color: #000000; font-weight: 500;">Program memory</span>
                        </div>
                        <div class="flex items-center gap-2" style="background-color: #FFFFFF; border-radius: 9999px; padding: 4px;">
                            <div class="flex items-center justify-center" style="width: 32px; height: 32px; background-color: #F0F2F5; border-radius: 50%;">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/21.svg" alt="Handle structure" style="width: 20px; height: 20px;">
                            </div>
                            <span style="font-size: 18px; color: #000000; font-weight: 500;">Handle structure</span>
                        </div>
                    </div>
                    
                    <!-- Description Text -->
                    <p class="text-lg mb-8 leading-relaxed">
                        The ForceX therapy system represents the next step in our innovation: a powerful, intelligent tool designed to enhance circulation, mobility, and healing through precision and evidence-based design.
                    </p>
                    
                    <!-- FIND OUT MORE Button -->
                    <a href="<?php echo esc_url(home_url('/technology')); ?>" class="btn-primary inline-block">
                        FIND OUT MORE
                    </a>
                </div>
                
                <!-- Right Column - Product Images -->
                <div class="flex justify-center lg:justify-end">
                    <div class="">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/ProductImage.png" alt="ForceX CX9" class="w-full h-auto object-contain" style="max-width: 400px;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Who We Serve Section -->
    <?php
    $who_we_serve_items = forcex_get_who_we_serve_items();
    if (!empty($who_we_serve_items)):
    ?>
    <div class="bg-white py-16 md:py-24 px-4 md:px-8 who-rents-section" style="overflow-x: hidden;">
        <div class="container-custom mx-auto" style="max-width: 950px;">
            <!-- Section Title -->
            <h2 class="title-h2 mb-8 md:mb-12 text-center" style="color: #000;">
                Who we serve
            </h2>

            <!-- Navigation Tabs -->
            <div class="mb-8 md:mb-12 overflow-x-auto">
                <div class="rent-tabs-container flex gap-1 justify-center min-w-max px-1 py-1 rounded-full" id="nordic-who-serve-tabs">
                    <?php foreach ($who_we_serve_items as $index => $item): 
                        $tab_slug = sanitize_title($item['tab_label']);
                        $is_first = $index === 0;
                    ?>
                        <button class="rent-tab-btn px-1 md:px-4 py-1 md:py-2 rounded-full font-medium whitespace-nowrap transition-all <?php echo $is_first ? 'active' : ''; ?>" data-tab="<?php echo esc_attr($tab_slug); ?>">
                            <?php echo esc_html($item['tab_label']); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Slides Container -->
            <div class="rent-slides-container" style="position: relative; width: 100%;">
                <div class="rent-slides-track" id="nordic-who-serve-slides-track">
                    <?php foreach ($who_we_serve_items as $index => $item): 
                        $tab_slug = sanitize_title($item['tab_label']);
                        $is_first = $index === 0;
                        
                        // Get background image URL
                        $bg_image_url = '';
                        if (!empty($item['bg_image_id'])) {
                            $bg_image_url = wp_get_attachment_image_url(intval($item['bg_image_id']), 'full');
                        }
                        if (empty($bg_image_url)) {
                            $bg_image_url = get_template_directory_uri() . '/assets/img/recovery_bg.png';
                        }
                        
                        $bg_position = !empty($item['bg_position']) ? esc_attr($item['bg_position']) : 'center right';
                        $gradient_direction = !empty($item['gradient_direction']) ? esc_attr($item['gradient_direction']) : 'to left';
                    ?>
                        <div class="rent-slide <?php echo $is_first ? 'active first-slide' : ''; ?>" data-slide="<?php echo esc_attr($tab_slug); ?>">
                            <div class="rounded-lg relative overflow-hidden w-full h-full" style="height: 100%; background-image: linear-gradient(<?php echo $gradient_direction; ?>, rgba(4, 89, 150, 0.7) 0%, rgba(4, 89, 150, 0.3) 50%, transparent 100%), url('<?php echo esc_url($bg_image_url); ?>'); background-position: <?php echo $bg_position; ?>; background-repeat: no-repeat; background-size: cover;">
                                <!-- White box in bottom left corner -->
                                <div class="absolute bottom-4 left-4 md:bottom-10 md:left-10 bg-white p-3 md:p-5 max-w-[calc(100%-2rem)] md:max-w-[70%] z-10 rounded-md">
                                    <h3 class="text-xl md:text-3xl lg:text-3xl mb-3 md:mb-4" style="color: #000;"><?php echo esc_html($item['title']); ?></h3>
                                    
                                    <?php if (!empty($item['description'])): ?>
                                        <p class="text-gray-700 text-xs md:text-base leading-relaxed">
                                            <?php echo esc_html($item['description']); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Key Products Section -->
    <?php
    $key_products = forcex_get_key_products();
    if (!empty($key_products)):
    ?>
    <section class="py-20 relative" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/articlesbg.png'); background-position: center; background-repeat: no-repeat; background-size: cover;">
        <div class="container-custom max-w-[1400px] mx-auto px-4">
            <!-- Section Title -->
            <h2 class="title-h2 text-white text-center mb-12">Key products</h2>
            
            <!-- Products Slider -->
            <div class="key-products-slider-container relative">
                <div class="key-products-slider-track" id="key-products-slider-track">
                    <?php foreach ($key_products as $index => $product_id):
                        $product = wc_get_product($product_id);
                        if (!$product) continue;
                    ?>
                        <div class="key-products-slide" data-slide-index="<?php echo $index; ?>">
                            <div class="bg-white rounded-lg p-8 md:p-12 w-full" style="max-width: 1024px; margin-left: auto; margin-right: auto;">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                                    <!-- Product Image -->
                                    <div class="flex justify-center">
                                        <?php if ($product->get_image_id()): ?>
                                            <?php echo $product->get_image('large', array('class' => 'w-full h-auto object-contain', 'style' => 'max-width: 400px;')); ?>
                                        <?php else: ?>
                                            <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center" style="max-width: 400px;">
                                                <span class="text-gray-400">No image</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Product Info -->
                                    <div>
                                        <h3 class="text-3xl md:text-4xl  text-gray-900 mb-3"><?php echo esc_html($product->get_name()); ?></h3>
                                        <p class="text-gray-600 text-lg mb-6">
                                            <?php 
                                            $description = $product->get_short_description();
                                            if (empty($description)) {
                                                $description = $product->get_description();
                                            }
                                            if (empty($description)) {
                                                $description = 'Heat and cold compression therapy machine';
                                            }
                                            echo esc_html(wp_trim_words(wp_strip_all_tags($description), 20));
                                            ?>
                                        </p>
                                        
                                        <!-- Price -->
                                        <?php if ($product->get_price()): ?>
                                            <div class="text-4xl font-bold text-gray-900 mb-6">
                                                <?php echo $product->get_price_html(); ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <!-- Quantity and Purchase -->
                                        <div class="flex items-center gap-2">
                                            <div class="flex items-center gap-2">
                                                <button class="quantity-btn disabled" 
                                                        style="width: 56px; height: 56px; background-color: white; border: 1px solid #D9E2E7;" 
                                                        data-action="decrease">
                                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M4 10H16" stroke="#96A2AF" stroke-width="2" stroke-linecap="round"/>
                                                    </svg>
                                                </button>
                                                <input type="text" 
                                                       class="quantity-input text-center" 
                                                       style="width: 56px; height: 56px; background-color: #EEF2F6; border: none; border-radius: 8px;" 
                                                       value="1"
                                                       data-product-id="<?php echo esc_attr($product->get_id()); ?>">
                                                <button class="quantity-btn" 
                                                        style="width: 56px; height: 56px; background-color: white; border: 1px solid #D9E2E7;" 
                                                        data-action="increase">
                                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M4 10H16M10 4V16" stroke="#25AAE1" stroke-width="2" stroke-linecap="round"/>
                                                    </svg>
                                                </button>
                                            </div>
                                            <button class="btn-gradient key-product-add-to-cart flex items-center" 
                                                    data-product-id="<?php echo esc_attr($product->get_id()); ?>"
                                                    style="padding: 16px 32px;">
                                                <span>PURCHASE</span>
                                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Navigation Dots -->
                <div class="flex items-center justify-center gap-3 mt-8" id="key-products-dots" style="max-width: 1024px; margin-left: auto; margin-right: auto; width: 100%;">
                    <?php foreach ($key_products as $index => $product_id):
                        $is_first = $index === 0;
                    ?>
                        <button class="key-product-dot <?php echo $is_first ? 'active' : ''; ?>" 
                                data-slide-index="<?php echo $index; ?>"
                                style="flex: 1; height: 4px; border-radius: 2px; transition: all 0.3s ease; <?php echo $is_first ? 'background-color: #fff;' : 'background-color: rgba(255, 255, 255, 0.4);'; ?>">
                        </button>
                    <?php endforeach; ?>
                </div>
                
                <!-- View All Products Button -->
                <div class="text-center mt-12">
                    <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop')) ?: home_url('/products')); ?>" class="btn-white">
                        VIEW ALL PRODUCTS
                    </a>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Our Leadership Section -->
    <section class="py-20" style="background-color: #f0f3f7;">
        <div class="container-custom max-w-[1400px] mx-auto px-4">
            <!-- Section Title -->
            <div class="text-center mb-8">
                <h2 class="title-h2 mb-4">Our leadership</h2>
                <p class="text-lg text-gray-700 max-w-3xl mx-auto leading-relaxed">
                    Nordic Health Systems is led by a team of innovators committed to advancing the science and clinical impact of energy-based medicine.
                </p>
            </div>
            
            <!-- Leadership Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
                <!-- Card 1: Douglas S. Johnson -->
                <div class="leadership-card bg-white p-8" style="border-radius: 0 80px 0 0;">
                    <div class="flex flex-col">
                        <!-- Profile Image -->
                        <div class="mb-6" style="width: 122px; height: 112px;">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/man1.png" alt="Douglas S. Johnson" class="w-full h-full object-cover rounded-full" style="border: 1px solid #D9E2E7;" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center rounded-full" style="display: none; border: 1px solid #D9E2E7;">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Name -->
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 text-left">Douglas S. Johnson</h3>
                        
                        <!-- Title Badge -->
                        <div class="mb-4">
                            <span class="inline-block px-4 py-2 rounded-full text-sm font-medium" style="background-color: #EEF2F6; color: #748394;">
                                Chief Science Officer
                            </span>
                        </div>
                        
                        <!-- Description -->
                        <p class="text-gray-600 mb-6 leading-relaxed text-left">
                            Led global research and regulatory strategy for PBM, Shockwave, Radiofrequency, and Imaging platforms.
                        </p>
                        
                        <!-- Button -->
                        <div class="text-left">
                            <a href="#" class="btn-gradient text-sm inline-block">
                                FIND OUT MORE
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Card 2: Max Kanarsky -->
                <div class="leadership-card bg-white p-8" style="border-radius: 0 80px 0 0;">
                    <div class="flex flex-col">
                        <!-- Profile Image -->
                        <div class="mb-6" style="width: 122px; height: 112px;">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/man2.png" alt="Max Kanarsky" class="w-full h-full object-cover rounded-full" style="border: 1px solid #D9E2E7;" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center rounded-full" style="display: none; border: 1px solid #D9E2E7;">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Name -->
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 text-left">Max Kanarsky</h3>
                        
                        <!-- Title Badges -->
                        <div class="mb-4 flex flex-wrap gap-2">
                            <span class="inline-block px-4 py-2 rounded-full text-sm font-medium" style="background-color: #EEF2F6; color: #748394;">
                                Founder
                            </span>
                            <span class="inline-block px-4 py-2 rounded-full text-sm font-medium" style="background-color: #EEF2F6; color: #748394;">
                                Chief Executive Officer
                            </span>
                        </div>
                        
                        <!-- Description -->
                        <p class="text-gray-600 mb-6 leading-relaxed text-left">
                            World leader in the development of energy-based medical technologies.
                        </p>
                        
                        <!-- Button -->
                        <div class="text-left">
                            <a href="#" class="btn-gradient text-sm inline-block">
                                FIND OUT MORE
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Card 3: Douglas S. Johnson (Duplicate) -->
                <div class="leadership-card bg-white p-8" style="border-radius: 0 80px 0 0;">
                    <div class="flex flex-col">
                        <!-- Profile Image -->
                        <div class="mb-6" style="width: 122px; height: 112px;">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/man1.png" alt="Douglas S. Johnson" class="w-full h-full object-cover rounded-full" style="border: 1px solid #D9E2E7;" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center rounded-full" style="display: none; border: 1px solid #D9E2E7;">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Name -->
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 text-left">Douglas S. Johnson</h3>
                        
                        <!-- Title Badge -->
                        <div class="mb-4">
                            <span class="inline-block px-4 py-2 rounded-full text-sm font-medium" style="background-color: #EEF2F6; color: #748394;">
                                Chief Science Officer
                            </span>
                        </div>
                        
                        <!-- Description -->
                        <p class="text-gray-600 mb-6 leading-relaxed text-left">
                            Led global research and regulatory strategy for PBM, Shockwave, Radiofrequency, and Imaging platforms.
                        </p>
                        
                        <!-- Button -->
                        <div class="text-left">
                            <a href="#" class="btn-gradient text-sm inline-block">
                                FIND OUT MORE
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="pb-20" style="background-color: #f0f3f7;">
        <div class="container-custom max-w-[1400px] mx-auto px-4">
            <div class="max-w-[900px] mx-auto">
                <div class="bg-white p-8 md:p-12" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/articlesbg.png'); background-position: center; background-repeat: no-repeat; background-size: cover; border-radius: 80px 0 80px 0;">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
                        <!-- Left Section: Profile -->
                        <div class="flex flex-col items-center md:items-start">
                            <!-- Profile Image -->
                            <div class="mb-6" style="width: 72px; height: 72px;">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/man1.png" alt="Douglas S. Johnson" class="w-full h-full object-cover rounded-full" style="border: 1px solid #fff;">
                            </div>
                            
                            <!-- Name -->
                            <h3 class="text-xl font-bold text-white mb-3">Douglas S. Johnson</h3>
                            
                            <!-- Title Badge -->
                            <div class="mb-4">
                                <span class="inline-block px-4 py-2 rounded-full text-sm font-medium" style="background-color: #045996; color: #fff;">
                                    Chief Science Officer
                                </span>
                            </div>
                        </div>
                        
                        <!-- Right Section: Quote -->
                        <div class="md:col-span-2">
                            <blockquote class="text-white" style="color: #fff; font-family: 'Host Grotesk', sans-serif; font-weight: 400; font-style: normal; font-size: 28px; line-height: 32px; ">
                                "Our mission is to create clinically optimized solutions for fast recovery — reducing pain, controlling swelling, and accelerating healing, all without the need for ice or complex equipment"
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Vision Section -->
    <section class="py-20 " style="background-color: #eef2f6;">
        <div class="container-custom">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
                <!-- Left Column -->
                <div>
                    <h2 class="title-h2">
                        Our vision
                    </h2>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        Driving innovation and advancing recovery solutions to empower clinicians, improve patient outcomes, and expand access worldwide.
                    </p>
                </div>
                
                <!-- Right Column - 3 Vision Cards -->
                <div class="tech-widget-container">
                    <!-- Desktop: Regular stacked layout -->
                    <div class="tech-widget-desktop space-y-6">
                        <!-- Card 1: Advance clinical research -->
                        <div class="rounded-xl p-6 shadow-sm" style="background:#fff;">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pp1.png" alt="Advance clinical research" class="object-contain" style="width: 240px; height: 240px;">
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 mb-2" style="font-size: 28px;">Advance clinical research</h3>
                                    <p class="text-gray-600 leading-relaxed" style="font-size: 18px;">
                                        Our vision is to continue expanding our global footprint, bringing innovative recovery technologies to more healthcare professionals, clinics, and patients worldwide.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Card 2: Empower healthcare professionals -->
                        <div class="rounded-xl p-6 shadow-sm" style="background:#fff;">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pp2.png" alt="Empower healthcare professionals" class="object-contain" style="width: 240px; height: 240px;">
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 mb-2" style="font-size: 28px;">Empower healthcare professionals</h3>
                                    <p class="text-gray-600 leading-relaxed" style="font-size: 18px;">
                                        We strive to equip clinicians with the latest advancements in recovery technology, empowering them to improve patient outcomes and transform recovery protocols with smart, evidence-driven solutions.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Card 3: Expand global impact and education -->
                        <div class="rounded-xl p-6 shadow-sm" style="background:#fff;">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pp3.png" alt="Expand global impact and education" class="object-contain" style="width: 240px; height: 240px;">
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 mb-2" style="font-size: 28px;">Expand global impact and education</h3>
                                    <p class="text-gray-600 leading-relaxed" style="font-size: 18px;">
                                        As leaders in clinical research, our goal is to continuously push the boundaries of energy-based medicine, ensuring that our products remain scientifically validated and effective in treating a wide range of conditions.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mobile: Slider layout -->
                    <div class="tech-widget-mobile">
                        <div class="tech-widget-slider-container overflow-hidden">
                            <div class="tech-widget-slider-track flex transition-transform duration-300 ease-in-out" id="tech-widget-slider-track-nordic">
                                <!-- Card 1: Advance clinical research -->
                                <div class="tech-widget-slide w-full flex-shrink-0 px-2">
                                    <div class="rounded-xl p-6 shadow-sm" style="background:#fff;">
                                        <div class="flex flex-col items-center gap-4 text-center">
                                            <div class="flex-shrink-0">
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pp1.png" alt="Advance clinical research" class="object-contain mx-auto" style="width: 150px; height: 150px;">
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-gray-900 mb-2" style="font-size: 22px;">Advance clinical research</h3>
                                                <p class="text-gray-600 leading-relaxed" style="font-size: 16px;">
                                                    Our vision is to continue expanding our global footprint, bringing innovative recovery technologies to more healthcare professionals, clinics, and patients worldwide.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Card 2: Empower healthcare professionals -->
                                <div class="tech-widget-slide w-full flex-shrink-0 px-2">
                                    <div class="rounded-xl p-6 shadow-sm" style="background:#fff;">
                                        <div class="flex flex-col items-center gap-4 text-center">
                                            <div class="flex-shrink-0">
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pp2.png" alt="Empower healthcare professionals" class="object-contain mx-auto" style="width: 150px; height: 150px;">
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-gray-900 mb-2" style="font-size: 22px;">Empower healthcare professionals</h3>
                                                <p class="text-gray-600 leading-relaxed" style="font-size: 16px;">
                                                    We strive to equip clinicians with the latest advancements in recovery technology, empowering them to improve patient outcomes and transform recovery protocols with smart, evidence-driven solutions.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Card 3: Expand global impact and education -->
                                <div class="tech-widget-slide w-full flex-shrink-0 px-2">
                                    <div class="rounded-xl p-6 shadow-sm" style="background:#fff;">
                                        <div class="flex flex-col items-center gap-4 text-center">
                                            <div class="flex-shrink-0">
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pp3.png" alt="Expand global impact and education" class="object-contain mx-auto" style="width: 150px; height: 150px;">
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-gray-900 mb-2" style="font-size: 22px;">Expand global impact and education</h3>
                                                <p class="text-gray-600 leading-relaxed" style="font-size: 16px;">
                                                    As leaders in clinical research, our goal is to continuously push the boundaries of energy-based medicine, ensuring that our products remain scientifically validated and effective in treating a wide range of conditions.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Mobile Slider Navigation -->
                        <div class="tech-widget-navigation flex items-center justify-between mt-5">
                            <button class="tech-widget-prev" data-slider="nordic">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/left_slider_arrow.svg" alt="Previous" class="w-12 h-12">
                            </button>
                            
                            <!-- Indicators -->
                            <div class="tech-widget-indicators flex items-center gap-2 flex-1 justify-center" data-slider="nordic">
                                <div class="tech-widget-indicator active" data-slide="0"></div>
                                <div class="tech-widget-indicator" data-slide="1"></div>
                                <div class="tech-widget-indicator" data-slide="2"></div>
                            </div>
                            
                            <button class="tech-widget-next" data-slider="nordic">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/right_slider_arrow.svg" alt="Next" class="w-12 h-12">
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Partner with us Form Section -->
    <section class="py-20 relative" style="background-color: #EEF2F6; background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/gradientform.png'); background-position: center bottom; background-repeat: no-repeat; background-size: cover;">
        <div class="container-custom max-w-[1400px] mx-auto px-4">
            <div class="max-w-2xl mx-auto">
                <!-- Form Card -->
                <div class="bg-white p-8 md:p-12 rounded-lg shadow-lg">
                    <!-- Title and Description -->
                    <div class="mb-8 text-center">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Partner with us</h2>
                        <p class="text-gray-600 text-base md:text-lg">
                            Complete the form below. Our representative will contact you to explore partnership opportunities.
                        </p>
                    </div>

                    <!-- Form -->
                    <form id="partner-form" class="forcex-contact-form" data-form-source="partner">
                       <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/embed/v2.js"></script>
                          <script>
                            hbspt.forms.create({
                              portalId: "7594926",
                              formId: "d696bb67-ddab-4be1-bc3c-cda63f45e280",
                              region: "na1"
                            });
                          </script>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<?php endwhile; ?>

<style>
/* Nordic Hero Section Mobile Background */
@media (max-width: 1023px) {
    .nordic-top-section {
        position: relative;
    }
    
    .nordic-top-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(180deg, #0D3452 0%, rgba(13, 52, 82, 0.9) 60%, rgba(13, 52, 82, 0.7) 80%, transparent 100%);
        z-index: 0;
        pointer-events: none;
    }
    
    .nordic-top-section > * {
        position: relative;
        z-index: 1;
    }
}

.forcex-contact-form input::placeholder,
.forcex-contact-form textarea::placeholder {
    color: #748394;
}

.nordic-products-scroll-container {
    position: relative;
    width: 100%;
    overflow-x: hidden;
    overflow-y: visible;
}

.nordic-products-track {
    display: flex;
    animation: scroll-nordic-products 30s linear infinite;
    will-change: transform;
}

@keyframes scroll-nordic-products {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-33.333%);
    }
}

.nordic-product-card {
    /* No hover effects */
}

/* Pause animation on hover */
.nordic-products-scroll-container:hover .nordic-products-track {
    animation-play-state: paused;
}

/* Who We Serve Section Styles - Same as Who Rents */
.who-rents-section {
    overflow-x: hidden;
    position: relative;
}

/* Slider Container: Allows slides to extend beyond container boundaries */
.rent-slides-container {
    position: relative;
    width: 100%;
    height: 500px;
    overflow: visible;
}

/* Track: Inner container that slides with transform */
.rent-slides-track {
    display: flex;
    position: relative;
    width: max-content;
    height: 500px;
    transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    will-change: transform;
    gap: 16px;
}

.rent-slide {
    flex-shrink: 0;
    width: 900px;
    height: 500px;
    opacity: 1;
    visibility: visible;
    transition: opacity 0.3s ease;
}

.rent-slide > div {
    height: 100%;
    width: 100%;
}

/* Active slide - centered and full opacity */
.rent-slide.active {
    opacity: 1;
    z-index: 10;
}

/* Non-active slides - same size and full opacity */
.rent-slide:not(.active) {
    opacity: 1;
    z-index: 1;
}

/* Tabs Container - Background Secondary */
.rent-tabs-container {
    background-color: #f0f3f7;
}

/* Active button - uses btn-primary gradient */
.rent-tab-btn.active {
    background: linear-gradient(135deg, #25AAE1 0%, #004F8C 100%);
    color: #fff !important;
    border: none !important;
    font-size: 18px;
    box-shadow: 0 4px 15px rgba(37, 170, 225, 0.4);
}

/* Non-active buttons - white background */
.rent-tab-btn:not(.active) {
    background-color: #fff !important;
    color: #333 !important;
    border: none !important;
    font-size: 18px;
}

.rent-tab-btn:hover:not(.active) {
    background-color: #f8f9fa !important;
}

/* Mobile: Keep slides centered, show one at a time */
@media (max-width: 1023px) {
    .who-rents-section {
        overflow-x: hidden !important;
        padding-left: 1rem !important;
        padding-right: 1rem !important;
    }
    
    .who-rents-section .rent-slides-container {
        overflow: hidden !important;
        width: 100% !important;
        height: auto !important;
        min-height: 400px;
    }
    
    .who-rents-section .rent-slides-track {
        height: auto !important;
        min-height: 400px;
        width: 100% !important;
        display: flex;
        flex-direction: column;
        gap: 0 !important;
    }
    
    .who-rents-section .rent-slide {
        width: 100% !important;
        max-width: 100% !important;
        height: auto !important;
        min-height: 400px;
        opacity: 0 !important;
        visibility: hidden !important;
        position: absolute;
        top: 0;
        left: 0;
    }
    
    .who-rents-section .rent-slide.active {
        opacity: 1 !important;
        visibility: visible !important;
        position: relative;
    }
    
    .who-rents-section .rent-slide > div {
        min-height: 400px;
        height: auto;
    }
    
    /* Tabs container mobile */
    .who-rents-section .rent-tabs-container {
        justify-content: flex-start !important;
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }
    
    .who-rents-section .rent-tab-btn {
        font-size: 14px !important;
        padding: 8px 12px !important;
        white-space: nowrap;
    }
}

/* Key Products Slider Styles */
.key-products-slider-container {
    position: relative;
    width: 100%;
    overflow: hidden;
}

.key-products-slider-track {
    display: flex;
    transition: transform 0.5s ease-in-out;
    width: 100%;
    align-items: center;
    cursor: grab;
    user-select: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    touch-action: pan-y;
}

.key-products-slider-track:active {
    cursor: grabbing;
}

.key-products-slider-track.dragging {
    transition: none;
}

.key-products-slide {
    flex: 0 0 100%;
    width: 100%;
    min-width: 100%;
    display: flex;
    justify-content: center;
    align-items: flex-start;
}

.key-products-slide > div {
    width: 100%;
    max-width: 1024px;
}

.key-product-dot {
    cursor: pointer;
    border: none;
    padding: 0;
    transition: all 0.3s ease;
}

.key-product-dot.active {
    background-color: #fff !important;
}

.key-product-dot:not(.active) {
    background-color: rgba(255, 255, 255, 0.4) !important;
}

/* Quantity buttons use the same styles as home page */
#key-products-slider-track .quantity-btn {
    cursor: pointer;
    transition: all 0.2s ease;
}

#key-products-slider-track .quantity-btn:hover:not(.disabled) {
    background-color: #f0f3f7 !important;
}

#key-products-slider-track .quantity-btn.disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Key Products Slider
    const keyProductsSliderTrack = document.getElementById('key-products-slider-track');
    const keyProductsDots = document.querySelectorAll('.key-product-dot');
    const keyProductsSlides = document.querySelectorAll('.key-products-slide');
    
    if (!keyProductsSliderTrack || keyProductsSlides.length === 0) return;
    
    let currentSlide = 0;
    const totalSlides = keyProductsSlides.length;
    
    // Touch/swipe variables
    let touchStartX = 0;
    let touchEndX = 0;
    let isDragging = false;
    let startPos = 0;
    let currentTranslate = 0;
    let prevTranslate = 0;
    let animationID = 0;
    
    function updateKeyProductsSlider() {
        // Update dots
        keyProductsDots.forEach((dot, index) => {
            dot.classList.remove('active');
            if (index === currentSlide) {
                dot.classList.add('active');
                dot.style.backgroundColor = '#fff';
            } else {
                dot.style.backgroundColor = 'rgba(255, 255, 255, 0.4)';
            }
        });
        
        // Update slider position - center the active slide
        const translateX = -currentSlide * 100;
        keyProductsSliderTrack.style.transform = `translateX(${translateX}%)`;
        currentTranslate = translateX;
        prevTranslate = translateX;
    }
    
    function goToSlide(index) {
        if (index < 0) index = 0;
        if (index >= totalSlides) index = totalSlides - 1;
        currentSlide = index;
        updateKeyProductsSlider();
    }
    
    // Touch event handlers
    function getPositionX(event) {
        return event.type.includes('mouse') ? event.clientX : event.touches[0].clientX;
    }
    
    function touchStart(event) {
        startPos = getPositionX(event);
        isDragging = true;
        animationID = requestAnimationFrame(animation);
        keyProductsSliderTrack.style.cursor = 'grabbing';
        keyProductsSliderTrack.classList.add('dragging');
    }
    
    function touchMove(event) {
        if (!isDragging) return;
        const currentPosition = getPositionX(event);
        const moved = currentPosition - startPos;
        const slideWidth = keyProductsSliderTrack.offsetWidth;
        const translateX = prevTranslate + (moved / slideWidth) * 100;
        
        // Prevent sliding beyond boundaries with resistance
        const minTranslate = -(totalSlides - 1) * 100;
        const maxTranslate = 0;
        
        if (translateX > maxTranslate) {
            // Add resistance when dragging past the first slide
            currentTranslate = maxTranslate + (translateX - maxTranslate) * 0.3;
        } else if (translateX < minTranslate) {
            // Add resistance when dragging past the last slide
            currentTranslate = minTranslate + (translateX - minTranslate) * 0.3;
        } else {
            currentTranslate = translateX;
        }
    }
    
    function touchEnd() {
        if (!isDragging) return;
        cancelAnimationFrame(animationID);
        isDragging = false;
        keyProductsSliderTrack.style.cursor = 'grab';
        keyProductsSliderTrack.classList.remove('dragging');
        
        const movedBy = currentTranslate - prevTranslate;
        
        // Determine if we should change slide (threshold: 30% of slide width)
        if (movedBy < -30 && currentSlide < totalSlides - 1) {
            // Swiped left - go to next slide
            goToSlide(currentSlide + 1);
        } else if (movedBy > 30 && currentSlide > 0) {
            // Swiped right - go to previous slide
            goToSlide(currentSlide - 1);
        } else {
            // Snap back to current slide
            updateKeyProductsSlider();
        }
    }
    
    function animation() {
        keyProductsSliderTrack.style.transform = `translateX(${currentTranslate}%)`;
        if (isDragging) requestAnimationFrame(animation);
    }
    
    // Add touch event listeners
    keyProductsSliderTrack.addEventListener('touchstart', touchStart, { passive: true });
    keyProductsSliderTrack.addEventListener('touchmove', touchMove, { passive: true });
    keyProductsSliderTrack.addEventListener('touchend', touchEnd);
    
    // Add mouse event listeners for desktop drag support
    keyProductsSliderTrack.addEventListener('mousedown', touchStart);
    keyProductsSliderTrack.addEventListener('mousemove', touchMove);
    keyProductsSliderTrack.addEventListener('mouseup', touchEnd);
    keyProductsSliderTrack.addEventListener('mouseleave', touchEnd);
    
    // Prevent image drag
    keyProductsSliderTrack.addEventListener('dragstart', (e) => e.preventDefault());
    
    // Dot navigation
    keyProductsDots.forEach((dot, index) => {
        dot.addEventListener('click', function() {
            goToSlide(index);
        });
    });
    
    // Quantity controls
    document.querySelectorAll('#key-products-slider-track .quantity-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const action = this.getAttribute('data-action');
            const input = this.closest('.flex').querySelector('.quantity-input');
            if (!input) return;
            
            let value = parseInt(input.value) || 1;
            if (action === 'increase') {
                value++;
            } else if (action === 'decrease' && value > 1) {
                value--;
            }
            
            input.value = value;
            
            // Update decrease button state
            const decreaseBtn = this.closest('.flex').querySelector('.quantity-btn[data-action="decrease"]');
            if (decreaseBtn) {
                if (value <= 1) {
                    decreaseBtn.classList.add('disabled');
                } else {
                    decreaseBtn.classList.remove('disabled');
                }
            }
        });
    });
    
    // Add to cart
    document.querySelectorAll('.key-product-add-to-cart').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const quantityInput = this.closest('.flex').querySelector('.quantity-input');
            const quantity = quantityInput ? parseInt(quantityInput.value) || 1 : 1;
            
            // Add to cart via AJAX
            if (typeof forcex_ajax !== 'undefined') {
                const formData = new FormData();
                formData.append('action', 'forcex_add_to_cart');
                formData.append('product_id', productId);
                formData.append('quantity', quantity);
                formData.append('nonce', forcex_ajax.nonce);
                
                fetch(forcex_ajax.ajax_url, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update cart count if element exists
                        const cartCount = document.getElementById('cart-count');
                        if (cartCount && data.cart_count !== undefined) {
                            cartCount.textContent = data.cart_count;
                            cartCount.style.display = data.cart_count > 0 ? 'flex' : 'none';
                        }
                        // Trigger cart update event
                        document.dispatchEvent(new CustomEvent('cart_updated'));
                        // Redirect to cart
                        window.location.href = '<?php echo esc_url(wc_get_cart_url()); ?>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            } else {
                // Fallback: redirect to product page
                window.location.href = '<?php echo esc_url(home_url()); ?>/product/?add-to-cart=' + productId + '&quantity=' + quantity;
            }
        });
    });
    
    // Initialize
    updateKeyProductsSlider();
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('#nordic-who-serve-tabs .rent-tab-btn');
    const slides = document.querySelectorAll('#nordic-who-serve-slides-track .rent-slide');
    const slidesTrack = document.getElementById('nordic-who-serve-slides-track');
    
    if (!slidesTrack) return;
    
    // Get slide width including gap
    function getSlideWidth() {
        if (window.innerWidth <= 1023) {
            const container = document.querySelector('.who-rents-section .rent-slides-container');
            return container ? container.offsetWidth : window.innerWidth - 32; // Account for padding
        }
        return 900; // Fixed 900px on desktop
    }
    
    // Get gap between slides
    function getSlideGap() {
        return 16; // 16px gap as defined in CSS
    }
    
    // Calculate transform to center a slide in the container
    function centerSlide(slideIndex) {
        if (window.innerWidth <= 1023) {
            // On mobile, just show/hide slides - no transform needed
            slides.forEach((slide, index) => {
                if (index === slideIndex) {
                    slide.classList.add('active');
                } else {
                    slide.classList.remove('active');
                }
            });
            slidesTrack.style.transform = 'translateX(0)';
            return;
        }
        
        const slideWidth = getSlideWidth();
        const gap = getSlideGap();
        const container = document.querySelector('.who-rents-section .rent-slides-container');
        if (!container) return;
        
        const containerWidth = container.offsetWidth;
        const containerCenter = containerWidth / 2;
        
        // Calculate slide position: each slide takes slideWidth + gap (except last one)
        const slideStart = slideIndex * (slideWidth + gap);
        const slideCenter = slideStart + (slideWidth / 2);
        
        // Translate track so slide center aligns with container center
        const translateX = containerCenter - slideCenter;
        
        slidesTrack.style.transform = `translateX(${translateX}px)`;
    }
    
    // Initialize: center first slide
    function initializeSlider() {
        centerSlide(0);
    }
    
    // Run after DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeSlider);
    } else {
        initializeSlider();
    }
    
    // Also run after a short delay to ensure layout is calculated
    setTimeout(initializeSlider, 100);
    
    // And on window load
    window.addEventListener('load', initializeSlider);
    
    tabButtons.forEach((button) => {
        button.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            const targetSlide = document.querySelector(`#nordic-who-serve-slides-track .rent-slide[data-slide="${targetTab}"]`);
            const currentActiveSlide = document.querySelector('#nordic-who-serve-slides-track .rent-slide.active');
            
            if (!targetSlide || targetSlide === currentActiveSlide) return;
            
            // Remove active class from all buttons
            tabButtons.forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Remove active class from current slide
            if (currentActiveSlide) {
                currentActiveSlide.classList.remove('active');
            }
            
            // Add active class to target slide
            targetSlide.classList.add('active');
            
            // Find the index of the target slide
            const slideIndex = Array.from(slides).indexOf(targetSlide);
            
            // Slide track to center the selected slide
            centerSlide(slideIndex);
        });
    });
    
    // Recalculate on window resize
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            const activeSlide = document.querySelector('#nordic-who-serve-slides-track .rent-slide.active');
            if (activeSlide) {
                const slideIndex = Array.from(slides).indexOf(activeSlide);
                centerSlide(slideIndex);
            }
        }, 250);
    });
});
</script>

<?php get_footer(); ?>

