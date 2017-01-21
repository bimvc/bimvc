<?php
/*
Template Name: База знаний - Главная
*/
?>
<?php get_header(); ?>
<div class="knowbase">
<div class="container" style="margin-top:100px;">
	<div class="row">
		<div class="col-sm-12">
			<div class="col-sm-12 col-lg-6">
				<h1>База знаний</h1>
				<p>Миссия Vysotskiy Consulting — распространение профессиональных знаний по эффективной работе в BIM-среде.</p>
				<p>Помимо основной работы, мы уделяем большое внимание публикации открытой информации по информационному моделированию, доступной для всех посетителей нашего ресурса.</p>
			</div>
			<div class="col-sm-12 col-lg-5 col-lg-offset-1">
				<div class="alex-quote">
					<p>В Базе Знаний сосредоточны все необходимые знания для работы с BIM-технологиями.</p>
					<p>Если у вас сложная и уникальная задача — пишите, постараемся помочь.
					</p>
					<span>Александр Высоцкий,<br>Основатель Vysotskiy Consulting</span>
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
					<h2><a href="http://bim.vc/base/video">Видеокурсы</a></h2>
					<div class="col-sm-12 nopadding">
						<?php 

							$args = array(
								'sort_order'   => 'ASC',
								'parent'       => 395,
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
					<span class="all-items"><a href="http://bim.vc/base/video/">Все видеокурсы</a></span>
				</div>
				<div class="col-lg-4 article">
					<h2><a href="#" class="h2">Статьи</a></h2>

						<?php 

							$args = array(
								'parent'       => 1962,
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

					<span class="all-items"><a href="#">Все статьи</a></span>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<div class="col-sm-7 testing">
				<h2><a href="http://bim.vc/base/test" class="h2">Тестирования</a></h2>
				<p>В дополнение к нашим бесплатным видеокурсам по BIM-программам мы разработали уникальную бесплатную систему тестирования знаний.</p>

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
				<h2><a href="#" class="h2">Истории успеха наших&nbsp;заказчиков</a></h2>

				<?php 

					$args = array(
						'sort_order'   => 'ASC',
						'sort_column'  => 'post_date',
						'parent'       => 1966,
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