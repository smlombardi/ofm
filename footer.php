<?php


 /**

  */
 if (!isset($sa_settings)) {
     $sa_settings = get_option('sa_options'); //gets the current value of all the settings as stored in the db
 }

?>

<div id="clearer">

</div>

</div>

</div>



<footer>
<div class="row">
  <div class="col-md-12">

	<div id="footcontain">

	<ul class="footbar" id="footer-center"><li></li>

	<?php dynamic_sidebar(3); ?>

	</ul>


			<p class="hardfoot">Old Fashioned Mom Magazine | Copyright &copy; <?php echo date('Y'); ?> | <a href="mailto:mmh@oldfashionedmom.org" target="_top">Advertising</a><br /><a href="mailto:mmh@oldfashionedmom.org" target="_top">

Contact Michelle-Marie Heinemann: mmh@oldfashionedmom.org</a></p>





	</div>

</div>
</div>

</footer>

<?php if ($sa_settings['cf_analytics_code'] != '') {
    ?>

<?php echo(stripslashes($sa_settings['cf_analytics_code']));
    ?>

<?php
} ?>



<?php wp_footer(); ?>

</body>



</html>
