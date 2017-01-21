<?php
/*
Template Name: База Знаний
*/
?>
<?php get_header(); ?>

<!-- content -->
<div class="container">
     <div class="row" style="margin-top:100px;">
			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
			<?php the_content(); ?>
			<?php endwhile; ?>
	</div>
</div>
<!-- content -->
<?php get_footer(); ?>