<?php

/* template name: Home */


get_header();?>

<div class="row">
<?php
		$categories = array(209,303,106,147,3,12,6,7,105,83,8,4,5);
		foreach($categories as $category) {
		$args = array( 'posts_per_page' => 1,'cat' => $category, 'orderby' => 'date', 'order' => 'DESC' );
		$loop = new WP_Query( $args );

		while ( $loop->have_posts() ) : $loop->the_post(); ?>
		<div class="col-md-4">

			<?php the_title() ; ?>
			<?php the_excerpt() ; ?>


		</div>
		<?php endwhile;  ?>  <!-- end the loop -->
<?php } ; ?>


</div>


</div> <!-- close content -->
<?php get_sidebar(); ?>

<?php get_footer(); ?>
