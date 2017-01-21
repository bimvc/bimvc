<?php
/*
Template Name: Статья
*/
?>
<?php get_header(); ?>
<div class="topic emerge" data-effect="slide">
	<div id="sidebar">
	<?php 
	   if ( is_active_sidebar( 'header-widget-area' ) ){
	            dynamic_sidebar( 'header-widget-area' ); 
	      };
	?>
	</div>
    <div class="container">
      <div class="row">
        <div class="col-sm-9" style="padding-left:15px;">
          <ol class="breadcrumb hidden-xs">
		    <?php if(function_exists('bcn_display'))
		    {
		        bcn_display();
		    }?>
          </ol>
        </div>     	
        <div class="col-sm-3 pull-right" style="padding: 16px 14px 0 12px; text-align:right;">
	        <h6><?php if ( is_user_logged_in() ) : ?>
			<span class="glyphicon glyphicon-user" aria-hidden="true"></span>&ensp;	
			<?php $current_user = wp_get_current_user();
			echo '<b>' . $current_user->user_firstname . '</b> ';
			echo '<b>' . $current_user->user_lastname . '</b> ';
			?>
			<?php else : ?>
			<a href="#" class ="btn btn-theme-primary btn-xs" data-toggle="modal" data-target="#registration">
			Регистрация</a>&ensp;
			<a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#login" title="Войти">
			<span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>&ensp;Вход</a>
			<?php endif; ?>	
			</h6>
        </div>
      </div>
    </div>
</div>
<!-- content -->
<div class="container emerge" data-effect="slide" style="padding:0;">
	<div class="col-sm-12" style="margin-top:30px;">
			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
			<div class="row"><div class="col-md-9" style="margin-bottom: 40px;"><h1><?php the_title(); ?></h1></div></div>	
			<?php the_content(); ?>
			<?php endwhile; ?>
	</div>
</div>
<!-- content -->
<?php get_footer(); ?>