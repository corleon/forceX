<?php
/**
 * Template for displaying review archives
 */

get_header(); ?>

<main id="main" class="site-main relative" style="background-color: #EEF2F6;">
    <div class="hero-background absolute inset-0 bg-center bg-no-repeat" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/bgblur.png'), url('<?php echo get_template_directory_uri(); ?>/assets/img/bgreviews.png'); background-position: center, center; background-repeat: no-repeat, no-repeat; "></div>
    <div class="container-custom py-12 relative z-10">
        <!-- Breadcrumbs -->
        <nav class="mb-6">
            <div class="flex justify-center">
                <ol class="flex items-center  text-base text-gray-500 bg-white px-4 py-2 rounded-full">
                    <li><a href="<?php echo home_url(); ?>" class="hover:text-primary-500">Main</a></li>
                    <li class="flex items-center">
                        <span class="mx-2 text-gray-400">/</span>
                        <span class="text-gray-900 font-medium">Reviews</span>
                    </li>
                </ol>
            </div>
        </nav>

        <!-- Page Title -->
        <div class="text-center mb-12">
            <h1 class="title-h2">Reviews</h1>
        </div>

        <?php
        // Get 2 highlighted reviews
        $highlighted_query = new WP_Query(array(
            'post_type' => 'review',
            'posts_per_page' => 2,
            'meta_query' => array(
                array(
                    'key' => '_is_highlighted',
                    'value' => '1',
                    'compare' => '='
                )
            ),
            'orderby' => 'date',
            'order' => 'DESC'
        ));
        
        // Collect highlighted review IDs for exclusion
        $highlighted_ids = array();
        if ($highlighted_query->have_posts()) {
            foreach ($highlighted_query->posts as $post) {
                $highlighted_ids[] = $post->ID;
            }
        }
        ?>

        <!-- Top Section: 2 Highlighted Reviews -->
        <?php if ($highlighted_query->have_posts()) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
                <?php while ($highlighted_query->have_posts()) : $highlighted_query->the_post(); 
                    $reviewer_name = get_post_meta(get_the_ID(), '_reviewer_name', true);
                    $reviewer_title = get_post_meta(get_the_ID(), '_reviewer_title', true);
                    ?>
                    <div class="rounded p-6 " style="background: linear-gradient(180deg, #EEF2F6 0%, #F5F9FC 100%);">
                        <blockquote class="text-gray-700 mb-6 leading-relaxed">
                            <?php echo wp_kses_post(get_the_content()); ?>
                        </blockquote>
                        <div class="flex items-center">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="w-12 h-12 rounded-full overflow-hidden mr-4 flex-shrink-0">
                                    <?php the_post_thumbnail('thumbnail', array('class' => 'w-full h-full object-cover')); ?>
                                </div>
                            <?php else : ?>
                                <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            <?php endif; ?>
                            <div>
                                <div class="font-semibold text-gray-900"><?php echo esc_html($reviewer_name ?: get_the_title()); ?></div>
                                <?php if ($reviewer_title) : ?>
                                    <div class="text-sm text-gray-600"><?php echo esc_html($reviewer_title); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; 
        wp_reset_postdata();
        ?>

        <?php
        // Get slider reviews
        $slider_query = new WP_Query(array(
            'post_type' => 'review',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => '_is_in_slider',
                    'value' => '1',
                    'compare' => '='
                )
            ),
            'orderby' => 'date',
            'order' => 'DESC'
        ));
        
        // Collect slider review IDs for exclusion
        $slider_ids = array();
        if ($slider_query->have_posts()) {
            foreach ($slider_query->posts as $post) {
                $slider_ids[] = $post->ID;
            }
        }
        ?>

        <!-- Slider Section -->
        <?php if ($slider_query->have_posts()) : ?>
            <div class="relative mb-16 py-16 bg-white overflow-hidden rounded-tl-[90px] rounded-br-[90px] mx-auto" style="position: relative; max-width: 1120px;">
                <!-- Subtle blue wave patterns at top and bottom -->
                <div class="absolute top-0 left-0 right-0 h-32 overflow-hidden pointer-events-none">
                    <div class="absolute top-0 left-0 w-full h-full" style="background: linear-gradient(180deg, rgba(228, 240, 249, 0.3) 0%, transparent 100%); border-radius: 0 0 50% 50%;"></div>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-32 overflow-hidden pointer-events-none">
                    <div class="absolute bottom-0 left-0 w-full h-full" style="background: linear-gradient(0deg, rgba(228, 240, 249, 0.3) 0%, transparent 100%); border-radius: 50% 50% 0 0;"></div>
                </div>
                
                <div class="reviews-slider relative mx-auto px-6 z-10" style="max-width: 1100px;">
                    <div class="overflow-hidden">
                        <div class="reviews-slider-track flex" id="reviews-slider-track">
                            <?php while ($slider_query->have_posts()) : $slider_query->the_post(); 
                                $reviewer_name = get_post_meta(get_the_ID(), '_reviewer_name', true);
                                $reviewer_title = get_post_meta(get_the_ID(), '_reviewer_title', true);
                                $post_title = get_the_title();
                                $post_content = get_the_content();
                                ?>
                            <div class="reviews-slider-slide min-w-full px-4 flex-shrink-0">
                                <div class="flex flex-col md:flex-row gap-8 md:gap-12 items-start md:items-center">
                                    <!-- Left Side: Reviewer Information -->
                                    <div class="flex-shrink-0 w-full md:w-auto">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <div class="w-20 h-20 md:w-24 md:h-24 rounded-full overflow-hidden mb-4">
                                                <?php the_post_thumbnail('thumbnail', array('class' => 'w-full h-full object-cover')); ?>
                                            </div>
                                        <?php else : ?>
                                            <div class="w-20 h-20 md:w-24 md:h-24 bg-gray-200 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-10 h-10 md:w-12 md:h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                        <?php endif; ?>
                                        <div class="font-bold text-gray-900 text-xl md:text-2xl mb-2">
                                            <?php echo esc_html($reviewer_name ?: get_the_title()); ?>
                                        </div>
                                        <?php if ($reviewer_title) : ?>
                                            <div class="inline-block text-sm md:text-base text-gray-600 rounded-full px-4 py-1.5 bg-gray-100">
                                                <?php echo esc_html($reviewer_title); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Right Side: Review Content -->
                                    <div class="flex-1">
                                        <blockquote class="mb-4">
                                            <?php if (!empty($post_title)) : ?>
                                                <h3 class="title-h3">
                                                    "<?php echo esc_html($post_title); ?>"
                                                </h3>
                                            <?php endif; ?>
                                            <?php if (!empty($post_content)) : ?>
                                                <div class="text-base md:text-lg text-gray-700 leading-relaxed">
                                                    <?php echo wp_kses_post(wpautop($post_content)); ?>
                                                </div>
                                            <?php endif; ?>
                                        </blockquote>
                                    </div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    
                    <!-- Slider Navigation -->
                    <div class="flex items-center justify-center mt-10 gap-6">
                        <button type="button" id="reviews-slider-prev" class="reviews-slider-btn flex items-center justify-center bg-transparent hover:opacity-80 transition-opacity duration-200">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/leftblackarrow.svg" alt="Previous" class="w-12 h-12 md:w-16 md:h-16">
                        </button>
                        <span id="reviews-slider-counter" class="text-gray-900 font-medium px-6 text-lg md:text-xl">
                            <span class="text-gray-900 text-2xl md:text-3xl font-bold">1</span> / <span class="text-gray-500 text-lg md:text-xl"><?php echo $slider_query->post_count; ?></span>
                        </span>
                        <button type="button" id="reviews-slider-next" class="reviews-slider-btn flex items-center justify-center bg-transparent hover:opacity-80 transition-opacity duration-200">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/rightblackarrow.svg" alt="Next" class="w-12 h-12 md:w-16 md:h-16">
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; 
        wp_reset_postdata();
        ?>

        <?php
        // Combine IDs to exclude
        $exclude_ids = array_unique(array_merge($highlighted_ids, $slider_ids));
        
        // Get all other reviews (not highlighted, not in slider)
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $all_reviews_args = array(
            'post_type' => 'review',
            'posts_per_page' => 6,
            'paged' => $paged,
            'orderby' => 'date',
            'order' => 'DESC'
        );
        
        // Only exclude IDs if we have any
        if (!empty($exclude_ids)) {
            $all_reviews_args['post__not_in'] = $exclude_ids;
        }
        
        $all_reviews_query = new WP_Query($all_reviews_args);
        ?>

        <!-- All Other Reviews (3-Column Grid) -->
        <?php if ($all_reviews_query->have_posts()) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php while ($all_reviews_query->have_posts()) : $all_reviews_query->the_post(); 
                    $reviewer_name = get_post_meta(get_the_ID(), '_reviewer_name', true);
                    $reviewer_title = get_post_meta(get_the_ID(), '_reviewer_title', true);
                    ?>
                    <div class="rounded p-6  hover:shadow-lg transition-shadow duration-300" style="background: linear-gradient(102.27deg, #EEF2F6 20.84%, #F5F9FC 86.86%);">
                        <blockquote class="body-18 lg:min-h-[120px]">
                            <?php echo wp_kses_post(get_the_content()); ?>
                        </blockquote>
                        <div class="border-t border-solid mb-6" style="border-color: #25AAE1;"></div>
                        <div class="flex items-center">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="w-12 h-12 rounded-full overflow-hidden mr-4 flex-shrink-0">
                                    <?php the_post_thumbnail('thumbnail', array('class' => 'w-full h-full object-cover')); ?>
                                </div>
                            <?php else : ?>
                                <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            <?php endif; ?>
                            <div>
                                <div class="body-22-dark"><?php echo esc_html($reviewer_name ?: get_the_title()); ?></div>
                                <?php if ($reviewer_title) : ?>
                                    <div class="text-center text-gray-600 rounded-full px-3 py-1 bg-white"  ><?php echo esc_html($reviewer_title); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <div class="col-span-full text-center py-12">
                <div class="text-gray-500 text-lg">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <p>No reviews found.</p>
                </div>
            </div>
        <?php endif; ?>

        <!-- Pagination -->
        <?php if ($all_reviews_query->max_num_pages > 1) : ?>
            <div class="mt-12 flex justify-center">
                <?php
                echo paginate_links(array(
                    'total' => $all_reviews_query->max_num_pages,
                    'current' => $paged,
                    'format' => '?paged=%#%',
                    'show_all' => false,
                    'type' => 'list',
                    'end_size' => 2,
                    'mid_size' => 1,
                    'prev_text' => '&laquo; Previous',
                    'next_text' => 'Next &raquo;',
                    'add_args' => false,
                    'add_fragment' => '',
                ));
                ?>
            </div>
        <?php endif; 
        wp_reset_postdata();
        ?>
    </div>
</main>

<!-- Recovery CTA Section -->
<section class="relative py-20 md:py-24 overflow-hidden" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/recovery_bg.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="container-custom relative z-10">
        <div class="text-center max-w-3xl mx-auto">
            <h2 class="text-3xl md:text-4xl lg:text-5xl text-white mb-4">
                Ready to experience recovery redefined?
            </h2>
            <p class="text-lg md:text-xl text-white mb-8">
                Join thousands who trust ForceX for safer,<br> smarter healing.
            </p>
            <a href="<?php echo esc_url(home_url('/products')); ?>" class="btn-white">
                GET ForceX
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>

