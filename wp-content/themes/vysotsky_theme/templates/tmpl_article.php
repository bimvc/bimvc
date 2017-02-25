<?php
/*
Template Name: Article
*/
?>
<?php get_header('new'); ?>
<style>
	main{
		margin-top: 70px;
	}
	.breadcrumb{
	    padding: 10px 15px;
	    margin-bottom: 0;
	}
	.breadcrumb h6{
	    text-align: right;
	    line-height: 20px;
	}
	.article__content .aligncenter{
	    margin: 0 auto !important;
	}
	.article__content img{
		box-shadow: 0 0 10px 0 rgba(0,0,0,0.5);
		display: block;
		margin: 0 auto;
	}
	.article__content p{
	    margin: 0 0 2rem;
	    line-height: 1.6;
	    font-size: 14px;
	    font-weight: 400;
	}
	iframe{
		text-align: center;
		margin: 0 auto;
		display: block;
	}
</style>
<main>
	<section class="breadcrumb">
		<div class="container">
			<div class="row">
				<div class="col-md-9">
					<ol class="breadcrumb">
						<?php 
							if(function_exists('bcn_display')){
							    bcn_display();
							}
						?>			
					</ol>
				</div>
				<div class="col-md-3">
			        <h6>
			        	<?php if ( is_user_logged_in() ) : ?>
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
	</section>
	<article>
		<div class="container">
			<div class="col-sm-12" style="margin-top:30px;">
				<h1><?php the_title(); ?></h1>
				<?php while ( have_posts() ) : the_post(); ?>
					<div class="row">
						<div class="col-md-9 col-sm-12 article__content" style="margin-bottom: 40px;">
							<?php the_content(); ?>
						</div>
					</div>	
				<?php endwhile; ?>
			</div>
		</div>
	</article>
</main>
<?php get_footer(); ?>