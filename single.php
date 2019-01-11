<?php 
get_header();
$cats = get_the_category();
$meta = get_post_meta( get_the_ID(), 'standard_post_options', true );
?>
	<main id="main" class="single" role="main" itemprop="mainContentOfPage" itemscope itemtype="http://schema.org/Blog">
			<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
				<header class="entry-header">
					<?php the_title( '<h2 class="title" itemprop="name">', '</h2>' ); ?>
					<div class="meta">发布于 <time itemprop="datePublished" datetime="<?php echo get_the_date('c');?>"><?php the_time(); ?></time> / <a href="<?php echo esc_url( get_category_link( $cats[0]->term_id ) );?>"><?php echo $cats[0]->name; ?></a>
						<?php if(edit_post_link('编辑')) echo ' / '.edit_post_link('编辑'); ?></div>
				</header>
				<div id="entry-content" class="entry-content <?php echo $shadow.' ' .$max; ?>" itemprop="articleBody">
					<?php the_content(); ?>
				</div>
				<?php post_tags(); ?>
				<?php post_copyright(); ?>
			</article>
			<?php endwhile; ?>
			<div id='gitalk-container'></div>
			<script type="text/javascript">
				var gitalk = new Gitalk({
				  clientID: 'cde90ea8102c6531be8f',
				  clientSecret: 'a73575efa8578bf98021390fea663a16510e22ea',
				  repo: 'ahwgs_blog',
				  owner: 'ahwgs',
				  admin: ['ahwgs'],
				  id:decodeURI(window.location.pathname),      // Ensure uniqueness and length less than 50
				  distractionFreeMode: false  // Facebook-like distraction free mode
				})

				gitalk.render('gitalk-container');
            
            
			</script>
      <style type="text/css">
				.gt-copyright{
					display: none!important;
				}
			</style>
			<div id="pagination">
				<div class="nav-next fr"><?php if (get_previous_post()) { previous_post_link('上一篇: %link');} else {echo "没有了，已经是最后文章";} ?></div>
				<div class="nav-previous fl"><?php if (get_next_post()) { next_post_link('下一篇: %link');} else {echo "没有了，已经是最新文章";} ?></div>
			</div>
				
	</main>
<?php  get_footer(); ?>