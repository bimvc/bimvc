<?php
/*
Template Name: Курс
*/
?>
<?php get_header(); ?>
<?php get_template_part( 'partials/content', 'sidebar' ); ?>

<div class="container emerge" data-effect="slide" style="padding:0;">
    <div class="row" style="margin-top:30px;">
        <div class="col-sm-12 emerge">
        	<?php while ( have_posts() ) : the_post(); ?>
        		<?php the_content(); ?>
        	<?php endwhile; ?>
        </div>
    </div>
</div>
<script src="/wp-content/themes/vysotsky_theme/js/my/hashLinkClick.js"></script>
<?php get_footer(); ?>