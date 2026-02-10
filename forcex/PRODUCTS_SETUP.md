# How to Add Accessories to the Products Page

## Method 1: Using WooCommerce Admin (Recommended)

### Step 1: Create Product Categories

1. Go to **WooCommerce → Products → Categories** in your WordPress admin
2. Click **"Add New Category"**
3. Create the following categories:

   **Category 1: Devices**
   - Name: `Devices`
   - Slug: `devices` (auto-generated, but make sure it's exactly "devices")
   - Description: ForceX therapy machines and devices
   - Click **"Add New Category"**

   **Category 2: Accessoires**
   - Name: `Accessoires`
   - Slug: `accessoires` (auto-generated, but make sure it's exactly "accessoires")
   - Description: ForceX accessories and wraps
   - Click **"Add New Category"**

### Step 2: Assign Products to Categories

1. Go to **WooCommerce → Products** in your WordPress admin
2. Edit the product you want to categorize (e.g., a wrap or accessory)
3. In the **Product Categories** box on the right side, check the box for:
   - **"Accessoires"** (for wraps, ankle wraps, knee wraps, shoulder wraps, etc.)
   - **"Devices"** (for therapy machines like CX3, CX5, CX9, etc.)
4. Click **"Update"** to save

### Step 3: Verify on Products Page

1. Visit `/products` on your website
2. Click the **"Accessoires"** filter button
3. You should see all products assigned to the "Accessoires" category

## Method 2: Automatic Category Creation

The theme will automatically create these categories when you first load the products page. However, you still need to assign products to them manually.

## Category Slug Requirements

The filter recognizes these category slugs:
- `devices` or `device` (for therapy machines)
- `accessoires`, `accessories`, or `accessoire` (for accessories)
- Any category containing "device", "machine", or "cx" in the slug → **Devices**
- Any category containing "accessor", "wrap" in the slug → **Accessoires**

## Fallback Detection

If a product doesn't have a category assigned, the system will:
- Check the product name for keywords:
  - Products with "wrap", "ankle", "knee", or "shoulder" → **Accessoires**
  - All other products → **Devices** (default)

## Quick Setup Checklist

- [ ] Create "Devices" category in WooCommerce
- [ ] Create "Accessoires" category in WooCommerce
- [ ] Assign therapy machines (CX3, CX5, CX9) to "Devices" category
- [ ] Assign wraps (Ankle, Knee, Shoulder) to "Accessoires" category
- [ ] Test filters on `/products` page

## Example Products

**Devices Category:**
- ForceX CX3
- ForceX CX5
- ForceX CX9

**Accessoires Category:**
- ForceX Ankle Wrap
- ForceX Knee Wrap
- ForceX Shoulder Wrap

