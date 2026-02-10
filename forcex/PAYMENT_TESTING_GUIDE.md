# Payment Testing Guide for Staging

This guide will help you test all payment methods on your staging environment before going live.

## Prerequisites

Before testing payments, ensure:

1. ✅ **Payment gateways are enabled** in WooCommerce → Settings → Payments
2. ✅ **Test/Sandbox mode is enabled** for payment gateways (if available)
3. ✅ **Test API keys are configured** (not production keys!)
4. ✅ **Shipping methods are configured** (required for checkout)
5. ✅ **At least one product exists** and is purchasable

---

## 1. Testing Bank Transfer (BACS)

**Status:** ✅ Already configured for auto-completion

### How to Test:
1. Add products to cart
2. Go to checkout
3. Fill in all required information
4. Select **"Direct Bank Transfer"** as payment method
5. Complete the order

### What to Verify:
- ✅ Order is created in WooCommerce → Orders
- ✅ Order status is automatically set to "Processing"
- ✅ Order is marked as paid
- ✅ Customer receives order confirmation email
- ✅ Order appears on the order received page

**Note:** BACS orders are automatically marked as paid for testing purposes (see `functions.php` lines 396-415).

---

## 2. Testing Stripe (Credit Card Payments)

### Setup (if Stripe plugin is installed):

1. **Enable Test Mode:**
   - Go to **WooCommerce → Settings → Payments → Stripe**
   - Enable **Test Mode**
   - Enter your **Test Publishable Key** and **Test Secret Key**
   - Save changes

2. **Get Test API Keys:**
   - Log into your Stripe Dashboard: https://dashboard.stripe.com
   - Go to **Developers → API keys**
   - Make sure you're viewing **Test mode** keys (toggle in top right)
   - Copy the **Publishable key** and **Secret key**

### Test Card Numbers:

Use these test card numbers (any future expiry date, any 3-digit CVC):

| Card Type | Card Number | Expected Result |
|-----------|-------------|-----------------|
| **Success** | `4242 4242 4242 4242` | Payment succeeds |
| **Decline** | `4000 0000 0000 0002` | Card declined |
| **Requires Authentication** | `4000 0025 0000 3155` | Requires 3D Secure |
| **Visa (Debit)** | `4000 0566 5566 5556` | Payment succeeds |
| **Mastercard** | `5555 5555 5555 4444` | Payment succeeds |
| **American Express** | `3782 822463 10005` | Payment succeeds |

**Test CVC:** Any 3 digits (e.g., `123`)  
**Test Expiry:** Any future date (e.g., `12/25`)  
**Test ZIP:** Any 5 digits (e.g., `12345`)

### How to Test:
1. Add products to cart
2. Go to checkout
3. Fill in all required information
4. Select **"Stripe"** as payment method
5. Enter test card number: `4242 4242 4242 4242`
6. Enter any future expiry date and CVC
7. Complete the order

### What to Verify:
- ✅ Payment form loads correctly
- ✅ Card validation works (try invalid card numbers)
- ✅ Successful payment redirects to order confirmation
- ✅ Order is created with status "Processing" or "Completed"
- ✅ Order shows payment method as "Stripe"
- ✅ Payment appears in Stripe Dashboard → Payments (test mode)
- ✅ Customer receives order confirmation email

### Testing 3D Secure (if enabled):
- Use card: `4000 0025 0000 3155`
- You'll be redirected to Stripe's test authentication page
- Click "Complete authentication" to simulate successful 3DS

---

## 3. Testing PayPal

### Setup (if PayPal plugin is installed):

1. **Enable Sandbox Mode:**
   - Go to **WooCommerce → Settings → Payments → PayPal**
   - Enable **Sandbox Mode** or **Test Mode**
   - Enter your **Sandbox API credentials**
   - Save changes

2. **Get Sandbox Credentials:**
   - Go to PayPal Developer: https://developer.paypal.com
   - Log in and go to **Dashboard → My Apps & Credentials**
   - Create a Sandbox app or use existing one
   - Copy **Client ID** and **Secret**

### Test PayPal Accounts:

Create test accounts in PayPal Sandbox:
- Go to PayPal Developer Dashboard
- Navigate to **Accounts → Sandbox accounts**
- Create personal and business test accounts
- Use these accounts to test payments

### How to Test:
1. Add products to cart
2. Go to checkout
3. Fill in all required information
4. Select **"PayPal"** as payment method
5. Click "Pay Now" - you'll be redirected to PayPal
6. Log in with a **Sandbox test account** (not your real PayPal!)
7. Complete payment on PayPal
8. You'll be redirected back to your site

### What to Verify:
- ✅ Redirect to PayPal works
- ✅ Can log in with sandbox account
- ✅ Payment completes successfully
- ✅ Redirect back to order confirmation works
- ✅ Order is created with status "Processing"
- ✅ Order shows payment method as "PayPal"
- ✅ Payment appears in PayPal Sandbox Dashboard
- ✅ Customer receives order confirmation email

---

## 4. Testing Cash on Delivery (COD)

### Setup:
1. Go to **WooCommerce → Settings → Payments**
2. Enable **Cash on Delivery**
3. Configure settings (title, description, etc.)

### How to Test:
1. Add products to cart
2. Go to checkout
3. Fill in all required information
4. Select **"Cash on Delivery"** as payment method
5. Complete the order

### What to Verify:
- ✅ Order is created
- ✅ Order status is "Processing" or "On Hold"
- ✅ Order shows payment method as "Cash on Delivery"
- ✅ Customer receives order confirmation email
- ✅ Order notes indicate COD payment method

---

## 5. Testing Check Payments

### Setup:
1. Go to **WooCommerce → Settings → Payments**
2. Enable **Check Payments**
3. Configure settings

### How to Test:
1. Add products to cart
2. Go to checkout
3. Fill in all required information
4. Select **"Check Payments"** as payment method
5. Complete the order

### What to Verify:
- ✅ Order is created
- ✅ Order status is "On Hold" (pending payment)
- ✅ Order shows payment method as "Check Payments"
- ✅ Customer receives order confirmation email

---

## Complete Testing Checklist

### Before Testing:
- [ ] All payment gateways are enabled in WooCommerce admin
- [ ] Test/Sandbox mode is enabled for payment gateways
- [ ] Test API keys are configured (not production keys!)
- [ ] Shipping methods are configured
- [ ] At least one product is available for purchase

### Test Each Payment Method:
- [ ] **Bank Transfer (BACS)** - Order auto-completes
- [ ] **Stripe** - Test with card `4242 4242 4242 4242`
- [ ] **PayPal** - Test with sandbox account
- [ ] **Cash on Delivery** - Order created successfully
- [ ] **Check Payments** - Order created successfully

### For Each Successful Order, Verify:
- [ ] Order appears in WooCommerce → Orders
- [ ] Order has correct status
- [ ] Order shows correct payment method
- [ ] Order total is correct
- [ ] Customer receives order confirmation email
- [ ] Order confirmation page displays correctly
- [ ] Order number is displayed correctly

### Test Error Scenarios:
- [ ] **Declined card** - Use Stripe test card `4000 0000 0000 0002`
- [ ] **Invalid card number** - Enter invalid card format
- [ ] **Expired card** - Enter past expiry date
- [ ] **Missing required fields** - Try submitting without filling all fields
- [ ] **Invalid email** - Enter invalid email format

### Test Edge Cases:
- [ ] **Zero amount order** (if coupons allow this)
- [ ] **Very large order** (test with high-value products)
- [ ] **Multiple products** in cart
- [ ] **Product with variations** (if applicable)
- [ ] **Apply coupon code** during checkout
- [ ] **Change shipping method** and verify totals update
- [ ] **Change payment method** after selecting one

---

## Common Issues & Solutions

### Issue: Payment methods not showing on checkout
**Solution:**
- Check WooCommerce → Settings → Payments
- Ensure payment gateways are enabled
- Verify payment gateways are configured with required credentials
- Check if payment gateways have location restrictions

### Issue: Stripe test mode not working
**Solution:**
- Verify you're using **Test** API keys (not Live keys)
- Check Stripe Dashboard → Developers → Logs for errors
- Ensure test mode is enabled in Stripe settings
- Clear browser cache and cookies

### Issue: PayPal redirect not working
**Solution:**
- Verify sandbox credentials are correct
- Check PayPal sandbox mode is enabled
- Ensure return URL is configured correctly
- Check browser console for JavaScript errors

### Issue: Orders not being created
**Solution:**
- Check WooCommerce → Status → Logs for errors
- Verify database connection is working
- Check WordPress debug log (if WP_DEBUG is enabled)
- Ensure WooCommerce is properly installed and activated

### Issue: Emails not sending
**Solution:**
- Check WooCommerce → Settings → Emails
- Verify email templates are configured
- Test WordPress email functionality
- Check spam folder
- Consider using an SMTP plugin for staging

---

## Verifying Payments in Admin

### Check Order Details:
1. Go to **WooCommerce → Orders**
2. Click on an order number
3. Verify:
   - **Order Status** - Should be "Processing" or "Completed" for paid orders
   - **Payment Method** - Should show the selected payment gateway
   - **Order Total** - Should match cart total
   - **Billing Address** - Should match checkout form
   - **Shipping Address** - Should match checkout form
   - **Order Notes** - Check for payment-related notes

### Check Payment Gateway Dashboard:
- **Stripe:** Go to Stripe Dashboard → Payments (test mode)
- **PayPal:** Go to PayPal Sandbox Dashboard → Transactions
- Verify payments appear with correct amounts

---

## Security Checklist for Staging

⚠️ **IMPORTANT:** Before going to production:

- [ ] **Remove test API keys** - Replace with production keys
- [ ] **Disable test/sandbox mode** - Switch to live mode
- [ ] **Remove auto-complete for BACS** - Update `functions.php` if needed
- [ ] **Test with real payment methods** - Do a small real transaction
- [ ] **Verify SSL certificate** - Ensure HTTPS is working
- [ ] **Check PCI compliance** - Ensure you're following PCI-DSS requirements
- [ ] **Review payment gateway settings** - Double-check all configurations
- [ ] **Test refund process** - Ensure refunds work correctly
- [ ] **Test failed payment handling** - Ensure errors are handled gracefully

---

## Quick Test Script

Run through this quick test for each payment method:

1. **Add to Cart:** Add a test product
2. **Go to Checkout:** Navigate to checkout page
3. **Fill Form:** Complete all checkout steps
4. **Select Payment:** Choose payment method
5. **Complete Order:** Submit the order
6. **Verify Order:** Check WooCommerce → Orders
7. **Check Email:** Verify confirmation email received
8. **Test Again:** Try with different payment method

---

## Need Help?

If you encounter issues:

1. **Check Logs:**
   - WooCommerce → Status → Logs
   - WordPress debug log (if enabled)
   - Browser console (F12)

2. **Verify Configuration:**
   - Payment gateway settings
   - API keys (test vs. production)
   - Test mode enabled

3. **Test in Incognito Mode:**
   - Clear cache and cookies
   - Test in private/incognito browser window

4. **Contact Support:**
   - Payment gateway support (Stripe, PayPal, etc.)
   - WooCommerce documentation
   - WordPress support forums

---

## Notes

- **BACS orders auto-complete** for testing (see `functions.php`)
- **Always use test/sandbox mode** on staging
- **Never use production API keys** on staging
- **Test all payment methods** before going live
- **Keep test transactions separate** from production data






