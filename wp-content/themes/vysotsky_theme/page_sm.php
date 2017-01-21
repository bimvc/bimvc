<?php
/*
Template Name: Page With Sub Menu
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
<!-- content -->
<div class="container">
     <div class="row" style="margin-top:30px;">
			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
			<?php the_content(); ?>
			<?php endwhile; ?>
	</div>
</div>
<!-- content -->
<?php get_footer(); ?>