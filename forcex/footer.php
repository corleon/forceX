</main>

<footer class="footer-wrapper">
    <div class="footer-container">
        <!-- Top Section: Company Info and Navigation -->
        <div class="footer-top">
            <!-- Left: Company Info -->
            <div class="footer-company-info">
                <!-- Logo -->
                <div class="footer-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.svg" alt="FORCE X">
                </div>
                
                <!-- Company Name and Address -->
                <div class="footer-company-details">
                    <p class="company-name">Nordic Health Systems, LLC</p>
                    <p class="company-address">6521 Davis industrial Pkwy., Unit B Cleveland, OH 44139</p>
                </div>
            </div>

            <!-- Right: Contact Info and Navigation -->
            <div class="footer-right">
                <!-- Contact Info -->
                <div class="footer-contact">
                    <div class="contact-item">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/cil_phone.svg" alt="Phone" class="contact-icon" width="40" height="40">
                        <span class="contact-text">440-500-3060</span>
                    </div>
                    <div class="contact-item">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/clarity_email-line.svg" alt="Email" class="contact-icon" width="40" height="40">
                        <span class="contact-text">info@forcextherapy.com</span>
                    </div>
                    <div class="contact-item contact-item-address">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/tdesign_location.svg" alt="Location" class="contact-icon" width="40" height="40">
                        <span class="contact-text">6521 Davis industrial Pkwy., Unit B Cleveland, OH 44139</span>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="footer-navigation">
                    <!-- Products -->
                    <div class="footer-nav-column" data-expanded="true" aria-expanded="true">
                        <button class="footer-nav-header footer-nav-toggle" type="button" aria-expanded="true">
                            <span>Products</span>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/arrowbottom.svg" alt="Toggle" class="footer-nav-arrow" width="16" height="16">
                        </button>
                        <ul class="footer-nav-links footer-nav-content">
                            <?php
                            // Products page
                            $products_page = get_page_by_path('products') ?: get_page_by_path('products-page');
                            $products_url = $products_page ? get_permalink($products_page) : home_url('/products');
                            ?>
                            <li><a href="<?php echo esc_url($products_url); ?>">Products</a></li>
                            
                            <?php
                            // Technology page
                            $technology_page = get_page_by_path('technology');
                            $technology_url = $technology_page ? get_permalink($technology_page) : home_url('/technology');
                            ?>
                            <li><a href="<?php echo esc_url($technology_url); ?>">Technology</a></li>
                            
                            <?php
                            // Reviews archive
                            $reviews_url = get_post_type_archive_link('review') ?: home_url('/reviews');
                            ?>
                            <li><a href="<?php echo esc_url($reviews_url); ?>">Reviews</a></li>
                            
                            <?php
                            // For Medical Professionals page
                            $medical_prof_page = get_page_by_path('for-medical-professionals') ?: get_page_by_path('medical-professionals');
                            $medical_prof_url = $medical_prof_page ? get_permalink($medical_prof_page) : home_url('/for-medical-professionals');
                            ?>
                            <li><a href="<?php echo esc_url($medical_prof_url); ?>">For medical professionals</a></li>
                            
                            <?php
                            // Clinical Resources page
                            $clinical_resources_page = get_page_by_path('clinical-resources');
                            $clinical_resources_url = $clinical_resources_page ? get_permalink($clinical_resources_page) : home_url('/clinical-resources');
                            ?>
                            <li><a href="<?php echo esc_url($clinical_resources_url); ?>">Clinical resources</a></li>
                        </ul>
                    </div>

                    <!-- Company -->
                    <div class="footer-nav-column" data-expanded="false" aria-expanded="false">
                        <button class="footer-nav-header footer-nav-toggle" type="button" aria-expanded="false">
                            <span>Company</span>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/arrowbottom.svg" alt="Toggle" class="footer-nav-arrow" width="16" height="16">
                        </button>
                        <ul class="footer-nav-links footer-nav-content">
                            <?php
                            // Company page
                            $company_url = home_url('/company');
                            ?>
                            <li><a href="<?php echo esc_url($company_url); ?>">About us</a></li>
                            
                            <?php
                            // Contact page
                            $contact_page = get_page_by_path('contact') ?: get_page_by_path('contacts');
                            $contact_url = $contact_page ? get_permalink($contact_page) : home_url('/contact');
                            ?>
                            <li><a href="<?php echo esc_url($contact_url); ?>">Contacts</a></li>
                            
                            <?php
                            // Events archive
                            $events_url = get_post_type_archive_link('event') ?: home_url('/events');
                            ?>
                            <li><a href="<?php echo esc_url($events_url); ?>">Events</a></li>
                            
                            <?php
                            // Press releases / Articles archive
                            $press_releases_url = get_post_type_archive_link('article') ?: home_url('/blog');
                            ?>
                            <li><a href="<?php echo esc_url($press_releases_url); ?>">Press releases</a></li>
                            
                            <?php
                            // Blog page or posts archive
                            $blog_page = get_page_by_path('blog');
                            $blog_url = $blog_page ? get_permalink($blog_page) : (get_option('page_for_posts') ? get_permalink(get_option('page_for_posts')) : home_url('/blog'));
                            ?>
                            <li><a href="<?php echo esc_url($blog_url); ?>">Blog</a></li>
                        </ul>
                    </div>

                    <!-- Purchase -->
                    <div class="footer-nav-column" data-expanded="false" aria-expanded="false">
                        <button class="footer-nav-header footer-nav-toggle" type="button" aria-expanded="false">
                            <span>Purchase</span>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/arrowbottom.svg" alt="Toggle" class="footer-nav-arrow" width="16" height="16">
                        </button>
                        <ul class="footer-nav-links footer-nav-content">
                            <li><a href="<?php echo esc_url(home_url('/payment-methods')); ?>">Payment methods</a></li>
                            <li><a href="<?php echo esc_url(home_url('/orders-and-delivery')); ?>">Orders and delivery</a></li>
                            
                            <?php
                            // Cart page (WooCommerce)
                            $cart_url = function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart');
                            ?>
                            <li><a href="<?php echo esc_url($cart_url); ?>">Cart</a></li>
                        </ul>
                    </div>

                    <!-- Profile -->
                    <div class="footer-nav-column footer-profile-column">
                        <h5 class="footer-nav-header footer-profile-header">Profile</h5>
                        <div class="footer-profile-actions">
                            <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="footer-login-btn">LOG IN</a>
                            <?php /* Temporarily hidden
                            <a href="<?php echo esc_url(add_query_arg('signup', '1', wc_get_page_permalink('myaccount'))); ?>" class="footer-signup-link">SIGN UP</a>
                            */ ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Section: Copyright and Additional Info -->
        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <!-- Left: Copyright and Legal Links -->
                <div class="footer-legal">
                    <p class="copyright-text">© 2026 Nordic Health Systems, LLC. ForceX</p>
                    <div class="footer-legal-links">
                        <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>">Privacy Policy</a>
                        <a href="<?php echo esc_url(home_url('/terms-of-service')); ?>">Terms of Service</a>
                        <a href="<?php echo esc_url(home_url('/cookie-settings')); ?>">Cookie settings</a>
                    </div>
                </div>

                <!-- Middle: Payment Icons -->
                <div class="footer-payment-icons">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/amrxpres.svg" alt="American Express" class="payment-icon">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/master.svg" alt="Mastercard" class="payment-icon">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/visa.svg" alt="Visa" class="payment-icon">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pypal.svg" alt="PayPal" class="payment-icon">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/jcb.svg" alt="JCB" class="payment-icon">
                </div>

                <!-- Right: Designer Credit -->
                <?php /*
                <div class="footer-designer">
                    <span class="designed-by-text">Designed by</span>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/Dab_logo.svg" alt="DAB" class="dab-logo">
                </div>
                */ ?>
            </div>
        </div>
    </div>
</footer>

<!-- Cookie Consent Banner (US best practices: CCPA/state laws, first-visit notice) -->
<?php
$privacy_url = home_url('/privacy-policy');
$cookie_settings_url = home_url('/cookie-settings');
?>
<div id="cookie-consent-banner" class="cookie-consent-banner" role="dialog" aria-labelledby="cookie-consent-heading" aria-describedby="cookie-consent-desc" hidden>
    <div class="cookie-consent-inner">
        <div class="cookie-consent-content">
            <h2 id="cookie-consent-heading" class="cookie-consent-heading">We value your privacy</h2>
            <p id="cookie-consent-desc" class="cookie-consent-desc">
                We use cookies and similar technologies to run this site, improve your experience, and personalize content. You can choose which categories you allow. Necessary cookies are required for the site to function and cannot be disabled. For more information, see our <a href="<?php echo esc_url($privacy_url); ?>" class="cookie-consent-link">Privacy Policy</a>.
            </p>
        </div>
        <div class="cookie-consent-actions">
            <button type="button" id="cookie-consent-reject" class="cookie-consent-btn cookie-consent-btn-secondary">Reject non-essential</button>
            <button type="button" id="cookie-consent-manage" class="cookie-consent-btn cookie-consent-btn-secondary">Manage preferences</button>
            <button type="button" id="cookie-consent-accept" class="cookie-consent-btn cookie-consent-btn-primary">Accept all</button>
        </div>
    </div>
</div>

<!-- Cookie preferences modal -->
<div id="cookie-consent-modal" class="cookie-consent-modal" role="dialog" aria-modal="true" aria-labelledby="cookie-modal-heading" aria-describedby="cookie-modal-desc" hidden>
    <div class="cookie-consent-modal-backdrop" id="cookie-consent-modal-backdrop"></div>
    <div class="cookie-consent-modal-content">
        <div class="cookie-consent-modal-header">
            <h2 id="cookie-modal-heading" class="cookie-consent-modal-title">Cookie preferences</h2>
            <button type="button" id="cookie-consent-modal-close" class="cookie-consent-modal-close" aria-label="Close cookie preferences">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6L6 18M6 6l12 12"/></svg>
            </button>
        </div>
        <p id="cookie-modal-desc" class="cookie-consent-modal-intro">
            You can enable or disable different types of cookies below. Necessary cookies are required for the website to function and cannot be turned off.
        </p>
        <div class="cookie-consent-toggles">
            <div class="cookie-consent-toggle-item cookie-consent-toggle-necessary">
                <div class="cookie-consent-toggle-info">
                    <span class="cookie-consent-toggle-label">Necessary</span>
                    <span class="cookie-consent-toggle-desc">Required for the site to work (e.g., security, cart, login).</span>
                </div>
                <span class="cookie-consent-toggle-badge">Always on</span>
            </div>
            <div class="cookie-consent-toggle-item">
                <div class="cookie-consent-toggle-info">
                    <label for="cookie-toggle-analytics" class="cookie-consent-toggle-label">Analytics</label>
                    <span class="cookie-consent-toggle-desc">Help us understand how visitors use the site so we can improve it.</span>
                </div>
                <label class="cookie-consent-switch">
                    <input type="checkbox" id="cookie-toggle-analytics" class="cookie-consent-switch-input" checked>
                    <span class="cookie-consent-switch-slider"></span>
                </label>
            </div>
            <div class="cookie-consent-toggle-item">
                <div class="cookie-consent-toggle-info">
                    <label for="cookie-toggle-marketing" class="cookie-consent-toggle-label">Marketing</label>
                    <span class="cookie-consent-toggle-desc">Used to deliver relevant ads and measure ad performance.</span>
                </div>
                <label class="cookie-consent-switch">
                    <input type="checkbox" id="cookie-toggle-marketing" class="cookie-consent-switch-input">
                    <span class="cookie-consent-switch-slider"></span>
                </label>
            </div>
            <div class="cookie-consent-toggle-item">
                <div class="cookie-consent-toggle-info">
                    <label for="cookie-toggle-functional" class="cookie-consent-toggle-label">Functional</label>
                    <span class="cookie-consent-toggle-desc">Remember your choices (e.g., language, region) and enhanced features.</span>
                </div>
                <label class="cookie-consent-switch">
                    <input type="checkbox" id="cookie-toggle-functional" class="cookie-consent-switch-input" checked>
                    <span class="cookie-consent-switch-slider"></span>
                </label>
            </div>
        </div>
        <p class="cookie-consent-modal-legal">
            For details and your rights (including “Do Not Sell or Share My Personal Information”), see our <a href="<?php echo esc_url($privacy_url); ?>" class="cookie-consent-link">Privacy Policy</a>.
        </p>
        <div class="cookie-consent-modal-actions">
            <button type="button" id="cookie-consent-save" class="cookie-consent-btn cookie-consent-btn-primary">Save preferences</button>
            <button type="button" id="cookie-consent-accept-all-modal" class="cookie-consent-btn cookie-consent-btn-secondary">Accept all</button>
        </div>
    </div>
</div>

<!-- Toast Notification Container -->
<div id="toast-container" class="toast-container"></div>

<!-- Confirmation Modal -->
<div id="confirmation-modal" class="confirmation-modal hidden">
    <div class="confirmation-modal-content">
        <div class="confirmation-modal-icon warning">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        </div>
        <h3 id="confirmation-modal-title" class="confirmation-modal-title">Confirm Action</h3>
        <p id="confirmation-modal-message" class="confirmation-modal-message"></p>
        <div class="confirmation-modal-actions">
            <button id="confirmation-modal-cancel" class="btn-white px-6 py-2">Cancel</button>
            <button id="confirmation-modal-confirm" class="btn-gradient px-6 py-2">Confirm</button>
        </div>
    </div>
</div>

<!-- Order Modal -->
<div id="order-modal" class="modal hidden">
    <div class="modal-content max-w-2xl">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Order Details</h2>
            <button id="order-modal-close" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <div id="order-modal-content">
            <!-- Order details will be loaded here -->
            <div class="animate-pulse">
                <div class="h-4 bg-gray-200 rounded w-3/4 mb-4"></div>
                <div class="h-4 bg-gray-200 rounded w-1/2 mb-4"></div>
                <div class="h-4 bg-gray-200 rounded w-2/3"></div>
            </div>
        </div>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>
