<?php
/**
 * Single template for Articles (article CPT)
 */

get_header(); ?>

<main id="main" class="site-main">
	<?php while (have_posts()) : the_post(); ?>
		<?php
		$terms = wp_get_post_terms(get_the_ID(), 'article_type', array('fields' => 'slugs'));
		$badge_type = in_array('press-release', $terms) ? 'press' : 'article';
		$shop_url = function_exists('wc_get_page_id') && wc_get_page_id('shop') ? get_permalink(wc_get_page_id('shop')) : home_url('/products');
		$thumb_url = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'full') : '';
		?>

		<!-- Full-width 50/50 Hero -->
		<section class="w-full">
			
			<div class="grid grid-cols-1 md:grid-cols-[48%_52%] items-stretch">
				<!-- Left: red tag, title, date with subtle red accents -->
				<div class="relative">
					
				 
					<div class="relative z-10 w-full px-6 py-12 md:py-20 bg-[#EEF2F6] rounded-tr-[80px] min-h-[320px] md:min-h-[520px]">
						 <nav class="mb-6">
							<div class="flex justify-center">
								<ol class="flex items-center  text-base text-gray-500 bg-white px-4 py-2 rounded-full">
									<li><a href="<?php echo home_url(); ?>" class="hover:text-primary-500">Main</a></li>
									<li class="flex items-center">
										<span class="mx-2 text-gray-400">/</span>
										<a href="<?php echo get_post_type_archive_link('article'); ?>" class="hover:text-primary-500">Articles &amp; Press releases</a>
									</li>
									<li class="flex items-center">
										<span class="mx-2 text-gray-400">/</span>
										<span class="text-gray-900 font-medium"><?php the_title(); ?></span>
									</li>
								</ol>
							</div>
						</nav>
						<span class="inline-block px-4 py-2 rounded-full text-xs font-semibold uppercase tracking-wide <?php echo $badge_type === 'press' ? 'bg-primary-100 text-white' : 'bg-primary-500  text-white'; ?>">
							<?php echo $badge_type === 'press' ? 'Press release' : 'Article'; ?>
						</span>
						<h1 class="title-h1 md:text-5xl font-bold text-gray-900 mt-4 mb-3 leading-tight"><?php the_title(); ?></h1>
						<div class="text-gray-600"><?php echo get_the_date('F j, Y'); ?></div>
					</div>
				</div>

				<!-- Right: background image, slightly wider and anchored to the right edge -->
				<div class="relative z-0 min-h-[320px] md:min-h-[520px]">
					<div class="absolute inset-y-0 right-0 left-[-12%] md:left-[-18%] bg-gray-200" style="<?php echo $thumb_url ? 'background-image:url(' . esc_url($thumb_url) . ');' : ''; ?> background-size:cover; background-position:center;"></div>
				</div>
			</div>
		</section>

		<!-- Breadcrumbs -->
		<div class="container-custom py-8">


			<!-- Content + Sidebar CTA -->
			<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
				<div class="lg:col-span-2">
					<div class="prose prose-lg max-w-none">
						<?php the_content(); ?>
					</div>
				</div>
				<div class="lg:col-span-1">
					<div class="rounded-2xl bg-brand-gradient text-white p-6 lg:p-7 shadow-lg">
						<h3 class="text-xl font-semibold mb-2">Explore ForceX™ Products</h3>
						<p class="text-sm opacity-90 mb-5">Discover our full range of ForceX™ therapy systems designed to accelerate recovery, reduce swelling, and enhance performance.</p>
						<a href="<?php echo esc_url($shop_url); ?>" class="btn-white">View Products</a>
					</div>
				</div>
			</div>
		</div>
	<?php endwhile; ?>
</main>

<?php get_footer(); ?>


