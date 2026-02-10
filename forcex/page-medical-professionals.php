<?php
/**
 * Template Name: For Medical Professionals
 * Description: For medical professionals page template
 */

defined('ABSPATH') || exit;

get_header();
?>

<style>
    .forcex-contact-form input::placeholder {
        color: #748394;
    }
</style>

<main id="main" class="site-main relative bg-white"  >
 
    <div class=" container-custom py-12 pb-24 md:pb-32 relative z-10" style="max-width: 900px; margin: 0 auto;">
        <!-- Breadcrumbs -->
        <nav class="mb-6">
            <div class="flex justify-center">
                <ol class="flex items-center  text-sm text-gray-500 bg-white px-3 py-1.5 md:px-4 md:py-2 rounded-full medical-professionals-breadcrumbs">
                    <li><a href="<?php echo home_url(); ?>" class="hover:text-primary-500">Main</a></li>
                    <li class="flex items-center">
                        <span class="mx-1.5 md:mx-2 text-gray-400">/</span>
                        <a href="<?php echo esc_url(home_url('/get-forcex')); ?>" class="hover:text-primary-500">Get ForceX</a>
                    </li>
                    <li class="flex items-center">
                        <span class="mx-1.5 md:mx-2 text-gray-400">/</span>
                        <span class="text-gray-900 font-medium text-xs md:text-sm"><?php echo esc_html(get_the_title()); ?></span>
                    </li>
                </ol>
            </div>
        </nav>

        <!-- Main Heading -->
        <div class="text-center mb-8">
            <h1 class="title-h2 mb-4">
                <?php echo esc_html(get_the_title()); ?>
            </h1>
            <?php
            // Get description from excerpt or content
            $description = '';
            if (has_excerpt()) {
                $description = get_the_excerpt();
            } elseif (get_the_content()) {
                $content = get_the_content();
                $content = wp_strip_all_tags($content);
                $description = wp_trim_words($content, 50);
            }
            if ($description) : ?>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    <?php echo esc_html($description); ?>
                </p>
            <?php endif; ?>
        </div>
    </div>

    <!-- 5 Therapy Options Section -->
    <section class="py-20 bg-white">
        <div class="container-custom">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
                <!-- Left Column -->
                <div>
                    <h2 class="title-h2">
                        5 therapy options of ForceX™ technology
                    </h2>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        ForceX powered by CDC Tech is the first system to deliver dynamic positive compression with intelligent heat and cold cycling.
                    </p>
                </div>
                
                <!-- Right Column - 5 Therapy Options -->
                <div class="tech-widget-container">
                    <!-- Desktop: Regular stacked layout -->
                    <div class="tech-widget-desktop space-y-6">
                        <!-- Option 1: Heat therapy -->
                        <div class="rounded-xl p-6 shadow-sm" style="background-color: #EEF2F6;">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pp1.png" alt="Heat therapy" class="object-contain" style="width: 240px; height: 240px;">
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 mb-2" style="font-size: 28px;">Heat therapy</h3>
                                    <p class="text-gray-600 leading-relaxed" style="font-size: 18px;">
                                        Promotes blood flow, relaxes muscles, and alleviates stiffness by expanding blood vessels. It's effective for chronic pain, muscle tension, and improving flexibility.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Option 2: Cold therapy -->
                        <div class="rounded-xl p-6 shadow-sm" style="background-color: #EEF2F6;">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pp2.png" alt="Cold therapy" class="object-contain" style="width: 240px; height: 240px;">
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 mb-2" style="font-size: 28px;">Cold therapy</h3>
                                    <p class="text-gray-600 leading-relaxed" style="font-size: 18px;">
                                        Helps reduce inflammation, numb pain, and limit swelling by constricting blood vessels, making it ideal for acute injuries and post-surgical recovery.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Option 3: Compression therapy -->
                        <div class="rounded-xl p-6 shadow-sm" style="background-color: #EEF2F6;">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pp3.png" alt="Compression therapy" class="object-contain" style="width: 240px; height: 240px;">
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 mb-2" style="font-size: 28px;">Compression therapy</h3>
                                    <p class="text-gray-600 leading-relaxed" style="font-size: 18px;">
                                        Uses controlled pressure to enhance circulation, reduce swelling, and accelerate tissue recovery. It's ideal for managing edema and improving recovery after surgery or injury.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Option 4: Heat compression therapy -->
                        <div class="rounded-xl p-6 shadow-sm" style="background-color: #EEF2F6;">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pp4.png" alt="Heat compression therapy" class="object-contain" style="width: 240px; height: 240px;">
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 mb-2" style="font-size: 28px;">Heat compression therapy</h3>
                                    <p class="text-gray-600 leading-relaxed" style="font-size: 18px;">
                                        Provides soothing warmth along with compression to increase blood flow, relax muscles, and relieve stiffness. It's ideal for chronic pain relief, muscle recovery, and improving joint mobility.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Option 5: Cold compression therapy -->
                        <div class="rounded-xl p-6 shadow-sm" style="background-color: #EEF2F6;">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pp5.png" alt="Cold compression therapy" class="object-contain" style="width: 240px; height: 240px;">
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 mb-2" style="font-size: 28px;">Cold compression therapy</h3>
                                    <p class="text-gray-600 leading-relaxed" style="font-size: 18px;">
                                        Targets inflammation, pain, and swelling. It provides the benefits of ice therapy with the added advantage of reducing swelling through continuous compression.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mobile: Slider layout -->
                    <div class="tech-widget-mobile">
                        <div class="tech-widget-slider-container overflow-hidden">
                            <div class="tech-widget-slider-track flex transition-transform duration-300 ease-in-out" id="tech-widget-slider-track-medical">
                                <!-- Option 1: Heat therapy -->
                                <div class="tech-widget-slide w-full flex-shrink-0 px-2">
                                    <div class="rounded-xl p-6 shadow-sm" style="background-color: #EEF2F6;">
                                        <div class="flex flex-col items-center gap-4 text-center">
                                            <div class="flex-shrink-0">
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pp1.png" alt="Heat therapy" class="object-contain mx-auto" style="width: 150px; height: 150px;">
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-gray-900 mb-2" style="font-size: 22px;">Heat therapy</h3>
                                                <p class="text-gray-600 leading-relaxed" style="font-size: 16px;">
                                                    Promotes blood flow, relaxes muscles, and alleviates stiffness by expanding blood vessels. It's effective for chronic pain, muscle tension, and improving flexibility.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Option 2: Cold therapy -->
                                <div class="tech-widget-slide w-full flex-shrink-0 px-2">
                                    <div class="rounded-xl p-6 shadow-sm" style="background-color: #EEF2F6;">
                                        <div class="flex flex-col items-center gap-4 text-center">
                                            <div class="flex-shrink-0">
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pp2.png" alt="Cold therapy" class="object-contain mx-auto" style="width: 150px; height: 150px;">
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-gray-900 mb-2" style="font-size: 22px;">Cold therapy</h3>
                                                <p class="text-gray-600 leading-relaxed" style="font-size: 16px;">
                                                    Helps reduce inflammation, numb pain, and limit swelling by constricting blood vessels, making it ideal for acute injuries and post-surgical recovery.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Option 3: Compression therapy -->
                                <div class="tech-widget-slide w-full flex-shrink-0 px-2">
                                    <div class="rounded-xl p-6 shadow-sm" style="background-color: #EEF2F6;">
                                        <div class="flex flex-col items-center gap-4 text-center">
                                            <div class="flex-shrink-0">
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pp3.png" alt="Compression therapy" class="object-contain mx-auto" style="width: 150px; height: 150px;">
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-gray-900 mb-2" style="font-size: 22px;">Compression therapy</h3>
                                                <p class="text-gray-600 leading-relaxed" style="font-size: 16px;">
                                                    Uses controlled pressure to enhance circulation, reduce swelling, and accelerate tissue recovery. It's ideal for managing edema and improving recovery after surgery or injury.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Option 4: Heat compression therapy -->
                                <div class="tech-widget-slide w-full flex-shrink-0 px-2">
                                    <div class="rounded-xl p-6 shadow-sm" style="background-color: #EEF2F6;">
                                        <div class="flex flex-col items-center gap-4 text-center">
                                            <div class="flex-shrink-0">
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pp4.png" alt="Heat compression therapy" class="object-contain mx-auto" style="width: 150px; height: 150px;">
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-gray-900 mb-2" style="font-size: 22px;">Heat compression therapy</h3>
                                                <p class="text-gray-600 leading-relaxed" style="font-size: 16px;">
                                                    Provides soothing warmth along with compression to increase blood flow, relax muscles, and relieve stiffness. It's ideal for chronic pain relief, muscle recovery, and improving joint mobility.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Option 5: Cold compression therapy -->
                                <div class="tech-widget-slide w-full flex-shrink-0 px-2">
                                    <div class="rounded-xl p-6 shadow-sm" style="background-color: #EEF2F6;">
                                        <div class="flex flex-col items-center gap-4 text-center">
                                            <div class="flex-shrink-0">
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pp5.png" alt="Cold compression therapy" class="object-contain mx-auto" style="width: 150px; height: 150px;">
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-gray-900 mb-2" style="font-size: 22px;">Cold compression therapy</h3>
                                                <p class="text-gray-600 leading-relaxed" style="font-size: 16px;">
                                                    Targets inflammation, pain, and swelling. It provides the benefits of ice therapy with the added advantage of reducing swelling through continuous compression.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Mobile Slider Navigation -->
                        <div class="tech-widget-navigation flex items-center justify-between mt-5">
                            <button class="tech-widget-prev" data-slider="medical">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/left_slider_arrow.svg" alt="Previous" class="w-12 h-12">
                            </button>
                            
                            <!-- Indicators -->
                            <div class="tech-widget-indicators flex items-center gap-2 flex-1 justify-center" data-slider="medical">
                                <div class="tech-widget-indicator active" data-slide="0"></div>
                                <div class="tech-widget-indicator" data-slide="1"></div>
                                <div class="tech-widget-indicator" data-slide="2"></div>
                                <div class="tech-widget-indicator" data-slide="3"></div>
                                <div class="tech-widget-indicator" data-slide="4"></div>
                            </div>
                            
                            <button class="tech-widget-next" data-slider="medical">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/right_slider_arrow.svg" alt="Next" class="w-12 h-12">
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Key Benefits Slider Section -->
    <?php
    // Get slider items from admin or use hardcoded defaults
    $key_benefits_items = forcex_get_key_benefits_items();
    
    // If no items in admin, use hardcoded 6 images
    if (empty($key_benefits_items)) {
        for ($i = 1; $i <= 6; $i++) {
            $key_benefits_items[] = array(
                'image_url' => get_template_directory_uri() . '/assets/img/ss' . $i . '.png'
            );
        }
    }
    
    // Calculate slides: 3 items per slide
    $items_per_slide = 3;
    $total_items = count($key_benefits_items);
    $total_slides = ceil($total_items / $items_per_slide);
    ?>
    <section class="key-benefits-slider-section py-20 relative" style="background-color: #0D3452;">
        <div class="container-custom relative z-10">
            <!-- Section Title -->
            <h2 class="title-h2 text-white text-center mb-12" style="color: #fff;">
                Key benefits of ForceX™ technology
            </h2>
            
            <?php if (!empty($key_benefits_items)): ?>
                <!-- Slider Container -->
                <div class="key-benefits-slider-container relative">
                    <div class="key-benefits-slider-track overflow-hidden" id="key-benefits-slider-track">
                        <?php 
                        // Group items into slides (3 per slide)
                        $slides = array_chunk($key_benefits_items, $items_per_slide);
                        foreach ($slides as $slide_index => $slide_items): 
                        ?>
                            <div class="key-benefits-slide w-full flex-shrink-0 <?php echo $slide_index === 0 ? 'active' : ''; ?>" data-slide-index="<?php echo $slide_index; ?>">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <?php foreach ($slide_items as $item_index => $item): ?>
                                        <div class="key-benefits-card">
                                            <img src="<?php echo esc_url($item['image_url']); ?>" alt="Key Benefit <?php echo ($slide_index * $items_per_slide) + $item_index + 1; ?>" class="w-full h-auto object-contain" />
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Slider Navigation -->
                    <div class="flex items-center justify-center mt-8 gap-4">
                        <button type="button" id="key-benefits-slider-prev" class="key-benefits-slider-btn" aria-label="Previous slide">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/left_slider_arrow.svg" alt="Previous" class="h-6 w-auto pointer-events-none">
                        </button>
                        
                        <span id="key-benefits-slider-counter" class="text-white font-medium px-4">
                            <span class="text-2xl md:text-3xl font-bold">1</span> / <span class="text-lg md:text-xl text-gray-300"><?php echo $total_slides; ?></span>
                        </span>
                        
                        <button type="button" id="key-benefits-slider-next" class="key-benefits-slider-btn" aria-label="Next slide">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/right_slider_arrow.svg" alt="Next" class="h-6 w-auto pointer-events-none">
                        </button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Targeted Recovery Solutions Section -->
    <?php
    $recovery_items = forcex_get_targeted_recovery_items();
    if (!empty($recovery_items)):
    ?>
    <div class="bg-white py-16 md:py-24 px-4 md:px-8 targeted-recovery-section" style="overflow-x: hidden;">
        <div class="container-custom mx-auto" style="max-width: 950px;">
            <!-- Section Title -->
            <h2 class="title-h2 mb-8 md:mb-12 text-center" style="color: #000;">
                Targeted recovery solutions
            </h2>

            <!-- Navigation Tabs -->
            <div class="mb-8 md:mb-12 overflow-x-auto">
                <div class="lg:inline-block rent-tabs-container flex gap-1 justify-center min-w-max px-1 py-1 rounded-full" id="targeted-recovery-tabs">
                    <?php foreach ($recovery_items as $index => $item): 
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
                <div class="rent-slides-track" id="targeted-recovery-slides-track">
                    <?php foreach ($recovery_items as $index => $item): 
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
                                    
                                    <?php if (!empty($item['benefits']) && is_array($item['benefits'])): ?>
                                        <div class="flex flex-wrap items-center gap-1.5 md:gap-3 mb-3 md:mb-4">
                                            <?php foreach ($item['benefits'] as $benefit): 
                                                if (!empty(trim($benefit))):
                                            ?>
                                                <div class="inline-flex items-center gap-1.5 md:gap-2 px-1.5 md:px-1 py-1 rounded-full" style="background-color: #f0f3f7;">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/check.svg" alt="Check" class="w-5 h-5 md:w-6 md:h-6 flex-shrink-0 p-0.5 md:p-1 bg-white rounded-full">
                                                    <span class="text-gray-700 text-xs md:text-base"><?php echo esc_html($benefit); ?></span>
                                                </div>
                                            <?php 
                                                endif;
                                            endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    
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

    <!-- Contact Form Section -->
    <section class="py-16 md:py-24 px-4 md:px-8 relative" style=" background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/gradientform.png'); background-position: center bottom; background-repeat: no-repeat; background-size: cover; position: relative;">
        
        <div class="container-custom relative z-10" style="max-width: 900px; margin: 0 auto;">
            <!-- Form Section -->
            <div class="w-full bg-white p-8 md:p-12">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Rent ForceX™</h2>
                    <p class="text-gray-600">
                        Complete the form below, and our team will contact you with more information on distribution opportunities, pricing, and support.
                    </p>
                </div>

                <form id="medical-professionals-form" class="forcex-contact-form" data-form-source="medical-professionals">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="medical_professionals_first_name" class="block text-sm font-medium text-gray-700 mb-2 pl-4">
                                First name *
                            </label>
                            <input type="text" id="medical_professionals_first_name" name="first_name" required
                                   class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
                                   style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
                                   placeholder="Your name">
                        </div>
                        <div>
                            <label for="medical_professionals_last_name" class="block text-sm font-medium text-gray-700 mb-2 pl-4">
                                Last name *
                            </label>
                            <input type="text" id="medical_professionals_last_name" name="last_name" required
                                   class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
                                   style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
                                   placeholder="Your name">
                        </div>
                        <div>
                            <label for="medical_professionals_email" class="block text-sm font-medium text-gray-700 mb-2 pl-4">
                                Email *
                            </label>
                            <input type="email" id="medical_professionals_email" name="email" required
                                   class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
                                   style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
                                   placeholder="Email">
                        </div>
                        <div>
                            <label for="medical_professionals_phone" class="block text-sm font-medium text-gray-700 mb-2 pl-4">
                                Phone number *
                            </label>
                            <input type="tel" id="medical_professionals_phone" name="phone" required
                                   class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
                                   style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
                                   placeholder="Phone number">
                        </div>
                    </div>

                    <div id="medical-professionals-form-message" class="mb-6 hidden"></div>

                    <button type="submit" class="btn-gradient">
                        SUBMIT
                    </button>
                </form>
            </div>
        </div>
    </section>
</main>

<style>
/* Breadcrumbs Mobile Styles */
@media (max-width: 1023px) {
    .medical-professionals-breadcrumbs {
        border: 1px solid #D9E2E7 !important;
        font-size: 12px !important;
        padding: 8px 12px !important;
    }
    
    .medical-professionals-breadcrumbs li {
        font-size: 12px !important;
    }
    
    .medical-professionals-breadcrumbs a,
    .medical-professionals-breadcrumbs span {
        font-size: 12px !important;
    }
}

/* Targeted Recovery Section Styles - Reuse Who Rents styles */
.targeted-recovery-section {
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
    background-color: #f0f3f7; /* Background_Secondary */
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
    .targeted-recovery-section {
        overflow-x: hidden !important;
        padding-left: 1rem !important;
        padding-right: 1rem !important;
    }
    
    .targeted-recovery-section .rent-slides-container {
        overflow: hidden !important;
        width: 100% !important;
        height: auto !important;
        min-height: 400px;
    }
    
    .targeted-recovery-section .rent-slides-track {
        height: auto !important;
        min-height: 400px;
        width: 100% !important;
        display: flex;
        flex-direction: column;
        gap: 0 !important;
    }
    
    .targeted-recovery-section .rent-slide {
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
    
    .targeted-recovery-section .rent-slide.active {
        opacity: 1 !important;
        visibility: visible !important;
        position: relative;
    }
    
    .targeted-recovery-section .rent-slide > div {
        min-height: 400px;
        height: auto;
    }
    
    /* Tabs container mobile */
    .targeted-recovery-section .rent-tabs-container {
        justify-content: flex-start !important;
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }
    
    .targeted-recovery-section .rent-tab-btn {
        font-size: 14px !important;
        padding: 8px 12px !important;
        white-space: nowrap;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Targeted Recovery Solutions Slider
    const targetedRecoveryTabButtons = document.querySelectorAll('#targeted-recovery-tabs .rent-tab-btn');
    const targetedRecoverySlides = document.querySelectorAll('#targeted-recovery-slides-track .rent-slide');
    const targetedRecoverySlidesTrack = document.getElementById('targeted-recovery-slides-track');
    
    if (!targetedRecoverySlidesTrack) return;
    
    // Get slide width including gap
    function getTargetedRecoverySlideWidth() {
        if (window.innerWidth <= 1023) {
            const container = document.querySelector('.targeted-recovery-section .rent-slides-container');
            return container ? container.offsetWidth : window.innerWidth - 32; // Account for padding
        }
        return 900; // Fixed 900px on desktop
    }
    
    // Get gap between slides
    function getTargetedRecoverySlideGap() {
        return 16; // 16px gap as defined in CSS
    }
    
    // Calculate transform to center a slide in the container
    function centerTargetedRecoverySlide(slideIndex) {
        if (window.innerWidth <= 1023) {
            // On mobile, just show/hide slides - no transform needed
            targetedRecoverySlides.forEach((slide, index) => {
                if (index === slideIndex) {
                    slide.classList.add('active');
                } else {
                    slide.classList.remove('active');
                }
            });
            targetedRecoverySlidesTrack.style.transform = 'translateX(0)';
            return;
        }
        
        const slideWidth = getTargetedRecoverySlideWidth();
        const gap = getTargetedRecoverySlideGap();
        const container = document.querySelector('.targeted-recovery-section .rent-slides-container');
        if (!container) return;
        
        const containerWidth = container.offsetWidth; // 900px
        const containerCenter = containerWidth / 2; // 450px
        
        // Calculate slide position: each slide takes slideWidth + gap (except last one)
        // Slide center position in the track
        const slideStart = slideIndex * (slideWidth + gap);
        const slideCenter = slideStart + (slideWidth / 2);
        
        // Translate track so slide center aligns with container center
        const translateX = containerCenter - slideCenter;
        
        targetedRecoverySlidesTrack.style.transform = `translateX(${translateX}px)`;
    }
    
    // Initialize: center first slide
    function initializeTargetedRecoverySlider() {
        centerTargetedRecoverySlide(0);
    }
    
    // Run after DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeTargetedRecoverySlider);
    } else {
        initializeTargetedRecoverySlider();
    }
    
    // Also run after a short delay to ensure layout is calculated
    setTimeout(initializeTargetedRecoverySlider, 100);
    
    // And on window load
    window.addEventListener('load', initializeTargetedRecoverySlider);
    
    targetedRecoveryTabButtons.forEach((button) => {
        button.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            const targetSlide = document.querySelector(`#targeted-recovery-slides-track .rent-slide[data-slide="${targetTab}"]`);
            const currentActiveSlide = document.querySelector('#targeted-recovery-slides-track .rent-slide.active');
            
            if (!targetSlide || targetSlide === currentActiveSlide) return;
            
            // Remove active class from all buttons
            targetedRecoveryTabButtons.forEach(btn => {
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
            const slideIndex = Array.from(targetedRecoverySlides).indexOf(targetSlide);
            
            // Slide track to center the selected slide
            centerTargetedRecoverySlide(slideIndex);
        });
    });
    
    // Recalculate on window resize
    let targetedRecoveryResizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(targetedRecoveryResizeTimer);
        targetedRecoveryResizeTimer = setTimeout(function() {
            const activeSlide = document.querySelector('#targeted-recovery-slides-track .rent-slide.active');
            if (activeSlide) {
                const slideIndex = Array.from(targetedRecoverySlides).indexOf(activeSlide);
                centerTargetedRecoverySlide(slideIndex);
            }
        }, 250);
    });
});
</script>

<style>
/* Key Benefits Slider Styles */
.key-benefits-slider-container {
    position: relative;
    width: 100%;
}

.key-benefits-slider-track {
    display: flex;
    transition: transform 0.5s ease-in-out;
    width: 100%;
}

.key-benefits-slide {
    display: none;
    width: 100%;
}

.key-benefits-slide.active {
    display: block;
}

.key-benefits-card {
    display: flex;
    align-items: center;
    justify-content: center;
}

.key-benefits-slider-btn {
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 0;
    transition: opacity 0.3s ease;
}

.key-benefits-slider-btn:hover {
    opacity: 0.7;
}

.key-benefits-slider-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sliderTrack = document.getElementById('key-benefits-slider-track');
    const prevBtn = document.getElementById('key-benefits-slider-prev');
    const nextBtn = document.getElementById('key-benefits-slider-next');
    const counter = document.getElementById('key-benefits-slider-counter');
    
    if (!sliderTrack || !prevBtn || !nextBtn || !counter) return;
    
    const slides = sliderTrack.querySelectorAll('.key-benefits-slide');
    const totalSlides = slides.length;
    let currentSlide = 0;
    
    if (totalSlides <= 1) {
        prevBtn.style.display = 'none';
        nextBtn.style.display = 'none';
        return;
    }
    
    function updateSlider() {
        // Hide all slides
        slides.forEach((slide, index) => {
            slide.classList.remove('active');
            if (index === currentSlide) {
                slide.classList.add('active');
            }
        });
        
        // Update counter
        counter.innerHTML = `<span class="text-2xl md:text-3xl font-bold">${currentSlide + 1}</span> / <span class="text-lg md:text-xl text-gray-300">${totalSlides}</span>`;
        
        // Update button states
        prevBtn.disabled = currentSlide === 0;
        nextBtn.disabled = currentSlide === totalSlides - 1;
    }
    
    // Previous button
    prevBtn.addEventListener('click', function() {
        if (currentSlide > 0) {
            currentSlide--;
            updateSlider();
        }
    });
    
    // Next button
    nextBtn.addEventListener('click', function() {
        if (currentSlide < totalSlides - 1) {
            currentSlide++;
            updateSlider();
        }
    });
    
    // Initialize
    updateSlider();
});
</script>

<?php
get_footer();
?>

