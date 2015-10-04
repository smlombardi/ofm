<?php

/**
 * @package WordPress
 * @subpackage Cleanfrog
 */

get_header();?>


<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>

			
		<div class="post">
			
			
			<div class="entry">
				<?php the_content(''); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:'), 'after' => '</div>' ) ); ?>

			</div>
			<p class="pagemetadata"> 
			<?php edit_post_link('Edit', '', ''); ?></p></div>


<?php if ( comments_open() && $sa_settings['cf_pagecommentdisable'] == '') : ?>	
		<?php comments_template(); ?>
		<?php endif; ?>
<?php endwhile; ?>

<?php endif; ?></div>


<?php get_sidebar(); ?><?php get_footer(); ?>