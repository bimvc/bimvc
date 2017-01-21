<?
/*

Template Name: main_section


*/
?>
<?php get_header(); ?>
<!-- content -->
	<div class="wrapper" style="margin-top:100px;">
		<div class="container">
				<?php /* The loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
				<?php the_content(); ?>
				<?php endwhile; ?>
		</div>
	</div>
<!-- content -->
<?php get_footer(); ?>