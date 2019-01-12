<article id="post-<?php the_ID(); ?>" <?php post_class();?> itemscope itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
	<header class="post-head">
		<?php the_title( sprintf( '<h2 class="title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		<time itemprop="datePublished" datetime="<?php echo get_the_date('c');?>"> <?php the_time();?></time>
		<span class="nickname">&nbsp;<?php the_author(); ?></span>
	</header>
	<section class="post-excerpt">
		<div class="summary" itemprop="description">
			<?php post_excerpt(); ?>
		</div>
		
	</section>
</article>