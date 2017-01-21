<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?>
<div class="blog">
<?php echo get_wp_user_avatar(); ?>
<div class="blog-desc">              
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
		<div class="entry-thumbnail">
		<?php the_post_thumbnail(); ?>
		</div>
		<?php endif; ?>
		<?php if ( is_single() ) : ?>
		<h2><?php the_title(); ?></h2>
		<?php else : ?>
		<h2>
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h2>
		<?php endif; // is_single() ?>
	</header>
    <hr><!-- .entry-header -->
<div class="text-muted">
     <?php twentythirteen_entry_meta(); ?>
     <?php edit_post_link( __( 'Edit', 'twentythirteen' ), '<span class="edit-link">', '</span>' ); ?>
</div>
	 <?php if ( is_search() ) : // Only display Excerpts for Search ?>
<div class="entry-summary">
	<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php
			/* translators: %s: Name of current post */
			the_content( sprintf(
				__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'twentythirteen' ),
				the_title( '<span class="screen-reader-text">', '</span>', false )
			) );

			wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
		?>
		<?php $description = tag_description(); 
echo $description;
?>
	</div>
</div>
	<?php endif; ?>
</article>        
</div>
