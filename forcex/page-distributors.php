<?php
/**
 * Template Name: Distributors
 * Description: Become a ForceX™ distributor page with form
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<style>
    .forcex-contact-form input::placeholder {
        color: #748394;
    }
</style>

<main id="main" class="site-main relative" style="background-color: #EEF2F6; background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/gradientform.png'); background-position: center bottom; background-repeat: no-repeat; background-size: cover; position: relative;">
    <div class="absolute inset-0" style="background: radial-gradient(circle at center bottom, transparent 0%, transparent 40%, rgba(214, 239, 250, 0.3) 60%, rgba(196, 233, 248, 0.5) 100%); pointer-events: none;"></div>
    <div class="container-custom py-12 pb-24 md:pb-32 relative z-10" style="max-width: 900px; margin: 0 auto;">
        <!-- Breadcrumbs -->
        <nav class="mb-6">
            <div class="flex justify-center">
                <ol class="flex items-center  text-base text-gray-500 bg-white px-4 py-2 rounded-full">
                    <li><a href="<?php echo home_url(); ?>" class="hover:text-primary-500">Main</a></li>
                    <li class="flex items-center">
                        <span class="mx-2 text-gray-400">/</span>
                        <a href="<?php echo esc_url(home_url('/get-forcex')); ?>" class="hover:text-primary-500">Get ForceX</a>
                    </li>
                    <li class="flex items-center">
                        <span class="mx-2 text-gray-400">/</span>
                        <span class="text-gray-900 font-medium">Distributors</span>
                    </li>
                </ol>
            </div>
        </nav>

        <!-- Main Heading -->
        <div class="text-center mb-8">
            <h1 class="title-h2 mb-4">
                Become a ForceX™ distributor and bring cutting-edge recovery technology to your region
            </h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Expand your product offerings with the ForceX™ – the leading solution in iceless cold and compression therapy.
            </p>
        </div>

        <!-- Feature Tags -->
        <div class="flex flex-wrap justify-center gap-4 mb-12">
            <div class="flex items-center gap-2" style="background-color: #FFFFFF; border-radius: 9999px; padding: 4px;">
                <div class="flex items-center justify-center" style="width: 32px; height: 32px; background-color: #F0F2F5; border-radius: 50%;">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/control.svg" alt="Swelling control" style="width: 20px; height: 20px;">
                </div>
                <span style="font-size: 18px; color: #000000; font-weight: 500;">Swelling control</span>
            </div>
            <div class="flex items-center gap-2" style="background-color: #FFFFFF; border-radius: 9999px; padding: 4px;">
                <div class="flex items-center justify-center" style="width: 32px; height: 32px; background-color: #F0F2F5; border-radius: 50%;">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/smart_therapy.svg" alt="Smart therapy" style="width: 20px; height: 20px;">
                </div>
                <span style="font-size: 18px; color: #000000; font-weight: 500;">Smart therapy</span>
            </div>
            <div class="flex items-center gap-2" style="background-color: #FFFFFF; border-radius: 9999px; padding: 4px;">
                <div class="flex items-center justify-center" style="width: 32px; height: 32px; background-color: #F0F2F5; border-radius: 50%;">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/rehabilitation.svg" alt="Rehabilitation" style="width: 20px; height: 20px;">
                </div>
                <span style="font-size: 18px; color: #000000; font-weight: 500;">Rehabilitation</span>
            </div>
            <div class="flex items-center gap-2" style="background-color: #FFFFFF; border-radius: 9999px; padding: 4px;">
                <div class="flex items-center justify-center" style="width: 32px; height: 32px; background-color: #F0F2F5; border-radius: 50%;">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/home.svg" alt="Home care" style="width: 20px; height: 20px;">
                </div>
                <span style="font-size: 18px; color: #000000; font-weight: 500;">Home care</span>
            </div>
            <div class="flex items-center gap-2" style="background-color: #FFFFFF; border-radius: 9999px; padding: 4px;">
                <div class="flex items-center justify-center" style="width: 32px; height: 32px; background-color: #F0F2F5; border-radius: 50%;">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/sports_medicine.svg" alt="Sports medicine" style="width: 20px; height: 20px;">
                </div>
                <span style="font-size: 18px; color: #000000; font-weight: 500;">Sports medicine</span>
            </div>
        </div>

        <!-- Form Section -->
        <div class="w-full bg-white p-8 md:p-12">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Become a distributor</h2>
                <p class="text-gray-600">
                    Complete the form below, and our team will contact you with more information on distribution opportunities, pricing, and support.
                </p>
            </div>

            <form id="distributor-form" class="forcex-contact-form" data-form-source="distributors">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="distributor_first_name" class="block text-sm font-medium text-gray-700 mb-2 pl-4">
                            First name *
                        </label>
                        <input type="text" id="distributor_first_name" name="first_name" required
                               class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
                               style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
                               placeholder="Your name">
                    </div>
                    <div>
                        <label for="distributor_last_name" class="block text-sm font-medium text-gray-700 mb-2 pl-4">
                            Last name *
                        </label>
                        <input type="text" id="distributor_last_name" name="last_name" required
                               class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
                               style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
                               placeholder="Your name">
                    </div>
                    <div>
                        <label for="distributor_email" class="block text-sm font-medium text-gray-700 mb-2 pl-4">
                            Email *
                        </label>
                        <input type="email" id="distributor_email" name="email" required
                               class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
                               style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
                               placeholder="Email">
                    </div>
                    <div>
                        <label for="distributor_phone" class="block text-sm font-medium text-gray-700 mb-2 pl-4">
                            Phone number *
                        </label>
                        <input type="tel" id="distributor_phone" name="phone" required
                               class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
                               style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
                               placeholder="Phone number">
                    </div>
                </div>

                <div id="distributor-form-message" class="mb-6 hidden"></div>

                <button type="submit" class="btn-gradient">
                    SUBMIT
                </button>
            </form>
        </div>
    </div>
</main>

<?php get_footer(); ?>

