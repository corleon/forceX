# Checkout Page - Admin Setup Guide

The checkout page has been updated to be fully functional with WooCommerce. Here's what you need to configure in the WordPress/WooCommerce admin:

## Required Admin Settings

### 1. Shipping Methods
**Location:** WooCommerce → Settings → Shipping

You need to set up at least one shipping method for the checkout to work properly:

1. Go to **WooCommerce → Settings → Shipping**
2. Click on a **Shipping Zone** (or create a new one)
3. Add shipping methods such as:
   - **Flat Rate** - Fixed shipping cost
   - **Free Shipping** - Free shipping option
   - **Local Pickup** - For local customers
   - **UPS** or other shipping plugins if installed

4. Configure each method:
   - **Method Title**: This will appear on the checkout page (e.g., "UPS Ground Delivery")
   - **Cost**: Set the shipping cost
   - **Tax Status**: Whether shipping is taxable

**Note:** The checkout page will automatically display all available shipping methods based on the customer's location.

### 2. Payment Gateways
**Location:** WooCommerce → Settings → Payments

Enable and configure payment methods:

1. Go to **WooCommerce → Settings → Payments**
2. Enable the payment methods you want to offer:
   - **PayPal** - PayPal payments
   - **Stripe** - Credit card payments (if plugin installed)
   - **Bank Transfer (BACS)** - Direct bank transfer
   - **Cash on Delivery** - Payment on delivery
   - Other payment gateways as needed

3. Configure each gateway:
   - Click "Manage" next to each payment method
   - Enter required credentials (API keys, account details, etc.)
   - Set the **Title** that will appear on checkout
   - Configure any additional settings

**Note:** Only enabled payment gateways will appear on the checkout page.

### 3. Countries & States
**Location:** WooCommerce → Settings → General

1. Go to **WooCommerce → Settings → General**
2. Set your **Store Address** (Country, State, City, etc.)
3. Configure **Selling Locations**:
   - **Sell to specific countries**: Select countries you ship to
   - **Ship to specific countries**: Select shipping destinations

**Note:** The state field on checkout will automatically show as a dropdown for countries that have states defined (like USA, Canada, etc.).

### 4. Tax Settings (Optional)
**Location:** WooCommerce → Settings → Tax

If you want to charge taxes:

1. Go to **WooCommerce → Settings → Tax**
2. Enable **Enable taxes and tax calculations**
3. Configure tax rates for your locations
4. Set **Display prices during cart and checkout** to "Including tax" or "Excluding tax"

### 5. Coupons (Optional)
**Location:** WooCommerce → Marketing → Coupons

To allow customers to use promo codes:

1. Go to **WooCommerce → Marketing → Coupons**
2. Click **Add Coupon**
3. Configure:
   - **Coupon Code**: The code customers will enter
   - **Discount Type**: Percentage or fixed amount
   - **Coupon Amount**: The discount value
   - **Usage Limits**: How many times it can be used
   - **Expiry Date**: When the coupon expires

**Note:** Customers can enter coupon codes in the "Promo code" field on the checkout page.

### 6. Terms and Conditions / Privacy Policy
**Location:** Pages → Add New (or edit existing)

1. Create or edit your **Terms and Conditions** page:
   - Go to **Pages → Add New**
   - Create a page with your terms and conditions
   - Publish it

2. Create or edit your **Privacy Policy** page:
   - Go to **Pages → Add New**
   - Create a page with your privacy policy
   - Publish it

3. Link them in WooCommerce:
   - Go to **WooCommerce → Settings → Advanced**
   - Set **Terms and conditions page** to your terms page
   - Set **Privacy policy page** to your privacy page

**Note:** These checkboxes will appear on the checkout page and are required before order submission.

### 7. Order Status and Emails
**Location:** WooCommerce → Settings → Emails

Configure order confirmation emails:

1. Go to **WooCommerce → Settings → Emails**
2. Configure **New Order** email (sent to admin)
3. Configure **Customer Processing Order** email (sent to customer)
4. Customize email templates as needed

## How It Works Now

### Checkout Flow:
1. **Step 1 - Personal Information**: Customer enters name, email, phone, company
2. **Step 2 - Delivery**: Customer enters address and selects shipping method
3. **Step 3 - Payment**: Customer selects payment method and agrees to terms
4. **Step 4 - Complete**: Order confirmation (shown after order is placed)

### Dynamic Features:
- ✅ **Shipping Methods**: Automatically loaded from WooCommerce settings
- ✅ **Payment Methods**: Automatically loaded from enabled payment gateways
- ✅ **State Field**: Automatically switches between text input and dropdown based on country
- ✅ **Order Totals**: Automatically calculated (subtotal, shipping, tax, discounts, total)
- ✅ **Coupons**: Fully integrated with WooCommerce coupon system
- ✅ **Order Number**: Shows real order number after order is placed

### What's No Longer Hardcoded:
- ❌ Shipping methods (now uses WooCommerce shipping)
- ❌ Payment methods (now uses WooCommerce payment gateways)
- ❌ Order numbers (now shows real order ID)
- ❌ Discount amounts (now calculated from applied coupons)
- ❌ Shipping costs (now calculated from selected shipping method)
- ❌ State fields (now dynamic based on country)

## Testing Checklist

After configuring the above settings, test:

1. ✅ Add products to cart
2. ✅ Go to checkout
3. ✅ Fill in personal information (Step 1)
4. ✅ Fill in delivery address and select shipping method (Step 2)
5. ✅ Select payment method (Step 3)
6. ✅ Apply a coupon code (if configured)
7. ✅ Complete the order
8. ✅ Verify order is created in WooCommerce → Orders
9. ✅ Check that customer receives order confirmation email

## Troubleshooting

### Shipping methods not showing:
- Check that shipping zones are configured
- Verify shipping methods are enabled in the shipping zone
- Ensure customer's address matches a shipping zone

### Payment methods not showing:
- Verify payment gateways are enabled in WooCommerce → Settings → Payments
- Check that payment gateways are configured with required credentials
- Some payment gateways may require additional plugins

### State field not updating:
- Clear browser cache
- Ensure jQuery is loaded (WooCommerce requires it)
- Check browser console for JavaScript errors

### Coupons not working:
- Verify coupon is published and not expired
- Check coupon usage limits
- Ensure coupon is valid for the products in cart

## Support

If you encounter any issues, check:
1. WooCommerce → Status → Logs for error messages
2. Browser console (F12) for JavaScript errors
3. WordPress debug log (if WP_DEBUG is enabled)

