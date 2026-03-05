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
        // Each slide has: title, study_ref, study_link, rows (array of finding/meaning pairs with optional link), why_title, why_text
        $clinical_evidence_slides = array(
            // ── SLIDE 1 — Sadoghi et al., 2018 ──
            array(
                'title' => 'Hot & Cold Compression Therapy',
                'study_ref' => 'Sadoghi P, Hasenhütl S, Gruber G, et al. Impact of a new cryotherapy device on early rehabilitation after primary total knee arthroplasty: a prospective randomised controlled trial. Int Orthop. 2018.',
                'study_link' => 'https://pubmed.ncbi.nlm.nih.gov/29356932/',
                'col_left_title' => 'Clinical Finding (Sadoghi et al., 2018)',
                'col_right_title' => 'What It Means for Force X',
                'rows' => array(
                    array('+7° improvement in knee ROM by Day 6 using controlled cryotherapy versus standard cold packs', '', 'Force X provides consistent, regulated cooling—mirroring the controlled approach shown to improve mobility during early rehabilitation.'),
                    array('Significantly lower motion-related pain on Day 2 (p = 0.034)', '', 'Force X delivers stable temperature and compression, helping reduce pain early when patients typically experience the most discomfort.'),
                    array('No differences in swelling or medication use', '', 'Demonstrates that outcomes are driven by precise thermal control, not by ice alone. Force X eliminates temperature variability inherent in traditional cold packs.'),
                    array('No adverse events reported with device-based cryotherapy', '', 'Force X aligns with safety profiles seen in clinical trials and supports confident use in both clinic and home settings.'),
                    array('Better functional recovery in the acute post-op period', '', 'Early improvements in ROM and pain support better adherence to rehab plans—the same advantages Force X is designed to deliver.'),
                ),
                'why_title' => 'Why Force X Is Clinically Supported',
                'why_text' => 'The study by Sadoghi and colleagues demonstrated that controlled, consistent cryotherapy leads to meaningful improvements in pain and mobility following orthopedic surgery. Force X applies these same principles through its automated temperature control, dynamic compression, and hands-free design, giving clinicians and patients the therapeutic advantages shown in randomized clinical trials—without the inconsistency of ice packs. Force X ensures the right temperature, pressure, and duration, every time.',
            ),
            // ── SLIDE 2 — Murgier & Cassard, 2014 ──
            array(
                'title' => 'Cryotherapy with Dynamic Intermittent Compression',
                'study_ref' => 'Murgier J, Cassard X. Cryotherapy with dynamic intermittent compression for analgesia after anterior cruciate ligament reconstruction. Orthop Traumatol Surg Res. 2014;100(3):309-312.',
                'study_link' => 'https://pubmed.ncbi.nlm.nih.gov/24679367/',
                'col_left_title' => 'Clinical Finding (Murgier & Cassard, 2014)',
                'col_right_title' => 'What It Means for Force X',
                'rows' => array(
                    array('Patients using cryotherapy + dynamic intermittent compression (vs cryotherapy + static compression) required ~57.5 mg tramadol (range 0–200) vs. ~128.6 mg (0–250) in static group (P = 0.023).', 'https://pubmed.ncbi.nlm.nih.gov/24679367/', 'The compression component matters. Force X\'s dynamic, regulated compression helps reduce analgesic load—which supports faster, less painful recovery.'),
                    array('Morphine usage: 0 mg vs. 1.14 mg (P <0.05) in static group.', 'https://pubmed.ncbi.nlm.nih.gov/24679367/', 'Early pain control without heavy narcotics aligns with value-based rehab—an advantage Force X can deliver.'),
                    array('Mean knee flexion at discharge: 90.5° (range 80–100°) in dynamic compression group vs. 84.5° (75–90°) in static (P = 0.0015).', 'https://pubmed.ncbi.nlm.nih.gov/24679367/', 'Force X supports early range of motion gains by combining cold + compression—matching this clinical finding.'),
                    array('This was a Level III case-control study after ACL reconstruction.', 'https://pubmed.ncbi.nlm.nih.gov/24679367/', 'While not a high-level RCT, the data still provides credible support for dynamic cryocompression protocols—protocols Force X is designed for.'),
                ),
                'why_title' => 'Why Force X Is Backed by Clinical Data',
                'why_text' => 'A key study by Murgier and Cassard found that adding dynamic intermittent compression to cryotherapy significantly decreases pain medication use and improves knee flexion compared to static compression alone. Force X is built around the same principles—combining precise temperature control, active intermittent compression, and consistent treatment duration—which means patients and clinicians benefit from the same evidence-based protocol. Force X: delivering cold. compression. control. for better recovery.',
            ),
            // ── SLIDE 3 — Klaber et al., 2019 ──
            array(
                'title' => 'Compressive Cryotherapy After Hip Arthroscopy',
                'study_ref' => 'Klaber I, Greeff E, O\'Donnell J. Compressive cryotherapy is superior to cryotherapy alone in reducing pain after hip arthroscopy. J Hip Preserv Surg. 2019;6(4):364-369.',
                'study_link' => 'https://academic.oup.com/jhps/article/6/4/364/5610188',
                'col_left_title' => 'Clinical Finding (Klaber et al., 2019)',
                'col_right_title' => 'What It Means for Force X',
                'rows' => array(
                    array('Patients who received compressive cryotherapy (CC) had significantly lower pain scores on post-operative days than those who received standard cryotherapy alone (VAS Day 1: range 0–3; Day 2: 0–5; p = 0.0028)', 'https://academic.oup.com/jhps/article/6/4/364/5610188', 'Dynamic compression + cooling, as delivered by Force X, supports earlier pain relief in the critical early rehab phase.'),
                    array('20/20 patients in CC group discharged on post-op day 1 vs. 17/20 in standard group (trend, p = 0.23)', 'https://academic.oup.com/jhps/article/6/4/364/5610188', 'Quicker discharge potential aligns with improved patient flow and reduced hospital resource use when using Force X technology.'),
                    array('Trend toward lower analgesic use (1.75 vs 2.8 doses per patient) though not statistically significant', 'https://academic.oup.com/jhps/article/6/4/364/5610188', 'Suggests that compression + cooling may reduce reliance on pain medication—an important clinical benefit that Force X supports.'),
                ),
                'why_title' => 'Why Force X Is Backed by High-Level Clinical Data',
                'why_text' => 'In a study by Klaber et al., adding compressive cryotherapy after hip arthroscopy resulted in significantly lower pain scores and a trend toward reduced analgesic use and earlier discharge compared to cryotherapy alone. Force X incorporates that same controlled cooling + dynamic compression approach—giving clinicians and patients the protocol shown to enhance early recovery. Force X = Cold. Compression. Control. The clinical advantage is real.',
            ),
            // ── SLIDE 4 — Leegwater et al., 2012 ──
            array(
                'title' => 'Cryocompression After Hip Arthroplasty',
                'study_ref' => 'Leegwater NC, Willems JH, Brohet R, Nolte PA. Cryocompression therapy after elective arthroplasty of the hip. Hip Int. 2012;22(5):527-533.',
                'study_link' => 'https://pubmed.ncbi.nlm.nih.gov/23112075/',
                'col_left_title' => 'Clinical Finding (Leegwater et al., 2012)',
                'col_right_title' => 'What It Means for Force X',
                'rows' => array(
                    array('Elective hip arthroplasty patients: intervention group received intermittent cryo-compression (n=15) vs control (n=15) with compression band alone.', 'https://pubmed.ncbi.nlm.nih.gov/23112075/', 'This supports using combined cooling + compression rather than compression alone—matching Force X\'s approach.'),
                    array('Day 1 post-op: Hemoglobin drop was 2.34 mmol/L in control vs 1.87 mmol/L in cryo-compression group (p = 0.027) — indicating less immediate blood loss.', 'https://pubmed.ncbi.nlm.nih.gov/23112075/', 'Suggests that cryo-compression may reduce bleeding/hemorrhage risk. Force X\'s regulated compression may assist this benefit.'),
                    array('Trends (but not statistically significant) toward lower morphine use, shorter hospital stay, and less wound discharge in the cryo-compression group.', 'https://pubmed.ncbi.nlm.nih.gov/23112075/', 'Force X\'s design (consistent cooling + compression) aligns with outcomes like reduced analgesic use, faster discharge and fewer wound complications.'),
                    array('No difference found in pain scores at short-term measurement in this study.', 'https://pubmed.ncbi.nlm.nih.gov/23112075/', 'While pain reduction wasn\'t statistically proven here, the hematological and functional trends still point to meaningful recovery benefits from cryo-compression.'),
                ),
                'why_title' => 'Why Force X Is Backed by High-Level Clinical Data',
                'why_text' => 'In the study by Leegwater et al., using intermittent cryocompression after hip arthroplasty resulted in less blood loss, reduced wound discharge, and trends toward less pain medication usage and shorter hospital stay compared to a standard compression band alone. Force X incorporates the same key elements — regulated cooling, intermittent/dynamic compression, and proven protocol alignment — positioning it as the clinically supported solution for postoperative rehabilitation. Force X = Controlled Cold + Compression + Reliable Outcomes.',
            ),
            // ── SLIDE 5 — Song et al., 2016 (Prospective) ──
            array(
                'title' => 'Compressive Cryotherapy vs Cryotherapy Alone',
                'study_ref' => 'Song M, et al. Compressive cryotherapy versus cryotherapy alone in early rehabilitation after knee surgery: a prospective randomized study. (2016; PMID 27462522)',
                'study_link' => 'https://pubmed.ncbi.nlm.nih.gov/27462522/',
                'col_left_title' => 'Clinical Finding (Song et al., 2016)',
                'col_right_title' => 'What It Means for Force X',
                'rows' => array(
                    array('Patients receiving compressive cryotherapy (cold + intermittent compression) versus cryotherapy alone showed improved outcomes in the early rehabilitation period after knee surgery.', 'https://pubmed.ncbi.nlm.nih.gov/27462522/', 'Force X\'s design pairs controlled cooling with dynamic compression—mirroring the "cold + compression" approach shown to enhance early post-operative recovery.'),
                    array('The study highlights that compression adds value beyond cooling alone, especially in early rehab after knee surgery.', 'https://pubmed.ncbi.nlm.nih.gov/27462522/', 'This supports positioning Force X as more than a cold pack—it\'s a cryocompression system engineered for optimized rehabilitation protocols.'),
                    array('The benefits were observed in the "early rehabilitation stage" (immediate post-operative phase) which is a critical window for mobility, pain control and functional recovery.', 'https://pubmed.ncbi.nlm.nih.gov/27462522/', 'Force X should be emphasized as particularly effective immediately post-surgery, when patients and clinicians seek faster, smoother recovery.'),
                ),
                'why_title' => 'Why Force X Is Clinically Supported',
                'why_text' => 'In the randomized study by Song and colleagues, adding compression to cryotherapy during early knee-surgery rehab resulted in better outcomes than cooling alone. Force X replicates that model—delivering controlled temperature, intermittent/dynamic compression, and protocol-driven duration—so clinicians and patients get the evidence-based advantage. Force X = Cold Control + Dynamic Compression + Fast Recovery.',
            ),
            // ── SLIDE 6 — Song et al., 2016 (Meta-analysis) ──
            array(
                'title' => 'Compressive Cryotherapy — Meta-analysis',
                'study_ref' => 'Song M, Sun X, Tian X, et al. Compressive cryotherapy versus cryotherapy alone in patients undergoing knee surgery: a meta-analysis. SpringerPlus. 2016.',
                'study_link' => 'https://pubmed.ncbi.nlm.nih.gov/27462522/',
                'col_left_title' => 'Finding',
                'col_right_title' => 'Implication for Force X',
                'rows' => array(
                    array('In the meta-analysis of 10 RCTs (522 patients) comparing compressive cryotherapy to cryotherapy alone after knee surgery, patients receiving compression + cooling had less pain at POD2 and POD3.', 'https://pubmed.ncbi.nlm.nih.gov/27462522/', 'Force X\'s combination of regulated cooling + dynamic compression supports the clinical benefit of this approach in early rehab.'),
                    array('The same analysis found a strong tendency toward less swelling with compressive cryotherapy at POD1 and POD2.', 'https://pubmed.ncbi.nlm.nih.gov/27462522/', 'Force X\'s compression component may help reduce swelling in the acute post-operative window.'),
                    array('During the intermediate rehabilitation phase, no significant difference was found between compression + cryotherapy vs cryotherapy alone.', 'https://pubmed.ncbi.nlm.nih.gov/27462522/', 'Emphasizes that the greatest benefit is in the early post-surgical period—a time when Force X is uniquely positioned to deliver value.'),
                ),
                'why_title' => 'Why Force X Aligns With Clinical Evidence',
                'why_text' => 'A large meta-analysis (Song M et al., 2016) found that adding compression to cryotherapy significantly reduces pain and tends to reduce swelling in the early days after knee surgery. Force X brings together precisely controlled cooling, dynamic intermittent compression, and optimized treatment duration—mirroring the protocols shown to drive early recovery benefits. Force X = cold. compression. control. early recovery.',
            ),
            // ── SLIDE 7 — Yang et al., 2023 ──
            array(
                'title' => 'Cryopneumatic Device vs Ice Packs',
                'study_ref' => 'Yang JH, Hwang KT, Lee MK, Jo S, Cho E, Lee JK. Comparison of a Cryopneumatic Compression Device and Ice Packs for Cryotherapy Following Anterior Cruciate Ligament Reconstruction. Clin Orthop Surg. 2023;15(2):234-240. (PMID 37008961)',
                'study_link' => 'https://pubmed.ncbi.nlm.nih.gov/37008961/',
                'col_left_title' => 'Clinical Finding (Yang et al., 2023)',
                'col_right_title' => 'What It Means for Force X',
                'rows' => array(
                    array('Significantly lower pain (VAS) score on post-op Day 4 for the cryo-pneumatic compression device vs standard ice packs (2.1 ± 1.4 vs 3.3 ± 1.3; p = 0.001).', 'https://pmc.ncbi.nlm.nih.gov/articles/PMC10060780/', 'Shows that the addition of regulated compression + cooling—core technology in Force X—can deliver measurable benefit in early post-surgical pain relief.'),
                    array('The sum of post-operative drainage + joint effusion (measured via 3D MRI reconstruction) was significantly less in the compression-device group (p = 0.015).', 'https://pmc.ncbi.nlm.nih.gov/articles/PMC10060780/', 'Indicates that Force X\'s compression component may contribute to less joint fluid/effusion—therefore supporting faster recovery and less swelling.'),
                    array('No statistically significant difference found in cumulative fentanyl (48h) or rescue medication use between groups.', 'https://pmc.ncbi.nlm.nih.gov/articles/PMC10060780/', 'While pain and effusion improved, analgesic usage did not differ significantly—suggesting that benefits may be more functional/structural, not solely via reduced medication.'),
                ),
                'why_title' => 'Why Force X Is Backed by Cutting-Edge Clinical Data',
                'why_text' => 'In the randomized trial by Yang et al., patients who used a cryo-pneumatic compression device after ACL reconstruction had significantly lower pain on Day 4 and less joint fluid/effusion compared to standard ice-pack therapy. Force X incorporates the same key elements—precise cooling, dynamic compression, and protocol-driven duration—so that clinicians and patients benefit from the proven approach. Force X = Controlled Cold + Active Compression + Evidence-Based Recovery.',
            ),
            // ── SLIDE 8 — Sawada et al., 2022 ──
            array(
                'title' => 'Alternating Heat and Cold Stimulation',
                'study_ref' => 'Sawada T, Okawara H, Nakashima D, et al. "Effects of alternating heat and cold stimulation using a wearable thermo-device on subjective and objective shoulder stiffness." J Physiol Anthropol. 2022;41:1.',
                'study_link' => 'https://jphysiolanthropol.biomedcentral.com/articles/10.1186/s40101-021-00275-9',
                'col_left_title' => 'Clinical Finding (Sawada et al., 2022)',
                'col_right_title' => 'What It Means for Force X',
                'rows' => array(
                    array('In healthy young men, alternating heat + cold (HC) applied via a wearable thermo-device significantly reduced trapezius muscle hardness (from ~1.43 N to ~1.37 N; d = 0.44; p < 0.05).', 'https://jphysiolanthropol.biomedcentral.com/articles/10.1186/s40101-021-00275-9', 'Indicates that switching between thermal states (cold + heat) with controlled devices can measurably soften muscle tissue — a mechanism Force X leverages via cold + compression (and optionally heat) control.'),
                    array('Subjective reports: HC condition produced greater improvements in "refreshed feeling," reduced muscle stiffness and fatigue compared to no-stimulation and cold alone.', 'https://jphysiolanthropol.biomedcentral.com/articles/10.1186/s40101-021-00275-9', 'Aligns with the recovery narrative: when patients feel less stiffness and fatigue sooner, their mobility and engagement in rehab improve — exactly the goal Force X aims for.'),
                    array('The reduction in muscle hardness correlated significantly with the magnitude of skin cooling (cold max: r = 0.634, p < 0.01) rather than heating.', 'https://jphysiolanthropol.biomedcentral.com/articles/10.1186/s40101-021-00275-9', 'Demonstrates that controlled cold stimulation (in combination context) plays a key role — supporting the cold-compression emphasis built into Force X.'),
                    array('Although this was a healthy-participant study (not post-surgical), it supports the concept of thermotherapy + compression/contrast stimuli in soft-tissue recovery.', 'https://jphysiolanthropol.biomedcentral.com/articles/10.1186/s40101-021-00275-9', 'Provides mechanistic support that controlled thermal protocols matter — reinforcing the value of Force X\'s precision temperature and compression regulation.'),
                ),
                'why_title' => 'Why Force X Supports Advanced Recovery Protocols',
                'why_text' => 'In the study by Sawada et al., applying alternating heat and cold using a wearable device resulted in measurable soft-tissue benefits — including reduced muscle stiffness and improved subjective recovery in the shoulder region. Force X builds on this evidence by offering precise thermal regulation (cold and optional heat modes), dynamic compression, and protocol-driven treatment cycles—giving clinicians and patients a system that aligns with state-of-the-art recovery science. Force X = Precision Cold & Compression + Evidence-Informed Recovery.',
            ),
            // ── SLIDE 9 — Trybulski et al., 2024 ──
            array(
                'title' => 'Cold, Heat and Contrast Pressure Therapy',
                'study_ref' => 'Trybulski R, Kużdżał A, Stanula A, et al. "Acute effects of cold, heat and contrast pressure therapy on forearm muscles regeneration in combat sports athletes: a randomized clinical trial." Sci Rep. 2024;14:22410.',
                'study_link' => 'https://www.nature.com/articles/s41598-024-72412-0',
                'col_left_title' => 'Clinical Finding (Trybulski et al., 2024)',
                'col_right_title' => 'What It Means for Force X',
                'rows' => array(
                    array('Cold-therapy alone produced a significantly lower muscle elasticity (i.e., stiffer muscle) compared to heat, contrast or control groups (e.g., ColdT elasticity 0.99 ± 0.07 vs HeatT 1.11 ± 0.07; p = 0.002)', 'https://www.nature.com/articles/s41598-024-72412-0', 'Indicates that controlled thermal protocols matter for tissue mechanics—Force X\'s regulated cooling (and optionally heat) helps maintain/improve tissue elasticity.'),
                    array('Contrast (cold + heat + pressure) and heat groups improved biomechanical muscle properties in the hours after treatment in combat sports athletes.', 'https://www.nature.com/articles/s41598-024-72412-0', 'Supports the concept of "cold + compression + optional heat" — which aligns with Force X\'s multi-modality capability.'),
                    array('The study was done in trained athletes (MMA) focusing on muscle regeneration and biomechanical changes rather than just pain or swelling.', 'https://www.nature.com/articles/s41598-024-72412-0', 'Shows that advanced recovery protocols benefit from more than just pain relief—Force X supports underlying tissue recovery which is a differentiator.'),
                ),
                'why_title' => 'Why Force X Incorporates Advanced Recovery Science',
                'why_text' => 'In the randomized trial by Trybulski et al., applying cold, heat and contrast pressure therapy led to measurable improvements in muscle biomechanical properties—better tissue elasticity and regeneration—compared to basic cold alone. Force X mirrors these advanced protocols through precision temperature control, dynamic compression, and optional heat/contrast modes—giving clinicians and patients access to next-level therapeutic recovery devices. Force X = Cold + Compression + Smart Thermal Contrast = Real Recovery Advantage.',
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
                                    <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6"><?php echo esc_html($slide['title']); ?></h3>

                                    <!-- Two Column Table Header -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8 mb-2">
                                        <h4 class="text-base font-semibold text-gray-900"><?php echo esc_html($slide['col_left_title']); ?></h4>
                                        <h4 class="text-base font-semibold text-gray-900 hidden md:block"><?php echo esc_html($slide['col_right_title']); ?></h4>
                                    </div>

                                    <!-- Table Rows -->
                                    <?php foreach ($slide['rows'] as $row): 
                                        $finding = $row[0];
                                        $finding_link = $row[1];
                                        $meaning = $row[2];
                                    ?>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8 py-3 border-t border-gray-100">
                                        <div class="text-gray-700 text-sm leading-relaxed">
                                            <?php echo esc_html($finding); ?>
                                            <?php if (!empty($finding_link)): ?>
                                                <a href="<?php echo esc_url($finding_link); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center ml-1 text-xs font-medium hover:underline" style="color: #25AAE1;">PubMed ↗</a>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <h4 class="text-base font-semibold text-gray-900 mb-1 md:hidden"><?php echo esc_html($slide['col_right_title']); ?></h4>
                                            <p class="text-gray-600 text-sm leading-relaxed"><?php echo esc_html($meaning); ?></p>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>

                                    <!-- Bottom Boxes -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 mt-6 mb-8">
                                        <!-- Box: Why Force X -->
                                        <div class="rounded-xl p-5 md:p-5" style="background-color: #f0f5fa;">
                                            <h5 class="text-base font-semibold text-gray-900 mb-2"><?php echo esc_html($slide['why_title']); ?></h5>
                                            <p class="text-gray-600 text-sm leading-relaxed"><?php echo esc_html($slide['why_text']); ?></p>
                                        </div>
                                        <!-- Box: Study Referenced with prominent link -->
                                        <div class="rounded-xl p-5 md:p-5" style="background-color: #f0f5fa;">
                                            <h5 class="text-base font-semibold text-gray-900 mb-2">Study Referenced</h5>
                                            <p class="text-gray-600 text-sm leading-relaxed mb-3"><?php echo esc_html($slide['study_ref']); ?></p>
                                            <?php if (!empty($slide['study_link'])): ?>
                                                <a href="<?php echo esc_url($slide['study_link']); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-white text-sm font-medium hover:opacity-90 transition-opacity" style="background: linear-gradient(135deg, #25AAE1 0%, #004F8C 100%);">
                                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                    VIEW STUDY
                                                </a>
                                            <?php endif; ?>
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
    
    // Clinical Evidence Slider - Fade Effect with Autoplay
    const clinicalEvidenceTrack = document.getElementById('clinical-evidence-slider-track');
    
    if (clinicalEvidenceTrack) {
        let currentEvidenceSlide = 0;
        const evidenceSlides = clinicalEvidenceTrack.querySelectorAll('.clinical-evidence-slide');
        const totalEvidenceSlides = evidenceSlides.length;
        let evidenceAutoplayTimer = null;
        const EVIDENCE_AUTOPLAY_INTERVAL = 7000;
        
        if (totalEvidenceSlides > 1) {
            function updateClinicalEvidenceSlider() {
                evidenceSlides.forEach((slide, index) => {
                    slide.classList.remove('active');
                    if (index === currentEvidenceSlide) slide.classList.add('active');
                });
                const activeSlide = evidenceSlides[currentEvidenceSlide];
                if (activeSlide) {
                    const counter = activeSlide.querySelector('.clinical-evidence-counter');
                    if (counter) counter.innerHTML = '<span class="text-2xl md:text-3xl font-bold">' + (currentEvidenceSlide + 1) + '</span> / <span class="text-lg md:text-xl text-gray-500">' + totalEvidenceSlides + '</span>';
                    const container = document.querySelector('.clinical-evidence-slider-container');
                    if (container) setTimeout(() => { container.style.minHeight = activeSlide.offsetHeight + 'px'; }, 100);
                }
            }
            function handleEvidenceNav(direction) {
                if (direction === 'next') currentEvidenceSlide = (currentEvidenceSlide + 1) % totalEvidenceSlides;
                else currentEvidenceSlide = currentEvidenceSlide === 0 ? totalEvidenceSlides - 1 : currentEvidenceSlide - 1;
                updateClinicalEvidenceSlider();
            }
            function startEvidenceAutoplay() { stopEvidenceAutoplay(); evidenceAutoplayTimer = setInterval(function() { handleEvidenceNav('next'); }, EVIDENCE_AUTOPLAY_INTERVAL); }
            function stopEvidenceAutoplay() { if (evidenceAutoplayTimer) { clearInterval(evidenceAutoplayTimer); evidenceAutoplayTimer = null; } }
            function resetEvidenceAutoplay() { stopEvidenceAutoplay(); startEvidenceAutoplay(); }
            
            clinicalEvidenceTrack.addEventListener('click', function(e) {
                if (e.target.closest('a[href]')) return;
                if (e.target.closest('.clinical-evidence-prev')) { e.preventDefault(); e.stopPropagation(); handleEvidenceNav('prev'); resetEvidenceAutoplay(); }
                else if (e.target.closest('.clinical-evidence-next')) { e.preventDefault(); e.stopPropagation(); handleEvidenceNav('next'); resetEvidenceAutoplay(); }
            });
            const evidenceContainer = document.querySelector('.clinical-evidence-slider-container');
            if (evidenceContainer) {
                let eTouchStartX = 0, eTouchEndX = 0;
                evidenceContainer.addEventListener('touchstart', function(e) { eTouchStartX = e.changedTouches[0].screenX; }, { passive: true });
                evidenceContainer.addEventListener('touchend', function(e) { eTouchEndX = e.changedTouches[0].screenX; const diff = eTouchStartX - eTouchEndX; if (Math.abs(diff) > 50) { if (diff > 0) handleEvidenceNav('next'); else handleEvidenceNav('prev'); resetEvidenceAutoplay(); } }, { passive: true });
                evidenceContainer.addEventListener('mouseenter', function() { stopEvidenceAutoplay(); });
                evidenceContainer.addEventListener('mouseleave', function() { startEvidenceAutoplay(); });
            }
            document.addEventListener('visibilitychange', function() { if (document.hidden) stopEvidenceAutoplay(); else startEvidenceAutoplay(); });
            updateClinicalEvidenceSlider();
            startEvidenceAutoplay();
            window.addEventListener('resize', function() { clearTimeout(resizeTimer); resizeTimer = setTimeout(function() { updateClinicalEvidenceSlider(); }, 250); });
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

