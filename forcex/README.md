# ForceX WordPress Theme

A modern WooCommerce storefront theme built with Tailwind CSS and Vite for optimal performance and developer experience.

## Features

- **Modern Design**: Clean, accessible interface with custom design tokens
- **WooCommerce Integration**: Full e-commerce functionality with AJAX cart
- **Responsive**: Mobile-first design with Tailwind CSS
- **Performance**: Vite build system with HMR in development
- **Accessibility**: WCAG compliant with keyboard navigation
- **Custom Checkout**: 4-step checkout process with email gate

## Development Setup

### Prerequisites

- Node.js 16+ and npm
- WordPress 5.0+
- WooCommerce plugin (optional but recommended)

### Installation

1. **Install dependencies:**
   ```bash
   npm install
   ```

2. **Production build (recommended for initial setup):**
   ```bash
   npm run build
   ```
   This creates optimized, hashed assets in the `dist/` directory.

3. **Development mode (with HMR):**
   ```bash
   npm run dev
   ```
   This starts Vite dev server on `http://localhost:5173` with hot module replacement.

### WordPress Configuration

1. **Activate the theme** in WordPress admin under Appearance > Themes
2. **Enable WooCommerce** (optional) for full e-commerce functionality
3. **Set development environment** by adding to your `wp-config.php`:
   ```php
   define('WP_ENV', 'development'); // For HMR
   ```

## Theme Structure

```
forcex/
├── src/
│   ├── main.js          # Main JavaScript entry point
│   └── main.css         # Tailwind CSS styles
├── woocommerce/         # WooCommerce template overrides
│   ├── cart/
│   ├── checkout/
│   └── myaccount/
├── functions.php        # Theme functions and hooks
├── header.php          # Site header
├── footer.php          # Site footer
├── index.php           # Home page template
├── style.css           # Theme information
├── package.json        # Dependencies and scripts
├── tailwind.config.js  # Tailwind configuration
├── vite.config.js      # Vite configuration
└── README.md           # This file
```

## Key Features

### Home Page
- Hero section with gradient background
- ForceX technology showcase
- Featured products grid (WooCommerce integration)
- Applications section with body part links
- Customer testimonials
- Articles & press releases

### Cart & Checkout
- **Cart Page**: Product list with quantity controls, promo codes, summary
- **Email Gate**: Modal before checkout requiring email validation
- **4-Step Checkout**: Personal info → Delivery → Payment → Complete
- **Order Summary**: Real-time updates with WooCommerce

### My Account
- **Profile Dashboard**: User info and quick actions
- **Orders List**: Order history with status badges
- **Order Modal**: Detailed order information
- **Account Settings**: Personal information management

### Header & Footer
- **Sticky Header**: Logo, navigation, cart icon, account access
- **Mobile Menu**: Off-canvas navigation for mobile devices
- **Mini Cart**: Slide-out cart drawer with AJAX updates
- **Footer**: Company info, links, payment icons

## WooCommerce Integration

### Featured Products
To display products on the home page:

1. Go to **Products** in WordPress admin
2. Edit a product
3. Check **"Featured"** in the Product Data section
4. Save the product

The home page will automatically display up to 3 featured products.

### Cart Functionality
- AJAX add to cart from product cards
- Real-time cart count updates
- Mini cart drawer with product details
- Cart page with quantity controls and promo codes

### Checkout Process
- Custom 4-step checkout interface
- Email gate before checkout
- Delivery day selection
- Payment method selection
- Order completion with success/error states

## Customization

### Design Tokens
The theme uses custom Tailwind configuration with:

- **Primary Colors**: `#0F6CBD` to `#0593F3` gradient
- **Dark Color**: `#0B2239`
- **Container**: Max-width 1220px with 24px padding
- **Border Radius**: `rounded-lg` (0.5rem) and `rounded-2xl` (1rem)

### Custom Classes
- `.btn-primary`: Primary gradient button
- `.btn-secondary`: Secondary outline button
- `.card`: Standard card component
- `.container-custom`: Main container with custom max-width

### JavaScript Features
- Alpine.js for reactive components
- AJAX cart functionality
- Email gate validation
- Checkout stepper navigation
- Modal and drawer interactions
- Focus trap for accessibility

## Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

## Performance

- **Development**: Vite HMR for instant updates
- **Production**: Optimized, hashed assets
- **Images**: Lazy loading for better performance
- **CSS**: Tailwind CSS with purging for minimal bundle size
- **JavaScript**: Alpine.js for lightweight reactivity

## Accessibility

- WCAG 2.1 AA compliant
- Keyboard navigation support
- Screen reader friendly
- Focus management for modals
- Skip links for navigation
- Semantic HTML structure

## Troubleshooting

### Styles Not Loading
1. **First, build the assets:**
   ```bash
   npm run build
   ```
2. **Check if dist/ directory exists** with CSS and JS files
3. **Verify WordPress is loading the theme** (check browser dev tools for 404 errors)
4. **Clear any caching** (browser cache, WordPress cache plugins)

### HMR Not Working
1. Ensure `WP_ENV=development` is set in `wp-config.php`
2. Check that Vite dev server is running (`npm run dev`)
3. Verify no firewall blocking port 5173

### Build Issues
1. Clear `dist/` directory: `rm -rf dist/` (Linux/Mac) or `rmdir /s dist` (Windows)
2. Reinstall dependencies: `rm -rf node_modules && npm install`
3. Run build again: `npm run build`

### WooCommerce Issues
1. Ensure WooCommerce plugin is installed and activated
2. Check that products are marked as "Featured" for home page display
3. Verify WooCommerce pages are created (Cart, Checkout, My Account)

## Support

For theme support and customization requests, please contact the development team.

## License

This theme is licensed under GPL v2 or later.
