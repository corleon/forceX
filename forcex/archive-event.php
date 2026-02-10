<?php
/**
 * Template for displaying event archives
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container-custom py-12">
        <!-- Breadcrumbs -->
        <nav class="mb-6">
            <div class="flex justify-center">
                <ol class="flex items-center  text-base text-gray-500 bg-white px-4 py-2 rounded-full">
                    <li><a href="<?php echo home_url(); ?>" class="hover:text-primary-500">Main</a></li>
                    <li class="flex items-center">
                        <span class="mx-2 text-gray-400">/</span>
                        <span class="text-gray-900 font-medium">Events</span>
                    </li>
                </ol>
            </div>
        </nav>

        <!-- Page Title -->
        <div class="text-center mb-12">
            <h1 class="title-h2">Events</h1>
        </div>

        <!-- Event Filters -->
        <div class="flex justify-center mb-12">
            <div class="flex flex-wrap justify-center gap-1" style="background-color: #EEF2F6; border-radius: 32px; padding: 3px;">
                <button class="event-filter-btn active" data-filter="all">
                    All
                </button>
                <button class="event-filter-btn" data-filter="exhibitions">
                    Exhibitions
                </button>
                <button class="event-filter-btn" data-filter="conferences">
                    Conferences
                </button>
                <button class="event-filter-btn" data-filter="trade-shows">
                    Trade Shows
                </button>
                <button class="event-filter-btn" data-filter="webinars">
                    Webinars
                </button>
            </div>
        </div>

        <!-- Events Grid -->
        <div class="events-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $events_query = new WP_Query(array(
                'post_type' => 'event',
                'posts_per_page' => 6,
                'paged' => $paged,
                'meta_key' => '_event_date',
                'orderby' => 'meta_value',
                'order' => 'ASC',
                'meta_query' => array(
                    array(
                        'key' => '_event_date',
                        'value' => date('Y-m-d'),
                        'compare' => '>='
                    )
                )
            ));

            if ($events_query->have_posts()) :
                while ($events_query->have_posts()) : $events_query->the_post();
                    $event_type = get_post_meta(get_the_ID(), '_event_type', true);
                    $event_location = get_post_meta(get_the_ID(), '_event_location', true);
                    $event_date = get_post_meta(get_the_ID(), '_event_date', true);
                    $event_speakers = get_post_meta(get_the_ID(), '_event_speakers', true);
                    $event_register_url = get_post_meta(get_the_ID(), '_event_register_url', true);
                    $speakers_array = !empty($event_speakers) ? array_map('trim', explode(',', $event_speakers)) : array();
                    ?>
                    <div class="event-card bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300" data-event-type="<?php echo esc_attr($event_type); ?>">
                        <!-- Event Image -->
                        <div class="relative">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('large', array('class' => 'w-full h-64 object-cover')); ?>
                            <?php else : ?>
                                <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Event Type Badge -->
                            <div class="absolute top-4 left-4">
                                <span class="event-type-badge px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide
                                    <?php 
                                    switch($event_type) {
                                        case 'exhibitions':
                                            echo 'bg-primary-100 text-primary-800';
                                            break;
                                        case 'conferences':
                                            echo 'bg-green-100 text-green-800';
                                            break;
                                        case 'trade-shows':
                                            echo 'bg-purple-100 text-purple-800';
                                            break;
                                        case 'webinars':
                                            echo 'bg-orange-100 text-orange-800';
                                            break;
                                        default:
                                            echo 'bg-gray-100 text-gray-800';
                                    }
                                    ?>">
                                    <?php echo ucfirst(str_replace('-', ' ', $event_type)); ?>
                                </span>
                            </div>
                        </div>

                        <!-- Event Content -->
                        <div class="p-6">
                            <!-- Event Title -->
                            <h3 class="text-xl font-bold text-gray-900 mb-4"><?php the_title(); ?></h3>

                            <!-- Event Details -->
                            <div class="space-y-3 mb-6">
                                <!-- Location -->
                                <?php if ($event_location) : ?>
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span><?php echo esc_html($event_location); ?></span>
                                    </div>
                                <?php endif; ?>

                                <!-- Date -->
                                <?php if ($event_date) : ?>
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span><?php echo date('F j, Y', strtotime($event_date)); ?></span>
                                    </div>
                                <?php endif; ?>

                                <!-- Speakers -->
                                <?php if (!empty($speakers_array)) : ?>
                                    <div class="flex items-start text-gray-600">
                                        <svg class="w-5 h-5 mr-2 mt-0.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <div>
                                            <span class="text-sm"><?php echo implode(', ', array_slice($speakers_array, 0, 3)); ?>
                                            <?php if (count($speakers_array) > 3) : ?>
                                                <span class="text-gray-400">and <?php echo count($speakers_array) - 3; ?> more</span>
                                            <?php endif; ?>
                                            </span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Event Description -->
                            <?php if (has_excerpt()) : ?>
                                <div class="text-gray-600 text-sm mb-6">
                                    <?php the_excerpt(); ?>
                                </div>
                            <?php endif; ?>

                            <!-- Register Button -->
                            <div class="text-center">
                                <?php if ($event_register_url) : ?>
                                    <a href="<?php echo esc_url($event_register_url); ?>" 
                                       class="inline-block bg-primary-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-600 transition-colors duration-200"
                                       target="_blank" rel="noopener">
                                        REGISTER
                                    </a>
                                <?php else : ?>
                                    <button class="inline-block bg-gray-300 text-gray-500 px-6 py-3 rounded-lg font-semibold cursor-not-allowed">
                                        REGISTER
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            else : ?>
                <div class="col-span-full text-center py-12">
                    <div class="text-gray-500 text-lg">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p>No events found. Check back soon for upcoming events!</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if ($events_query->max_num_pages > 1) : ?>
            <div class="mt-12 flex justify-center">
                <?php
                echo paginate_links(array(
                    'total' => $events_query->max_num_pages,
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
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>

