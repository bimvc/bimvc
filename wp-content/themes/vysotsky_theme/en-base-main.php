<?php
/*
Template Name: Knowledge Base
*/

$topDescription = get_field( "top_description" );
$alexandrQuote = get_field( "alexandr_vysotskiy_quoute" );
$testingDescript = get_field( "testing_description" );

?>
<?php get_header(); ?>
<div class="knowbase">
<div class="container" style="margin-top:100px;">
	<div class="row">
		<div class="col-sm-12">
			<div class="col-sm-12 col-lg-6">
				<h1>Knowledge Base</h1>
				<p><?php echo $topDescription; ?></p>
			</div>
			<div class="col-sm-12 col-lg-5 col-lg-offset-1">
				<div class="alex-quote">
					<p><?php echo $alexandrQuote; ?></p>
					<span>Alexander Vysotskiy,<br>CEO Vysotskiy Consulting</span>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="video-article">	
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="col-sm-8 video">
					<h2><a href="/en/base/video">Videocourses</a></h2>
					<div class="col-sm-12 nopadding">
						<?php 

							$args = array(
								'sort_order'   => 'ASC',
								'parent'       => 2842,
								'exclude_tree' => '',
								'number'       => '4',
								'offset'       => 0,
							); 
							$pages = get_pages($args);
							foreach($pages as $post){ setup_postdata($post);

						?>
							<a href="<?php the_permalink(); ?>">
								<div class="nopadding video__item">
									<?php echo get_the_post_thumbnail(); ?>
									<?php the_title(); ?>
								</div>
							</a>

						<?php } wp_reset_postdata(); ?>

					</div>
					<span class="all-items"><a href="/en/base/video/">All videocourses</a></span>
				</div>
				<div class="col-lg-4 article">
					<h2><a href="en/base/articles" class="h2">Articles</a></h2>

						<?php 

							$args = array(
								'parent'       => 2850,
								'number'       => '5',
								'offset'       => 0,
								'hierarchical' => 0,
							); 
							$pages = get_pages($args);
							foreach($pages as $post){ setup_postdata($post);

						?>
							<div class="article__item">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								<span><?php the_date('F, Y'); ?></span>
							</div>

						<?php } wp_reset_postdata(); ?>

					<span class="all-items"><a href="en/base/articles">All articles</a></span>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<div class="col-sm-7 testing">
				<h2><a href="en/base/testing" class="h2">Testing</a></h2>
				<p><?php echo $testingDescript; ?></p>

				<?php 

					$args = array(
						'sort_order'   => 'ASC',
						'sort_column'  => 'post_date',
						'parent'       => 93,
						'number'       => '3',
						'offset'       => 0,
					); 
					$pages = get_pages($args);
					foreach($pages as $post){ setup_postdata($post);

				?>
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

				<?php } wp_reset_postdata(); ?>

			</div>
			<div class="col-sm-4 col-sm-offset-1 base-feedback">
				<h2><a href="/en/base/successstories/" class="h2">Our customer<br>success stories</a></h2>

				<?php 

					$args = array(
						'sort_order'   => 'ASC',
						'sort_column'  => 'post_date',
						'parent'       => 2852,
						'exclude_tree' => '',
						'number'       => '4',
						'offset'       => 0,
					); 
					$pages = get_pages($args);
					foreach($pages as $post){ setup_postdata($post);

				?>
					<div class="article__item">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						<span><?php the_date('F, Y'); ?></span>
					</div>

				<?php } wp_reset_postdata(); ?>
			</div>
		</div>
	</div>
</div>
</div>
<?php get_footer(); ?>