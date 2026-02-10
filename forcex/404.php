<?php
/**
 * The template for displaying 404 pages (not found)
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
                        <span class="text-gray-900 font-medium">404</span>
                    </li>
                </ol>
            </div>
        </nav>

        <!-- 404 Content -->
        <div class="text-center max-w-2xl mx-auto py-16 md:py-24">
            <!-- Error Number -->
            <div class="mb-8">
                <h1 class="text-8xl md:text-9xl font-bold text-gray-300 mb-4" style="line-height: 1;">
                    404
                </h1>
            </div>

            <!-- Title -->
            <h2 class="title-h2 mb-6">
                Page Not Found
            </h2>

            <!-- Description -->
            <p class="text-lg md:text-xl text-gray-600 mb-8 leading-relaxed">
                Sorry, the page you are looking for doesn't exist or has been moved. 
                Let's get you back on track with your recovery journey.
            </p>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-gradient">
                    Go to Homepage
                </a>
                <a href="<?php echo esc_url(home_url('/products')); ?>" class="btn-white">
                    Explore Products
                </a>
            </div>

            <!-- Helpful Links -->
            <div class="mt-12 pt-8 border-t border-gray-200">
                <p class="text-sm text-gray-500 mb-4">You might be looking for:</p>
                <div class="flex flex-wrap justify-center gap-4 text-sm">
                    <a href="<?php echo esc_url(home_url('/products')); ?>" class="text-primary-500 hover:text-primary-600 hover:underline">
                        Products
                    </a>
                    <span class="text-gray-300">|</span>
                    <a href="<?php echo esc_url(get_post_type_archive_link('review') ?: home_url('/reviews')); ?>" class="text-primary-500 hover:text-primary-600 hover:underline">
                        Reviews
                    </a>
                    <span class="text-gray-300">|</span>
                    <a href="<?php echo esc_url(get_post_type_archive_link('article') ?: home_url('/articles')); ?>" class="text-primary-500 hover:text-primary-600 hover:underline">
                        Articles
                    </a>
                    <span class="text-gray-300">|</span>
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="text-primary-500 hover:text-primary-600 hover:underline">
                        Contact
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>

