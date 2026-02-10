<?php
/**
 * Default Page Template
 * Used for all pages that don't have a specific template assigned
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<style>
    .default-page-template {
        background-color: white;
    }
    .default-page-template input::placeholder {
        color: #748394;
    }
</style>

<main id="main" class="site-main default-page-template">
    <div class="container-custom py-8" style="background-color: white;">
        <!-- Breadcrumbs -->
        <nav class="mb-6">
            <div class="flex justify-center">
                <ol class="flex items-center text-base text-gray-500 bg-white px-4 py-2 rounded-full">
                    <li><a href="<?php echo home_url(); ?>" class="hover:text-primary-500">Main</a></li>
                    <li class="flex items-center">
                        <span class="mx-2 text-gray-400">/</span>
                        <span class="text-gray-900 font-medium"><?php echo esc_html(get_the_title()); ?></span>
                    </li>
                </ol>
            </div>
        </nav>

        <!-- Page Title -->
        <div class="mb-8 text-center">
            <h1 class="title-h1"><?php the_title(); ?></h1>
        </div>

        <!-- Page Content -->
        <div class="max-w-4xl mx-auto">
            <div class="bg-white p-8 md:p-12" >
                <div class="page-content space-y-4" style="color: #283440; font-size: 16px; line-height: 1.75;">
                    <?php
                    while (have_posts()) :
                        the_post();
                        the_content();
                    endwhile;
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
.page-content h2 {
    font-size: clamp(20px, 3vw, 28px);
    font-weight: 500;
    color: #111827;
    margin-top: 2rem;
    margin-bottom: 1rem;
}
.page-content h3 {
    font-size: clamp(18px, 2.5vw, 24px);
    font-weight: 500;
    color: #111827;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
}
.page-content h4 {
    font-size: clamp(16px, 2vw, 20px);
    font-weight: 500;
    color: #111827;
    margin-top: 1.25rem;
    margin-bottom: 0.5rem;
}
.page-content p {
    margin-bottom: 1rem;
    color: #283440;
    line-height: 1.75;
}
.page-content ul,
.page-content ol {
    margin-bottom: 1rem;
    padding-left: 1.5rem;
    color: #283440;
}
.page-content li {
    margin-bottom: 0.5rem;
    line-height: 1.75;
}
.page-content a {
    color: #25AAE1;
    text-decoration: underline;
}
.page-content a:hover {
    color: #1a8bc7;
}
.page-content img {
    max-width: 100%;
    height: auto;
    margin: 1.5rem 0;
    border-radius: 8px;
}
.page-content blockquote {
    border-left: 4px solid #25AAE1;
    padding-left: 1rem;
    margin: 1.5rem 0;
    font-style: italic;
    color: #748394;
}
.page-content code {
    background-color: #EEF2F6;
    padding: 0.125rem 0.375rem;
    border-radius: 4px;
    font-size: 0.875em;
    color: #111827;
}
.page-content pre {
    background-color: #EEF2F6;
    padding: 1rem;
    border-radius: 8px;
    overflow-x: auto;
    margin: 1.5rem 0;
}
.page-content pre code {
    background-color: transparent;
    padding: 0;
}
.page-content table {
    width: 100%;
    border-collapse: collapse;
    margin: 1.5rem 0;
}
.page-content table th,
.page-content table td {
    padding: 0.75rem;
    border: 1px solid #D9E2E7;
    text-align: left;
}
.page-content table th {
    background-color: #EEF2F6;
    font-weight: 600;
    color: #111827;
}
</style>

<?php get_footer(); ?>
