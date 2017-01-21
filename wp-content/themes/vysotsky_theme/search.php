<?php get_header(); ?>
<div class="container">
     <div class="row">
         <div class="col-sm-12">
			<div id="primary" class="content-area">
				<div id="content" class="site-content" role="main">
<?php if ( have_posts() ) : ?>
				<h2 class="headline first-child"><span><?php printf( __( 'Search Results for: %s', 'twentythirteen' ), get_search_query() ); ?></span></h2>
<?php /* The loop */ ?>
<?php while ( have_posts() ) : the_post(); ?>
<?php get_template_part( 'content', get_post_format() ); ?>
<?php endwhile; ?>

<?php else : ?>
<?php get_template_part( 'content', 'none' ); ?>
<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>
</div>
<?php get_footer(); ?>