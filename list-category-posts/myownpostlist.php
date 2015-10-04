<?php
$lcp_display_output = '';
$lcp_display_output .= '<ul>';
foreach ($this->catlist->get_categories_posts() as $single):
$lcp_display_output .= '<li>';
$lcp_display_output .= $this->get_post_title($single);
$lcp_display_output .= $this->get_date($single);
$lcp_display_output .= $this->get_thumbnail($single);
$lcp_display_output .= $this->get_excerpt($single, 'p', 'your p style');
$lcp_display_output .= '<br /><a href="'.get_permalink($single->ID).'">Read more</a>';
$lcp_display_output .= '</li>';
endforeach;
$lcp_display_output .= '</ul>';
$this->lcp_output = $lcp_display_output;
?>
