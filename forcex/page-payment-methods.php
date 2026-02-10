<?php
/**
 * Template Name: Payment Methods
 * Description: Payment methods information page
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<style>
    .payment-methods-page {
        background-color: white;
    }
    .payment-methods-page input::placeholder {
        color: #748394;
    }
</style>

<main id="main" class="site-main payment-methods-page">
    <div class="container-custom py-8" style="background-color: white;">
        <!-- Breadcrumbs -->
        <nav class="mb-6">
            <div class="flex justify-center">
                <ol class="flex items-center text-base text-gray-500 bg-white px-4 py-2 rounded-full">
                    <li><a href="<?php echo home_url(); ?>" class="hover:text-primary-500">Main</a></li>
                    <li class="flex items-center">
                        <span class="mx-2 text-gray-400">/</span>
                        <span class="text-gray-900 font-medium">Payment Methods</span>
                    </li>
                </ol>
            </div>
        </nav>

        <!-- Page Title -->
        <div class="mb-8 text-center">
            <h1 class="title-h1">Payment Methods</h1>
        </div>

        <!-- Content Section -->
        <div class="max-w-4xl mx-auto">
            <div class="bg-white p-8 md:p-12" style="border: 1px solid #D9E2E7;">
                <!-- Payment Methods List -->
                <div class="space-y-6 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Accepted Payment Methods</h2>
                    
                    <!-- Credit/Debit Cards -->
                    <div class="p-4 rounded-lg" style="background-color: #EEF2F6;">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="text-gray-900 ml-3 font-medium">Credit/Debit Cards</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/visa.svg" alt="Visa" class="h-6">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/master.svg" alt="Mastercard" class="h-6">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/amrxpres.svg" alt="American Express" class="h-6">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/jcb.svg" alt="JCB" class="h-6">
                            </div>
                        </div>
                    </div>

                    <!-- PayPal -->
                    <div class="p-4 rounded-lg" style="background-color: #EEF2F6;">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="text-gray-900 ml-3 font-medium">PayPal</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pypal.svg" alt="PayPal" class="h-6">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="mt-8 pt-8 border-t" style="border-color: #D9E2E7;">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Payment Information</h3>
                    <div class="space-y-4 text-gray-700">
                        <p>
                            We accept all major credit and debit cards, as well as PayPal for your convenience. 
                            All payments are processed securely through our payment gateway.
                        </p>
                        <p>
                            Your payment information is encrypted and secure. We do not store your full credit card details on our servers.
                        </p>
                    </div>
                </div>

                <!-- Security Notice -->
                <div class="mt-8 pt-8 border-t" style="border-color: #D9E2E7;">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Secure Payments</h3>
                    <p class="text-gray-700">
                        All transactions are protected by industry-standard SSL encryption to ensure your payment information remains safe and secure.
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
