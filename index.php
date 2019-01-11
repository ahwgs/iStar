
<?php get_header(); ?>

<section id="content">
	<main id="main" class="home fl" role="main" itemprop="mainContentOfPage" itemscope itemtype="http://schema.org/Blog">
		<?php
			if ( have_posts() ) :
				while ( have_posts() ) : the_post();
				get_template_part( 'loop/list', get_post_format() );
				endwhile;
			else :
				get_template_part( 'loop/none' );
			endif;
		?>
		<div id="pagination">
			<div class="nav-next fr"><?php next_posts_link(__('Next ＞')) ?></div>
			<div class="nav-previous fl"><?php previous_posts_link(__('＜ Last')) ?></div>
		</div>
	</main>
	<?php get_sidebar(); ?>
</section>

<?php get_footer(); ?>
