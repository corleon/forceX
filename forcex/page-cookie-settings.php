<?php
/**
 * Template Name: Cookie Settings
 * Page slug: cookie-settings (create a page with this slug to use).
 * Cookie consent modal opens automatically on load via JS.
 */
if (!defined('ABSPATH')) {
    exit;
}
get_header();
$privacy_url = home_url('/privacy-policy');
?>
<main class="container-custom py-12 md:py-16">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">Cookie preferences</h1>
        <p class="text-gray-600 mb-6">
            You can manage your cookie preferences below. If you don't see the preferences panel, 
            <button type="button" onclick="typeof window.openCookieSettings === 'function' && window.openCookieSettings();" class="text-primary-500 hover:underline font-medium">open it here</button>.
        </p>
        <p class="text-gray-600">
            For more information about how we use cookies and your privacy rights (including "Do Not Sell or Share My Personal Information"), see our 
            <a href="<?php echo esc_url($privacy_url); ?>" class="text-primary-500 hover:underline">Privacy Policy</a>.
        </p>
    </div>
</main>
<?php get_footer(); ?>
