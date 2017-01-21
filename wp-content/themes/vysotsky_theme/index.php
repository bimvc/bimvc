<?php get_header(); ?>
	<div class="container" style="margin-top:120px;">

			<div class="col-sm-9">
				<?php if ( have_posts() ) : ?>
				<?php /* The loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
				<?php endwhile; ?>
				<?php twentythirteen_paging_nav(); ?>
				<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
				<?php endif; ?>
			</div>
			<div class="col-sm-3">
				<?php get_sidebar(); ?>
			</div>

	</div>
</div>
<?php get_footer(); ?>
