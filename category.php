<?php

/**
 * @package WordPress
 * @subpackage Cleanfrog
 */

get_header();?>



<?php if(have_posts()) : ?>
 <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
 	  <?php /* If this is a category archive */ if (is_category()) { ?>
		<h2 class="pagetitle"><?php single_cat_title(); ?></h2>
 	  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
		<h2 class="pagetitle">Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h2>
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h2 class="pagetitle">Archive for <?php the_time('F jS Y'); ?></h2>
 	  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h2 class="pagetitle">Archive for <?php the_time('F Y'); ?></h2>
 	  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h2 class="pagetitle">Archive for <?php the_time('Y'); ?></h2>
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h2 class="pagetitle">Author Archive</h2>
 	  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h2 class="pagetitle">Blog Archives</h2>
 	  <?php } ?>


		<ul class="medium-block-grid-3 small-block-grid-1">
<?php while(have_posts()) : the_post(); ?>

		  <li>
		    <div class="post">
		    <div class="posthead">
		    <!-- <div class="dater">

		    <p class="day"><a href="<?php the_permalink(); ?>" ><?php the_time('j'); ?></a></p>
		    <p class="monthyear"><a href="<?php the_permalink(); ?>" ><?php the_time('M y'); ?></a></p>
		    </div> -->

		      <h2 class="cat-post-head"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		          <p class="date"><?php the_date(); ?></p>

		      </div>


		      <div class="entry">
            <? if ( has_post_thumbnail() ) { ?>
    			<div class="image">
    				<? the_post_thumbnail('home-square'); ?>
    			</div>
    			<?	} ?>


		        <?php the_excerpt('Read More &raquo;'); ?>
		        <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'cleanfrog' ), 'after' => '</div>' ) ); ?>
		      </div>
		      <!-- <p class="postmetadata">
		      <span class="comm"><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></span>
		      <?php edit_post_link('Edit', '&nbsp;|&nbsp;', ''); ?>
		      <?php if ($sa_settings['cf_hidetags'] == '') { the_tags('<br /><span class="tags">Tags: ',', ', '</span>'); } ?>
		      </p> -->
		    </div>
		  </li>

<?php endwhile; ?>
		</ul>
		<div class="navigation">

			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		</div>

<?php endif; ?></div>

</div>

<?php get_sidebar(); ?><?php get_footer(); ?>
