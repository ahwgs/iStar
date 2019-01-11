<?php get_header(); ?>
<section id="content">
	<main id="main" class="width-half fl page" role="main" itemprop="mainContentOfPage" itemscope itemtype="http://schema.org/Blog">
		<div id="primary" class="content">
			<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
				<header class="entry-header">
					<?php the_title( '<h1 class="title" itemprop="name">', '</h1>' ); ?>
				</header>
				<div id="entry-content" class="entry-content" itemprop="articleBody">
					<?php the_content(); ?>
				</div>
			</article>
			<?php endwhile; ?>
		</div>
	</main>
	<?php get_sidebar(); ?>
</section>
<?php  get_footer(); ?>