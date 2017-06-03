<?php

/* Отключаем админ панель для всех пользователей */
show_admin_bar(false);

/* миниатюра */

add_theme_support( 'post-thumbnails' );


/* Отключаем переносы в редакторе */
remove_filter('the_content', 'wpautop');
remove_filter('the_excerpt', 'wpautop');

/* Меню */
register_nav_menus(array(
	'top'    => 'Верхнее меню',    //Название месторасположения меню в шаблоне
));
$args = array(
	'menu'            => 'Навигация',     // (string) Название выводимого меню (указывается в админке при создании меню, приоритетнее 
	'container'       => 'div',           // (string) Контейнер меню. Обворачиватель ul. Указывается тег контейнера (по умолчанию в тег div)
	'container_class' => 'collapse navbar-collapse',              // (string) class контейнера (div тега)
	'container_id'    => '',              // (string) id контейнера (div тега)
	'menu_class'      => 'nav navbar-nav navbar-right',          // (string) class самого меню (ul тега)
	'menu_id'         => '',              // (string) id самого меню (ul тега)
	'echo'            => true,            // (boolean) Выводить на экран или возвращать для обработки
	'fallback_cb'     => 'wp_page_menu',  // (string) Используемая (резервная) функция, если меню не существует (не удалось получить)
	'before'          => '',              // (string) Текст перед <a> каждой ссылки
	'after'           => '',              // (string) Текст после </a> каждой ссылки
	'link_before'     => '',              // (string) Текст перед анкором (текстом) ссылки
	'link_after'      => '',              // (string) Текст после анкора (текста) ссылки
	'depth'           => 0,               // (integer) Глубина вложенности (0 - неограничена, 2 - двухуровневое меню)
	'walker'          => '',              // (object) Класс собирающий меню. Default: new Walker_Nav_Menu
	'theme_location'  => ''               // (string) Расположение меню в шаблоне. (указывается ключ которым было зарегистрировано меню в функции register_nav_menus)
);
// function keep_me_logged_in_for_1_year( $expirein ) {
//  return 31556926; // 1 год в секундах
// }
// add_filter( 'auth_cookie_expiration', 'keep_me_logged_in_for_1_year' );

function login_by_email( $user, $username, $password ) {
	// если введен логин, то отправляем лесом
	if ( !is_email( $username ) ) 
		return;
 
	// получаем ID пользователя 
	if ( ! empty( $username ) )
		$user = get_user_by( 'email', $username );
 
	// подбираем соответствующее емейлу имя пользователя (логин)
	if ( isset( $user->user_login, $user ) )
		$username = $user->user_login;
 
	return wp_authenticate_username_password( NULL, $username, $password );
}
function cwc_member_check_shortcode( $atts, $content = null ) {
	if ( is_user_logged_in() && !is_null( $content ) && !is_feed() )
		return $content;
	return '';
}
add_shortcode( 'member', 'cwc_member_check_shortcode' );

//Переадресация после авторизации и регистрации
function custom_loginout_default_page($logout_url, $redirect) {
  $go_to_url = home_url( '/course' );
  if ( empty($redirect) )
    $logout_url = add_query_arg('redirect_to', urlencode($go_to_url), $logout_url);
  return $logout_url;
}
add_filter('logout_url', 'custom_loginout_default_page', 10, 2);

add_filter('private_title_format', 'bez_pristavki_zachicsheno');        // - личное.
add_filter('protected_title_format', 'bez_pristavki_zachicsheno');   // - защищенное паролем.
 
function bez_pristavki_zachicsheno($zagolovok) {
  return '%s';
}

function remove_menus(){
  remove_menu_page( 'edit-comments.php' );          //Комментарии          


}
add_action( 'admin_menu', 'remove_menus' );

// Register custom navigation walker
require_once('wp_bootstrap_navwalker.php');

//[pl]
function pl_func( $atts ){
	$register_url = wp_registration_url();
 return '<h5>Для прохождения курса <a href="#" data-toggle="modal" data-target="#registration">заполните анкету</a><br>или <a href="#" data-toggle="modal" data-target="#login">войдите</a></h5>';
}
add_shortcode( 'pl', 'pl_func', 'reg_func' );

//[plt]
function plt_func( $atts ){
	$register_url = wp_registration_url();
 return '<h5>Для прохождения теста <a href="#" data-toggle="modal" data-target="#registration">заполните анкету</a><br>или <a href="#" data-toggle="modal" data-target="#login">войдите</a></h5>';

}
add_shortcode( 'plt', 'plt_func');

//Название урока
function lesson( $atts, $content ) {

    return '<h4 id="buttons"><span>'. do_shortcode($content). '</span></h4>';
}

add_shortcode( 'lesson-title', 'lesson' );

//фрейм нужного размера
function video_container( $atts, $content ) {
	
return '<div class="youtube shadow" id="'.do_shortcode($content).'"></div>';

	}
add_shortcode( 'lesson-video', 'video_container' );

//блок
function block_func( $atts, $content ) {
		extract(shortcode_atts(array(
			'id' => 'tab',
			'class' => '',
			), $atts ) );
return '<div class="tab-pane ' . esc_attr($class) .'" id="' . esc_attr($id) .'">'.do_shortcode($content).'</div>';
}
add_shortcode( 'block', 'block_func' );

// TEST
function test_func($atts, $content = null){
extract(shortcode_atts(array(
			'img' => 'link',
			'testname' => 'default',
			'href' => 'link',
			), $atts ));
  ob_start();
  ?><div class="margin"> <div class="col-sm-8"> <div class="panel panel-default"> <div class="panel-heading"><h4><?php echo (esc_attr($testname)); ?></h4></div> <div class="text-body"> <?php echo ($content); ?> </div> </div> </div> <div class="col-sm-4 text-center"> <?php echo '<img style="max-width:100%;" class="shadow" src="' . esc_attr($img) .'" width="350">'; ?> <div class="margin"> <?php if ( is_user_logged_in() ) {echo '<a class="btn btn-default btn-lg" href="'. esc_attr($href) .'"> <span class="glyphicon glyphicon-play" aria-hidden="true"></span> Пройти тест</a>'; } else{echo do_shortcode('[plt]'); } ;?> </div> </div> </div> 
<?php $output_string = ob_get_contents(); ob_end_clean(); return $output_string;
}
add_shortcode('test', 'test_func');

// VIDEO
function video_func($atts, $content = null){
			extract(shortcode_atts(array(
			'img' => 'link',
			'videoname' => 'default',
			'href' => 'link',
			'type' => 'default',
			), $atts ));
  ob_start();
  ?> 
<div class="col-md-12 sm-margin emerge" data-effect="slide" data-continue="true"> <div class="col-sm-8"> <?php echo '<div class="panel panel-'. esc_attr($type) .'">';?> <div class="panel-heading"> <h4><?php echo (esc_attr($videoname)); ?></h4></div> <div class="panel-body"> <?php echo ($content); ?> </div> </div> </div> <div class="col-sm-4 text-center"> <?php echo' <a href="'. esc_attr($href) .'"><div class="shadow vid" style="background-image: url(' . esc_attr($img) .');" ><div class="pv"></div></a></div>'; ?> </div> </div>
<?php
  $output_string = ob_get_contents();
  ob_end_clean();
  return $output_string;
}
add_shortcode('video', 'video_func');

// НЕДОСТУПНЫЙ ТЕСТ
function cl_test_func($atts, $content){
			extract(shortcode_atts(array(
			'img' => 'link',
			'testname' => 'default',
			), $atts ));
  ob_start();
  ?><div class="margin"> <div class="col-sm-8"> <div class="panel panel-default"> <div class="panel-heading"><h4><?php echo (esc_attr($testname)); ?></h4></div> <div class="text-body"> <?php echo ($content); ?> </div> </div> </div> <div class="col-sm-4 text-center"> <?php echo '<img style="max-width:100%;" class="shadow" src="' . esc_attr($img) .'" width="350">'; ?> <?php if (is_user_logged_in()){echo'<div class="margin"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Доступ закрыт</div>'; } else {echo '<h5>Для прохождения теста <a href="#" data-toggle="modal" data-target="#registration">заполните анкету</a><br>или <a href="#" data-toggle="modal" data-target="#login">войдите</a></h5>'; }; ?> </div> </div> 
 <?php
  $output_string = ob_get_contents();
  ob_end_clean();
  return $output_string;
}
add_shortcode('cl_test', 'cl_test_func');

// навигация по блокам
function nav_block_func($atts, $content) {
	
  return '<div class="col-sm-4 pull-right"> <div class="tabbable tabs-right"> <ul class="nav nav-tabs emerge" style="font-size:13px;">' .do_shortcode($content). '</ul></div></div>';
}
add_shortcode('nav_block', 'nav_block_func');

function nav_li_func($atts, $content) {
	extract(shortcode_atts(array(
			'class' => '',
			'name' => '',
			'id' => '',
			), $atts ));
	return '<li class="' . esc_attr($class) . '"><a href="#tab' . esc_attr($id) . '" data-toggle="tab">' . esc_attr($content) . '</a></li>';
}
add_shortcode('nav_li', 'nav_li_func');


add_action( 'template_redirect', function() {
	if ( preg_match( '#^/wp-include/?$#i', $_SERVER['REQUEST_URI'] ) ) {
		wp_redirect( '/', 301 );
		exit;
	}
} );
add_action( 'template_redirect', function() {
	if ( preg_match( '#^/wp-include/?$#i', $_SERVER['REQUEST_URI'] ) ) {
		wp_redirect( '/', 301 );
		exit;
	}
} );

function n_nav_func($atts, $content) {
  return '<div class="col-sm-3" style="padding:0;"> <div class="panel-group scr" id="ad" role="tablist" aria-multiselectable="true"> <div class="panel"> <div class="nb"> <ul class="nt"> ' .do_shortcode($content). '</ul> </div> </div> </div> </div>'; }
add_shortcode('навигация', 'n_nav_func');


function n_li_func($atts, $content) {
	extract(shortcode_atts(array(
			'name' => '',
			'class' => '',
			'id' => '',
			), $atts ));

	return '<a href="#tab' . esc_attr($id) . '" data-toggle="tab"><li class="' . esc_attr($class) . '">' . esc_attr($name) . '</li></a>';
}
add_shortcode('пункт', 'n_li_func');

function pdz($atts, $content) {
	return '<h4>' . esc_attr($content) . '</h4>';
}
add_shortcode('подзаголовок', 'pdz');


add_filter('auth_cookie_expiration', 'my_expiration_filter', 99, 3);
function my_expiration_filter($seconds, $user_id, $remember){
    //if "remember me" is checked;
    if ( $remember ) {
        //WP defaults to 2 weeks;
        $expiration = 14*24*60*60; //UPDATE HERE;
    } else {
        //WP defaults to 48 hrs/2 days;
        $expiration = 90*24*60*60; //UPDATE HERE;
    }
    //http://en.wikipedia.org/wiki/Year_2038_problem
    if ( PHP_INT_MAX - time() < $expiration ) {
        //Fix to a little bit earlier!
        $expiration =  PHP_INT_MAX - time() - 5;
    }
    return $expiration;
}

function videofunc2($atts, $content) {
	extract(shortcode_atts(array(
			'name' => '',
			'link' => '',
			'id' => '',
			'class' => '',
		), $atts));
		if (is_user_logged_in()){
		return '<div class="tp ' . esc_attr($class) .'" id="tab' . esc_attr($id) .'"> <h4>' . esc_attr($name) . '</h4> <div class="youtube shadow" id="'.do_shortcode($link).'" style="margin-left:0;"></div> </div>'; }else{
		return '<div class="tp ' . esc_attr($class) .'" id="tab' . esc_attr($id) .'"> <h4>' . esc_attr($name) . '</h4> <div class="loginalert"> <div class="blalert"> Для проcмотра видеоурока <a href="#" data-toggle="modal" data-target="#registration">заполните анкету</a> <br>или <a href="#" data-toggle="modal" data-target="#login">войдите</a> </div> </div> <div style="background-image: url(http://i.ytimg.com/vi/'.do_shortcode($link).'/sddefault.jpg);" class="youtube2 shadow" style="margin-left:0;"></div> </div>'; };
}
add_shortcode('видео2', 'videofunc2');


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Видео 
function videofunc($atts, $content) {
	extract(shortcode_atts(array(
			'name' => '',
			'link' => '',
			'id' => '',
			'class' => '',
		), $atts));

		if (is_user_logged_in()){
			return '<div class="tp ' . esc_attr($class) . '" id="tab' . esc_attr($id) .'"><h4>' . esc_attr($name) . '</h4><div class="youtube shadow" id="'.do_shortcode($link).'"></div>' .do_shortcode($content). '</div>';
		}else{
			return '
			<div class="tp ' . esc_attr($class) . '" id="tab' . esc_attr($id) .'">
				<h4>' . esc_attr($name) . '</h4>
				<div class="loginalert2">
					<div class="blalert">
						Для проcмотра видеоурока <a href="#" data-toggle="modal" data-target="#registration">заполните анкету</a> 
						<br>или <a href="#" data-toggle="modal" data-target="#login">войдите</a>
					</div>
				</div>
				<div style="background-image: url(http://i.ytimg.com/vi/'.do_shortcode($link).'/sddefault.jpg);" class="youtube2 ver2 shadow" ></div>
				' .do_shortcode($content). '
			</div>
			';};

}
add_shortcode('видео', 'videofunc');


// описание
function description( $atts, $content ) {
		extract(shortcode_atts(array(
			), $atts ) );
return '<p>'. $content .'</p>';
	}
add_shortcode( 'описание', 'description' );

// теги
function tags( $atts, $content ) {
		extract(shortcode_atts(array(
			), $atts ) );
return '<p class="tags">'. $content .'</p>';
	}
add_shortcode( 'теги', 'tags' );

// навигация
function navigationfunc( $atts, $content ) {
		extract(shortcode_atts(array(
			), $atts ) );
return '<div class="col-sm-3" style="padding:0; margin-left:15px;">
				  				<div class="panel-group scr" id="accordion" role="tablist" aria-multiselectable="true">
				  					<div class="panel">
				  						<div class="nav-body">
											<ul class="nt">'. do_shortcode($content).'
											</ul>
				  						</div>
									</div>
				  				</div>
				  			</div>';}				  		
add_shortcode( 'навигация', 'navigationfunc' );

// раздел навигации
function razdel( $atts, $content ) {
		extract(shortcode_atts(array(
			), $atts ) );
return '<h5>'. $content .'</h5>';}
add_shortcode( 'раздел', 'razdel' );

// ссылка навигации
function navlinkfunc( $atts, $content ) {
		extract(shortcode_atts(array(
			'id' => '',
			'class' => '',
			), $atts ) );
return '<li class="'.esc_attr($class).'"><a href="#tab'.esc_attr($id).'" data-toggle="tab">'. $content .'</a></li>';}
add_shortcode( 'ссылка', 'navlinkfunc' );

// контент
function n_cont_func($atts, $content) {
  return '<div class="tc col-sm-8" style="margin-left:10px;">' .do_shortcode($content). '</div>';
}
add_shortcode('Контент', 'n_cont_func');

// блок в контенте
function cont_block_func($atts, $content) {
		extract(shortcode_atts(array(
			'id' => '',
			'class' => '',
			), $atts ) );

  return '<div id="tab'.esc_attr($id).'" class="tp '.esc_attr($class).'">' .do_shortcode($content). '</div>';
}
add_shortcode('блок', 'cont_block_func');

// заголовок в контенте
function h4($atts, $content) {
  return '<h4>' .do_shortcode($content). '</h4>';
}
add_shortcode('заголовок', 'h4');

// абзац в контенте
function p($atts, $content) {
  return '<p>' .do_shortcode($content). '</p>';
}
add_shortcode('абзац', 'p');

// отступ в контенте
function br($atts, $content) {
  return '<br><br>';
}
add_shortcode('отступ', 'br');

//файл
function file_func($atts, $content){
	extract(shortcode_atts(array(
			'href' => 'link',
			), $atts ));
return '<span class="file"><a href="'. esc_attr($href) .'"><span class="glyphicon glyphicon-file" aria-hidden="true" style="margin-right:10px"></span>'.do_shortcode($content).'</a></span><br>';}
add_shortcode('file', 'file_func');

//ajax-отправка формы

function sendfeedback($atts){

	$admin_email = get_option('admin_email');

	$from = htmlspecialchars($_POST['from']);
	$name = htmlspecialchars($_POST['name']);
	$message = htmlspecialchars($_POST['message']);
	$headers = "Content-Type: text/plain; charset=utf-8 \r\n";
	$headers .= 'From: '. $name . ' < '. $from . ' > ';

	mail( 'contact@bim.vc', 'Форма обратной связи', $message, $headers );

 	die();
 }

add_action( 'wp_ajax_sendfeedback', 'sendfeedback' );
add_action( 'wp_ajax_nopriv_sendfeedback', 'sendfeedback' );

// шорткод для баннера бм 2016
function bmBanner(){
	return '
	<script>$(document).ready(function(){$("#close").click(function(){$("#bm-banner").remove();});});</script>
	<div id="bm-banner" class="col-sm-12">
		<div class="info-board info-board_primary">
			<div class="info-board_header">
			<button id="close" type="button" class="close"><span aria-hidden="true">&times;</span></button></div>
			<div class="info-board__body"><h2>Авторский тренинг “BIM-менеджер”: юбилейный курс</h2><p>09 - 11 сентября 2016 года</p><p>Уникальный курс ориентированный на руководителей, проектировщиков и BIM-специалистов проектно-строительных компаний России и СНГ.</p>
			<a href="http://bim.vc/bm2016/"><button class="btn btn-success">Подробнее</button></a>
			</div>
		</div>
	</div>';
}
add_shortcode ('banner-bm-2016', 'bmBanner');

// виджет

// Creating the widget 
class wpb_widget extends WP_Widget {

function __construct() {
parent::__construct(	
// Base ID of your widget
'wpb_widget', 

// Widget name will appear in UI
__('WPBeginner Widget', 'wpb_widget_domain'), 

// Widget description
array( 'description' => __( 'Объявление в шапке', 'wpb_widget_domain' ), ) );
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {

$color = $instance['color'];
$before = '<div class="topAds__container" style="background-color: '.$color.';"><div class="container"><div class="topAds">';
$after = '</div>';

$link = $instance['link'];
$title = apply_filters( 'widget_title', $instance['title'] );
$btn = '<a href="'.$link.'"><button>Подробнее</button></a></div><span class="closeBanner">×</span></div>
<script>
$(".closeBanner").click(function(){
	$(this).parent(".topAds__container").hide();
	$(".topic").css("margin-top","65px");
});
</script>';



if ( ! empty( $title ) )
echo $before . $title . $after . $btn;
// This is where you run the code and display the output
echo '';

}		
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ])  || isset( $instance[ 'link' ]) || isset( $instance[ 'color' ]) ) {
	$title = $instance[ 'title' ];
	$link = $instance[ 'link' ];
	$color = $instance[ 'color' ];
}
else {
	$title = __( 'New title', 'wpb_widget_domain' );
	$link = __( 'New link', 'wpb_widget_domain' );
	$color = __( 'New color', 'wpb_widget_domain' );
}
// Widget admin form
?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Текст объявления:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Ссылка на "Подробнее":' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo $link; ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Цвет блока:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'color' ); ?>" name="<?php echo $this->get_field_name( 'color' ); ?>" type="text" value="<?php echo $color; ?>" />
		</p>
<?php 
}
// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['link'] = ( ! empty( $new_instance['link'] ) ) ? $new_instance['link'] : '';
		$instance['color'] = ( ! empty( $new_instance['color'] ) ) ? $new_instance['color'] : '';
		return $instance;
	}
} // Class wpb_widget ends here

// Register and load the widget
function wpb_load_widget() {
	register_widget( 'wpb_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );

register_sidebar(array(
    'name' => __('topHeader'),
    'id' => 'header-widget-area',
    'description' => __('Виджеты в шапке, например для баннера'),
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h3><a href="#">',
    'after_title' => '</a></h3>',
));


// shortcodes
// абзац

function abzacFunc($atts, $content){
			extract(shortcode_atts(array(
			'img' => 'link',
			'testname' => 'default',
			), $atts ));
  			ob_start();?>

<p style="margin-bottom: 20px; font-size: 15px; line-height: 20px;">
	<?php echo $content; ?>
</p>

<?php $output_string = ob_get_contents();
  ob_end_clean();
  return $output_string;
}
add_shortcode('abz', 'abzacFunc');


function quoteFunc($atts, $content){
	extract(shortcode_atts(array(
			'name' => 'name',
			'position' => 'position',
			'img' => 'img',
		), $atts));

	ob_start();?>
	<div class="alex-quote2">
		<div class="img" style="background-image: url(<?php echo esc_attr($img);?>);"></div>
		<div>
			<p style="font-size: 15px; font-style: italic;">«<?php echo $content;?>»</p>
			<span><?php echo esc_attr($name); ?>,<br><?php echo esc_attr($position); ?></span>
		</div>
	</div>
	<?php
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode('quote', 'quoteFunc');


function textFunc($atts, $content){
			extract(shortcode_atts(array(
			'img' => 'link',
			), $atts ));
  			ob_start();?>

<div class="row">
	<div class="col-md-8 col-xs-12">
		<?php echo $content; ?>
	</div>
</div>


<?php $output_string = ob_get_contents();
  ob_end_clean();
  return $output_string;
}
add_shortcode('text', 'textFunc');