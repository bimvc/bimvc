<?
/**
*
*  Template Name: News
*  
**/
get_header(); ?>
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
<div class="wrapper" style="margin-top:20px;">
	<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
	<script src="//yastatic.net/share2/share.js"></script>
	<div class="container">
		<div class="col-md-7">
			<?php 
				$args = array(
					'numberposts' => 5,
					'category'    => 0,
					'orderby'     => 'date',
					'order'       => 'DESC',
					'include'     => array(),
					'exclude'     => array(),
					'meta_key'    => '',
					'meta_value'  =>'',
					'post_type'   => 'post',
					'suppress_filters' => true,
				);
				$posts = get_posts( $args );
				foreach($posts as $post){ setup_postdata($post);
					?>
					<div class="row news news__single">
							<h2><?php the_title(); ?></h2>
							<div class="news__tags">
								<!-- <span><?php the_date( 'F Y' ); ?></span> -->
								<?php 
									$tags = get_tags();
									foreach ($tags as $tag){
										$tag_link = get_tag_link($tag->term_id);

										$html .= "<a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug} label label-info'>";
										$html .= "{$tag->name}</a>";
									}
									echo $html;
									$html = '';
								 ?>
							</div>
							<div class="news__text">
								<?php echo get_the_post_thumbnail( $page->ID ); ?>
								<?php the_content(); ?>
							</div>
							<div class="ya-share2" data-size="s" data-services="vkontakte,facebook,twitter,linkedin,telegram"></div>
					</div>
					<?php
				}
				wp_reset_postdata(); 
			?>
		</div>
		<div class="col-md-4 col-md-offset-1">
			<div class="row">
				<div class="news__baner">
					<p>Различная информация</p>
				</div>
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