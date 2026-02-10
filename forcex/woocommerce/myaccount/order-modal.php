<?php
/**
 * Order Modal Template
 */

defined('ABSPATH') || exit; ?>

<!-- Order Modal Content -->
<div id="order-modal-content-template" class="hidden">
    <div class="space-y-6">
        <!-- Order Header -->
        <div class="border-b border-gray-200 pb-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">Order #<span id="order-number"></span></h3>
                    <p class="text-sm text-gray-600">Placed on <span id="order-date"></span></p>
                </div>
                <span id="order-status" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"></span>
            </div>
        </div>
        
        <!-- Order Items -->
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-4">Order Items</h4>
            <div id="order-items" class="space-y-4">
                <!-- Items will be populated here -->
            </div>
        </div>
        
        <!-- Order Summary -->
        <div class="border-t border-gray-200 pt-4">
            <div class="space-y-2">
                <div class="flex justify-between text-gray-700">
                    <span>Subtotal:</span>
                    <span id="order-subtotal"></span>
                </div>
                <div class="flex justify-between text-gray-700">
                    <span>Shipping:</span>
                    <span id="order-shipping"></span>
                </div>
                <div class="flex justify-between text-gray-700">
                    <span>Tax:</span>
                    <span id="order-tax"></span>
                </div>
                <div class="flex justify-between text-lg font-semibold text-gray-900 border-t border-gray-200 pt-2">
                    <span>Total:</span>
                    <span id="order-total"></span>
                </div>
            </div>
        </div>
        
        <!-- Delivery Information -->
        <div class="border-t border-gray-200 pt-4">
            <h4 class="text-lg font-semibold text-gray-900 mb-4">Delivery Information</h4>
            <div id="delivery-info" class="text-sm text-gray-600">
                <!-- Delivery info will be populated here -->
            </div>
        </div>
    </div>
</div>
