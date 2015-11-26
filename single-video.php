<?php

/**
 * @package WordPress
 * @subpackage Cleanfrog
 */

get_header();?>



<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>

	<div class="post">

			<div class="entry">
				<div class="row">
					<div class="small-12 columns text-center ">
            <img src="<?php bloginfo(stylesheet_directory); ?>/images/ofm-500.png"/>
						<h1 class="video-title"><?php the_title(); ?></h1>
					</div>
				</div>
				<div class="row">
        <div class="video small-12 columns text-center">
          <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php the_field('video_number'); ?>?showinfo=0" frameborder="0" allowfullscreen></iframe>
        </div>

				</div>

				<?php the_content(); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:'), 'after' => '</div>' ) ); ?>
			</div>
			<p class="postmetadata">
			<span class="cat">Posted in <?php the_category(', ') ?></span>
			</p>

	</div>
		<?php comments_template(); ?>

<?php endwhile; ?>

<?php endif; ?></div>

</div>
<?php get_sidebar(); ?><?php get_footer(); ?>
