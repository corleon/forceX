<?php
/**
 * Template for displaying single events
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container-custom py-12">
        <?php while (have_posts()) : the_post(); ?>
            <?php
            $event_type = get_post_meta(get_the_ID(), '_event_type', true);
            $event_location = get_post_meta(get_the_ID(), '_event_location', true);
            $event_date = get_post_meta(get_the_ID(), '_event_date', true);
            $event_speakers = get_post_meta(get_the_ID(), '_event_speakers', true);
            $event_register_url = get_post_meta(get_the_ID(), '_event_register_url', true);
            $speakers_array = !empty($event_speakers) ? array_map('trim', explode(',', $event_speakers)) : array();
            ?>
            
            <!-- Breadcrumbs -->
            <nav class="mb-6">
                <div class="flex justify-center">
                    <ol class="flex items-center  text-base text-gray-500 bg-white px-4 py-2 rounded-full">
                        <li><a href="<?php echo home_url(); ?>" class="hover:text-primary-500">Main</a></li>
                        <li class="flex items-center">
                            <span class="mx-2 text-gray-400">/</span>
                            <a href="<?php echo get_post_type_archive_link('event'); ?>" class="hover:text-primary-500">Events</a>
                        </li>
                        <li class="flex items-center">
                            <span class="mx-2 text-gray-400">/</span>
                            <span class="text-gray-900 font-medium"><?php the_title(); ?></span>
                        </li>
                    </ol>
                </div>
            </nav>

            <div class="max-w-4xl mx-auto">
                <!-- Event Header -->
                <div class="mb-8">
                    <!-- Event Type Badge -->
                    <?php if ($event_type) : ?>
                        <div class="mb-4">
                            <span class="event-type-badge px-4 py-2 rounded-full text-sm font-semibold uppercase tracking-wide
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
                    <?php endif; ?>

                    <!-- Event Title -->
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6"><?php the_title(); ?></h1>

                    <!-- Event Meta -->
                    <div class="flex flex-wrap gap-6 text-gray-600 mb-8">
                        <?php if ($event_location) : ?>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="font-medium"><?php echo esc_html($event_location); ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if ($event_date) : ?>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-medium"><?php echo date('F j, Y', strtotime($event_date)); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Event Image -->
                <?php if (has_post_thumbnail()) : ?>
                    <div class="mb-8">
                        <?php the_post_thumbnail('large', array('class' => 'w-full h-96 object-cover rounded-2xl shadow-lg')); ?>
                    </div>
                <?php endif; ?>

                <!-- Event Content -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Main Content -->
                    <div class="lg:col-span-2">
                        <div class="prose prose-lg max-w-none">
                            <?php the_content(); ?>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-8">
                            <!-- Speakers -->
                            <?php if (!empty($speakers_array)) : ?>
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Speakers & Attendees</h3>
                                    <div class="space-y-2">
                                        <?php foreach ($speakers_array as $speaker) : ?>
                                            <div class="flex items-center text-gray-600">
                                                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                                <span><?php echo esc_html($speaker); ?></span>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Registration -->
                            <div class="border-t pt-6">
                                <?php if ($event_register_url) : ?>
                                    <a href="<?php echo esc_url($event_register_url); ?>" 
                                       class="w-full bg-primary-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-600 transition-colors duration-200 text-center block"
                                       target="_blank" rel="noopener">
                                        REGISTER NOW
                                    </a>
                                <?php else : ?>
                                    <button class="w-full bg-gray-300 text-gray-500 px-6 py-3 rounded-lg font-semibold cursor-not-allowed text-center">
                                        REGISTRATION CLOSED
                                    </button>
                                <?php endif; ?>
                            </div>

                            <!-- Event Details -->
                            <div class="mt-6 space-y-4 text-sm">
                                <?php if ($event_type) : ?>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Type:</span>
                                        <span class="font-medium"><?php echo ucfirst(str_replace('-', ' ', $event_type)); ?></span>
                                    </div>
                                <?php endif; ?>

                                <?php if ($event_location) : ?>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Location:</span>
                                        <span class="font-medium"><?php echo esc_html($event_location); ?></span>
                                    </div>
                                <?php endif; ?>

                                <?php if ($event_date) : ?>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Date:</span>
                                        <span class="font-medium"><?php echo date('M j, Y', strtotime($event_date)); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Back to Events -->
                <div class="mt-12 text-center">
                    <a href="<?php echo get_post_type_archive_link('event'); ?>" 
                       class="inline-flex items-center text-primary-500 hover:text-primary-600 font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to All Events
                    </a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>

