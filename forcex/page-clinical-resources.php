<?php
/**
 * Template Name: Clinical Resources
 * Description: Clinical resources page template
 */

defined('ABSPATH') || exit;

get_header();

// Start the loop
while (have_posts()) : the_post();
?>

<main id="main" class="site-main relative">
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

        <!-- Page Title and Description -->
        <div class="container-custom py-8 max-w-[1200px]">
            <div class="text-center mb-8">
                <h1 class="title-h1 mb-6"><?php echo esc_html(get_the_title()); ?></h1>
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
                    <p class="text-lg text-gray-600 max-w-3xl mx-auto leading-relaxed" style="font-size: 22px;">
                        <?php echo esc_html($description); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Clinical Evidence Supporting Force X Therapy Slider -->
        <?php
        $clinical_evidence_slides = array(
            array(
                'title' => 'Hot & Cold Compression Therapy',
                'study_ref' => 'Sadoghi P, Hasenhütl S, Gruber G, et al. Impact of a new cryotherapy device on early rehabilitation after primary total knee arthroplasty. Int Orthop. 2018.',
                'clinical_finding_title' => 'Clinical Finding',
                'clinical_finding' => 'Patients who received compressive cryotherapy (cold + intermittent compression) demonstrated improved outcomes during the early rehabilitation phase after knee surgery compared to patients who received cooling alone. The study highlights that compression provides additional value beyond cooling alone, particularly in the immediate post-operative period.',
                'why_forcex_title' => 'Why Force X Is Clinically Supported',
                'why_forcex' => 'The randomized study demonstrates that combining compression with cryotherapy enhances early rehabilitation outcomes after knee surgery. Force X replicates this evidence-based model by delivering Cold Control + Dynamic Compression + Optimized Recovery Protocols. Force X aligns with clinically validated principles shown to improve early post-operative recovery.',
                'box_left_title' => 'What it Means for Force X',
                'box_left' => 'Force X mirrors the studied model: controlled cold + dynamic compression. This positions Force X as more than a cold pack — it is a clinical cryocompression system engineered for optimized early-stage recovery.',
                'box_right_title' => 'Study Referenced',
                'box_right' => 'Compressive cryotherapy versus cryotherapy alone in patients undergoing knee surgery. (PMID: 27462522 / PubMed)',
            ),
            array(
                'title' => 'Cryotherapy with Dynamic Compression',
                'study_ref' => 'Murgier J, Cassard X. Cryotherapy with dynamic intermittent compression for analgesia after anterior cruciate ligament reconstruction. Orthop Traumatol Surg Res. 2014;100(3):309-312.',
                'clinical_finding_title' => 'Clinical Finding',
                'clinical_finding' => 'Patients using cryotherapy + dynamic intermittent compression required approximately 57.5 mg tramadol versus 128.6 mg in the static compression group (P = 0.023). Mean knee flexion at discharge was 90.5° in the dynamic group versus 84.5° in the static group (P = 0.0015).',
                'why_forcex_title' => 'Why Force X Is Backed by Clinical Data',
                'why_forcex' => 'Adding dynamic intermittent compression to cryotherapy significantly decreases pain medication use and improves knee flexion compared to static compression alone. Force X is built around the same principles — combining precise temperature control, active intermittent compression, and consistent treatment duration.',
                'box_left_title' => 'What it Means for Force X',
                'box_left' => 'The compression component matters. Force X\'s dynamic, regulated compression helps reduce analgesic load — which supports faster, less painful recovery.',
                'box_right_title' => 'Study Referenced',
                'box_right' => 'Cryotherapy with dynamic intermittent compression for analgesia after ACLR. (PMID: 24679367 / PubMed)',
            ),
            array(
                'title' => 'Compressive Cryotherapy After Hip Arthroscopy',
                'study_ref' => 'Klaber I, Greeff E, O\'Donnell J. Compressive cryotherapy is superior to cryotherapy alone in reducing pain after hip arthroscopy. J Hip Preserv Surg. 2019;6(4):364-369.',
                'clinical_finding_title' => 'Clinical Finding',
                'clinical_finding' => 'Patients who received compressive cryotherapy had significantly lower pain scores on post-operative days than those who received standard cryotherapy alone (VAS Day 1: range 0-3; Day 2: 0-5; p = 0.0028). All 20 patients in the compression group were discharged on post-op day 1 versus 17/20 in the standard group.',
                'why_forcex_title' => 'Why Force X Is Backed by High-Level Clinical Data',
                'why_forcex' => 'Adding compressive cryotherapy after hip arthroscopy resulted in significantly lower pain scores and a trend toward reduced analgesic use and earlier discharge compared to cryotherapy alone. Force X incorporates that same controlled cooling + dynamic compression approach.',
                'box_left_title' => 'What it Means for Force X',
                'box_left' => 'Dynamic compression + cooling, as delivered by Force X, supports earlier pain relief in the critical early rehab phase. Quicker discharge potential aligns with improved patient flow.',
                'box_right_title' => 'Study Referenced',
                'box_right' => 'Compressive cryotherapy vs cryotherapy alone after hip arthroscopy. (OUP Academic / J Hip Preserv Surg. 2019)',
            ),
            array(
                'title' => 'Cryocompression After Hip Arthroplasty',
                'study_ref' => 'Leegwater NC, Willems JH, Brohet R, Nolte PA. Cryocompression therapy after elective arthroplasty of the hip. Hip Int. 2012;22(5):527-533.',
                'clinical_finding_title' => 'Clinical Finding',
                'clinical_finding' => 'Elective hip arthroplasty patients receiving intermittent cryo-compression showed a hemoglobin drop of 1.87 mmol/L versus 2.34 mmol/L in the control group (p = 0.027), indicating less immediate blood loss. Trends toward lower morphine use, shorter hospital stay and less wound discharge were also observed.',
                'why_forcex_title' => 'Why Force X Is Backed by High-Level Clinical Data',
                'why_forcex' => 'Using intermittent cryocompression after hip arthroplasty resulted in less blood loss, reduced wound discharge, and trends toward less pain medication usage and shorter hospital stay compared to compression alone. Force X incorporates the same key elements.',
                'box_left_title' => 'What it Means for Force X',
                'box_left' => 'This supports using combined cooling + compression rather than compression alone — matching Force X\'s approach. Force X\'s regulated compression may assist in reducing bleeding and hemorrhage risk.',
                'box_right_title' => 'Study Referenced',
                'box_right' => 'Cryocompression therapy after elective arthroplasty of the hip. (PMID: 23112075 / PubMed)',
            ),
            array(
                'title' => 'Compressive Cryotherapy After Knee Surgery',
                'study_ref' => 'Song M, et al. Compressive cryotherapy versus cryotherapy alone in patients undergoing knee surgery. SpringerPlus. 2016. (PMID: 27462522)',
                'clinical_finding_title' => 'Clinical Finding',
                'clinical_finding' => 'In a meta-analysis of 10 RCTs (522 patients), patients receiving compression + cooling had less pain at post-operative days 2 and 3. The same analysis found a strong tendency toward less swelling with compressive cryotherapy at post-operative days 1 and 2.',
                'why_forcex_title' => 'Why Force X Aligns With Clinical Evidence',
                'why_forcex' => 'A large meta-analysis found that adding compression to cryotherapy significantly reduces pain and tends to reduce swelling in the early days after knee surgery. Force X brings together precisely controlled cooling, dynamic intermittent compression, and optimized treatment duration.',
                'box_left_title' => 'What it Means for Force X',
                'box_left' => 'Force X\'s combination of regulated cooling + dynamic compression supports the clinical benefit of this approach in early rehab. The greatest benefit is in the early post-surgical period.',
                'box_right_title' => 'Study Referenced',
                'box_right' => 'Compressive cryotherapy versus cryotherapy alone — meta-analysis. (PMID: 27462522 / PubMed)',
            ),
            array(
                'title' => 'Cryopneumatic Device vs Ice Packs',
                'study_ref' => 'Yang JH, Hwang KT, Lee MK, et al. Comparison of a Cryopneumatic Compression Device and Ice Packs for Cryotherapy Following ACL Reconstruction. Clin Orthop Surg. 2023;15(2):234-240.',
                'clinical_finding_title' => 'Clinical Finding',
                'clinical_finding' => 'Significantly lower pain (VAS) score on post-op Day 4 for the cryo-pneumatic compression device versus standard ice packs (2.1 ± 1.4 vs 3.3 ± 1.3; p = 0.001). The sum of post-operative drainage + joint effusion was significantly less in the compression-device group (p = 0.015).',
                'why_forcex_title' => 'Why Force X Is Backed by Cutting-Edge Clinical Data',
                'why_forcex' => 'Patients who used a cryo-pneumatic compression device after ACL reconstruction had significantly lower pain on Day 4 and less joint fluid/effusion compared to standard ice-pack therapy. Force X incorporates the same key elements — precise cooling, dynamic compression, and protocol-driven duration.',
                'box_left_title' => 'What it Means for Force X',
                'box_left' => 'Regulated compression + cooling — core technology in Force X — can deliver measurable benefit in early post-surgical pain relief. Force X\'s compression may contribute to less joint effusion and faster recovery.',
                'box_right_title' => 'Study Referenced',
                'box_right' => 'Comparison of a Cryopneumatic Compression Device and Ice Packs. (PMID: 37008961 / PubMed)',
            ),
            array(
                'title' => 'Alternating Heat and Cold Stimulation',
                'study_ref' => 'Sawada T, Okawara H, Nakashima D, et al. Effects of alternating heat and cold stimulation using a wearable thermo-device. J Physiol Anthropol. 2022;41:1.',
                'clinical_finding_title' => 'Clinical Finding',
                'clinical_finding' => 'In healthy young men, alternating heat + cold applied via a wearable thermo-device significantly reduced trapezius muscle hardness (d = 0.44; p < 0.05). Subjective reports showed greater improvements in "refreshed feeling," reduced muscle stiffness and fatigue compared to cold alone.',
                'why_forcex_title' => 'Why Force X Supports Advanced Recovery Protocols',
                'why_forcex' => 'Applying alternating heat and cold using a wearable device resulted in measurable soft-tissue benefits — including reduced muscle stiffness and improved subjective recovery. Force X builds on this evidence by offering precise thermal regulation, dynamic compression, and protocol-driven treatment cycles.',
                'box_left_title' => 'What it Means for Force X',
                'box_left' => 'Switching between thermal states with controlled devices can measurably soften muscle tissue — a mechanism Force X leverages via cold + compression and optionally heat control.',
                'box_right_title' => 'Study Referenced',
                'box_right' => 'Effects of alternating heat and cold stimulation using a wearable thermo-device. (J Physiol Anthropol. 2022)',
            ),
            array(
                'title' => 'Cold, Heat and Contrast Pressure Therapy',
                'study_ref' => 'Trybulski R, Kużdżał A, Stanula A, et al. Acute effects of cold, heat and contrast pressure therapy on forearm muscles regeneration in combat sports athletes. Sci Rep. 2024;14:22410.',
                'clinical_finding_title' => 'Clinical Finding',
                'clinical_finding' => 'Cold-therapy alone produced significantly lower muscle elasticity compared to heat, contrast or control groups (p = 0.002). Contrast (cold + heat + pressure) and heat groups improved biomechanical muscle properties in the hours after treatment in combat sports athletes.',
                'why_forcex_title' => 'Why Force X Incorporates Advanced Recovery Science',
                'why_forcex' => 'Applying cold, heat and contrast pressure therapy led to measurable improvements in muscle biomechanical properties — better tissue elasticity and regeneration — compared to basic cold alone. Force X mirrors these advanced protocols through precision temperature control and dynamic compression.',
                'box_left_title' => 'What it Means for Force X',
                'box_left' => 'Controlled thermal protocols matter for tissue mechanics — Force X\'s regulated cooling and optionally heat helps maintain and improve tissue elasticity for better recovery.',
                'box_right_title' => 'Study Referenced',
                'box_right' => 'Acute effects of cold, heat and contrast pressure therapy on muscle regeneration. (Nature / Sci Rep. 2024)',
            ),
        );
        $total_evidence_slides = count($clinical_evidence_slides);
        ?>
        <div class="bg-white py-16 md:py-24 px-4 md:px-8">
            <div class="container-custom max-w-[1200px] mx-auto">
                <!-- Section Title -->
                <h2 class="title-h2 mb-12 md:mb-16 text-center" style="color: #000;">
                    Clinical Evidence Supporting Force X Therapy
                </h2>

                <!-- Evidence Slider -->
                <div class="clinical-evidence-slider-container relative">
                    <div class="clinical-evidence-slider-track" id="clinical-evidence-slider-track">
                        <?php foreach ($clinical_evidence_slides as $idx => $slide): ?>
                            <div class="clinical-evidence-slide <?php echo $idx === 0 ? 'active' : ''; ?>" data-slide-index="<?php echo $idx; ?>">
                                <div class="bg-white rounded-2xl border border-gray-200 p-6 md:p-10">
                                    <!-- Slide Title -->
                                    <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-8"><?php echo esc_html($slide['title']); ?></h3>

                                    <!-- Two Column Layout -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-10 mb-8">
                                        <!-- Left Column: Clinical Finding -->
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-900 mb-3"><?php echo esc_html($slide['clinical_finding_title']); ?></h4>
                                            <p class="text-gray-600 leading-relaxed text-base"><?php echo esc_html($slide['clinical_finding']); ?></p>
                                        </div>
                                        <!-- Right Column: Why ForceX -->
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-900 mb-3"><?php echo esc_html($slide['why_forcex_title']); ?></h4>
                                            <p class="text-gray-600 leading-relaxed text-base"><?php echo esc_html($slide['why_forcex']); ?></p>
                                        </div>
                                    </div>

                                    <!-- Bottom Boxes -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 mb-8">
                                        <!-- Box Left -->
                                        <div class="rounded-xl p-5 md:p-5" style="background-color: #f0f5fa;">
                                            <h5 class="text-base font-semibold text-gray-900 mb-2"><?php echo esc_html($slide['box_left_title']); ?></h5>
                                            <p class="text-gray-600 text-sm leading-relaxed"><?php echo esc_html($slide['box_left']); ?></p>
                                        </div>
                                        <!-- Box Right -->
                                        <div class="rounded-xl p-5 md:p-5" style="background-color: #f0f5fa;">
                                            <h5 class="text-base font-semibold text-gray-900 mb-2"><?php echo esc_html($slide['box_right_title']); ?></h5>
                                            <p class="text-gray-600 text-sm leading-relaxed"><?php echo esc_html($slide['box_right']); ?></p>
                                        </div>
                                    </div>

                                    <!-- Navigation -->
                                    <div class="flex items-center justify-center gap-4">
                                        <button type="button" class="clinical-evidence-slider-btn clinical-evidence-prev" aria-label="Previous slide">
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/blueleftarrow.png" alt="Previous" class="h-6 w-auto pointer-events-none">
                                        </button>
                                        <span class="clinical-evidence-counter text-gray-900 font-medium px-4">
                                            <span class="text-2xl md:text-3xl font-bold"><?php echo $idx + 1; ?></span> / <span class="text-lg md:text-xl text-gray-500"><?php echo $total_evidence_slides; ?></span>
                                        </span>
                                        <button type="button" class="clinical-evidence-slider-btn clinical-evidence-next" aria-label="Next slide">
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/bluerightarrow.svg" alt="Next" class="h-6 w-auto pointer-events-none">
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- The Core Therapeutic Modalities Section -->
        <div class="bg-white py-16 md:py-24 px-4 md:px-8">
            <div class="container-custom max-w-[1400px] mx-auto">
                <!-- Section Title -->
                <h2 class="title-h2 mb-12 md:mb-16 text-center" style="color: #000;">
                    The core therapeutic modalities
                </h2>

                <!-- Three Feature Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                    <!-- Card 1: Cold therapy -->
                    <div class="rounded-lg p-6 md:p-8 relative overflow-hidden" style="min-height: 350px; border-top-right-radius: 80px; background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/tech1.png'); background-position: top right; background-repeat: no-repeat; background-size: cover;">
                        <!-- Number Badge -->
                        <div class="relative z-10 mb-5 lg:mb-32">
                            <span class="inline-block px-4 py-2  font-semibold rounded-full" style="background-color: #fff; color: #748394; font-size: 28px;">01</span>
                        </div>
                        
                        <!-- Content -->
                        <div class="relative z-10">
                            <h3 class="text-xl md:text-2xl mb-4" style="color: #000; font-weight: 400;">Cold therapy</h3>
                            <p class="leading-relaxed" style="color: #333; font-size: 18px;">
                                Cold therapy constricts blood vessels and numbs nerve endings to reduce swelling and inflammation. It is most effective during the initial stages of recovery after injury or surgery.
                            </p>
                        </div>
                    </div>

                    <!-- Card 2: Heat therapy -->
                    <div class="rounded-lg p-6 md:p-8 relative overflow-hidden" style="min-height: 350px; border-top-right-radius: 80px; background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/tech2.png'); background-position: top right; background-repeat: no-repeat; background-size: cover;">
                        <!-- Number Badge -->
                        <div class="relative z-10 mb-5 lg:mb-32">
                            <span class="inline-block px-4 py-2  font-semibold rounded-full" style="background-color: #fff; color: #748394; font-size: 28px;">02</span>
                        </div>
                        
                        <!-- Content -->
                        <div class="relative z-10">
                            <h3 class="text-xl md:text-2xl mb-4" style="color: #000; font-weight: 400;">Heat therapy</h3>
                            <p class="leading-relaxed" style="color: #333; font-size: 18px;">
                                Heat therapy increases blood flow, relaxes muscles, and improves tissue flexibility — accelerating healing during later stages of recovery.
                            </p>
                        </div>
                    </div>

                    <!-- Card 3: Compression therapy -->
                    <div class="rounded-lg p-6 md:p-8 relative overflow-hidden" style="min-height: 350px; border-top-right-radius: 80px; background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/tech3.png'); background-position: top right; background-repeat: no-repeat; background-size: cover;">
                        <!-- Number Badge -->
                        <div class="relative z-10 mb-5 lg:mb-32">
                            <span class="inline-block px-4 py-2  font-semibold rounded-full" style="background-color: #fff; color: #748394; font-size: 28px;">03</span>
                        </div>
                        
                        <!-- Content -->
                        <div class="relative z-10">
                            <h3 class="text-xl md:text-2xl mb-4" style="color: #000; font-weight: 400;">Compression therapy</h3>
                            <p class="leading-relaxed" style="color: #333; font-size: 18px;">
                                When paired with temperature therapy, compression enhances lymphatic drainage, reduces fluid build-up, and maintains consistent pressure for maximum therapeutic efficiency.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Clinically Proven Benefits Section -->
        <?php
        $clinical_benefits_items = forcex_get_clinical_benefits_items();
        if (!empty($clinical_benefits_items)):
        ?>
        <div class="bg-white py-16 md:py-24 px-4 md:px-8 who-rents-section" style="overflow-x: hidden;">
            <div class="container-custom mx-auto" style="max-width: 950px;">
                <!-- Section Title -->
                <h2 class="title-h2 mb-8 md:mb-12 text-center" style="color: #000;">
                    Clinically proven benefits
                </h2>

                <!-- Navigation Tabs -->
                <div class="mb-8 md:mb-12 overflow-x-auto">
                    <div class="rent-tabs-container flex gap-1 justify-center min-w-max px-1 py-1 rounded-full" id="rent-tabs">
                        <?php foreach ($clinical_benefits_items as $index => $item): 
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
                        <?php foreach ($clinical_benefits_items as $index => $item): 
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

        <!-- Medical Experts' Feedback Section -->
        <section class="medical-experts-feedback-section py-20 relative">
            <div class="medical-experts-feedback-section-bg absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/articlesbg.png');"></div>
            
            <div class="container-custom relative z-10 max-w-[1200px]">
                <!-- Section Title -->
                <h2 class="title-h2 text-white text-center mb-12">Medical experts' feedback about ForceX™</h2>
                
                <?php
                // Get latest reviews (ordered by most recent first)
                $reviews_query = new WP_Query(array(
                    'post_type' => 'review',
                    'posts_per_page' => 10,
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'post_status' => 'publish'
                ));
                
                if ($reviews_query->have_posts()) :
                    // Get all reviews
                    $all_reviews = array();
                    while ($reviews_query->have_posts()) : $reviews_query->the_post();
                        $reviewer_name = get_post_meta(get_the_ID(), '_reviewer_name', true);
                        $reviewer_title = get_post_meta(get_the_ID(), '_reviewer_title', true);
                        
                        // Split content into quote (first sentence) and description (rest)
                        $content = get_the_content();
                        $content = wp_strip_all_tags($content);
                        $sentences = preg_split('/(?<=[.!?])\s+/', $content, 2);
                        $quote = !empty($sentences[0]) ? trim($sentences[0]) : '';
                        $description = !empty($sentences[1]) ? trim($sentences[1]) : '';
                        
                        $all_reviews[] = array(
                            'id' => get_the_ID(),
                            'quote' => $quote,
                            'description' => $description,
                            'reviewer_name' => $reviewer_name ?: get_the_title(),
                            'reviewer_title' => $reviewer_title,
                            'has_thumbnail' => has_post_thumbnail(),
                            'thumbnail' => has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') : null
                        );
                    endwhile;
                    wp_reset_postdata();
                    
                    $total_slides = count($all_reviews);
                ?>
                    <!-- Reviews Slider -->
                    <div class="relative">
                        <div class="medical-experts-slider-container relative">
                            <div class="medical-experts-slider-track" id="medical-experts-slider-track">
                                <?php foreach ($all_reviews as $index => $review) : ?>
                                    <div class="medical-experts-slide w-full <?php echo $index === 0 ? 'active' : ''; ?>" data-slide-index="<?php echo $index; ?>">
                                        <div class="bg-white shadow-lg" style="border-top-left-radius: 24px; border-bottom-right-radius: 24px; padding: 5rem;">
                                            <div class="flex flex-col md:flex-row" style="gap: 3rem;">
                                                <!-- Left: Doctor Info - 30% width -->
                                                <div class="medical-experts-person-col flex-shrink-0 flex flex-col items-center md:items-start">
                                                    <?php if ($review['has_thumbnail'] && $review['thumbnail']) : ?>
                                                        <div class="w-20 h-20 rounded-full overflow-hidden mb-4">
                                                            <img src="<?php echo esc_url($review['thumbnail']); ?>" alt="<?php echo esc_attr($review['reviewer_name']); ?>" class="w-full h-full object-cover">
                                                        </div>
                                                    <?php else : ?>
                                                        <div class="w-20 h-20 rounded-full flex items-center justify-center mb-4" style="background-color: #1B92CB;">
                                                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                            </svg>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="text-center md:text-left">
                                                        <div class="font-bold text-gray-900 text-lg mb-2"><?php echo esc_html($review['reviewer_name']); ?></div>
                                                        <?php if ($review['reviewer_title']) : ?>
                                                            <div class="inline-block px-3 py-1 rounded-full text-sm" style="background-color: #f0f3f7; color: #748394;"><?php echo esc_html($review['reviewer_title']); ?></div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                
                                                <!-- Right: Testimonial Content - 70% width -->
                                                <div class="medical-experts-content flex-1 flex flex-col">
                                                    <?php if (!empty($review['quote'])) : ?>
                                                        <blockquote class="text-gray-900 font-bold text-xl md:text-2xl mb-4 leading-relaxed">
                                                            "<?php echo esc_html($review['quote']); ?>"
                                                        </blockquote>
                                                    <?php endif; ?>
                                                    
                                                    <?php if (!empty($review['description'])) : ?>
                                                        <p class="text-gray-700 text-base md:text-lg leading-relaxed" style="min-height: 100px;">
                                                            <?php echo esc_html($review['description']); ?>
                                                        </p>
                                                    <?php endif; ?>
                                                    
                                                    <!-- Navigation - Inside card, under description, aligned left -->
                                                    <div class="flex items-center justify-start gap-4 mt-8 medical-experts-navigation">
                                                        <button type="button" class="medical-experts-slider-btn medical-experts-slider-prev" aria-label="Previous review">
                                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/blueleftarrow.png" alt="Previous" class="h-6 w-auto pointer-events-none">
                                                        </button>
                                                        
                                                        <span class="medical-experts-slider-counter text-gray-900 font-medium px-4">
                                                            <span class="text-2xl md:text-3xl font-bold"><?php echo $index + 1; ?></span> / <span class="text-lg md:text-xl text-gray-500"><?php echo $total_slides; ?></span>
                                                        </span>
                                                        
                                                        <button type="button" class="medical-experts-slider-btn medical-experts-slider-next" aria-label="Next review">
                                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/bluerightarrow.svg" alt="Next" class="h-6 w-auto pointer-events-none">
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="text-center py-12">
                        <p class="text-white">No reviews found.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Clinical Research Section -->
        <?php
        $research_items = forcex_get_clinical_research_items();
        if (!empty($research_items)):
            // Show first 3 items initially, rest can be loaded with "Load More"
            $display_items = array_slice($research_items, 0, 3);
            $has_more = count($research_items) > 3;
        ?>
        <section class="clinical-research-section py-16 md:py-24 px-4 md:px-8"  >
            <div class="container-custom max-w-[950px] mx-auto">
                <!-- Section Title -->
                <h2 class="title-h2 mb-12 md:mb-16 text-center" style="color: #000;">
                    Clinical research supporting ForceX™
                </h2>

                <!-- Research Items List -->
                <div class="space-y-4 mb-8">
                    <?php foreach ($display_items as $item): ?>
                        <div class="bg-white rounded-lg shadow-md p-4 md:p-6 flex flex-col md:flex-row items-start md:items-center gap-4 md:gap-6 hover:shadow-lg transition-shadow">
                            <!-- Document Icon -->
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 md:w-16 md:h-16 rounded-lg flex items-center justify-center"  >
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/ep_document.svg" alt="Document" class="w-8 h-8 md:w-10 md:h-10">
                                </div>
                            </div>
                            
                            <!-- Research Title -->
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base md:text-lg lg:text-xl font-semibold text-gray-900 break-words">
                                    <?php echo esc_html($item['title']); ?>
                                </h3>
                            </div>
                            
                            <!-- Action Button: Open in new window or Download -->
                            <?php
                            $open_as_link = !isset($item['open_external_link']) || !empty($item['open_external_link']);
                            if (!empty($item['download_url'])):
                                if ($open_as_link): ?>
                                <div class="flex-shrink-0 w-full md:w-auto">
                                    <a href="<?php echo esc_url($item['download_url']); ?>" target="_blank" rel="noopener noreferrer" class="inline-block w-full md:w-auto text-center px-4 md:px-6 py-2.5 md:py-3 rounded-lg text-white text-sm md:text-base font-medium hover:opacity-90 transition-opacity" style="background: linear-gradient(135deg, #25AAE1 0%, #004F8C 100%);">
                                        VIEW
                                    </a>
                                </div>
                                <?php else: ?>
                                <div class="flex-shrink-0 w-full md:w-auto">
                                    <a href="<?php echo esc_url($item['download_url']); ?>" download class="inline-block w-full md:w-auto text-center px-4 md:px-6 py-2.5 md:py-3 rounded-lg text-white text-sm md:text-base font-medium hover:opacity-90 transition-opacity" style="background: linear-gradient(135deg, #25AAE1 0%, #004F8C 100%);">
                                        DOWNLOAD
                                    </a>
                                </div>
                                <?php endif;
                            else: ?>
                                <div class="flex-shrink-0 w-full md:w-auto">
                                    <span class="inline-block w-full md:w-auto text-center px-4 md:px-6 py-2.5 md:py-3 rounded-lg text-gray-400 text-sm md:text-base font-medium cursor-not-allowed" style="background-color: #f0f3f7;">
                                        <?php echo $open_as_link ? 'VIEW' : 'DOWNLOAD'; ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                    
                    <!-- Hidden items for "Load More" -->
                    <div id="clinical-research-more-items" style="display: none;">
                        <?php foreach (array_slice($research_items, 3) as $item): ?>
                            <div class="bg-white rounded-lg shadow-md p-4 md:p-6 flex flex-col md:flex-row items-start md:items-center gap-4 md:gap-6 hover:shadow-lg transition-shadow mt-4">
                                <!-- Document Icon -->
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 md:w-16 md:h-16 rounded-lg flex items-center justify-center" style="background-color: #E3F2FD;">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/ep_document.svg" alt="Document" class="w-8 h-8 md:w-10 md:h-10">
                                    </div>
                                </div>
                                
                                <!-- Research Title -->
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-base md:text-lg lg:text-xl font-semibold text-gray-900 break-words">
                                        <?php echo esc_html($item['title']); ?>
                                    </h3>
                                </div>
                                
                                <!-- Action Button: Open in new window or Download -->
                                <?php
                                $open_as_link_more = !isset($item['open_external_link']) || !empty($item['open_external_link']);
                                if (!empty($item['download_url'])):
                                    if ($open_as_link_more): ?>
                                    <div class="flex-shrink-0 w-full md:w-auto">
                                        <a href="<?php echo esc_url($item['download_url']); ?>" target="_blank" rel="noopener noreferrer" class="inline-block w-full md:w-auto text-center px-4 md:px-6 py-2.5 md:py-3 rounded-lg text-white text-sm md:text-base font-medium hover:opacity-90 transition-opacity" style="background: linear-gradient(135deg, #25AAE1 0%, #004F8C 100%);">
                                            VIEW
                                        </a>
                                    </div>
                                    <?php else: ?>
                                    <div class="flex-shrink-0 w-full md:w-auto">
                                        <a href="<?php echo esc_url($item['download_url']); ?>" download class="inline-block w-full md:w-auto text-center px-4 md:px-6 py-2.5 md:py-3 rounded-lg text-white text-sm md:text-base font-medium hover:opacity-90 transition-opacity" style="background: linear-gradient(135deg, #25AAE1 0%, #004F8C 100%);">
                                            DOWNLOAD
                                        </a>
                                    </div>
                                    <?php endif;
                                else: ?>
                                    <div class="flex-shrink-0 w-full md:w-auto">
                                        <span class="inline-block w-full md:w-auto text-center px-4 md:px-6 py-2.5 md:py-3 rounded-lg text-gray-400 text-sm md:text-base font-medium cursor-not-allowed" style="background-color: #f0f3f7;">
                                            <?php echo $open_as_link_more ? 'VIEW' : 'DOWNLOAD'; ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Load More Button -->
                <?php if ($has_more): ?>
                    <div class="text-center">
                        <button type="button" id="clinical-research-load-more" class="inline-block w-full md:w-auto px-6 md:px-8 py-3 md:py-4 rounded-lg text-white text-sm md:text-base font-medium hover:opacity-90 transition-opacity" style="background: linear-gradient(135deg, #0D3452 0%, #1A1A1A 100%);">
                            LOAD MORE
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <?php endif; ?>

        <!-- Contact Form Section -->
        <section class="rent-form-section py-16 md:py-24 px-4 md:px-8 relative" style=" background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/gradientform.png'); background-position: center bottom; background-repeat: no-repeat; background-size: cover; position: relative;">
            <div class="absolute inset-0" style="  pointer-events: none;"></div>
            <div class="container-custom relative z-10" style="max-width: 900px; margin: 0 auto;">
                <!-- Form Section -->
                <div class="w-full bg-white p-8 md:p-12">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Rent or purchase ForceX™</h2>
                        <p class="text-gray-600">
                            Complete the form below to connect with a ForceX™ representative for details on pricing and setup.
                        </p>
                    </div>

                    <form id="clinical-resources-form" class="forcex-contact-form" data-form-source="clinical-resources">
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
        </section>
    </div>
</main>

<style>
/* Clinical Evidence Slider Styles */
.clinical-evidence-slider-container {
    position: relative;
    min-height: 400px;
    touch-action: pan-y;
}

.clinical-evidence-slider-track {
    position: relative;
    width: 100%;
}

.clinical-evidence-slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.5s ease-in-out, visibility 0.5s ease-in-out;
    pointer-events: none;
}

.clinical-evidence-slide.active {
    position: relative;
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
}

.clinical-evidence-slider-btn {
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 0;
    transition: opacity 0.3s ease;
}

.clinical-evidence-slider-btn:hover {
    opacity: 0.7;
}
</style>

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

<style>
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

/* Medical Experts Feedback Section Styles */
.medical-experts-feedback-section {
    position: relative;
    overflow: hidden;
}

.medical-experts-feedback-section-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 0;
}

.medical-experts-slider-container {
    position: relative;
    min-height: 400px;
    touch-action: pan-y;
}

.medical-experts-slider-track {
    position: relative;
    width: 100%;
}

.medical-experts-slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.5s ease-in-out, visibility 0.5s ease-in-out;
    pointer-events: none;
}

.medical-experts-slide.active {
    position: relative;
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
}

.medical-experts-navigation {
    position: relative;
    margin-top: 2rem;
}

/* Person column 30% width on desktop */
@media (min-width: 768px) {
    .medical-experts-person-col {
        width: 30% !important;
        max-width: 30% !important;
        min-width: 30% !important;
        flex: 0 0 30% !important;
    }
    .medical-experts-content {
        width: 70% !important;
        max-width: 70% !important;
        min-width: 30% !important;
        flex: 1 1 70% !important;
    }
}

.medical-experts-slider-btn {
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 0;
    transition: opacity 0.3s ease;
}

.medical-experts-slider-btn:hover {
    opacity: 0.7;
}

.medical-experts-slider-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Clinical Research Section Mobile Styles */
@media (max-width: 767px) {
    .clinical-research-section {
        padding-left: 1rem !important;
        padding-right: 1rem !important;
    }
    
    .clinical-research-section .container-custom {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }
    
    .clinical-research-section .space-y-4 > div {
        margin-bottom: 1rem;
    }
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
    
    // Medical Experts Feedback Slider - Fade Effect
    const medicalExpertsSliderTrack = document.getElementById('medical-experts-slider-track');
    
    if (medicalExpertsSliderTrack) {
        let currentSlide = 0;
        const slides = medicalExpertsSliderTrack.querySelectorAll('.medical-experts-slide');
        const totalSlides = slides.length;
        
        if (totalSlides > 0 && totalSlides > 1) {
            // Function to update slider with fade effect
            function updateMedicalExpertsSlider() {
                // Remove active class from all slides
                slides.forEach((slide, index) => {
                    slide.classList.remove('active');
                    if (index === currentSlide) {
                        slide.classList.add('active');
                    }
                });
                
                // Update counter in active slide
                const activeSlideElement = slides[currentSlide];
                if (activeSlideElement) {
                    const counter = activeSlideElement.querySelector('.medical-experts-slider-counter');
                    if (counter) {
                        counter.innerHTML = `<span class="text-2xl md:text-3xl font-bold">${currentSlide + 1}</span> / <span class="text-lg md:text-xl text-gray-500">${totalSlides}</span>`;
                    }
                }
                
                // Adjust container height based on active slide content
                const activeSlide = slides[currentSlide];
                if (activeSlide) {
                    const content = activeSlide.querySelector('.medical-experts-content');
                    const container = document.querySelector('.medical-experts-slider-container');
                    if (content && container) {
                        // Wait for fade transition to complete, then adjust height
                        setTimeout(() => {
                            const contentHeight = content.offsetHeight;
                            const cardPadding = 96; // 2rem top + 3rem bottom = 48px + 48px
                            const navigationHeight = 60; // Approximate navigation height
                            const newHeight = contentHeight + cardPadding + navigationHeight + 100; // Extra padding
                            container.style.minHeight = newHeight + 'px';
                        }, 100);
                    }
                }
            }
            
            // Function to handle navigation clicks
            function handleNavigation(direction) {
                if (direction === 'next') {
                    currentSlide = (currentSlide + 1) % totalSlides;
                } else {
                    currentSlide = currentSlide === 0 ? totalSlides - 1 : currentSlide - 1;
                }
                updateMedicalExpertsSlider();
            }
            
            // Attach event listeners to navigation buttons (use event delegation)
            medicalExpertsSliderTrack.addEventListener('click', function(e) {
                if (e.target.closest('.medical-experts-slider-prev')) {
                    e.preventDefault();
                    e.stopPropagation();
                    handleNavigation('prev');
                } else if (e.target.closest('.medical-experts-slider-next')) {
                    e.preventDefault();
                    e.stopPropagation();
                    handleNavigation('next');
                }
            });
            
            // Set button types
            const prevButtons = medicalExpertsSliderTrack.querySelectorAll('.medical-experts-slider-prev');
            const nextButtons = medicalExpertsSliderTrack.querySelectorAll('.medical-experts-slider-next');
            prevButtons.forEach(btn => btn.type = 'button');
            nextButtons.forEach(btn => btn.type = 'button');
            
            // Touch/swipe support for mobile (desktop unchanged)
            const medicalExpertsContainer = document.querySelector('.medical-experts-slider-container');
            if (medicalExpertsContainer) {
                let touchStartX = 0, touchEndX = 0;
                medicalExpertsContainer.addEventListener('touchstart', function(e) {
                    touchStartX = e.changedTouches[0].screenX;
                }, { passive: true });
                medicalExpertsContainer.addEventListener('touchend', function(e) {
                    touchEndX = e.changedTouches[0].screenX;
                    const diff = touchStartX - touchEndX;
                    if (Math.abs(diff) > 50) {
                        if (diff > 0) handleNavigation('next');
                        else handleNavigation('prev');
                    }
                }, { passive: true });
            }
            
            // Initialize slider
            updateMedicalExpertsSlider();
            
            // Adjust height on window resize
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    updateMedicalExpertsSlider();
                }, 250);
            });
        } else if (totalSlides === 1) {
            // Hide navigation if only one slide
            const navs = medicalExpertsSliderTrack.querySelectorAll('.medical-experts-navigation');
            navs.forEach(nav => {
                nav.style.display = 'none';
            });
        }
    }
    
    // Clinical Evidence Slider - Fade Effect
    const clinicalEvidenceTrack = document.getElementById('clinical-evidence-slider-track');
    
    if (clinicalEvidenceTrack) {
        let currentEvidenceSlide = 0;
        const evidenceSlides = clinicalEvidenceTrack.querySelectorAll('.clinical-evidence-slide');
        const totalEvidenceSlides = evidenceSlides.length;
        
        if (totalEvidenceSlides > 1) {
            function updateClinicalEvidenceSlider() {
                evidenceSlides.forEach((slide, index) => {
                    slide.classList.remove('active');
                    if (index === currentEvidenceSlide) {
                        slide.classList.add('active');
                    }
                });
                
                // Update counter in active slide
                const activeSlide = evidenceSlides[currentEvidenceSlide];
                if (activeSlide) {
                    const counter = activeSlide.querySelector('.clinical-evidence-counter');
                    if (counter) {
                        counter.innerHTML = '<span class="text-2xl md:text-3xl font-bold">' + (currentEvidenceSlide + 1) + '</span> / <span class="text-lg md:text-xl text-gray-500">' + totalEvidenceSlides + '</span>';
                    }
                }
                
                // Adjust container height
                if (activeSlide) {
                    const container = document.querySelector('.clinical-evidence-slider-container');
                    if (container) {
                        setTimeout(() => {
                            container.style.minHeight = activeSlide.offsetHeight + 'px';
                        }, 100);
                    }
                }
            }
            
            function handleEvidenceNav(direction) {
                if (direction === 'next') {
                    currentEvidenceSlide = (currentEvidenceSlide + 1) % totalEvidenceSlides;
                } else {
                    currentEvidenceSlide = currentEvidenceSlide === 0 ? totalEvidenceSlides - 1 : currentEvidenceSlide - 1;
                }
                updateClinicalEvidenceSlider();
            }
            
            clinicalEvidenceTrack.addEventListener('click', function(e) {
                if (e.target.closest('.clinical-evidence-prev')) {
                    e.preventDefault();
                    e.stopPropagation();
                    handleEvidenceNav('prev');
                } else if (e.target.closest('.clinical-evidence-next')) {
                    e.preventDefault();
                    e.stopPropagation();
                    handleEvidenceNav('next');
                }
            });
            
            // Touch/swipe support
            const evidenceContainer = document.querySelector('.clinical-evidence-slider-container');
            if (evidenceContainer) {
                let eTouchStartX = 0, eTouchEndX = 0;
                evidenceContainer.addEventListener('touchstart', function(e) {
                    eTouchStartX = e.changedTouches[0].screenX;
                }, { passive: true });
                evidenceContainer.addEventListener('touchend', function(e) {
                    eTouchEndX = e.changedTouches[0].screenX;
                    const diff = eTouchStartX - eTouchEndX;
                    if (Math.abs(diff) > 50) {
                        if (diff > 0) handleEvidenceNav('next');
                        else handleEvidenceNav('prev');
                    }
                }, { passive: true });
            }
            
            updateClinicalEvidenceSlider();
            
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    updateClinicalEvidenceSlider();
                }, 250);
            });
        }
    }
    
    // Clinical Research Load More
    const loadMoreBtn = document.getElementById('clinical-research-load-more');
    const moreItems = document.getElementById('clinical-research-more-items');
    
    if (loadMoreBtn && moreItems) {
        loadMoreBtn.addEventListener('click', function() {
            moreItems.style.display = 'block';
            this.style.display = 'none';
        });
    }
});
</script>

<?php
endwhile; // End of the loop.
get_footer();
?>

