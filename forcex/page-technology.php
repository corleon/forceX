<?php
/**
 * Template Name: Technology
 * Description: Technology page showcasing ForceX CX9 product features
 */

defined('ABSPATH') || exit;

get_header(); ?>

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
                    $description = "Our advanced therapy systems combine Cryothermic Dynamic Compression (CDC Tech™) with intelligent temperature control to deliver clinically effective heat and cold treatments – without the need for ice or bulky equipment.";
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
                    <!-- Card 1: Intelligent temperature control -->
                    <div class="p-6 md:p-8 relative overflow-hidden" style="background-color: #EEF2F6; border-top-right-radius: 80px;">
                        <!-- Icon at top left - positioned absolutely -->
                        <div class="absolute top-6 left-6 md:top-8 md:left-8">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/meteor-icons_cross.svg" alt="Intelligent temperature control" style="width: 48px; height: 48px;">
                        </div>
                        
                        <!-- Content - aligned with other cards -->
                        <div style="padding-top: 80px;">
                            <h3 class="mb-4" style="color: #000; font-weight: 400; font-size: 38px; line-height: 1.2;">Intelligent temperature control</h3>
                            <p class="leading-relaxed" style="color: #333; font-size: 18px;">
                                Precise heat and cold delivery without ice, powered by advanced semiconductor technology.
                            </p>
                        </div>
                    </div>

                    <!-- Card 2: Alternating hot & cold cycles -->
                    <div class="p-6 md:p-8 relative overflow-hidden" style="background-color: #EEF2F6; border-top-right-radius: 80px;">
                        <!-- Icon at top left - positioned absolutely -->
                        <div class="absolute top-6 left-6 md:top-8 md:left-8">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/fa6-solid_fire.svg" alt="Alternating hot & cold cycles" style="width: 48px; height: 48px;">
                        </div>
                        
                        <!-- Content - aligned with other cards -->
                        <div style="padding-top: 80px;">
                            <h3 class="mb-4" style="color: #000; font-weight: 400; font-size: 38px; line-height: 1.2;">Alternating hot & cold cycles</h3>
                            <p class="leading-relaxed" style="color: #333; font-size: 18px;">
                                Safe, targeted, and effective therapy through controlled temperature transitions.
                            </p>
                        </div>
                    </div>

                    <!-- Card 3: Active positive pressure -->
                    <div class="p-6 md:p-8 relative overflow-hidden" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/tech_list.png'); background-position: top right; background-repeat: no-repeat; background-size: cover; border-top-right-radius: 80px;">
                        <!-- Content - aligned with other cards -->
                        <div style="padding-top: 80px;">
                            <h3 class="mb-4" style="color: #fff; font-weight: 400; font-size: 38px; line-height: 1.2;">Active positive pressure</h3>
                            <p class="leading-relaxed" style="color: #fff; font-size: 18px;">
                                Adjustable compression to optimize therapeutic outcomes.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- The Core Therapeutic Modalities Section -->
        <section class="py-20 bg-white">
            <div class="container-custom">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
                    <!-- Left Column -->
                    <div>
                        <h2 class="title-h2">
                            The core therapeutic modalities
                        </h2>
                        <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                            ForceX powered by CDC Tech is the first system to deliver dynamic positive compression with intelligent heat and cold cycling.
                        </p>
                    </div>
                    
                    <!-- Right Column - 3 Therapy Options -->
                    <div class="tech-widget-container">
                        <!-- Desktop: Regular stacked layout -->
                        <div class="tech-widget-desktop space-y-6">
                            <!-- Option 1: Heat Therapy -->
                            <div class="rounded-xl p-6 shadow-sm" style="background-color: #EEF2F6;">
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pp1.png" alt="Heat Therapy" class="object-contain" style="width: 240px; height: 240px;">
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900 mb-2" style="font-size: 28px;">Heat Therapy</h3>
                                        <p class="text-gray-600 leading-relaxed" style="font-size: 18px;">
                                            Heat therapy increases blood flow, relaxes muscles, and improves tissue flexibility – accelerating healing during later stages of recovery.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Option 2: Cold Therapy -->
                            <div class="rounded-xl p-6 shadow-sm" style="background-color: #EEF2F6;">
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pp2.png" alt="Cold Therapy" class="object-contain" style="width: 240px; height: 240px;">
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900 mb-2" style="font-size: 28px;">Cold Therapy</h3>
                                        <p class="text-gray-600 leading-relaxed" style="font-size: 18px;">
                                            Cold therapy constricts blood vessels and numbs nerve endings to reduce swelling and inflammation. It is most effective during the initial stages of recovery after injury or surgery.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Option 3: Compression Therapy -->
                            <div class="rounded-xl p-6 shadow-sm" style="background-color: #EEF2F6;">
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pp3.png" alt="Compression Therapy" class="object-contain" style="width: 240px; height: 240px;">
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900 mb-2" style="font-size: 28px;">Compression Therapy</h3>
                                        <p class="text-gray-600 leading-relaxed" style="font-size: 18px;">
                                            When paired with temperature therapy, compression enhances lymphatic drainage, reduces fluid build-up, and maintains consistent pressure for maximum therapeutic efficiency.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Mobile: Slider layout -->
                        <div class="tech-widget-mobile">
                            <div class="tech-widget-slider-container overflow-hidden">
                                <div class="tech-widget-slider-track flex transition-transform duration-300 ease-in-out" id="tech-widget-slider-track-technology">
                                    <!-- Option 1: Heat Therapy -->
                                    <div class="tech-widget-slide w-full flex-shrink-0 px-2">
                                        <div class="rounded-xl p-6 shadow-sm" style="background-color: #EEF2F6;">
                                            <div class="flex flex-col items-center gap-4 text-center">
                                                <div class="flex-shrink-0">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pp1.png" alt="Heat Therapy" class="object-contain mx-auto" style="width: 150px; height: 150px;">
                                                </div>
                                                <div>
                                                    <h3 class="font-bold text-gray-900 mb-2" style="font-size: 22px;">Heat Therapy</h3>
                                                    <p class="text-gray-600 leading-relaxed" style="font-size: 16px;">
                                                        Heat therapy increases blood flow, relaxes muscles, and improves tissue flexibility – accelerating healing during later stages of recovery.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Option 2: Cold Therapy -->
                                    <div class="tech-widget-slide w-full flex-shrink-0 px-2">
                                        <div class="rounded-xl p-6 shadow-sm" style="background-color: #EEF2F6;">
                                            <div class="flex flex-col items-center gap-4 text-center">
                                                <div class="flex-shrink-0">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pp2.png" alt="Cold Therapy" class="object-contain mx-auto" style="width: 150px; height: 150px;">
                                                </div>
                                                <div>
                                                    <h3 class="font-bold text-gray-900 mb-2" style="font-size: 22px;">Cold Therapy</h3>
                                                    <p class="text-gray-600 leading-relaxed" style="font-size: 16px;">
                                                        Cold therapy constricts blood vessels and numbs nerve endings to reduce swelling and inflammation. It is most effective during the initial stages of recovery after injury or surgery.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Option 3: Compression Therapy -->
                                    <div class="tech-widget-slide w-full flex-shrink-0 px-2">
                                        <div class="rounded-xl p-6 shadow-sm" style="background-color: #EEF2F6;">
                                            <div class="flex flex-col items-center gap-4 text-center">
                                                <div class="flex-shrink-0">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pp3.png" alt="Compression Therapy" class="object-contain mx-auto" style="width: 150px; height: 150px;">
                                                </div>
                                                <div>
                                                    <h3 class="font-bold text-gray-900 mb-2" style="font-size: 22px;">Compression Therapy</h3>
                                                    <p class="text-gray-600 leading-relaxed" style="font-size: 16px;">
                                                        When paired with temperature therapy, compression enhances lymphatic drainage, reduces fluid build-up, and maintains consistent pressure for maximum therapeutic efficiency.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Mobile Slider Navigation -->
                            <div class="tech-widget-navigation flex items-center justify-between mt-5">
                                <button class="tech-widget-prev" data-slider="technology">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/left_slider_arrow.svg" alt="Previous" class="w-12 h-12">
                                </button>
                                
                                <!-- Indicators -->
                                <div class="tech-widget-indicators flex items-center gap-2 flex-1 justify-center" data-slider="technology">
                                    <div class="tech-widget-indicator active" data-slide="0"></div>
                                    <div class="tech-widget-indicator" data-slide="1"></div>
                                    <div class="tech-widget-indicator" data-slide="2"></div>
                                </div>
                                
                                <button class="tech-widget-next" data-slider="technology">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/right_slider_arrow.svg" alt="Next" class="w-12 h-12">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Types of Compression Section -->
        <section class="py-20" style="background-color: #EFF3F6;">
            <div class="container-custom max-w-[1400px] mx-auto">
                <!-- Section Title -->
                <h2 class="title-h2 mb-12 md:mb-16 text-center" style="color: #000;">
                    Types of compression used by ForceX™
                </h2>

                <!-- Two Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                    <!-- Card 1: Compression Therapy -->
                    <div class="bg-white rounded-lg p-6 md:p-8 shadow-sm">
                        <h3 class="text-gray-900 mb-4" style="font-size: 36px; line-height: 40px; font-weight: 400;">Compression Therapy</h3>`
                        <p class="mb-6" style="color: #748394; font-size: 18px;">
                            Continuous application of a fixed pressure over the treatment area
                        </p>
                        <div class="border-t border-gray-300 pt-6">
                            <div class="inline-block px-3 py-1 rounded-full mb-4" style="background-color: #25AAE1;">
                                <span class="text-white text-sm font-semibold">USAGE</span>
                            </div>
                            <ul class="space-y-3" style="font-size: 18px;">
                                <li class="flex items-start">
                                    <span class="mr-3 mt-1 flex-shrink-0 rounded-full" style="width: 8px; height: 8px; background-color: #25AAE1;"></span>
                                    <span style="color: #283440;">Acute injury management (first 24-72 hours after trauma) to limit swelling and bleeding.</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-3 mt-1 flex-shrink-0 rounded-full" style="width: 8px; height: 8px; background-color: #25AAE1;"></span>
                                    <span style="color: #283440;">Post-surgical edema control where stability is critical and minimal movement is desired.</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-3 mt-1 flex-shrink-0 rounded-full" style="width: 8px; height: 8px; background-color: #25AAE1;"></span>
                                    <span style="color: #283440;">Stabilization during transport or in patients who cannot tolerate pressure fluctuations.</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Card 2: Intermittent Compression -->
                    <div class="bg-white rounded-lg p-6 md:p-8 shadow-sm">
                        <h3 class="text-gray-900 mb-4" style="font-size: 36px; line-height: 40px; font-weight: 400;">Intermittent Compression</h3>
                        <p class="mb-6" style="color: #748394; font-size: 18px;">
                            Pressure cycles on and off over set intervals
                        </p>
                        <div class="border-t border-gray-300 pt-6">
                            <div class="inline-block px-3 py-1 rounded-full mb-4" style="background-color: #25AAE1;">
                                <span class="text-white text-sm font-semibold">USAGE</span>
                            </div>
                            <ul class="space-y-3" style="font-size: 18px;">
                                <li class="flex items-start">
                                    <span class="mr-3 mt-1 flex-shrink-0 rounded-full" style="width: 8px; height: 8px; background-color: #25AAE1;"></span>
                                    <span style="color: #283440;">Chronic edema or lymphedema to mobilize fluid into lymphatic and venous return pathways.</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-3 mt-1 flex-shrink-0 rounded-full" style="width: 8px; height: 8px; background-color: #25AAE1;"></span>
                                    <span style="color: #283440;">Venous insufficiency to boost the calf muscle pump effect.</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-3 mt-1 flex-shrink-0 rounded-full" style="width: 8px; height: 8px; background-color: #25AAE1;"></span>
                                    <span style="color: #283440;">Post-injury swelling after the acute phase to actively clear fluid.</span>
                                </li>
                            </ul>
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

<?php get_footer(); ?>


