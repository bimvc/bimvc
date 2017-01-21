<?php
/*
Template Name: Тест
*/
?>
<?php get_header(); ?>
<div class="topic emerge" data-effect="slide"><div class="container"><div class="row"><div class="col-sm-8" style="padding-left:15px;"><ol class="breadcrumb hidden-xs"><?php if(function_exists('bcn_display')) {bcn_display(); }?></ol></div><div class="col-sm-3 pull-right" style="padding: 16px 14px 0 12px; text-align:right;"><h6><?php if ( is_user_logged_in() ) : ?><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&ensp; <?php $current_user = wp_get_current_user(); echo '<b>' . $current_user->user_firstname . '</b> '; echo '<b>' . $current_user->user_lastname . '</b> '; ?> <?php else : ?> <!--<a href="#" class ="btn btn-theme-primary btn-xs" data-toggle="modal" data-target="#registration"> Регистрация</a>&ensp; --> <a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#login" title="Войти"> <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>&ensp;Вход</a> <?php endif; ?></h6></div></div></div></div><div class="container"><div class="emerge" data-effect="slide" style="padding:0;"><div class="row" style="margin-top:30px;"><?php /* The loop */ ?><?php while ( have_posts() ) : the_post(); ?><?php the_content(); ?><?php endwhile; ?></div></div></div>
<?php get_footer(); ?>