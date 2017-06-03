<?php get_header(); ?>
<?php get_template_part( 'partials/content', 'sidebar' ); ?>
<style>
.news__text img{
	max-width: 100% !important;
	height: auto !important;
}
</style>
<div class="wrapper" style="margin-top:20px;">
	<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
	<script src="//yastatic.net/share2/share.js"></script>
	<div class="container">
		<div class="col-md-7 nopadding">
		<h2><?php the_title(); ?></h2>
		<?php while ( have_posts() ) : the_post(); ?>
		<?php the_content(' '); ?>
		<?php endwhile; ?>
		</div>
		<div class="col-md-4 col-md-offset-1">
			<div class="row">
			</div>
		</div>
	</div>
</div>
<style>
	.news__single{
		margin-bottom: 40px;
	}
	.news__single h2{
		margin-bottom: 5px;
	}
	.news__text{
		margin-top: 5px;
	}
	.news__text div{
		margin: 10px 0;
	}
	.news__single span{
		display: inline-block;
	    font-size: 12px;
	}
	.news__tags a{
		display: inline-block;
		margin-right: 5px;
	}
	.ya-share2{
		margin-top: 10px;
	}
	.news__single img{
		display: block;
		margin: 20px 0;
	}
	.news__baner{
		margin-top: 12px;
	    padding: 10px;
	    border-radius: 1px;
	    box-shadow: inset 0 0 0 1px #ebebeb;
	}
</style>
<?php get_footer('new'); ?>