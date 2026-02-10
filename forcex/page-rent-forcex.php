<?php
/**
 * Template Name: Rent ForceX
 * Description: Rent ForceX™ page with product features and information
 */

defined('ABSPATH') || exit;

get_header(); ?>

<style>
    .forcex-contact-form input::placeholder,
    .forcex-contact-form select option:first-child {
        color: #748394;
    }
    .forcex-contact-form select {
        background-color: #EEF2F6;
        border-radius: 32px;
        height: 48px;
        border: none;
        color: #748394;
    }
    .forcex-contact-form select:not([value=""]) {
        color: #000;
    }
</style>

<?php
// Start the loop
while (have_posts()) : the_post();
?>

<main id="main" class="site-main relative min-h-screen" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/rentbg.png'); background-position: center; background-repeat: no-repeat; background-size: cover;">
    <div class="relative z-10">
        <!-- Breadcrumbs -->
        <div class="container-custom py-12 max-w-[1200px]">
            <nav class="mb-6">
                <div class="flex justify-center">
                    <ol class="flex items-center  text-base text-gray-500 bg-white px-4 py-2 rounded-full">
                        <li><a href="<?php echo home_url(); ?>" class="hover:text-primary-500">Main</a></li>
                        <li class="flex items-center">
                            <span class="mx-2 text-gray-400">/</span>
                            <span class="text-gray-900 font-medium"><?php echo esc_html(get_the_title()); ?></span>
                        </li>
                    </ol>
                </div>
            </nav>
        </div>

        <!-- Page Title -->
        <div class="container-custom py-8 max-w-[1200px]">
            <div class="text-center mb-8">
                <h1 class="title-h1 text-white mb-6"><?php echo esc_html(get_the_title()); ?></h1>
            </div>
        </div>

        <!-- Product Description Text -->
        <div class="container-custom max-w-[1200px] mb-8">
            <div class="text-white text-center text-lg md:text-xl" style="max-width: 800px; margin: 0 auto;">
                <?php
                // Use excerpt if available, otherwise use first paragraph of content, or fallback text
                $description = '';
                if (has_excerpt()) {
                    $description = get_the_excerpt();
                } elseif (get_the_content()) {
                    $content = get_the_content();
                    $content = wp_strip_all_tags($content);
                    $description = wp_trim_words($content, 40);
                } else {
                    $description = "Whether you're recovering from orthopedic surgery, an injury, or managing chronic pain, the ForceX™ is designed to provide clinically proven heat, cold, and compression therapy right at home – without the hassle of ice or bulky equipment.";
                }
                echo wp_kses_post(wpautop($description));
                ?>
            </div>
        </div>

        <!-- Main Product Section -->
        <div class="container-custom py-6 md:py-12 max-w-[1400px] relative flex justify-center px-4 md:px-0">
            <!-- Product Display - Centered (In Front) -->
            <div class="flex flex-col items-center justify-center bg-white pt-4 md:pt-8 pl-4 md:pl-8 pr-4 md:pr-8 pb-4 md:pb-8 rounded-lg relative z-20 w-full md:w-auto" style="max-width: 400px;">
                <!-- Shifted White Boxes - Desktop Only (Behind Product) -->
                <div class="hidden md:block absolute inset-0 pointer-events-none" style="z-index: -1; width: 100%; height: 100%;">
                    <!-- First white box - 50% opacity -->
                    <div class="absolute bg-white rounded-lg" style="width: 400px; height: 400px; top: -30px; right: -30px; opacity: 0.5;"></div>
                    <!-- Second white box - 40% opacity -->
                    <div class="absolute bg-white rounded-lg" style="width: 400px; height: 400px; top: -70px; right: -45px; transform: translate(15px, 15px); opacity: 0.4;"></div>
                </div>
                
                <!-- 5 Therapy Modes Feature Bubble -->
                <div class="hidden md:flex md:items-center md:gap-4 px-3 py-3 rounded-full shadow-lg z-30 absolute" style="background: linear-gradient(135deg, #045895 0%, #123B5A 100%); top: -33px; left: -64%;">
                    <span class="text-white font-semibold text-lg whitespace-nowrap flex items-center" style="border: 2px solid white; padding: 4px 4px; border-radius: 40px;">
                        <span style="border-radius: 50%; width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: bold; font-size: 20px; font-weight:400;">5</span>
                        <span style="background-color: #3d6a8c; padding: 4px 12px; border-radius: 20px; font-size: 16px;">therapy modes</span>
                    </span>
                    <div class="flex items-center gap-2">
                        <!-- Cold therapy icon -->
                        <div class="rounded-full flex items-center justify-center" style="width: 48px; height: 48px; background-color: #E3F2FD;">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/snow.svg" alt="Cold" style="width: 32px; height: 32px;">
                        </div>
                        <!-- Heat therapy icon -->
                        <div class="rounded-full flex items-center justify-center" style="width: 48px; height: 48px; background-color: #FFEBEE;">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/fire.svg" alt="Heat" style="width: 32px; height: 32px;">
                        </div>
                        <!-- Compression/Target icon -->
                        <div class="rounded-full flex items-center justify-center bg-gray-800" style="width: 38px; height: 38px;">
                            <div class="rounded-full border-2 border-white" style="width: 24px; height: 24px;"></div>
                        </div>
                        <!-- Cold therapy icon -->
                        <div class="rounded-full flex items-center justify-center" style="width: 48px; height: 48px; background-color: #E3F2FD;">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/snow.svg" alt="Cold" style="width: 32px; height: 32px;">
                        </div>
                        <!-- Clock/Timer icon (using fire as placeholder) -->
                        <div class="rounded-full flex items-center justify-center" style="width: 48px; height: 48px; background-color: #FFEBEE;">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/fire.svg" alt="Timer" style="width: 32px; height: 32px;">
                        </div>
                    </div>
                </div>
                
                <!-- 5 Therapy Modes Feature Bubble - Mobile Version -->
                <div class="md:hidden mb-6 flex flex-col sm:flex-row items-center gap-2 sm:gap-4 px-3 py-3 rounded-full shadow-lg z-30 w-full" style="background: linear-gradient(135deg, #045895 0%, #123B5A 100%);">
                    <span class="text-white font-semibold text-base sm:text-lg whitespace-nowrap flex items-center" style="border: 2px solid white; padding: 4px 4px; border-radius: 40px;">
                        <span style="border-radius: 50%; width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center; font-weight: bold; font-size: 18px; font-weight:400;">5</span>
                        <span style="background-color: #3d6a8c; padding: 4px 10px; border-radius: 20px; font-size: 14px;">therapy modes</span>
                    </span>
                    <div class="flex items-center gap-1.5 sm:gap-2 flex-wrap justify-center">
                        <!-- Cold therapy icon -->
                        <div class="rounded-full flex items-center justify-center" style="width: 40px; height: 40px; background-color: #E3F2FD;">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/snow.svg" alt="Cold" style="width: 26px; height: 26px;">
                        </div>
                        <!-- Heat therapy icon -->
                        <div class="rounded-full flex items-center justify-center" style="width: 40px; height: 40px; background-color: #FFEBEE;">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/fire.svg" alt="Heat" style="width: 26px; height: 26px;">
                        </div>
                        <!-- Compression/Target icon -->
                        <div class="rounded-full flex items-center justify-center bg-gray-800" style="width: 32px; height: 32px;">
                            <div class="rounded-full border-2 border-white" style="width: 20px; height: 20px;"></div>
                        </div>
                        <!-- Cold therapy icon -->
                        <div class="rounded-full flex items-center justify-center" style="width: 40px; height: 40px; background-color: #E3F2FD;">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/snow.svg" alt="Cold" style="width: 26px; height: 26px;">
                        </div>
                        <!-- Clock/Timer icon (using fire as placeholder) -->
                        <div class="rounded-full flex items-center justify-center" style="width: 40px; height: 40px; background-color: #FFEBEE;">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/fire.svg" alt="Timer" style="width: 26px; height: 26px;">
                        </div>
                    </div>
                </div>
                
            <!-- Product Image -->
                <div class="mb-4 md:mb-6 flex justify-center w-full px-4 md:px-0" style="max-width: 330px;">
                    <?php
                    $cx9_image = home_url('/wp-content/uploads/2025/10/2-300x195.jpg');
                    ?>
                    <img src="<?php echo esc_url($cx9_image); ?>" alt="ForceX CX9" class="w-full h-auto object-contain" style="max-width: 330px;">
                </div>

                <!-- Product Name and Description -->
                <div class="text-center w-full px-4 md:px-0" style="max-width: 330px;">
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-2" style="color: #000;">ForceX CX9</h2>
                    <p class="text-base md:text-lg opacity-90" style="color: #000;">Heat and cold compression therapy machine</p>
                </div>
                
                <!-- Smart Touchscreen Feature Bubble - Upper Right -->
                <div class="hidden md:flex items-center gap-3 px-1 py-1 rounded-full shadow-lg z-30 absolute text-white" style="background-color: #b6d9e8; top: -107px; right: -70%;">
                    <div class="bg-white rounded-full flex items-center justify-center flex-shrink-0" style="width: 38px; height: 38px;">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/rent1.svg" alt="Smart touchscreen" style="width: 27px; height: 27px;">
                    </div>
                    <span class="whitespace-nowrap  pr-5 " style="color: #fff; font-size: 24px;">Smart touchscreen</span>
                </div>
                
                <!-- Intuitive Controls Feature Bubble - Below Smart Touchscreen -->
                <div class="hidden md:flex items-center gap-3 px-1 py-1 rounded-full shadow-lg z-30 absolute text-white" style="background-color: #b6d9e8; top: -59px; right: -85%;">
                    <div class="bg-white rounded-full flex items-center justify-center flex-shrink-0" style="width: 38px; height: 38px;">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/rent2.svg" alt="Intuitive controls" style="width: 27px; height: 27px;">
                    </div>
                    <span class="whitespace-nowrap  pr-5 " style="color: #fff; font-size: 24px;">Intuitive controls</span>
                </div>
                
                <!-- Program Memory Feature Bubble - Lower Left -->
                <div class="hidden md:flex items-center gap-3 px-1 py-1 rounded-full shadow-lg z-30 absolute text-white" style="background-color: #b6d9e8; bottom: 54%; left: -68%;">
                    <div class="bg-white rounded-full flex items-center justify-center flex-shrink-0" style="width: 38px; height: 38px;">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/rent3.svg" alt="Program memory" style="width: 27px; height: 27px;">
                    </div>
                    <span class="whitespace-nowrap  pr-5 " style="color: #fff; font-size: 24px;">Program memory</span>
                </div>
                
                <!-- Iceless Technology Feature Bubble - Below Program Memory -->
                <div class="hidden md:flex items-center gap-3 px-1 py-1 rounded-full shadow-lg z-30 absolute text-white" style="background-color: #b6d9e8; bottom: 43%; left: -61%;">
                    <div class="bg-white rounded-full flex items-center justify-center flex-shrink-0" style="width: 38px; height: 38px;">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/rent4.svg" alt="Iceless technology" style="width: 27px; height: 27px;">
                    </div>
                    <span class="whitespace-nowrap  pr-5 " style="color: #fff; font-size: 24px;">Iceless technology</span>
                </div>
                
                <!-- Mobile Version - Feature Bubbles -->
                <div class="md:hidden mt-6 space-y-3 w-full">
                    <!-- Smart Touchscreen Mobile -->
                    <div class="flex items-center gap-2 sm:gap-3 px-3 sm:px-4 py-2 sm:py-3 rounded-full shadow-lg z-30" style="background-color: #b6d9e8;">
                        <div class="bg-white rounded-full flex items-center justify-center flex-shrink-0" style="width: 32px; height: 32px;">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/rent1.svg" alt="Smart touchscreen" style="width: 22px; height: 22px;">
                        </div>
                        <span class="font-semibold text-sm sm:text-base md:text-xl lg:text-2xl" style="color: #fff;">Smart touchscreen</span>
                    </div>
                    
                    <!-- Intuitive Controls Mobile -->
                    <div class="flex items-center gap-2 sm:gap-3 px-3 sm:px-4 py-2 sm:py-3 rounded-full shadow-lg z-30" style="background-color: #b6d9e8;">
                        <div class="bg-white rounded-full flex items-center justify-center flex-shrink-0" style="width: 32px; height: 32px;">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/rent2.svg" alt="Intuitive controls" style="width: 22px; height: 22px;">
                        </div>
                        <span class="font-semibold text-sm sm:text-base md:text-xl lg:text-2xl" style="color: #fff;">Intuitive controls</span>
                    </div>
                    
                    <!-- Program Memory Mobile -->
                    <div class="flex items-center gap-2 sm:gap-3 px-3 sm:px-4 py-2 sm:py-3 rounded-full shadow-lg z-30" style="background-color: #b6d9e8;">
                        <div class="bg-white rounded-full flex items-center justify-center flex-shrink-0" style="width: 32px; height: 32px;">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/rent3.svg" alt="Program memory" style="width: 22px; height: 22px;">
                        </div>
                        <span class="font-semibold text-sm sm:text-base md:text-xl lg:text-2xl" style="color: #fff;">Program memory</span>
                    </div>
                    
                    <!-- Iceless Technology Mobile -->
                    <div class="flex items-center gap-2 sm:gap-3 px-3 sm:px-4 py-2 sm:py-3 rounded-full shadow-lg z-30" style="background-color: #b6d9e8;">
                        <div class="bg-white rounded-full flex items-center justify-center flex-shrink-0" style="width: 32px; height: 32px;">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/rent4.svg" alt="Iceless technology" style="width: 22px; height: 22px;">
                        </div>
                        <span class="font-semibold text-sm sm:text-base md:text-xl lg:text-2xl" style="color: #fff;">Iceless technology</span>
                    </div>
                </div>
                
                <!-- 7 Wraps Section - Bottom Right Corner -->
                <div class="relative md:absolute md:bottom-10 md:right-0 z-30 lg:flex items-center gap-4 lg:gap-8 px-3 md:px-2 py-3 md:py-2 rounded-full mt-6 md:mt-0 w-full md:w-auto wraps-section" style="background: linear-gradient(135deg, #1B92CB 0%, #045A96 100%);">
                    <!-- White Circle with Wrap Image - Left Side with Concentric Circles -->
                    <div class="relative flex-shrink-0 mx-auto md:mx-0 wraps-circle-container">
                        <!-- Concentric Circles - All same size, shifted right evenly -->
                        <div class="absolute rounded-full wraps-circle-1" style="background-color: rgba(255, 255, 255, 0.10); top: 50%; transform: translateY(-50%); z-index: 1;"></div>
                        <div class="absolute rounded-full wraps-circle-2" style="background-color: rgba(255, 255, 255, 0.30); top: 50%; transform: translateY(-50%); z-index: 2;"></div>
                        <div class="absolute rounded-full wraps-circle-3" style="background-color: rgba(255, 255, 255, 0.22); top: 50%; transform: translateY(-50%); z-index: 3;"></div>
                        <!-- Image in its own rounded-full white div -->
                        <div class="absolute bg-white rounded-full flex items-center justify-center wraps-circle-main" style="right: 0; top: 50%; transform: translateY(-50%); z-index: 4;">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/bag.png" alt="7 wraps" class="w-10 h-10 md:w-14 md:h-14 object-contain">
                        </div>
                    </div>
                    <!-- Text Content -->
                    <div class="flex flex-col justify-center relative z-2 text-center md:text-left mt-2 md:mt-0">
                        <div class="text-white leading-tight text-3xl md:text-5xl">
                            <span class="font-bold" >7</span>
                            <span class="font-bold "> wraps</span>
                        </div>
                        <div class="px-3 py-1 rounded-full inline-block mx-auto md:mx-0" style="background-color: #3981b1;">
                            <div class="text-white text-xs md:text-sm leading-tight">for different body parts</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- How ForceX Technology Works Section -->
        <div class="bg-white py-16 md:py-24 px-4 md:px-8">
            <div class="container-custom max-w-[1400px] mx-auto">
                <!-- Section Title -->
                <h2 class="title-h2 mb-12 md:mb-16 text-center" style="color: #000;">
                    How ForceX™ technology works
                </h2>

                <!-- Three Feature Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                    <!-- Card 1: Effective Pain Relief -->
                    <div class="rounded-lg p-6 md:p-8 relative overflow-hidden" style="min-height: 350px; border-top-right-radius: 80px; background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/tech1.png'); background-position: top right; background-repeat: no-repeat; background-size: cover;">
                        <!-- Number Badge -->
                        <div class="relative z-10 mb-5 lg:mb-32">
                            <span class="inline-block px-4 py-2  font-semibold rounded-full" style="background-color: #fff; color: #748394; font-size: 28px;">01</span>
                        </div>
                        
                        <!-- Content -->
                        <div class="relative z-10">
                            <h3 class="text-xl md:text-2xl mb-4" style="color: #000; font-weight: 400;">Effective Pain Relief</h3>
                            <p class="leading-relaxed" style="color: #333; font-size: 18px;">
                                Promote faster recovery from injury, surgery, or strenuous activity by reducing inflammation and managing pain without the need for ice.
                            </p>
                        </div>
                    </div>

                    <!-- Card 2: Intelligent temperature regulation -->
                    <div class="rounded-lg p-6 md:p-8 relative overflow-hidden" style="min-height: 350px; border-top-right-radius: 80px; background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/tech2.png'); background-position: top right; background-repeat: no-repeat; background-size: cover;">
                        <!-- Number Badge -->
                        <div class="relative z-10 mb-5 lg:mb-32">
                            <span class="inline-block px-4 py-2  font-semibold rounded-full" style="background-color: #fff; color: #748394; font-size: 28px;">02</span>
                        </div>
                        
                        <!-- Content -->
                        <div class="relative z-10">
                            <h3 class="text-xl md:text-2xl mb-4" style="color: #000; font-weight: 400;">Intelligent temperature regulation</h3>
                            <p class="leading-relaxed" style="color: #333; font-size: 18px;">
                                Advanced Cryothermic Modulation to alternate between heat and cold therapy, precisely cycling temperatures for optimal healing.
                            </p>
                        </div>
                    </div>

                    <!-- Card 3: Universal & Portable -->
                    <div class="rounded-lg p-6 md:p-8 relative overflow-hidden" style="min-height: 350px; border-top-right-radius: 80px; background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/tech3.png'); background-position: top right; background-repeat: no-repeat; background-size: cover;">
                        <!-- Number Badge -->
                        <div class="relative z-10 mb-5 lg:mb-32">
                            <span class="inline-block px-4 py-2  font-semibold rounded-full" style="background-color: #fff; color: #748394; font-size: 28px;">03</span>
                        </div>
                        
                        <!-- Content -->
                        <div class="relative z-10">
                            <h3 class="text-xl md:text-2xl mb-4" style="color: #000; font-weight: 400;">Universal & Portable</h3>
                            <p class="leading-relaxed" style="color: #333; font-size: 18px;">
                                A single adaptable system fits multiple body regions and features a portable handle structure for ease of use in clinical or home settings.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Who rents the ForceX™ Section -->
        <?php
        $rent_items = forcex_get_who_rents_items();
        if (!empty($rent_items)):
        ?>
        <div class="bg-white py-16 md:py-24 px-4 md:px-8 who-rents-section" style="overflow-x: hidden;">
            <div class="container-custom mx-auto" style="max-width: 950px;">
                <!-- Section Title -->
                <h2 class="title-h2 mb-8 md:mb-12 text-center" style="color: #000;">
                    Who rents the ForceX™
                </h2>

                <!-- Navigation Tabs -->
                <div class="mb-8 md:mb-12 overflow-x-auto">
                    <div class="rent-tabs-container flex gap-1 justify-center min-w-max px-1 py-1 rounded-full" id="rent-tabs">
                        <?php foreach ($rent_items as $index => $item): 
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
                    <div class="rent-slides-track" id="rent-slides-track">
                        <?php foreach ($rent_items as $index => $item): 
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
                                    <div class="absolute bottom-4 left-4 md:bottom-10 md:left-10 bg-white p-3 md:p-5 max-w-[calc(100%-2rem)] md:max-w-[70%] z-10 rounded-md"  >
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

        <!-- What our users are saying Section -->
        <section class="rent-reviews-section py-20 relative">
            <div class="rent-reviews-section-bg absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/articlesbg.png');"></div>
            
            <div class="container-custom relative z-10 max-w-[1400px]">
                <!-- Section Header with READ MORE button -->
                <div class="flex items-center justify-center relative mb-12">
                    <h2 class="title-h2 text-white">What our users are saying</h2>
                    <a href="<?php echo esc_url(get_post_type_archive_link('review') ?: home_url('/reviews')); ?>" class="btn-white absolute right-0">
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
                        <div class="overflow-hidden">
                            <div class="rent-reviews-slider-track" id="rent-reviews-slider-track">
                                <?php foreach ($review_pairs as $pair) : ?>
                                    <div class="rent-reviews-slide w-full flex-shrink-0 px-2">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                            <?php foreach ($pair as $review) : ?>
                                                <div class="card bg-white rounded-lg p-6 shadow-lg">
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
                                                            <div class="w-12 h-12 rounded-full flex items-center justify-center mr-4 flex-shrink-0" style="background-color: #1B92CB;">
                                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                                </svg>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div>
                                                            <div class="font-semibold text-gray-900"><?php echo esc_html($review['reviewer_name']); ?></div>
                                                            <?php if ($review['reviewer_title']) : ?>
                                                                <div class="text-sm text-gray-600 mt-1">
                                                                    <span class="inline-block px-3 py-1 rounded-full text-xs" style="background-color: #f0f3f7; color: #748394;"><?php echo esc_html($review['reviewer_title']); ?></span>
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
                            <button type="button" id="rent-reviews-slider-prev" class="rent-reviews-slider-btn" aria-label="Previous reviews">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/left_slider_arrow.svg" alt="Previous" class="h-6 w-auto pointer-events-none">
                            </button>
                            
                            <span id="rent-reviews-slider-counter" class="text-white font-medium px-4">1 / <?php echo $total_slides; ?></span>
                            
                            <button type="button" id="rent-reviews-slider-next" class="rent-reviews-slider-btn" aria-label="Next reviews">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/right_slider_arrow.svg" alt="Next" class="h-6 w-auto pointer-events-none">
                            </button>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="text-center py-12">
                        <p class="text-white">No reviews found.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Frequently Asked Questions Section -->
        <?php
        $faq_items = forcex_get_faq_items();
        if (!empty($faq_items)):
        ?>
        <section class="rent-faq-section py-16 md:py-24 px-4 md:px-8" style="background-color: #e8f6fc;">
            <div class="container-custom max-w-[900px] mx-auto">
                <!-- Section Title -->
                <h2 class="title-h2 text-center mb-12 md:mb-16" style="color: #0D3452;">
                    Frequently asked questions
                </h2>
                
                <!-- FAQ Items -->
                <div class="rent-faq-container space-y-4">
                    <?php foreach ($faq_items as $index => $faq): ?>
                        <div class="rent-faq-item bg-white rounded-lg shadow-sm overflow-hidden">
                            <button class="rent-faq-question w-full flex items-center justify-between p-6 text-left" data-faq-index="<?php echo $index; ?>" aria-expanded="false">
                                <h3 class="title-h3 pr-4" style="color: #0D3452; margin: 0;">
                                    <?php echo esc_html($faq['question']); ?>
                                </h3>
                                <div class="rent-faq-icon flex-shrink-0">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/plus.svg" alt="Expand" class="rent-faq-icon-plus w-6 h-6">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/minus.svg" alt="Collapse" class="rent-faq-icon-minus w-6 h-6 hidden">
                                </div>
                            </button>
                            <div class="rent-faq-answer px-6" style="max-height: 0; padding-top: 0; padding-bottom: 0;">
                                <div class="body-22-dark py-4 rent-faq-description" style="color: #748394;">
                                    <?php echo wp_kses_post(wpautop($faq['answer'])); ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- Main Heading and Features Section -->
        <section class="rent-intro-section py-16 md:py-24 px-4 md:px-8 relative" style="background-color: #EEF2F6; background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/gradientform.png'); background-position: center bottom; background-repeat: no-repeat; background-size: cover; position: relative;">
            <div class="absolute inset-0" style="background: radial-gradient(circle at center bottom, transparent 0%, transparent 40%, rgba(214, 239, 250, 0.3) 60%, rgba(196, 233, 248, 0.5) 100%); pointer-events: none;"></div>
            <div class="container-custom relative z-10" style="max-width: 900px; margin: 0 auto;">
                <!-- Main Heading -->
                <div class="text-center mb-8">
                    <h1 class="title-h2 mb-4">
                        Rent or purchase ForceX™ for faster recovery after injury or surgery
                    </h1>
                    <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                        Whether you're recovering from orthopedic surgery, an injury, or managing chronic pain, the ForceX™ is designed to provide clinically proven heat, cold, and compression therapy right at home – without the hassle of ice or bulky equipment.
                    </p>
                </div>

                <!-- Feature Tags -->
                <div class="flex flex-wrap justify-center gap-4 mb-12">
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

                <!-- Form Section -->
                <div class="w-full bg-white p-8 md:p-12">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Rent ForceX™</h2>
                        <p class="text-gray-600">
                            Complete the form below, and our team will contact you with more information on distribution opportunities, pricing, and support.
                        </p>
                    </div>

                    <form id="rent-form" class="forcex-contact-form" data-form-source="patients">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="rent_first_name" class="block text-sm font-medium text-gray-700 mb-2 pl-4">
                                    First name *
                                </label>
                                <input type="text" id="rent_first_name" name="first_name" required
                                       class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
                                       style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
                                       placeholder="Your name">
                            </div>
                            <div>
                                <label for="rent_last_name" class="block text-sm font-medium text-gray-700 mb-2 pl-4">
                                    Last name *
                                </label>
                                <input type="text" id="rent_last_name" name="last_name" required
                                       class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
                                       style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
                                       placeholder="Your name">
                            </div>
                            <div>
                                <label for="rent_email" class="block text-sm font-medium text-gray-700 mb-2 pl-4">
                                    Email *
                                </label>
                                <input type="email" id="rent_email" name="email" required
                                       class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
                                       style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
                                       placeholder="Email">
                            </div>
                            <div>
                                <label for="rent_email_secondary" class="block text-sm font-medium text-gray-700 mb-2 pl-4">
                                    Email
                                </label>
                                <input type="email" id="rent_email_secondary" name="email_secondary"
                                       class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
                                       style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
                                       placeholder="Email">
                            </div>
                            <div class="md:col-span-2">
                                <label for="rent_physician_location" class="block text-sm font-medium text-gray-700 mb-2 pl-4">
                                    Choose your physician location *
                                </label>
                                <select id="rent_physician_location" name="physician_location" required
                                        class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
                                        style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;">
                                    <option value="">Location</option>
                                    <option value="cleveland-oh">Cleveland, OH</option>
                                    <option value="new-york-ny">New York, NY</option>
                                    <option value="los-angeles-ca">Los Angeles, CA</option>
                                    <option value="chicago-il">Chicago, IL</option>
                                    <option value="houston-tx">Houston, TX</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="flex items-start">
                                <input type="checkbox" name="privacy_policy" required
                                       class="mt-1 mr-3 w-4 h-4 text-primary-500 border-gray-300 rounded focus:ring-primary-500">
                                <span class="text-sm text-gray-700">
                                    I agree to the processing of my personal data as outlined in the <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>" class="text-primary-500 hover:underline">Privacy Policy</a>.
                                </span>
                            </label>
                        </div>

                        <div id="rent-form-message" class="mb-6 hidden"></div>

                        <button type="submit" class="btn-gradient">
                            SUBMIT
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</main>

<?php endwhile; ?>

<style>
@media (max-width: 768px) {
    .absolute.top-0.right-0,
    .absolute.top-16.right-0,
    .absolute.top-12.left-0,
    .absolute.top-28.left-0,
    .absolute.bottom-8.right-0 {
        position: relative !important;
        transform: none !important;
        margin: 0.5rem auto;
        display: flex;
        justify-content: center;
        width: fit-content;
    }
    
    .container-custom {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    /* 7 Wraps Section Mobile Styles */
    .wraps-section {
        left: auto !important;
        transform: none !important;
        min-width: auto !important;
    }
    
    .wraps-circle-container {
        width: 60px;
        height: 60px;
    }
    
    .wraps-circle-1,
    .wraps-circle-2,
    .wraps-circle-3,
    .wraps-circle-main {
        width: 60px;
        height: 60px;
    }
    
    .wraps-circle-1 {
        right: -6px;
    }
    
    .wraps-circle-2 {
        right: -12px;
    }
    
    .wraps-circle-3 {
        right: -18px;
    }
}

@media (min-width: 768px) {
    .wraps-section {
        left: 80%;
        transform: translate(40px, 0);
        min-width: 320px;
    }
    
    .wraps-circle-container {
        width: 80px;
        height: 80px;
    }
    
    .wraps-circle-1,
    .wraps-circle-2,
    .wraps-circle-3,
    .wraps-circle-main {
        width: 80px;
        height: 80px;
    }
    
    .wraps-circle-1 {
        right: -8px;
    }
    
    .wraps-circle-2 {
        right: -16px;
    }
    
    .wraps-circle-3 {
        right: -24px;
    }
}

/* Who Rents Section Styles - Prevent horizontal scroll */
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
    .who-rents-section {
        overflow-x: hidden !important;
        padding-left: 1rem !important;
        padding-right: 1rem !important;
    }
    
    .rent-slides-container {
        overflow: hidden !important;
        width: 100% !important;
        height: auto !important;
        min-height: 400px;
    }
    
    .rent-slides-track {
        height: auto !important;
        min-height: 400px;
        width: 100% !important;
        display: flex;
        flex-direction: column;
        gap: 0 !important;
    }
    
    .rent-slide {
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
    
    .rent-slide.active {
        opacity: 1 !important;
        visibility: visible !important;
        position: relative;
    }
    
    .rent-slide > div {
        min-height: 400px;
        height: auto;
    }
    
    /* Tabs container mobile */
    .rent-tabs-container {
        justify-content: flex-start !important;
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }
    
    .rent-tab-btn {
        font-size: 14px !important;
        padding: 8px 12px !important;
        white-space: nowrap;
    }
}

/* Rent Reviews Section Styles */
.rent-reviews-section {
    position: relative;
    overflow: hidden;
}

.rent-reviews-section-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 0;
}

.rent-reviews-slider-track {
    display: flex;
    transition: transform 0.3s ease-in-out;
    will-change: transform;
}

.rent-reviews-slide {
    min-width: 100%;
    width: 100%;
    flex-shrink: 0;
}

.rent-reviews-slider-btn {
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 0;
    transition: opacity 0.3s ease;
}

.rent-reviews-slider-btn:hover {
    opacity: 0.7;
}

.rent-reviews-slider-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Rent Form Section Styles */
.rent-form-section {
    position: relative;
}

.forcex-contact-form input::placeholder,
.forcex-contact-form select option:first-child {
    color: #748394;
}

.forcex-contact-form select {
    background-color: #EEF2F6;
    border-radius: 32px;
    height: 48px;
    border: none;
    color: #748394;
}

.forcex-contact-form select:not([value=""]) {
    color: #000;
}

/* Rent FAQ Section Styles */
.rent-faq-section {
    background-color: #E8F0F5;
}

.rent-faq-item {
    transition: all 0.3s ease;
}

.rent-faq-question {
    cursor: pointer;
    border: none;
    background: transparent;
}

.rent-faq-question:focus {
    outline: 2px solid #1B92CB;
    outline-offset: 2px;
}

.rent-faq-item.active .rent-faq-question:focus {
    outline: none;
}

.rent-faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1), padding 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    padding-top: 0;
    padding-bottom: 0;
    will-change: max-height;
}

.rent-faq-item.active .rent-faq-answer {
    padding-top: 0rem;
    padding-bottom: 2rem;
}

.rent-faq-item.active .rent-faq-description {
    border-top: 1px solid #D9E2E7;
    padding-top: 1rem;
    transition: border-top 0.3s ease, padding-top 0.3s ease;
}

.rent-faq-icon {
    position: relative;
    width: 24px;
    height: 24px;
}

.rent-faq-icon img {
    position: absolute;
    top: 0;
    left: 0;
}

.rent-faq-item.active .rent-faq-icon-plus {
    display: none;
}

.rent-faq-item.active .rent-faq-icon-minus {
    display: block;
}

.rent-faq-item:not(.active) .rent-faq-icon-plus {
    display: block;
}

.rent-faq-item:not(.active) .rent-faq-icon-minus {
    display: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.rent-tab-btn');
    const slides = document.querySelectorAll('.rent-slide');
    const slidesTrack = document.getElementById('rent-slides-track');
    
    if (!slidesTrack) return;
    
    // Get slide width including gap
    function getSlideWidth() {
        if (window.innerWidth <= 1023) {
            const container = document.querySelector('.rent-slides-container');
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
        const container = document.querySelector('.rent-slides-container');
        if (!container) return;
        
        const containerWidth = container.offsetWidth; // 900px
        const containerCenter = containerWidth / 2; // 450px
        
        // Calculate slide position: each slide takes slideWidth + gap (except last one)
        // Slide center position in the track
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
            const targetSlide = document.querySelector(`.rent-slide[data-slide="${targetTab}"]`);
            const currentActiveSlide = document.querySelector('.rent-slide.active');
            
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
            const activeSlide = document.querySelector('.rent-slide.active');
            if (activeSlide) {
                const slideIndex = Array.from(slides).indexOf(activeSlide);
                centerSlide(slideIndex);
            }
        }, 250);
    });
    
    // Rent Reviews Slider
    const rentReviewsSliderTrack = document.getElementById('rent-reviews-slider-track');
    const rentReviewsSliderPrev = document.getElementById('rent-reviews-slider-prev');
    const rentReviewsSliderNext = document.getElementById('rent-reviews-slider-next');
    const rentReviewsSliderCounter = document.getElementById('rent-reviews-slider-counter');
    
    if (rentReviewsSliderTrack && rentReviewsSliderPrev && rentReviewsSliderNext && rentReviewsSliderCounter) {
        let currentSlide = 0;
        const slides = rentReviewsSliderTrack.querySelectorAll('.rent-reviews-slide');
        const totalSlides = slides.length;
        
        if (totalSlides > 0 && totalSlides > 1) {
            // Update slider position
            function updateRentReviewsSlider() {
                const translateX = -currentSlide * 100;
                rentReviewsSliderTrack.style.transform = `translateX(${translateX}%)`;
                rentReviewsSliderTrack.style.webkitTransform = `translateX(${translateX}%)`;
                rentReviewsSliderCounter.textContent = `${currentSlide + 1} / ${totalSlides}`;
            }
            
            // Set initial transform
            rentReviewsSliderTrack.style.transform = 'translateX(0%)';
            rentReviewsSliderTrack.style.webkitTransform = 'translateX(0%)';
            
            // Prevent default button behavior
            rentReviewsSliderPrev.type = 'button';
            rentReviewsSliderNext.type = 'button';
            
            // Next slide
            rentReviewsSliderNext.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                currentSlide = (currentSlide + 1) % totalSlides;
                updateRentReviewsSlider();
            });
            
            // Previous slide
            rentReviewsSliderPrev.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                currentSlide = currentSlide === 0 ? totalSlides - 1 : currentSlide - 1;
                updateRentReviewsSlider();
            });
            
            // Initialize slider
            updateRentReviewsSlider();
        } else if (totalSlides === 1) {
            // Only one slide, disable navigation
            rentReviewsSliderPrev.style.opacity = '0.5';
            rentReviewsSliderNext.style.opacity = '0.5';
            rentReviewsSliderPrev.style.pointerEvents = 'none';
            rentReviewsSliderNext.style.pointerEvents = 'none';
            rentReviewsSliderCounter.textContent = '1 / 1';
        }
    }
    
    // Rent FAQ Accordion
    const faqQuestions = document.querySelectorAll('.rent-faq-question');
    faqQuestions.forEach(function(question) {
        question.addEventListener('click', function() {
            const faqItem = this.closest('.rent-faq-item');
            const isActive = faqItem.classList.contains('active');
            const answer = faqItem.querySelector('.rent-faq-answer');
            
            // Close all other FAQ items
            document.querySelectorAll('.rent-faq-item').forEach(function(item) {
                if (item !== faqItem) {
                    item.classList.remove('active');
                    const otherAnswer = item.querySelector('.rent-faq-answer');
                    otherAnswer.style.maxHeight = '0';
                    otherAnswer.style.paddingTop = '0';
                    otherAnswer.style.paddingBottom = '0';
                    item.querySelector('.rent-faq-question').setAttribute('aria-expanded', 'false');
                }
            });
            
            // Toggle current item
            if (isActive) {
                faqItem.classList.remove('active');
                answer.style.maxHeight = '0';
                answer.style.paddingTop = '0';
                answer.style.paddingBottom = '0';
                this.setAttribute('aria-expanded', 'false');
                this.blur(); // Remove focus to remove blue outline
            } else {
                faqItem.classList.add('active');
                // Set padding first
                answer.style.paddingTop = '0rem';
                answer.style.paddingBottom = '2rem';
                // Temporarily set to auto to measure actual height
                answer.style.maxHeight = 'none';
                const actualHeight = answer.scrollHeight;
                // Reset to 0 for smooth animation
                answer.style.maxHeight = '0';
                // Use double requestAnimationFrame to ensure browser has rendered
                requestAnimationFrame(function() {
                    requestAnimationFrame(function() {
                        answer.style.maxHeight = actualHeight + 'px';
                    });
                });
                this.setAttribute('aria-expanded', 'true');
                this.blur(); // Remove focus to remove blue outline
            }
        });
    });
});
</script>

<?php get_footer(); ?>
