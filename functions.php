<?php


define( 'THEME_VERSION', '1.0.1' );
define( 'THEME_URL', get_bloginfo('template_directory') );

add_action( 'wp_enqueue_scripts', 'static_load' );
function static_load(){
	wp_register_style( 'theme', get_stylesheet_uri(), array(), THEME_VERSION );
	wp_register_script( 'base', get_template_directory_uri() . '/static/javascript/base.js', '', THEME_VERSION, true ); 
  wp_register_script( 'preview', get_template_directory_uri() . '/static/javascript/preview.js', array(), THEME_VERSION, false ); 
	wp_register_script( 'html5', get_template_directory_uri() . '/static/javascript/html5shiv.js', array(), THEME_VERSION, false );
    wp_register_script( 'respond', get_template_directory_uri() . '/static/javascript/respond.min.js', array(), THEME_VERSION, false );
    wp_register_script( 'main', get_template_directory_uri() . '/static/javascript/main.js', array(), THEME_VERSION, true );
    wp_register_script( 'medium', get_template_directory_uri() . '/static/javascript/medium-zoom.js', array(), THEME_VERSION, true );
	wp_enqueue_style( 'theme' );
    wp_enqueue_script( 'base' ); 
     wp_enqueue_script( 'preview' ); 
    wp_enqueue_script( 'main' ); 
    wp_enqueue_script( 'html5' );
     // wp_enqueue_script( 'medium' );
    wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );
    wp_enqueue_script( 'respond' );
    wp_script_add_data( 'respond', 'conditional', 'lt IE 9' );  

    wp_localize_script( 'main', 'Theme' , array(
		'ajaxurl' => admin_url( 'admin-ajax.php' )
	));
}
/**
 * 添加功能
 */
add_theme_support( 'post-thumbnails' );
add_action( 'after_setup_theme', 'theme_setup' );
add_filter( 'pre_option_link_manager_enabled', '__return_true' );
function theme_setup() {
    register_nav_menu( 'top', '头部菜单' );
}
add_filter( 'upload_mimes', 'add_upload_mimes' );
function add_upload_mimes( $mimes = array() ) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'widget_text', 'do_shortcode' );
add_filter( 'widget_text', 'execute_php', 100 );
function execute_php( $html ){
     if( strpos( $html, "<"."?php" ) !== false ) {
          ob_start();
          eval( "?".">".$html );
          $html = ob_get_contents();
          ob_end_clean();
     }
     return $html;
}
/**
 * 移除功能
 */
add_action( 'init', 'disable_emojis' );
add_action( 'widgets_init', 'unregister_default_widgets', 11 );
function unregister_default_widgets() {
    unregister_widget( 'WP_Widget_Pages' );
    unregister_widget( 'WP_Widget_Calendar' );
    unregister_widget( 'WP_Widget_Archives' );
    unregister_widget( 'WP_Widget_Links' );
    unregister_widget( 'WP_Widget_Meta' );
    unregister_widget( 'WP_Widget_Search' );
    unregister_widget( 'WP_Widget_Categories' );
    unregister_widget( 'WP_Widget_Recent_Posts' );
    unregister_widget( 'WP_Widget_Recent_Comments' );
    unregister_widget( 'WP_Widget_RSS' );
    unregister_widget( 'WP_Widget_Text' );
    unregister_widget( 'WP_Widget_Tag_Cloud' );
    unregister_widget( 'WP_Nav_Menu_Widget' );
}
function disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    //add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
remove_action( 'wp_head', 'wp_generator');
remove_action( 'wp_head', 'wlwmanifest_link');
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
remove_action( 'wp_head', 'parent_post_rel_link' );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );

show_admin_bar( false );
remove_filter( 'term_description', 'wp_kses_data' );
remove_filter( 'pre_term_description', 'wp_filter_kses' );
remove_shortcode('gallery', 'gallery_shortcode');  


/**
 * 注册小工具
 */
add_action( 'widgets_init', 'widgets_init' );
function widgets_init() {
    register_sidebar(array(
        'name'          => '侧边栏',
        'id'            => 'sidebar-1',
        'description'   => '首页显示',
        'before_widget' => '<div class="widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    
}
/**
 * 优化站点标题
 */
add_filter( 'wp_title', 'site_title', 10, 2 );
function site_title( $title, $sep ) {

    global $paged, $page, $wp_query,$post;

    if ( is_feed() || $post->post_type == 'reads')
        return $post->post_title ;

    $title .= get_bloginfo( 'name', 'display' );

    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
        $title = "$title $sep $site_description";

    if ( is_search() )
        $title = get_search_query()."的搜索結果";

    if ( $paged >= 2 || $page >= 2 )
        $title = "第" .max( $paged, $page ) ."页 ". $sep . " " . $title;
    return $title;
}

/**
 * 优化标题描述
 */
add_action( 'wp_head', 'site_seo', 0 );
function site_seo() {
    global $s, $post , $wp_query;
    $keywords = '';
    $description = '';
    $blog_name = get_bloginfo( 'name' );
    if ( is_singular() ) {
        $ID = $post->ID;
        
        if ( ! get_post_meta( $ID, 'meta-description', true )) {
            $description = wp_trim_words( $post->post_content, 200); 
        }
        else {
            $description = get_post_meta( $ID, 'meta-description', true );
        }

        $tags = get_the_tags();
        if (!empty($tags)) {
            foreach ($tags as $key => $tag) {
                $keywords .= $tag->name.',';    
            }
        }
    }
    elseif ( is_home () ) {
        // $description = object( 'seo_description' );
        // $keywords = object( 'seo_keywords' );
    }
    elseif ( is_tag() ) {
        $description = single_tag_title( '', false ) . " - ". trim( strip_tags( tag_description() ) );
    }
    elseif ( is_category() ) {
        $description = single_cat_title( '', false ) . " - ". trim( strip_tags( category_description() ) );
    }
    elseif ( is_archive() ) {
        $description = $blog_name . "'" . trim( wp_title( '', false ) ) . "'";
    }
    elseif ( is_search() ) {
        $description = $blog_name . ": '" . esc_html( $s, 1 ) . "' 的搜索結果";
    }
    else { 
        $description = $blog_name . "'" . trim( wp_title( '', false ) ) . "'";
    }

    $description = mb_substr( $description, 0, 220, 'utf-8' );
    $pingback_url = get_bloginfo( 'pingback_url' );
    $rss2_url = get_bloginfo( 'rss2_url' );
    $atom_url = get_bloginfo( 'atom_url' );
    // $favicon = object( 'site_favicon' );
    echo "<meta name=\"description\" content=\"w候人兮猗-世俗却正义是一个小众的生活聚集地。只为分享情感文字、技术教程、诗与故事,影音视频,留住身边的感动,带给身边人不一样的乐趣。\">\n";
    echo "<meta name=\"keywords\" content=\"w候人兮猗,候人兮猗,情感文字,技术教程,闲言碎语,诗与故事,视频影音,生活,文艺,聚集地,小众\">\n";
    echo "<link rel=\"profile\" href=\"https://gmpg.org/xfn/11\">\n";
    echo "<link rel=\"pingback\" href=\"$pingback_url\" />\n";
    echo "<link rel=\"alternate\" type=\"application/rss+xml\" title=\"$blog_name\" href=\"$rss2_url\" />\n";
    echo "<link rel=\"alternate\" type=\"application/atom+xml\" title=\"$blog_name\" href=\"$atom_url\" />\n";
    echo "<link rel=\"shortcut icon\" type=\"images/x-icon\" href=\"https://www.ahwgs.cn/wp-content/uploads/2017/09/favicon.ico\" />\n";
}
/**
 * 外部链接自动加nofollow
 */
add_filter( 'the_content', 'link_nofollow');
function link_nofollow( $content ) {
    $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>";
    if( preg_match_all("/$regexp/siU", $content, $matches, PREG_SET_ORDER) ) {
        if( ! empty($matches) ) {
            $srcUrl = get_option( 'siteurl' );
            for ( $i=0; $i < count($matches); $i++ ){
                $tag = $matches[$i][0];
                $tag2 = $matches[$i][0];
                $url = $matches[$i][0];
                $noFollow = '';
                $pattern = '/target\s*=\s*"\s*_blank\s*"/';
                preg_match( $pattern, $tag2, $match, PREG_OFFSET_CAPTURE );
                if( count($match) < 1 ) $noFollow .= ' target="_blank" ';
                $pattern = '/rel\s*=\s*"\s*[n|d]ofollow\s*"/';
                preg_match( $pattern, $tag2, $match, PREG_OFFSET_CAPTURE );
                if( count($match) < 1 ) $noFollow .= ' rel="nofollow" ';
                $pos = strpos( $url, $srcUrl );
                if ( $pos === false ) {
                    $tag = rtrim ( $tag, '>' );
                    $tag .= $noFollow.'>';
                    $content = str_replace( $tag2, $tag, $content );
                }
            }
        }
    }

    $content = str_replace( ']]>', ']]>', $content );
    return $content;
}

/**
 * 图片自动alt标签
 */
add_filter('the_content', 'auto_images_alt');
function auto_images_alt($content) {
    global $post;
    $pattern ="/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
    $replacement = '<a$1href=$2$3.$4$5 alt="'.$post->post_title.'" title="'.$post->post_title.'"$6>';
    $content = preg_replace($pattern, $replacement, $content);
    return $content;
}
/**
 * 搜索结果排除页面
 */
add_filter('pre_get_posts','wpjam_exclude_page_from_search');
function wpjam_exclude_page_from_search($query) {
    if ($query->is_search) {
        $query->set('post_type', 'post');
    }
    return $query;
}

/**
 * 后台元素
 */
add_action( 'admin_bar_menu', 'remove_logo', 999 );
add_action( 'admin_menu', 'disable_dashboard_widgets' );
add_filter( 'admin_title', 'custom_admin_title', 10, 2 );
add_filter( 'admin_footer_text', 'change_footer_admin', 9999 );
add_filter( 'update_footer', 'change_footer_version', 9999 );
function custom_admin_title( $admin_title, $title ){
    return $title .' &lsaquo; '. get_bloginfo( 'name' );
}
function remove_logo( $wp_toolbar ) {
    $wp_toolbar->remove_node( 'wp-logo' );
}
function change_footer_admin () { return ''; }  
function change_footer_version() { return ''; }  
function disable_dashboard_widgets() {
    remove_meta_box( 'dashboard_primary', 'dashboard', 'core' );   // 博客  
    remove_meta_box( 'dashboard_secondary', 'dashboard', 'core' ); // 其它新闻 
    remove_meta_box( 'dashboard_right_now', 'dashboard', 'core' ); // 概况   
}

add_action( 'login_footer', 'custom_html' );
add_filter( 'login_headertitle', 'custom_headertitle' );
add_filter( 'login_headerurl', 'custom_loginlogo_url' );
function custom_html() {
    // $avatar = get_avatar_url( cs_get_option( 'sns_email' ) );
    echo "<style type=\"text/css\">\n";
    echo ".login h1 a { background-image:url(\"$avatar\"); border-radius: 999em; }\n";
    echo "</style>";
}
function custom_loginlogo_url( $url ) {
    return esc_url( home_url('/') );
}
function custom_headertitle ( $title ) {
    return get_bloginfo( 'name' );
}

add_filter('pre_option_link_manager_enabled','__return_true');//开启链接

/**
 * 友情链接
 */
function link_item( $id = null ) {
    $bookmarks = get_bookmarks( 'orderby=date&category=' . $id );
    $output    = '';
    if ( ! empty($bookmarks) ) {
        foreach ( $bookmarks as $bookmark ) {
            $img_type = strstr($bookmark->link_notes, 'http');
            if ( strstr($bookmark->link_notes, 'http') ) {
                $avatar = '<img alt="avatar" src="'. $bookmark->link_notes .'" srcset="'. $bookmark->link_notes .'" class="avatar avatar-80" height="80" width="80">';
            }
            else {
                $avatar = get_avatar( $bookmark->link_notes, 80 );
            }
            $output .='<a href="'. $bookmark->link_url .'" target="_blank" class="link-items">';
            $output .= '<div class="item">';
            $output .= '<div class="link-avatar">'. $avatar .'</div>';
            $output .= '</div>';
            $output .= '<div class="info">';
            $output .= '<h3 class="name">'. $bookmark->link_name .'</h3>';
            // $output .= '<div class="description">'. $bookmark->link_description .'</div>';
            $output .= '</div>';
            $output .= '</div><!-- .item -->';
            $output .='</a >';

        }
    }
    return $output;
}



/*
    文章摘要
*/
function post_excerpt( $post = false, $excerpt_length = 250 ) {
    

    if( ! $post ) $post = get_post();
    $post_excerpt = $post->post_excerpt;
    $post_content = $post->post_content;
    $post_content = do_shortcode( $post_content );
    $post_content = wp_strip_all_tags( $post_content );
    if( $post_excerpt == '' ) {
        $post_excerpt = mb_strimwidth( $post_content, 0, $excerpt_length, ' ...', 'utf-8' );
    }

    $post_excerpt = wp_strip_all_tags( $post_excerpt );
    $post_excerpt = trim( preg_replace( "/[\n\r\t ]+/", ' ', $post_excerpt ), ' ' );
    if ( post_password_required() ) {
        echo '<p>文章内容是加密的，你需要提供密码。</p><p>The content is encrypted and you need to provide the password.</p>';
    }
    else {
        echo $post_excerpt;
    }
}

function new_excerpt_length($length) {
    return 55;
}
add_filter('excerpt_length', 'new_excerpt_length');
function new_excerpt_more($more) {
    return ' ...';
}
add_filter('excerpt_more', 'new_excerpt_more');

/**
 * 日期格式
 */
add_filter( 'the_time', 'post_time' );
function post_time() {
    global $post;
    $date = $post->post_date;
    $time = get_post_time( 'G', true, $post );
    $diff = time() - $time;
    if ($diff <= 3600) {
        $mins = round($diff / 60);
        if ($mins <= 1) {
            $mins = 1;
        }
        $time = sprintf(_n('%s 分钟', '%s 分钟', $mins), $mins) . __( '前' );
    }
    else if (($diff <= 86400) && ($diff > 3600)) {
        $hours = round($diff / 3600);
        if ($hours <= 1) {
            $hours = 1;
        }
        $time = sprintf(_n('%s 小时', '%s 小时', $hours), $hours) . __( '前' );
    }
    elseif ($diff >= 86400) {
        $days = round($diff / 86400);
        if ($days <= 1) {
            $days = 1;
            $time = sprintf(_n('%s 天', '%s 天', $days), $days) . __( '前' );
        }
        elseif( $days > 29){
            $time = get_the_time(get_option('date_format'));
        }
        else{
            $time = sprintf(_n('%s 天', '%s 天', $days), $days) . __( '前' );
        }
    }
    return $time;
}
/**
 * 标签
 */
function post_tags() {
    $tags = get_the_tags();
    if ( $tags ) {
        $output = '<div class="tags">';
        foreach ( $tags as $tag ) {
            $output .= '<a href="'. get_tag_link( $tag->term_id ) .'" ># '. $tag->name .'</a>';
        }
        $output .= '</div>';
    }
    echo $output;
}

/**
 * 边栏友链
 */
function sidebar_links( $limit = 5 ) {
    $bookmarks = get_bookmarks( 'orderby=date&category=' . $id );
    $output = '';
    if ( ! empty($bookmarks) ) {
        $output .= '<ul class="items links-bar">';
        foreach ( $bookmarks as $key => $bookmark ) {
            $output .= '<li class="item fl"><a href="'. $bookmark->link_url .'" target="_blank">'. $bookmark->link_name .'</a></li>';
            if ( $key >= $limit - 1 ) break;
        }
        $output .= '</ul>';
        echo $output;
    }
}

/**
 * 转载声明
 */
function post_copyright() {
    if ( !wp_is_mobile() ) {
        echo '<div class="post-copyright">  本文采用 <a href="https://creativecommons.org/licenses/by-nc-sa/3.0/deed.zh" class="external" target="_blank">CC BY-NC-SA 3.0 Unported</a> 协议进行许可<br>本文链接： <a href="'.get_permalink().'" title="'.get_the_title().'">'.get_permalink().'</a></div>';
    }
}
/**
 * 友情链接
 */
add_action( 'widgets_init', 'widgets_links_init' );
function widgets_links_init() {
    register_widget( 'Links' );
}
class Links extends WP_Widget
{
    
    function Links() {
        $widget_ops = array('description' => '默认显示全部的链接');
        $this->WP_Widget('Links', '友情链接', $widget_ops);
    }

    // 表单
    function form($instance) {
        global $wpdb;
        $instance = wp_parse_args((array) $instance, array('title'=> '', 'limit' => ''));
        $title = esc_attr($instance['title']);
        $limit = strip_tags($instance['limit']);
    ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>">标题：<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>


        <p><label for="<?php echo $this->get_field_id('limit'); ?>">数量：<input id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></label>
        </p>

        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
    <?php
    }

    // 更新
    function update($new_instance,$old_instance) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['limit'] = strip_tags($new_instance['limit']);
        return $instance;
    }

    function widget($args,$instance) {
        extract( $args );
        $title = apply_filters('widget_title',esc_attr($instance['title']));
        
        

        $limit = strip_tags( $instance['limit'] );
        $limit = $limit ? $limit : 5;
        echo $before_widget;
        echo $before_title.$icon.$title.$after_title;
        sidebar_links($limit);
        echo $after_widget;
    }
}

/**
 * 文本工具
 */
add_action( 'widgets_init', 'widgets_codetext_init' );
function widgets_codetext_init() {
    register_widget( 'Codetext' );
}
class Codetext extends WP_Widget
{
    
    function Codetext() {
        $widget_ops = array('description' => '文本小工具，支持写入html和PHP代码');
        $this->WP_Widget('Codetext', '文本', $widget_ops);
    }

    // 表单
    function form($instance) {
        global $wpdb;
        $instance = wp_parse_args((array) $instance, array('title'=> '', 'limit' => ''));
        $title = esc_attr($instance['title']);
        $filter = isset( $instance['filter'] ) ? $instance['filter'] : 0;
    ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>">标题：<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>


        <p><label for="<?php echo $this->get_field_id( 'text' ); ?>">内容：</label>
        <textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo esc_textarea( $instance['text'] ); ?></textarea></p>

        <p><input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox"<?php checked( $filter ); ?> />&nbsp;<label for="<?php echo $this->get_field_id('filter'); ?>">自动分段</label></p>

        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
    <?php
    }

    // 更新
    function update($new_instance,$old_instance) {
        if (!isset($new_instance['submit']))
            return false;

        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);

        if ( current_user_can( 'unfiltered_html' ) )
            $instance['text'] = $new_instance['text'];
        else
            $instance['text'] = wp_kses_post( $new_instance['text'] );

        $instance['filter'] = ! empty( $new_instance['filter'] );
        return $instance;
    }

    function widget($args,$instance) {
        extract( $args );
        $title = apply_filters('widget_title',esc_attr($instance['title']));


        $widget_text = ! empty( $instance['text'] ) ? $instance['text'] : '';
        $text = apply_filters( 'widget_text', $widget_text, $instance, $this );
        $text = !empty( $instance['filter'] ) ? wpautop( $text ) : $text;
        echo $before_widget;
        echo $before_title.$icon.$title.$after_title;
        echo '<div class="textwidget">'. $text .'</div>';
        echo $after_widget;
    }
}
/**
 * 视频短代码
 */
add_shortcode( 'mp4', 'video_shortcode' );
function video_shortcode( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'url' => $url,
    ), $atts ) );

    $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' )[0];
    $poster = THEME_URL.'/static/img/play.png';
    $btn = THEME_URL.'/static/img/video.png';

    echo '<div id="media"><video id="video" class="bg" src="'.$url.'" controls="controls" poster="'.$poster.'" width="100%" height="100%" style="background-image:url('.$image.')"></video></div>';
}
/**
 * 增加编辑快捷按钮
 */
function themes_add_quicktags() { ?> 
    <script type="text/javascript"> 
        QTags.addButton( '视频播放器', '视频播放器', '\n[mp4 url="填写视频地址"]', '' );
        
    </script>
<?php
}
add_action('admin_print_footer_scripts', 'themes_add_quicktags' );

