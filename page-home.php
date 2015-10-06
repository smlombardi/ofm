<?php

/* template name: Home */


get_header();?>


<?php
		$args = array( 'post_type' => 'onourradar', 'posts_per_page' => 3, 'orderby' => 'date', 'order' => 'DESC' );
		$loop = new WP_Query( $args );
		while ( $loop->have_posts() ) : $loop->the_post(); ?>



		<?php endwhile;  ?>  <!-- end the loop -->



</div> <!-- close content -->
<?php get_sidebar(); ?>

<?php get_footer(); ?>
