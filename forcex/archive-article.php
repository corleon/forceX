<?php
/**
 * Archive template for Articles (article CPT)
 */

get_header(); ?>

<main id="main" class="site-main">
	<div class="container-custom py-12">
		<!-- Breadcrumbs -->
        <nav class="mb-6">
            <div class="flex justify-center">
                <ol class="flex items-center  text-base text-gray-500 bg-white px-4 py-2 rounded-full">
                    <li><a href="<?php echo home_url(); ?>" class="hover:text-primary-500">Main</a></li>
                    <li class="flex items-center">
                        <span class="mx-2 text-gray-400">/</span>
                        <span class="text-gray-900 font-medium">Articles &amp; Press releases</span>
                    </li>
                </ol>
            </div>
        </nav>

		<!-- Page Title -->
		<div class="text-center mb-12">
			<h1 class="title-h2">Articles &amp; Press releases</h1>
		</div>

		<!-- Article Filters -->
		<div class="flex justify-center mb-12">
			<div class="flex flex-wrap justify-center gap-1" style="background-color: #EEF2F6; border-radius: 32px; padding: 3px;">
				<button class="article-filter-btn active" data-filter="all">
					All
				</button>
				<button class="article-filter-btn" data-filter="article">
					Articles
				</button>
				<button class="article-filter-btn" data-filter="press-release">
					Press Releases
				</button>
			</div>
		</div>

		<!-- Grid -->
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 articles-grid">
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
					<?php
					$terms = wp_get_post_terms(get_the_ID(), 'article_type', array('fields' => 'slugs'));
					$badge_type = in_array('press-release', $terms) ? 'press' : 'article';
					$article_type = in_array('press-release', $terms) ? 'press-release' : 'article';
					?>
					<article class="article-card bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300" data-article-type="<?php echo esc_attr($article_type); ?>">
						<div class="relative">
							<?php if (has_post_thumbnail()) : ?>
								<?php the_post_thumbnail('large', array('class' => 'w-full h-64 object-cover')); ?>
							<?php else : ?>
								<div class="w-full h-64 bg-gray-200"></div>
							<?php endif; ?>

							<span class="absolute top-4 left-4 px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide <?php echo $badge_type === 'press' ? 'bg-primary-500 text-white' : 'bg-gray-100 text-gray-800'; ?>">
								<?php echo $badge_type === 'press' ? 'Press release' : 'Article'; ?>
							</span>
						</div>

						<div class="p-6">
							<h3 class="text-xl font-bold text-gray-900 mb-2">
								<a href="<?php the_permalink(); ?>" class="hover:underline"><?php the_title(); ?></a>
							</h3>
							<p class="text-gray-600 text-sm mb-4 line-clamp-3"><?php echo wp_kses_post(get_the_excerpt()); ?></p>
							<div class="text-gray-500 text-xs"><?php echo get_the_date('F j, Y'); ?></div>
						</div>
					</article>
				<?php endwhile; ?>
			<?php else : ?>
				<div class="col-span-full text-center py-12 text-gray-500">No posts found.</div>
			<?php endif; ?>
		</div>

		<?php if ($GLOBALS['wp_query']->max_num_pages > 1) : ?>
			<div class="mt-12 flex justify-center">
				<?php
				echo paginate_links(array(
					'total' => $GLOBALS['wp_query']->max_num_pages,
					'current' => max(1, get_query_var('paged')),
					'format' => '?paged=%#%',
					'type' => 'list',
					'end_size' => 2,
					'mid_size' => 1,
					'prev_text' => '&laquo; Previous',
					'next_text' => 'Next &raquo;',
				));
				?>
			</div>
		<?php endif; ?>
	</div>
</main>

<?php get_footer(); ?>


