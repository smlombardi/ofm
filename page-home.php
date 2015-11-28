<?php

/* template name: Home */


get_header();?>
<!-- remember there is an open "row" tag and "med-10 columns" in the header.php -->

<!-- get the contents of the WP page first -->
<?php while (have_posts()) : the_post(); ?>
		<?php the_content(); ?>
<?php endwhile; ?>
	<!-- end page content -->

 <!-- videos (2 most recent) -->
 <?php
    $args = array( 'post_type' => 'video', 'posts_per_page' => 2, 'orderby' => 'date', 'order' => 'DESC' );
    $loop = new WP_Query( $args ); ?>

    <div class="row">
      <div class="small-12 columns text-center">
        <img src="<?php bloginfo(stylesheet_directory); ?>/images/ofm-500.png"/>
      </div>
    </div>

    <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>


    <div class="row">
    <div class="video small-12 columns text-center">
      <div class="video-title"><?php the_title(); ?></div>
      <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php the_field('video_number'); ?>?showinfo=0" frameborder="0" allowfullscreen></iframe>
      <div class="video-caption"><?php the_content(); ?></div>
      <img src="<?php bloginfo(stylesheet_directory); ?>/images/horizontal-element.jpg"/>
    </div>
    </div>


<?php endwhile;  ?>
<!-- end the loop -->
<div class="row">
  <div class="small-12 columns text-center">
    <a href="/shows/" class="view-all-episodes">View All Episodes »</a>
  </div>
</div>

<!-- main grid of posts -->
<ul class="medium-block-grid-3 spacer-top-md">
<?php
		// $categories = array(209,303,106,147,3,12,6,7,105,83,8,4,5);
		$categories = array(5,4,8,83,105,7,6,12,3,147,106,303,209);

		foreach($categories as $category) {
		$args = array( 'posts_per_page' => 1,'cat' => $category, 'orderby' => 'date', 'order' => 'DESC' );
		$cat_link = get_category_link( $category );
		$loop = new WP_Query( $args );

		while ( $loop->have_posts() ) : $loop->the_post(); ?>
		<li class="home-box">

			<div class="section-title">
				<a href="<?php echo esc_url( $cat_link ); ?>">
				<?php foreach((get_the_category()) as $category) { echo $category->cat_name . ' '; } ?>
				<a>
			</div>
				<? if ( has_post_thumbnail() ) { ?>
			<div class="image">
				<a href="<?php the_permalink(); ?>"><? the_post_thumbnail('home-square'); ?></a>
			</div>
			<?	} ?>
			<p class="link"><a href="<?php the_permalink(); ?>"><?php the_title() ; ?></a></p>
			<div class="excerpt"><?php the_excerpt() ; ?></div>

		</li>
		<?php endwhile;  ?>  <!-- end the loop -->
<?php } ; ?> <!-- end foreach -->

<li class="home-box">
	<div class="section-title">
		<a href="http://oldfashionedmomstore.org/">OFM Products</a>
	</div>
	<div class="image">
		<a href="http://oldfashionedmomstore.org/"><img src="/wp-content/uploads/2015/11/pink-grapefruit-marmalade-sugar-scrub-3jar.jpg" alt="Old Fashioned Mom Pink Grapefruit Marmalade Sugar Scrub" /></a>
	</div>
			<p class="link"><a href="http://oldfashionedmomstore.org/">Old Fashioned Mom Pink Grapefruit Marmalade Sugar Scrub!!</a></p>
	<div class="excerpt"><p>Delight in the purest ingredients on Earth as your skin soaks up pure organic oils while exfoliating the dead skin away. Leaving your skin feeling forever young!</p></div>
</li>

<li class="home-box">
	<div class="section-title">
		<a href="/ofm-event/">OFM Special Event</a>
	</div>
	<div class="image">
		<a href="/ofm-event/"><img src="/wp-content/uploads/2015/11/image1431.jpg" alt="" /></a>
	</div>
			<p class="link"><a href="/ofm-event/">Holiday Shopping Extravaganza</a></p>
	<div class="excerpt"><p>Benefitting the Children's Home of Poughkeepsie. Thursday, December 10<br>5-8pm <a href="/ofm-event/">Click for details!</a></p></div>
</li>


</ul>

</div>
</div> <!-- close content -->
<?php get_sidebar(); ?>

<?php get_footer(); ?>
