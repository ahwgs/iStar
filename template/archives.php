<?php
/*
    Template Name: 文章归档
*/
get_header(); ?>
<section id="archive">
    <main id="main" class="archive-main" role="main" itemprop="mainContentOfPage" itemscope itemtype="http://schema.org/Blog">
        <div class="tag-cloud">
            <h1 class="tag-cloud-title">标签云</h1>
            <?php wp_tag_cloud('smallest=10&largest=10&orderby=count'); ?>
        </div>

        <div class="archive-head ">
            <?php the_title( '<h1 class="title" itemprop="name">', '</h1>' ); ?>
        </div>
        <div id="primary" class="content archives">
        <?php
            $args = array(
                'posts_per_page' => -1,
                'post_type' => array('post'),
                'ignore_sticky_posts' => 1,
            );
            $the_query = new WP_Query( $args );
            $year=0; $mon=0; $day=0; $all = array(); $output = ''; $i= 0;
            while ( $the_query->have_posts() ) : $the_query->the_post();
                $i++;
                $year_tmp = get_the_time('Y');
                $mon_tmp = get_the_time('n');
                $day_tmp = get_the_time('j');
                $y = $year;
                $m = $mon;
                if ($mon != $mon_tmp && $mon > 0) $output .= '</ul></article>';
                if ($year != $year_tmp) { // 年份      
                    $year = $year_tmp;
                    $output .= '<h2 class="date-year">'. $year .'</h2>';
                    $all[$year] = array();
                }
                if ($mon != $mon_tmp) { // 月份 
                    $i = 0;
                    $mon = $mon_tmp;
                    $output .= '<ul class="archives-ul">';
                }
                 $output .= '<li><span class="">'.get_the_time('m-d') .'</span><a class="" href="'. get_permalink() .'">'. get_the_title().'</a></li>';
            endwhile;
            wp_reset_postdata();
            $output .= '</ul></article>';
            echo $output; ?>
        </div>
    </main>
</section>
    
<?php  get_footer(); ?>