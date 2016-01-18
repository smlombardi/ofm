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

// removed options page from UI.  It will only mess up new code

// if (is_admin()) {
//     $functions_path = TEMPLATEPATH.'/options/';
//   //Theme Options
//   require_once $functions_path.'options.php';
// }

//END New options page

function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );


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
    //add_custom_background();

    function remove_customize_page(){
    	global $submenu;
    	unset($submenu['themes.php'][6]); // remove customize link
    }
    add_action( 'admin_menu', 'remove_customize_page');


function new_excerpt_more($more)
{
    global $post;
    return '...<a class="read-more" href="'.get_permalink($post->ID).'">Read More&nbsp;&raquo;</a>';
}

add_filter('excerpt_more', 'new_excerpt_more');

      function register_menus()
      {
        register_nav_menus(
          array(
            'header-menu' => __('Header Menu'),
            'primary-menu' => __('Primary Menu'),
            'secondary-menu' => __('Secondary Menu')
          )
        );
      }

      add_action('init', 'register_menus');

//Enques the custom scripts

if (!is_admin()) { // instruction to only load if it is not the admin area

  wp_register_script( 'jquery-js', get_template_directory_uri() . '/js/jquery.min.js', array( 'jquery' ), '3.0.1', true );

// this was loading JQuery a second time and breaking Foo Gallery, so commented out
//  wp_enqueue_script('jquery-js');

  // Collapser script
   wp_register_script('collapser',

   get_template_directory_uri().'/js/collapser.js', array('jquery'), '1.0');

   // enqueue the script
   wp_enqueue_script('collapser');
}


function my_foundation_theme_scripts() {
//  wp_register_script( 'foundation-js', get_template_directory_uri() . '/foundation/js/foundation.min.js');
  wp_register_style( 'foundation-css', get_template_directory_uri() . '/foundation/css/foundation.css' );
  wp_register_style( 'google-font', 'https://fonts.googleapis.com/css?family=Lora:400,400italic,700,700italic' );
  $ourFile_version = filemtime(dirname(__FILE__). "/style.css");
  wp_register_style( 'main-css', get_template_directory_uri() . '/style.css', true, $ourFile_version );

//  wp_enqueue_script( 'foundation-js' );
  wp_enqueue_style( 'foundation-css' );
  wp_enqueue_style( 'google-font' );
  wp_enqueue_style( 'main-css' );

  if ( is_singular() && comments_open() && get_option('thread_comments') )
    wp_enqueue_script( 'comment-reply');

}

add_action('wp_enqueue_scripts', 'my_foundation_theme_scripts');


//Loads an old comments.php file if wordpress does not support the new comment methods

add_filter('comments_template', 'legacy_comments');

function legacy_comments($file)
{
    if (!function_exists('wp_list_comments')) {
        $file = TEMPLATEPATH.'/old.comments.php';
    }

    return $file;
}


add_action( 'init', 'create_post_type' );
function create_post_type() {
	register_post_type( video,
		array(
			'labels' => array(
				'name' => __( 'Videos' ),
				'singular_name' => __( 'Video' ),
				'add_new' => _x('Add Video', 'videos'),
				'add_new_item' => __('Add Video'),
				'edit' => _x('Edit Videos', 'Videos'),
				'edit_item' => __('Edit Video'),
				'new_item' => __('New Video'),
				'view' => _x('View Video', 'videos'),
				'view_item' => __('View Video')
			),
		'menu_icon' => 'dashicons-video-alt3',
		'public' => true,
		'has_archive' => true,
		'menu_position' => 5,
		'supports' => array('title','editor','thumbnail', 'excerpt'),
		'capability_type' => 'page',
		'map_meta_cap' => true
		)
	);
};

// Exclude images from search results - WordPress
add_action( 'init', 'exclude_images_from_search_results' );
function exclude_images_from_search_results() {
	global $wp_post_types;

	$wp_post_types['attachment']->exclude_from_search = true;
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


add_action( 'after_setup_theme', 'wpdocs_theme_setup' );
function wpdocs_theme_setup() {
    add_image_size( 'home-square', 350, 350, array( 'left', 'top' ) ); // 300 pixels wide (and unlimited height)
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
        if ($r->have_posts()) : ?>
        <?php //echo print_r(explode(',', $exclude)); ?>
        <?php echo $before_widget;  ?>
        <?php if ($title) {
            echo $before_title.$title.$after_title;
            }  ?>
            <ul>
            <?php  while ($r->have_posts()) : $r->the_post();  ?>
            <li><a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID());  ?>"><?php if (get_the_title()) {
                the_title();
            } else {
                the_ID();
            }  ?></a></li>
        <?php endwhile;  ?>
        </ul>
        <?php echo $after_widget;  ?>
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
        $exclude = esc_attr($instance['exclude']);  ?>
        <p><label for="<?php echo $this->get_field_id('title');  ?>"><?php _e('Title:');  ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title');  ?>" name="<?php echo $this->get_field_name('title');  ?>" type="text" value="<?php echo $title;  ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('number');  ?>"><?php _e('Number of posts to show:');  ?></label>
        <input id="<?php echo $this->get_field_id('number');  ?>" name="<?php echo $this->get_field_name('number');  ?>" type="text" value="<?php echo $number;  ?>" size="3" /></p>

        <p>
          <label for="<?php echo $this->get_field_id('exclude');  ?>"><?php _e('Exclude Category(s):');  ?></label> <input type="text" value="<?php echo $exclude;  ?>" name="<?php echo $this->get_field_name('exclude');  ?>" id="<?php echo $this->get_field_id('exclude');  ?>" class="widefat" />
          <br />
          <small><?php _e('Category IDs, separated by commas.');  ?></small>
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
