<?php
/*
Template Name: All Of Theme
*/
?>
<?php get_header('new'); ?>
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
		<?php 
			$ancestors = get_ancestors( 208, 'category' );
			foreach ($ancestors as $key => $value) {
				echo $key;
			}
		 ?>
			<ul class="list-unstyled">
				<?php 

					$args = array(
						'sort_order'   => 'ASC',
						'parent'       => 2850,
						'exclude_tree' => '',
						'number'       => '4',
						'offset'       => 0,
					); 
					$pages = get_pages($args);
					foreach($pages as $post){ setup_postdata($post);

				?>
					<li>
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</li>
				<?php } wp_reset_postdata(); ?>			
				</ul>
		</div>
	</article>
</main>