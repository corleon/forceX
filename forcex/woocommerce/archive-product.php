<?php
/**
 * Template for WooCommerce Shop (/shop) archive
 * Overrides: woocommerce/archive-product.php
 */

defined('ABSPATH') || exit;

get_header('shop');

?>

<main id="primary" class="site-main">
	<?php
		// Remove default Woo breadcrumb just for this template
		if (has_action('woocommerce_before_main_content', 'woocommerce_breadcrumb')) {
			remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
		}
		/**
		 * Hook: woocommerce_before_main_content.
		 * @see woocommerce_output_content_wrapper - 10
		 */
		do_action('woocommerce_before_main_content');
	?>

	<!-- Hero pulled from Home -->
	<section class="hero-section relative py-20 flex items-center">
		<div class="hero-background absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/hero_home_bg.png');"></div>
		<div class="container-custom relative z-10">
			<div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
				<div class="animate-fade-in lg:col-span-8">
					<h1 class="title-h1 mb-6">Shop</h1>
					<p class="text-xl mb-8 leading-relaxed body-22-dark">Explore ForceX™ devices and accessories.</p>
					<a href="#shop-list" class="btn-gradient text-lg">Browse products</a>
				</div>
			 
			</div>
		</div>
	</section>

	<div class="container-custom py-12 max-w-[1200px]">
		<!-- Breadcrumbs styled like Events -->
		<nav class="mb-6">
			<div class="flex justify-center">
				<ol class="flex items-center  text-base text-gray-500 bg-white px-4 py-2 rounded-full">
					<li><a href="<?php echo home_url(); ?>" class="hover:text-primary-500">Main</a></li>
					<li class="flex items-center">
						<span class="mx-2 text-gray-400">/</span>
						<span class="text-gray-900 font-medium"><?php woocommerce_page_title(); ?></span>
					</li>
				</ol>
			</div>
		</nav>
	</div>

	<section id="shop-list" class="w-full">
		<div class="container-custom pb-10 md:pb-14 max-w-[1200px]">
			<?php wc_print_notices(); ?>
			<nav class="mb-6" role="navigation" aria-label="Shop navigation">
				<div class="flex items-center justify-between gap-4">
					<div class="text-sm text-gray-600"><?php woocommerce_result_count(); ?></div>
					<div><?php woocommerce_catalog_ordering(); ?></div>
				</div>
			</nav>

			<?php if (have_posts()) : ?>
				<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
					<?php while (have_posts()) : the_post(); global $product; ?>
						<article class="product-card">
							<div class="relative">
								<?php if ($product && $product->is_on_sale()) : ?>
									<span class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">Sale</span>
								<?php endif; ?>
								<a href="<?php the_permalink(); ?>" class="block">
									<?php if (has_post_thumbnail()) : ?>
										<?php the_post_thumbnail('large', array('class' => 'w-full h-64 object-cover rounded-lg')); ?>
									<?php else: ?>
										<div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
											<svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
										</div>
									<?php endif; ?>
								</a>
							</div>

							<div class="w-full h-0.5 bg-gray-300 mb-4" style="margin-left: -0.5rem; margin-right: -0.5rem; width: calc(100% + 1rem);"></div>

							<h3 class="title-h3 mb-2"><?php the_title(); ?></h3>
							<p class="text-gray-600 text-sm mb-4">
								<?php
								$description = $product ? $product->get_short_description() : '';
								if (empty($description)) { $description = $product ? $product->get_description() : ''; }
								if (empty($description)) { $description = get_the_excerpt(); }
								if (empty($description)) { $description = 'Advanced therapy technology for optimal recovery and performance.'; }
								echo wp_trim_words(wp_strip_all_tags($description), 15);
								?>
							</p>

							<?php if ($product) : ?>
								<div class="mb-4" style="font-size: 36px; font-weight: bold; color: black;">
									<?php echo $product->get_price_html(); ?>
								</div>
							<?php endif; ?>

							<div class="flex items-center justify-between gap-1">
								<div class="flex items-center gap-1">
									<button class="quantity-btn disabled" style="width:56px;height:56px;background-color:white;border:1px solid #D9E2E7;" data-action="decrease">
										<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 10H16" stroke="#96A2AF" stroke-width="2" stroke-linecap="round"/></svg>
									</button>
									<input type="text" class="quantity-input text-center" style="width:56px;height:56px;background-color:#EEF2F6;border:none;border-radius:8px;" value="1">
									<button class="quantity-btn" style="width:56px;height:56px;background-color:white;border:1px solid #D9E2E7;" data-action="increase">
										<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 10H16M10 4V16" stroke="#25AAE1" stroke-width="2" stroke-linecap="round"/></svg>
									</button>
								</div>
								<?php if ($product) {
									$add_to_cart_url = $product->add_to_cart_url();
									$add_to_cart_text = esc_html__('PURCHASE', 'woocommerce');
									echo '<a href="' . esc_url($add_to_cart_url) . '" class="btn-gradient">' . $add_to_cart_text . '</a>';
								} ?>
							</div>
						</article>
					<?php endwhile; ?>
				</div>

				<div class="mt-10">
					<?php do_action('woocommerce_after_shop_loop'); ?>
				</div>

			<?php else : ?>
				<?php do_action('woocommerce_no_products_found'); ?>
			<?php endif; ?>
		</div>
	</section>

	<?php
		/**
		 * Hook: woocommerce_after_main_content.
		 * @see woocommerce_output_content_wrapper_end - 10
		 */
		do_action('woocommerce_after_main_content');
	?>
</main>

<?php
get_footer('shop');
?>


