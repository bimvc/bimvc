<?php
/**
 * The VISOTSKY THEME
 */
?>
<!DOCTYPE html> 
<html lang="ru">
   <head>
      <title><?php bloginfo('name'); ?> <?php wp_title('|'); ?></title>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
      <meta name="description" content="Мы обучаем BIM-технологиям. Результат нашей работы - новый уровень проектирования.">
      <meta name="keywords" content="bim, bim-технологии, bim проектирование, bim моделирвание, bim технологии в проектировании, bim-менеджер, внедрение bim, bim модель, bim проект, моделирование зданий bim, bim в строительстве, уроки revit, курсы revit, revit видео, autodesk revit, revit 2015, revit 2016, revit architecture, revit mep, revit видео, revit самоучитель, revit для начинающих, navisworks">
      <link rel="shortcut icon" href="<?php echo get_template_directory_uri().'/img/favicon.ico'; ?>">
      <link rel="stylesheet" href="/libs/bootstrap/bootstrap-reboot.min.css">
      <link rel="stylesheet" href="/libs/bootstrap/bootstrap.min.css">
      <link href="<?php echo get_template_directory_uri().'/style.css'; ?>" rel="stylesheet">
      <style>
         .topHeader{
            padding-top: 0;
         }
         .topHeader__menu{
            flex-direction: row;
         }
      </style>
      <link href="http://fonts.googleapis.com/css?family=Open+Sans:700,400&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
      <script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
      <script src="<?php echo get_template_directory_uri().'/js/emerge.js'; ?>"></script>
      <script async src="<?php echo get_template_directory_uri().'/js/bootstrap/bootstrap.min.js'; ?>"></script>
      <script async src="<?php echo get_template_directory_uri().'/js/system.js'; ?>"></script>
   </head>
   <body>
      <header class="navbar navbar-default navbar-fixed-top topHeader" role="navigation">
         <div class="container" style="overflow: hidden;">
            <div class="navbar-header">
	            <a class="navbar-brand" href="<?php echo get_home_url(); ?>">
	            <img src="<?php echo get_template_directory_uri().'/img/VC.jpg'; ?>"></a>
	            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	            <span class="sr-only"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            </button>
            </div>
            <div class="collapse navbar-collapse menuHeader">
               <div>
	            <?php wp_nav_menu( 
                        array(
                           'menu' => 'Меню 1', 
                           'depth' => 2, 
                           'container' => false, 
                           'menu_class' => 'nav navbar-nav topHeader__menu', 
                           'walker' => new wp_bootstrap_navwalker()
                        ) 
               ); ?>
               </div>
               <div>
                  <ul class="langflags">
                     <?php 
                        $args = array(
                        'show_flags' => 1,
                        'show_names'=> 0
                        ); 
                        pll_the_languages($args); 
                     ?>
                  </ul>
               </div>
            </div>
         </div>
      </header>