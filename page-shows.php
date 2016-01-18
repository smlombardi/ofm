<?php

/* template name: Shows */


get_header();?>


<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>


		<div class="post">


			<div class="entry">
				<?php the_content(''); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:'), 'after' => '</div>' ) ); ?>

			</div>
			<p class="pagemetadata">
			<?php edit_post_link('Edit', '', ''); ?></p></div>

      <?php endwhile; ?>

<?php endif; ?>


 <?php
    $args = array( 'post_type' => 'video', 'posts_per_page' => 10, 'orderby' => 'date', 'order' => 'DESC' );
    $loop = new WP_Query( $args );
    while ( $loop->have_posts() ) : $loop->the_post(); ?>


    <div class="row">
    <div class="video small-12 columns text-center">
      <h1 class="video-title"><?php the_title(); ?></h1>
      <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php the_field('video_number'); ?>" frameborder="0" allowfullscreen></iframe>
      <div class="video-caption"><?php the_content(); ?></div>
      <img src="<?php bloginfo(stylesheet_directory); ?>/images/horizontal-element.jpg"/>
    </div>
    </div>


<?php endwhile;  ?>







</div>





</div> <!-- close content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
