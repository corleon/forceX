<?php
/**
 * My Account Orders Template
 */

defined('ABSPATH') || exit; ?>

<div style="background-color: white; border: 1px solid #D9E2E7; border-radius: 8px; padding: 24px;">
    <h2 class="text-2xl font-semibold text-gray-900 mb-6">Orders</h2>

    <?php
    // Get all orders for the current customer (excluding trash)
    $customer_orders = wc_get_orders(array(
        'customer' => get_current_user_id(),
        'status' => array('wc-processing', 'wc-completed', 'wc-on-hold', 'wc-pending', 'wc-cancelled', 'wc-refunded', 'wc-failed'),
        'limit' => -1, // Show all orders
        'orderby' => 'date',
        'order' => 'DESC',
    ));

    if ($customer_orders):
    ?>
        <div>
            <?php 
            $order_count = count($customer_orders);
            $index = 0;
            foreach ($customer_orders as $order): 
                $index++;
                $is_last = $index === $order_count;
                $status = $order->get_status();
                
                // Format date as shown in design: "3 / 4 / 2026"
                $order_date = $order->get_date_created();
                $day = $order_date->date('j');
                $month = $order_date->date('n');
                $year = $order_date->date('Y');
                $formatted_date = $day . ' / ' . $month . ' / ' . $year;
                
                // Get status label
                $status_label = wc_get_order_status_name($status);
                // Capitalize first letter of each word
                $status_label = ucwords(str_replace('-', ' ', $status_label));
            ?>
                <div class="flex items-center justify-between py-4 <?php echo !$is_last ? 'border-b' : ''; ?>" style="<?php echo !$is_last ? 'border-color: #D9E2E7;' : ''; ?>">
                    <!-- Order Number -->
                    <div class="font-semibold text-gray-900" style="min-width: 120px;">
                        Order #<?php echo $order->get_order_number(); ?>
                    </div>
                    
                    <!-- Date -->
                    <div class="text-gray-600" style="min-width: 120px;">
                        <?php echo esc_html($formatted_date); ?>
                    </div>
                    
                    <!-- Status Badge -->
                    <div style="min-width: 140px;">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium text-white" 
                              style="background-color: #25AAE1;">
                            <?php echo esc_html($status_label); ?>
                        </span>
                    </div>
                    
                    <!-- Price -->
                    <div class="font-semibold text-gray-900 text-right" style="min-width: 140px;">
                        <?php echo $order->get_formatted_order_total(); ?>
                    </div>
                    
                    <!-- VIEW THE RECEIPT Button -->
                    <div style="min-width: 180px;">
                        <button class="view-order-btn inline-flex items-center justify-center px-4 py-2 font-semibold text-gray-700 transition-colors hover:bg-gray-50" 
                                style="background-color: white; border: 1px solid #D9E2E7; border-radius: 32px 4px 32px 4px;"
                                data-order-id="<?php echo $order->get_id(); ?>">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/recepi.svg'); ?>" alt="Receipt" class="mr-2" style="width: 20px; height: 20px;">
                            VIEW THE RECEIPT
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No orders yet</h3>
            <p class="text-gray-600 mb-6">You haven't placed any orders yet. Start shopping to see your orders here.</p>
            <a href="<?php echo esc_url(home_url('/products')); ?>" class="btn-primary">
                Start Shopping
            </a>
        </div>
    <?php endif; ?>
</div>
