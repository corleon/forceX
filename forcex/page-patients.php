<?php
/**
 * Template Name: Patients
 * Description: Rent or purchase ForceX™ for patients page with form
 */

if (!defined('ABSPATH')) {
    exit;
}

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
                        <span class="text-gray-900 font-medium">Patients</span>
                    </li>
                </ol>
            </div>
        </nav>

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

            <form id="patients-form" class="forcex-contact-form" data-form-source="patients">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="patients_first_name" class="block text-sm font-medium text-gray-700 mb-2 pl-4">
                            First name *
                        </label>
                        <input type="text" id="patients_first_name" name="first_name" required
                               class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
                               style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
                               placeholder="Your name">
                    </div>
                    <div>
                        <label for="patients_last_name" class="block text-sm font-medium text-gray-700 mb-2 pl-4">
                            Last name *
                        </label>
                        <input type="text" id="patients_last_name" name="last_name" required
                               class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
                               style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
                               placeholder="Your name">
                    </div>
                    <div>
                        <label for="patients_email" class="block text-sm font-medium text-gray-700 mb-2 pl-4">
                            Email *
                        </label>
                        <input type="email" id="patients_email" name="email" required
                               class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
                               style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
                               placeholder="Email">
                    </div>
                    <div>
                        <label for="patients_email_secondary" class="block text-sm font-medium text-gray-700 mb-2 pl-4">
                            Email
                        </label>
                        <input type="email" id="patients_email_secondary" name="email_secondary"
                               class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
                               style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
                               placeholder="Email">
                    </div>
                    <div class="md:col-span-2">
                        <label for="patients_physician_location" class="block text-sm font-medium text-gray-700 mb-2 pl-4">
                            Choose your physician location *
                        </label>
                        <select id="patients_physician_location" name="physician_location" required
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

                <div id="patients-form-message" class="mb-6 hidden"></div>

                <button type="submit" class="btn-gradient">
                    SUBMIT
                </button>
            </form>
        </div>
    </div>
</main>

<?php get_footer(); ?>

