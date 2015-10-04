<?php


/*

add_action('admin_menu', 'option_menu');



function option_menu() {

    add_options_page('Cleanfrog Options', 'Cleanfrog Options', 'manage_options', 'cleanfrog_options', 'cleanfrog_options');

}



function cleanfrog_options() {

    if (!current_user_can('manage_options'))  {

        wp_die( __('You do not have sufficient permissions to access this page.') );

    }

include('options-page.php');

}

*/

if (!isset($sa_settings)) {
    $sa_settings = get_option('sa_options'); //gets the current value of all the settings as stored in the db
}

//New options page

if (is_admin()) {
    $functions_path = TEMPLATEPATH.'/options/';

//Theme Options

require_once $functions_path.'options.php';
}

//END New options page


// Remove the links to the extra feeds such as category feeds if chosen

if (get_option('cf_cleanfeedurls') != '') {
    remove_action('wp_head', 'feed_links_extra', 3);
}

//This will activate the widgetised sidebar and footer

if (function_exists('register_sidebar')) {
    register_sidebar(array('name' => 'Sidebar'));
}

    $args1 = array('name' => 'Footer-left','before_title' => '<h4 class="widgettitle">','after_title' => '</h4>');

    $args2 = array('name' => 'Footer-center','before_title' => '<h4 class="widgettitle">','after_title' => '</h4>');

    $args3 = array('name' => 'Footer-right','before_title' => '<h4 class="widgettitle">','after_title' => '</h4>');

    register_sidebar($args1);

    register_sidebar($args2);

    register_sidebar($args3);

//Theme support for thumbnails and feed lnks

add_theme_support('post-thumbnails');

add_theme_support('automatic-feed-links');

//allows for a custom background

add_custom_background();

//Changes the excerpt "read more" link to a raquo

    function new_excerpt_more($more)
    {
        global $post;

        return '...<a href="'.get_permalink($post->ID).'">&raquo;</a>';
    }

add_filter('excerpt_more', 'new_excerpt_more');

// register three menus kf

      function register_menus()
      {
          register_nav_menus(

      array(

      'header-menu' => __('Header Menu'),

      'primary-menu' => __('Primary Menu'),

      'secondary-menu' => __('Secondary Menu'),

      )

      );
      }

      add_action('init', 'register_menus');

//Enques the custom scripts

if (!is_admin()) { // instruction to only load if it is not the admin area

  wp_register_script( 'jquery-js', get_template_directory_uri() . '/js/jquery.min.js', array( 'jquery' ), '3.0.1', true );

  wp_enqueue_script('jquery-js');


   // cufon scripts

   wp_register_script('cufon',

       get_template_directory_uri().'/cufon/cufon-yui.js',

       array('jquery'),

       '1.0');

    wp_enqueue_script('cufon');

    wp_register_script('cufon-font',

       get_template_directory_uri().'/cufon/Superclarendon_Rg_700.font.js',

       array('cufon'),

       '1.0');

    wp_enqueue_script('cufon-font');

    wp_register_script('cufon-load',

       get_template_directory_uri().'/cufon/cufon-load.js',

       array('cufon'),

       '1.0');

    wp_enqueue_script('cufon-load');

   // Collapser script

   wp_register_script('collapser',

       get_template_directory_uri().'/js/collapser.js',

       array('jquery'),

       '1.0');

   // enqueue the script

   wp_enqueue_script('collapser');
}


// for loading Bootstrap, welcome to the 21st century
function my_bootstrap_theme_scripts() {
  wp_register_script( 'bootstrap-js', get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '3.0.1', true );
  wp_register_style( 'bootstrap-css', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css', array(), '3.0.1', 'all' );

  wp_enqueue_script( 'bootstrap-js' );
  wp_enqueue_style( 'bootstrap-css' );

  if ( is_singular() && comments_open() && get_option('thread_comments') )
    wp_enqueue_script( 'comment-reply');

}

add_action('wp_enqueue_scripts', 'my_bootstrap_theme_scripts');









//Loads an old comments.php file if wordpress does not support the new comment methods

add_filter('comments_template', 'legacy_comments');

function legacy_comments($file)
{
    if (!function_exists('wp_list_comments')) {
        $file = TEMPLATEPATH.'/old.comments.php';
    }

    return $file;
}

//sets the content width global variable

$GLOBALS['content_width'] = 620;

if (!isset($content_width)) {
    $content_width = 620;
}

//added for woocommerce support declaration

add_action('after_setup_theme', 'woocommerce_support');
function woocommerce_support()
{
    add_theme_support('woocommerce');
}

/* Disable Related products on single product pages */
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

/* exclude category */

/**
 * Recent_Posts widget w/ category exclude class
 * This allows specific Category IDs to be removed from the Sidebar Recent Posts list.
 */
class WP_Widget_Recent_Posts_Exclude extends WP_Widget
{
    public function __construct()
    {
        $widget_ops = array('classname' => 'widget_recent_entries', 'description' => __('The most recent posts on your site'));
        parent::__construct('recent-posts', __('Recent Posts with Exclude'), $widget_ops);
        $this->alt_option_name = 'widget_recent_entries';

        add_action('save_post', array(&$this, 'flush_widget_cache'));
        add_action('deleted_post', array(&$this, 'flush_widget_cache'));
        add_action('switch_theme', array(&$this, 'flush_widget_cache'));
    }

    public function widget($args, $instance)
    {
        $cache = wp_cache_get('widget_recent_posts', 'widget');

        if (!is_array($cache)) {
            $cache = array();
        }

        if (!isset($args['widget_id'])) {
            $args['widget_id'] = $this->id;
        }

        if (isset($cache[ $args['widget_id'] ])) {
            echo $cache[ $args['widget_id'] ];

            return;
        }

        ob_start();
        extract($args);

        $title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts') : $instance['title'], $instance, $this->id_base);
        if (empty($instance['number']) || !$number = absint($instance['number'])) {
            $number = 10;
        }
        $exclude = empty($instance['exclude']) ? '' : $instance['exclude'];

        $r = new WP_Query(array('posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'category__not_in' => explode(',', $exclude)));
        if ($r->have_posts()) :
?>
                <?php //echo print_r(explode(',', $exclude)); ?>
                <?php echo $before_widget;
        ?>
                <?php if ($title) {
    echo $before_title.$title.$after_title;
}
        ?>
                <ul>
                <?php  while ($r->have_posts()) : $r->the_post();
        ?>
                <li><a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID());
        ?>"><?php if (get_the_title()) {
    the_title();
} else {
    the_ID();
}
        ?></a></li>
                <?php endwhile;
        ?>
                </ul>
                <?php echo $after_widget;
        ?>
<?php
                // Reset the global $the_post as this query will have stomped on it
                wp_reset_postdata();

        endif;

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_recent_posts', $cache, 'widget');
    }

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];
        $instance['exclude'] = strip_tags($new_instance['exclude']);
        $this->flush_widget_cache();

        $alloptions = wp_cache_get('alloptions', 'options');
        if (isset($alloptions['widget_recent_entries'])) {
            delete_option('widget_recent_entries');
        }

        return $instance;
    }

    public function flush_widget_cache()
    {
        wp_cache_delete('widget_recent_posts', 'widget');
    }

    public function form($instance)
    {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $number = isset($instance['number']) ? absint($instance['number']) : 5;
        $exclude = esc_attr($instance['exclude']);
        ?>
                <p><label for="<?php echo $this->get_field_id('title');
        ?>"><?php _e('Title:');
        ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title');
        ?>" name="<?php echo $this->get_field_name('title');
        ?>" type="text" value="<?php echo $title;
        ?>" /></p>

                <p><label for="<?php echo $this->get_field_id('number');
        ?>"><?php _e('Number of posts to show:');
        ?></label>
                <input id="<?php echo $this->get_field_id('number');
        ?>" name="<?php echo $this->get_field_name('number');
        ?>" type="text" value="<?php echo $number;
        ?>" size="3" /></p>

                <p>
                        <label for="<?php echo $this->get_field_id('exclude');
        ?>"><?php _e('Exclude Category(s):');
        ?></label> <input type="text" value="<?php echo $exclude;
        ?>" name="<?php echo $this->get_field_name('exclude');
        ?>" id="<?php echo $this->get_field_id('exclude');
        ?>" class="widefat" />
                        <br />
                        <small><?php _e('Category IDs, separated by commas.');
        ?></small>
                </p>
<?php

    }
}

function WP_Widget_Recent_Posts_Exclude_init()
{
    unregister_widget('WP_Widget_Recent_Posts');
    register_widget('WP_Widget_Recent_Posts_Exclude');
}

add_action('widgets_init', 'WP_Widget_Recent_Posts_Exclude_init');

?>
