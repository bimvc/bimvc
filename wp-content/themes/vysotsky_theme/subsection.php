<?php
/*
Template Name: sub_menu
*/
?>
<?php get_header(); ?>
<?php get_template_part( 'partials/content', 'sidebar' ); ?>

<div class="container emerge" data-effect="slide" style="padding:0;">
	<div class="row" style="margin-top:30px;">
		<?php while ( have_posts() ) : the_post(); ?>
		<?php the_content(); ?>
		<?php endwhile; ?>
	</div>
</div>

<?php get_footer(); ?>