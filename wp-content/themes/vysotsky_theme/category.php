<?php
/**
 * The template for displaying Category pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>
<!-- #top_bar -->
      <div class="topic">
        <div class="container">
          <div class="row">
            <div class="col-sm-12">
              <ol class="breadcrumb pull-right hidden-xs">
            <?php if(function_exists('bcn_display'))
            {
                bcn_display();
            }?>
              </ol>
            </div>
          </div>
        </div>
      </div>
<!-- #/topbar -->
<div class="container">
     <div class="row">
         <div class="col-sm-9">
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
		<?php if ( have_posts() ) : ?>
			<header class="archive-header">
				<!--<h1 class="archive-title"><?php printf( __( 'Category Archives: %s', 'twentythirteen' ), single_cat_title( '', false ) ); ?></h1>-->

				<?php if ( category_description() ) : // Show an optional category description ?>
				<div class="archive-meta"><?php echo category_description(); ?></div>
				<?php endif; ?>
			</header><!-- .archive-header -->
			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>
</div></div>
			<?php twentythirteen_paging_nav(); ?>

		<?php else : ?>


</div>
			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>
		</div><!-- #content -->
	</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
