<?php
/**
 * Template Name: Contact
 * Description: Contact page with contact information and form
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<style>
    .forcex-contact-form input::placeholder,
    .forcex-contact-form textarea::placeholder {
        color: #748394;
    }
    
    .contact-map-container {
        width: 100%;
        height: 400px;
        border-radius: 16px;
        overflow: hidden;
        position: relative;
    }
    
    #contact-map {
        width: 100%;
        height: 100%;
    }
</style>

<main id="main" class="site-main relative" style="background-color: #EEF2F6; background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/gradientform.png'); background-position: center bottom; background-repeat: no-repeat; background-size: cover; position: relative;">
    <div class="container-custom py-12 pb-24 md:pb-32 relative z-10" style="margin: 0 auto;">
        <!-- Breadcrumbs -->
        <nav class="mb-6">
            <div class="flex justify-center">
                <ol class="flex items-center  text-base text-gray-500 bg-white px-4 py-2 rounded-full">
                    <li><a href="<?php echo home_url(); ?>" class="hover:text-primary-500">Main</a></li>
                    <li class="flex items-center">
                        <span class="mx-2 text-gray-400">/</span>
                        <span class="text-gray-900 font-medium">Contacts</span>
                    </li>
                </ol>
            </div>
        </nav>

        <!-- Main Heading -->
        <div class="text-center mb-12">
            <h1 class="title-h2 mb-4">
                Contacts
            </h1>
        </div>

        <!-- Two Column Layout: Contact Info + Form -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">
            <!-- Left Column: Contact Information and Map -->
            <div class="flex">
                <!-- Contact Information Card with Map -->
                <div class="bg-white p-8 md:p-10 rounded-md w-full flex flex-col">
                    <div class="space-y-6 mb-8">
                        <!-- Phone and Email on One Line -->
                        <div class="flex flex-wrap items-center gap-6 ">
                            <!-- Phone -->
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/cil_phone.svg" alt="Phone" class="w-6 h-6" style="opacity: 0.7;">
                                </div>
                                <p class="text-gray-700 text-base md:text-2xl font-semibold">440-500-3060</p>
                            </div>

                            <!-- Email -->
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/clarity_email-line.svg" alt="Email" class="w-6 h-6" style="opacity: 0.7;">
                                </div>
                                <p class="text-gray-700 text-base md:text-2xl font-semibold">info@forcextherapy.com</p>
                            </div>
                        </div>

                        <!-- Address on Second Line -->
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 mt-1">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/location.svg" alt="Location" class="w-6 h-6" style="opacity: 0.7;">
                            </div>
                            <p class="text-gray-700 text-base md:text-lg">6521 Davis industrial Pkwy., Unit B Cleveland, OH 44139</p>
                        </div>
                    </div>

                    <!-- Map -->
                    <?php
                    // Get coordinates from admin
                    $coordinates = forcex_get_contact_coordinates();
                    $marker_icon_url = get_template_directory_uri() . '/assets/img/location.svg';
                    $api_key = !empty($coordinates['api_key']) ? $coordinates['api_key'] : '';
                    ?>
                    <div id="contact-map" class="contact-map-container"></div>
                    
                    <script>
                    function initContactMap() {
                        const coordinates = {
                            lat: <?php echo floatval($coordinates['latitude']); ?>,
                            lng: <?php echo floatval($coordinates['longitude']); ?>
                        };
                        const zoom = <?php echo intval($coordinates['zoom']); ?>;
                        const markerIconUrl = '<?php echo esc_js($marker_icon_url); ?>';
                        
                        // Initialize map
                        const map = new google.maps.Map(document.getElementById('contact-map'), {
                            center: coordinates,
                            zoom: zoom,
                            disableDefaultUI: false,
                            zoomControl: true,
                            mapTypeControl: false,
                            streetViewControl: false,
                            fullscreenControl: true
                        });
                        
                        // Create custom marker icon
                        const markerIcon = {
                            url: markerIconUrl,
                            scaledSize: new google.maps.Size(48, 48),
                            anchor: new google.maps.Point(24, 24)
                        };
                        
                        // Add custom marker at coordinates
                        const marker = new google.maps.Marker({
                            position: coordinates,
                            map: map,
                            icon: markerIcon,
                            title: 'ForceX Location'
                        });
                    }
                    
                    // Load Google Maps API
                    if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
                        const script = document.createElement('script');
                        const apiKey = '<?php echo esc_js($api_key); ?>';
                        const apiKeyParam = apiKey ? 'key=' + apiKey + '&' : '';
                        script.src = 'https://maps.googleapis.com/maps/api/js?' + apiKeyParam + 'callback=initContactMap';
                        script.async = true;
                        script.defer = true;
                        document.head.appendChild(script);
                    } else {
                        initContactMap();
                    }
                    </script>
                </div>
            </div>

            <!-- Right Column: Contact Form -->
            <div class="bg-white p-8 md:p-10 rounded-md flex flex-col">
                <div class="mb-8 text-left">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">Contact us</h2>
                    <p class="text-gray-600 text-base">
                        Complete the form below. Our representative will contact you to answer all your questions.
                    </p>
                </div>

                <form id="contact-form" class="forcex-contact-form flex flex-col flex-grow" data-form-source="contact">
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
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Contact form submission is handled by the main.js forcex-contact-form handler
    // The form will automatically submit via AJAX when the form source is "contact"
});
</script>

<?php get_footer(); ?>

