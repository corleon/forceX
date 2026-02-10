<?php
/**
 * Template Name: Orders and Delivery
 * Description: Orders and delivery information page
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<style>
    .orders-delivery-page {
        background-color: white;
    }
    .orders-delivery-page input::placeholder {
        color: #748394;
    }
</style>

<main id="main" class="site-main orders-delivery-page">
    <div class="container-custom py-8" style="background-color: white;">
        <!-- Breadcrumbs -->
        <nav class="mb-6">
            <div class="flex justify-center">
                <ol class="flex items-center text-base text-gray-500 bg-white px-4 py-2 rounded-full">
                    <li><a href="<?php echo home_url(); ?>" class="hover:text-primary-500">Main</a></li>
                    <li class="flex items-center">
                        <span class="mx-2 text-gray-400">/</span>
                        <span class="text-gray-900 font-medium">Orders and Delivery</span>
                    </li>
                </ol>
            </div>
        </nav>

        <!-- Page Title -->
        <div class="mb-8 text-center">
            <h1 class="title-h1">Orders and Delivery</h1>
        </div>

        <!-- Content Section -->
        <div class="max-w-4xl mx-auto">
            <div class="bg-white p-8 md:p-12" style="border: 1px solid #D9E2E7;">
                <!-- Order Processing -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Order Processing</h2>
                    <div class="space-y-4 text-gray-700">
                        <p>
                            Once you place an order, you will receive an order confirmation email with your order details. 
                            We typically process orders within 1-2 business days.
                        </p>
                        <p>
                            You can track your order status by logging into your account and visiting the "My Orders" section.
                        </p>
                    </div>
                </div>

                <!-- Shipping Methods -->
                <div class="mt-8 pt-8 border-t" style="border-color: #D9E2E7;">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Shipping Methods</h3>
                    <div class="space-y-3">
                        <div class="p-4 rounded-lg" style="background-color: #EEF2F6;">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-900 font-medium">Standard Shipping</span>
                                <span class="text-gray-600">5-7 business days</span>
                            </div>
                        </div>
                        <div class="p-4 rounded-lg" style="background-color: #EEF2F6;">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-900 font-medium">Express Shipping</span>
                                <span class="text-gray-600">2-3 business days</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delivery Information -->
                <div class="mt-8 pt-8 border-t" style="border-color: #D9E2E7;">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Delivery Information</h3>
                    <div class="space-y-4 text-gray-700">
                        <p>
                            We ship to addresses within the United States. Shipping costs are calculated at checkout based on your location and selected shipping method.
                        </p>
                        <p>
                            Once your order ships, you will receive a tracking number via email so you can monitor your package's progress.
                        </p>
                    </div>
                </div>

                <!-- Returns -->
                <div class="mt-8 pt-8 border-t" style="border-color: #D9E2E7;">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Returns</h3>
                    <p class="text-gray-700">
                        If you need to return an item, please contact our customer service team. We'll be happy to assist you with the return process.
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
