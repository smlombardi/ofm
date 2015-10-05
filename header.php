<?php


 /**
  */
 if (!isset($sa_settings)) {
     $sa_settings = get_option('sa_options'); //gets the current value of all the settings as stored in the db
 }

global $sa_settings;

?>



<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head  profile="http://gmpg.org/xfn/11">
  <title><?php bloginfo('name'); ?><?php wp_title(); ?></title>

  <meta http-equiv="Content-Language" content="en">
  <meta name="description" content="">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

  <meta name="p:domain_verify" content="2c7d06a99910a5abaa87885533e0c92d"/>



  <link href="<?php bloginfo('stylesheet_url'); ?>" media="screen" rel="stylesheet" type="text/css" />

  <?php if ($sa_settings['cf_custom_css'] != '') {
    ?><!-- Here is the custom css -->

  <style type="text/css" media="screen">
    <?php echo stripcslashes($sa_settings['cf_custom_css']);
    ?>
  </style>

  <?php
} ?>

  <?php if (is_numeric($sa_settings['cf_headerfontsize'])) {
    ?>
  <style type="text/css">
    #header h1, #header h1 a{
    	font-size: <?php echo($sa_settings['cf_headerfontsize']);
    ?>px;
    }
  </style>

  <?php

} ?>



  <?php if (is_singular()) {
    wp_enqueue_script('comment-reply');
} ?>


  <?php //wp_get_archives('type=monthly&format=link'); ?><?php //comments_popup_script(); // off by default ?>

  <?php if ($sa_settings['cf_header_code'] != '') {
    echo stripslashes($sa_settings['cf_header_code']);
}?>

  <?php wp_head(); ?>

</head>


<?php flush(); ?>


<body <?php body_class(); ?>>

<div id="container" class="container">


  <div class="row">

	<div class="col-md-12 text-center">
	  <header>
	        <!-- header image -->
	        <a href="<?php echo home_url(); ?>">
	            <img class="img-responsive" src="<?php bloginfo('stylesheet_directory'); ?>/images/old-fashioned-mom-logo.jpg"/>
	        </a>
	  </header>
	</div>
</div>

<div class="row">
  <div class="col-md-12 text-center">
    <div class="cities-top">New York <span class="red-top">&#8226;</span> Paris <span class="red-top">&#8226;</span> London <span class="red-top">&#8226;</span> Palm Beach <span class="red-top">&#8226;</span> Hudson Valley</div>

  </div>
</div>

<div class="row">
  <div class="col-md-12 text-center no-pad">
    <div class="product-top"><a href="http://oldfashionedmomstore.org/">New!!! Shop Old Fashioned Mom Products!!!</a></div>
</div>
</div>


<div class="row">
  <div class="col-md-12 text-center no-pad">
     <div id="navbox">
			<?php
        $margs = array(
        'menu_id' => 'navbar',
        'container_class' => 'menu',
        'depth' => '2',
        );
        wp_nav_menu($margs);
      ?>
    </div>
    </div>



<div class="row">
  <div class="col-md-12 text-center">
    <div id="navbox">
        <?php wp_nav_menu(array('theme_location' => 'secondary-menu')); ?>
    </div>
</div></div>

<?php /*get_search_form();*/ ?>

<div id="navclearer"></div></div>


<div class="row">
  <div class="col-md-12 text-center">
<div id="contentcontainer">

  <div class="row">
    <div class="col-md-10">
  <div id="content">
