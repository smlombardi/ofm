<?php

/* template name: Home */


get_header();?>

<ul class="medium-block-grid-3">
<?php
		// $categories = array(209,303,106,147,3,12,6,7,105,83,8,4,5);
		$categories = array(5,4,8,83,105,7,6,12,3,147,106,303,209);

		foreach($categories as $category) {
		$args = array( 'posts_per_page' => 1,'cat' => $category, 'orderby' => 'date', 'order' => 'DESC' );
		$loop = new WP_Query( $args );

		while ( $loop->have_posts() ) : $loop->the_post(); ?>
		<li class="home-box">
			<div class="section-title"><?php foreach((get_the_category()) as $category) { echo $category->cat_name . ' '; } ?></div>


				<? if ( has_post_thumbnail() ) { ?>
			<div class="image">
				<? the_post_thumbnail(array(300, 300)); ?>
			</div>
			<?	} ?>
			<p class="link"><a href="<?php the_permalink(); ?>"><?php the_title() ; ?></a></p>
			<div class="excerpt"><?php the_excerpt() ; ?></div>

		</li>
		<?php endwhile;  ?>  <!-- end the loop -->
<?php } ; ?>


</ul>

</div>
</div> <!-- close content -->
<?php get_sidebar(); ?>

<?php get_footer(); ?>
