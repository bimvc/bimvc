<?php
/*
Template Name: promo
*/
?>
<?php get_header(); ?>
<!-- content -->
<div class="emerge" data-effect="slide">
		<?php /* The loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>
		<?php the_content(); ?>
		<?php endwhile; ?>
</div>
<!-- content -->
<?php get_footer(); ?>