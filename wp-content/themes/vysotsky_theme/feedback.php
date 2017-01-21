<?php
/*
Template Name: subsection
*/
?>
<?php get_header(); ?>
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
<div class="container">
     <div class="row">
         <div class="col-sm-12">
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
						<div class="entry-thumbnail">
							<?php the_post_thumbnail(); ?>
						</div>
						<?php endif; ?>
						<!--<h2 class="headline first-child"><span><?php the_title(); ?></span></h2>-->
					</header><!-- .entry-header -->
					<center>
					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
					</div>
					</center>
				</article>
				<?php comments_template(); ?>
			<?php endwhile; ?>
		</div></div></div>
		</div><!-- #content -->
	</div><!-- #primary -->
<?php get_footer(); ?>