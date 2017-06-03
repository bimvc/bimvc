<?php
/*
Template Name: Test (Let's Test)
*/
?>
<?php get_header(); ?>
<?php get_template_part( 'partials/content', 'sidebar' ); ?>
<div class="container emerge" data-effect="slide" style="padding:0;">
	<div class="row" style="margin-top:30px;">
		<div style='background:url("http://bim.vc/img/loading.gif") center center no-repeat'>
		<iframe id='letstest_frame' 
			scrolling='no' 
			onload="var f = document.getElementById('letstest_frame');window.addEventListener('message',function(e){var h=parseInt(e.data);if(h){f.height=h;}},false);"
			src="<?php echo get_field('link') ?>" 
			style='width:100%; min-height:500px; border:none; overflow-y: hidden;'>
		</iframe>

		</div>
	</div>
</div>
<?php get_footer(); ?>