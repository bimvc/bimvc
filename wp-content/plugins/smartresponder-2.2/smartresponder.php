<?php
/*
Plugin Name: Smartresponder
Plugin URI: http://smartresponder.ru
Description: Smartresponder plugin
Version: 2.2
Author: Smartresponder
Author URI: http://smartresponder.ru
*/

// Smartresponder WP Plugin Admin Menu
function smartresponder_wp_plugin_admin_menu() {
    if(function_exists('add_options_page')) {
        $admin_page = add_options_page('Smartresponder', 'Smartresponder', 8, 'smartresponder', 'smartresponder_wp_plugin_admin_menu_form');
	add_action( "admin_print_scripts-$admin_page", 'smartresponder_wp_plugin_admin_menu_form_head');
    }
}

// Smartresponder WP Plugin Admin Menu Form Head
function smartresponder_wp_plugin_admin_menu_form_head() {
    $plugindir = get_settings('home').'/wp-content/plugins/'.dirname(plugin_basename(__FILE__));
    // Include Smartresponder
    wp_enqueue_script('loadjs', $plugindir . '/smartresponder.js');
    echo '<link rel="stylesheet" href="'.$plugindir.'/smartresponder.css" type="text/css" />';
    
    // Include JQuery
    wp_deregister_script('jquery');
    wp_register_script('jquery', $plugindir . '/include/jquery.min.js');
    wp_enqueue_script('jquery');
    
    // Include Bootstrap
    wp_deregister_script('bootstrap');
    wp_register_script('bootstrap', $plugindir . '/include/bootstrap/js/bootstrap.min.js');
    wp_enqueue_script('bootstrap');
    echo '<link rel="stylesheet" href="'.$plugindir.'/include/bootstrap/css/bootstrap.min.css" type="text/css" />';
    
    // Include Minicolors
    echo '<link rel="stylesheet" href="'.$plugindir.'/include/jquery-miniColors-master/jquery.minicolors.css" type="text/css" />';
   
    // Include Pagination    
    wp_deregister_script('pagination');
    wp_register_script('pagination', $plugindir . '/include/mattpage-jquery.paginateTable/jquery.paginatetable.js');
    wp_enqueue_script('pagination');
        
}

// Get content with cURL
function sr_get_content($link, $data) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $link);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $result = curl_exec($ch);   

    return $result;
}

// Start session
session_start();

// Synchronization
function smartresponder_wp_plugin_sync() {
    $api_key = htmlspecialchars($_GET['api_key']);
            
    $link = 'http://api.smartresponder.ru/account.html';

    $data = array();
    $data['format'] = 'json';
    $data['action'] = 'info';
    $data['api_key'] = $api_key;

    $result = sr_get_content($link, $data);
    $obj = json_decode($result);
    if($obj->result == '1') {
        $_SESSION['api_key'] = $api_key;
    }
    echo $result;
    
    die();
}

add_action('wp_ajax_sync', 'smartresponder_wp_plugin_sync');

// Get Deliveries
function smartresponder_wp_plugin_get_deliveries() {
    $api_key = $_SESSION['api_key'];

    $link = 'http://api.smartresponder.ru/deliveries.html';

    $data = array();
    $data['format'] = 'json';
    $data['action'] = 'list';
    $data['api_key'] = $api_key;

    $result  = sr_get_content($link, $data);

    echo $result;
    
    die();
}

add_action('wp_ajax_get_deliveries', 'smartresponder_wp_plugin_get_deliveries');

// Get Deliveries
function smartresponder_wp_plugin_get_groups() {
    $api_key = $_SESSION['api_key'];

    $link = 'http://api.smartresponder.ru/groups.html';

    $data = array();
    $data['format'] = 'json';
    $data['action'] = 'list';
    $data['api_key'] = $api_key;

    $result  = sr_get_content($link, $data);

    echo $result;
    
    die();
}

add_action('wp_ajax_get_groups', 'smartresponder_wp_plugin_get_groups');

// Get Tracks
function smartresponder_wp_plugin_get_tracks() {
    $api_key = $_SESSION['api_key'];

    $link = 'http://api.smartresponder.ru/tracks.html';

    $data = array();
    $data['format'] = 'json';
    $data['action'] = 'list';
    $data['api_key'] = $api_key;

    $result  = sr_get_content($link, $data);

    echo $result;
    
    die();
}

add_action('wp_ajax_get_tracks', 'smartresponder_wp_plugin_get_tracks');

// Create Widget
function smartresponder_wp_plugin_widget() {
    global $wpdb;
    $html = $_POST['html'];
    if(strlen($html) > 0) {
        $create_table_sql = 'CREATE TABLE IF NOT EXISTS wp_sr_form (`id` int AUTO_INCREMENT PRIMARY KEY, `form_html` text) ENGINE=InnoDB DEFAULT CHARSET=utf8';
        $wpdb->query($create_table_sql);
        $insert_form_html = "INSERT INTO `wp_sr_form`(`form_html`) VALUES ('$html')";
        $wpdb->query($insert_form_html);
        smartresponder_init();
        echo json_encode('ok');
    }
    else {
        echo json_encode('bad');
    }
    
    die();
}

add_action('wp_ajax_widget', 'smartresponder_wp_plugin_widget');

function smartresponderOutput() {
    global $wpdb;
    $plugindir = get_settings('home').'/wp-content/plugins/'.dirname(plugin_basename(__FILE__));
    $homepage = file_get_contents($plugindir.'/form.html');
    $sql = 'SELECT form_html FROM wp_sr_form WHERE id = (SELECT MAX(id) FROM wp_sr_form)';
    $result = $wpdb->get_var($sql);
    echo $homepage.$result;
}

function widget_smartresponderSubscribeForm() {
    smartresponderOutput();
}

function smartresponder_init()
{
    register_sidebar_widget(__('Smartresponder subscribe form',"smartresponder"), 'widget_smartresponderSubscribeForm');
}

add_action("plugins_loaded", "smartresponder_init");

// Get Users
function smartresponder_wp_plugin_users() {
    global $wpdb;	
	$cnt = !empty($_POST['cnt']) ? (int)$_POST['cnt'] : 100;
	$page = !empty($_POST['page']) ? (int)$_POST['page'] : 1;
	$start = ($page-1)*$cnt;
	$whereClause = '';
    $query = "SELECT id, user_nicename, user_email, user_registered FROM $wpdb->users";
	$qTotal = "SELECT count(id) as cnt FROM $wpdb->users";
    if(isset($_POST['period']) or isset($_POST['email'])) {
        $data_mode = $_POST['period'];
        $email = $_POST['email'];
        if(strlen($data_mode) > 0) {
            if($data_mode == 'TODAY') {
                $whereClause= "WHERE user_registered = date(now()) AND user_email LIKE '%$email%' $send_users_ch ORDER BY id";
            }
            if($data_mode == 'YESTERDAY') {
                $whereClause .= "WHERE user_registered = DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND user_email LIKE '%$email%' $send_users_ch ORDER BY id";
            }
            if($data_mode == 'WEEK') {
                $whereClause .= "WHERE (user_registered >= NOW()-INTERVAL 7 DAY) AND user_email LIKE '%$email%' $send_users_ch ORDER BY id";
            }
        }
        else {
            $whereClause .= "WHERE user_email LIKE '%$email%' $send_users_ch ORDER BY id";
        }
    }	    
    $usersTotal = $wpdb->get_results($qTotal.' '.$whereClause.'', OBJECT);		
    $users = $wpdb->get_results($query.' '.$whereClause.' LIMIT '.$start.','.$cnt.'', OBJECT);
	$pages = ceil($usersTotal[0]->cnt/$cnt);	
	$return['status'] = 1;
	$return['view'] = smartresponder_renderExport($users, $pages, $page, $cnt, $email, $data_mode, $usersTotal[0]->cnt);
	echo json_encode($return);
    die();
}

add_action('wp_ajax_users', 'smartresponder_wp_plugin_users');

//Import users
function smartresponder_wp_plugin_import() {
	global $wpdb;
    //Ключ доступа
    $api_key = $_SESSION['api_key'];
    //Get destination
    $destination = htmlspecialchars($_POST['destination']);
    //Get nickname
    $nickname = htmlspecialchars($_POST['nickname']);
    $nickname_arr = explode(",",$nickname);
    //Get email
    $email = htmlspecialchars($_POST['email']);
    $email_arr = explode(",",$email);
	$f_exportAll = $_POST['expartAll'];
    //Import
    $import_data = array();
    $import_data['service_key'] = '7Kq2kzooNS6hmaHuh7VCggzSvnpMmMUA';
    //$import_data['format'] = 'JSON';
    $import_data['format'] = 'xml';
    $import_data['api_key'] = $api_key;
    $import_data['action'] = 'import';
    $import_data['email_source'] = 'otherservice';
    $import_data['details'] = 'Импорт пользователей используя smartresponder plugin.';
	$subscribers = array();
	if($f_exportAll == 1){
			$query = "SELECT id, user_nicename, user_email, user_registered FROM $wpdb->users ";			
			if(isset($_POST['period']) or isset($_POST['filter'])) {
				$data_mode = $_POST['period'];
				$filter = $_POST['filter'];
				if(strlen($data_mode) > 0) {
					if($data_mode == 'TODAY') {
						$query= "WHERE user_registered = date(now()) AND user_email LIKE '%$filter%' $send_users_ch ORDER BY id";
					}
					if($data_mode == 'YESTERDAY') {
						$query .= "WHERE user_registered = DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND user_email LIKE '%$filter%' $send_users_ch ORDER BY id";
					}
					if($data_mode == 'WEEK') {
						$query .= "WHERE (user_registered >= NOW()-INTERVAL 7 DAY) AND user_email LIKE '%$filter%' $send_users_ch ORDER BY id";
					}
				}
				else {
					$query .= "WHERE user_email LIKE '%$filter%' $send_users_ch ORDER BY id";
				}
			}	    			
			$users = $wpdb->get_results($query, OBJECT);
			foreach($users as $user){
				$subscribers[] = $user->user_email.";".$user->user_nicename.";;;;;;;;;;";
			}
	}
	else{		
		for($i = 0; $i < count($nickname_arr); $i++){
			for($i = 0; $i < count($email_arr); $i++) {
				$subscribers[] = $email_arr[$i].";".$nickname_arr[$i].";;;;;;;;;;";
			} 
		}		
	}
    $import_data['input_data'] = implode("\n", $subscribers);
    $import_data['destination'] = $destination;
    $import_data['description'] = 'Импорт пользователей используя smartresponder plugin.';
    $import_data['charset'] = 'utf-8';

    $link = 'http://smartresponder.ru/api/import.html';

    $result = sr_get_content($link, $import_data);

    $result = trim($result);
    //End import
    $tmp_result = simplexml_load_string($result);
    $result = json_encode($tmp_result);

    echo $result;
    
    die();
}

add_action('wp_ajax_import', 'smartresponder_wp_plugin_import');

// Result
function smartresponder_wp_plugin_result() {
    //Ключ доступа
    $api_key = $_SESSION['api_key'];
    //import_key
    $import_key = htmlspecialchars($_POST['import_key']);

    //Import
    $import_data2 = array();
    $import_data2['service_key'] = '7Kq2kzooNS6hmaHuh7VCggzSvnpMmMUA';
    $import_data2['format'] = 'xml';
    $import_data2['import_key'] = $import_key;
    $import_data2['action'] = 'result';
    $import_data2['api_key'] = $api_key;

    $link = 'http://smartresponder.ru/api/import.html';

    $result2 = sr_get_content($link, $import_data2);

    $result2 = trim($result2);
    $tmp_result = simplexml_load_string($result2);
    $result2 = json_encode($tmp_result);
    //End import

    echo $result2;
    
    die();
}

add_action('wp_ajax_result', 'smartresponder_wp_plugin_result');

// Smartresponder WP Plugin Admin Menu Form
function smartresponder_wp_plugin_admin_menu_form() {
	global $wpdb;
    $plugindir = get_settings('home').'/wp-content/plugins/'.dirname(plugin_basename(__FILE__));
	$qTotal = "SELECT count(id) as cnt FROM $wpdb->users";
    $postsTotal = $wpdb->get_results($qTotal, OBJECT);			
	$pages = ceil($postsTotal[0]->cnt/100);
	
?>
<div class="smartresponder">
    <div class="container">
        <div class="sync_success">
            <p class="text-success"></p>
        </div>
        <!-- SR Menu -->
        <ul id="sr_menu">
            <li class="api_key_li"><a href="javascript:void(0)"><img src="<?php echo $plugindir.'/'; ?>img/api_key_btn_active.png" /></a></li>
            <li class="form_generator_li"><a href="javascript:void(0)"><img src="<?php echo $plugindir.'/'; ?>img/form_gen_btn.png" /></a></li>
            <li class="export_li"><a href="javascript:void(0)"><img src="<?php echo $plugindir.'/'; ?>img/export_btn.png" /></a></li>
        </ul>
        <!-- Synchronization -->
        <div class="sync">
            <div class="input-append">
                <input class="span2" id="appendedInputButton" name="api_key" type="text" placeholder="Введите API-ключ">
                <input class="btn" name="sync_btn" type="button" value="Синхронизировать">
            </div>
            <div class="sync_loading"><img src="<?php echo $plugindir.'/'; ?>img/loading.gif"></div>
            <p class="text-error"></p>
        </div>
        <!-- Form Generator -->
        <div class="form_generator">
            <div class="leftCol">
                <div class="scene-editor">
                    <link rel="stylesheet" href="<?php echo $plugindir.'/'; ?>form.css" type="text/css" />
                    <form class="sr-box" method="post" action="https://smartresponder.ru/subscribe.html" target="_blank" name="SR_form" style="z-index: 1;width: 250px; border: 1px solid rgb(188, 188, 188); margin: 0 auto; margin-top: 130px; border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; ">
                        <ul class="sr-box-list ui-sortable" style="background: white;">
                            <li class="form-header" style="text-align: center; border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; border: 0px solid rgb(0, 0, 0); ">
                                <label class="header_title" style="width: 100%; height: auto; line-height: 25px; margin-top: 10px; font-size: 16px; color: rgb(0, 0, 0); font-family: arial; font-weight: bold; font-style: normal; ">Подписка на рассылку</label>
                                <input type="hidden" name="element_header" value="" style="font-family: Arial; color: rgb(0, 0, 0); font-size: 12px; font-style: normal; font-weight: normal; border: none; " />
                            </li>
                            <li class="fields" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; height: 60px; text-align: center; background-position: initial initial; background-repeat: initial initial; ">                                                                                                                                            
                                <label style="font-family: arial; color: rgb(0, 0, 0); font-size: 12px; font-style: normal; font-weight: normal; display: none; margin-top: 10px; " class="remove_labels">Ваше имя</label>
                                <input type="text" name="field_name_first" class="sr-required" value="" placeholder="Ваше имя" style="margin-top: 10px; background-image: none; font-family: arial; color: rgb(189, 189, 189); font-size: 13px; font-style: normal; font-weight: bold; border: 1px solid rgb(188, 188, 188); border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; height: 40px; -webkit-box-shadow: 0 0 0 0; " />
                            </li>
                            <li class="fields" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; height: 60px; text-align: center; background-position: initial initial; background-repeat: initial initial; ">
                                <label style="font-family: arial; color: rgb(0, 0, 0); font-size: 12px; font-style: normal; font-weight: normal; display: none; margin-top: 10px; " class="remove_labels">Ваш email-адрес</label>
                                <input type="text" name="field_email" class="sr-required" value="" placeholder="Ваш email-адрес" style="margin-top: 10px; background-image: none; font-family: arial; color: rgb(189, 189, 189); font-size: 13px; font-style: normal; font-weight: bold; border: 1px solid rgb(188, 188, 188); border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; height: 40px; -webkit-box-shadow: 0 0 0 0; " />
                            </li>
                            <li class="subscribe" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; text-align: center; background-color: none; border: 0px; height: 75px; background-position: initial initial; background-repeat: initial initial; ">            
                                <input type="submit" name="subscribe" disabled value="Подписаться" style="cursor: pointer; background-image: none !important; font-family: arial; color: rgb(255, 255, 255); font-size: 15px; font-style: normal; font-weight: bold; border: 1px solid rgb(99, 129, 18) !important; margin-top: 10px; width: 150px; background-color: rgb(153, 192, 48) !important; height: 40px; background-position: 0% 50%; background-repeat: repeat repeat; padding: 0; border-top: 0; -webkit-box-shadow: 0 0 0 0; text-shadow: none; " />
                            </li>
                            <li id="counter_li" style="display: none; text-align: center; height: 45px; border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; ">
                                <label id="cnt" style="font-size: 13px; color: rgb(173, 166, 173); font-family: arial; font-weight: bold; font-style: normal; height: 40px;">
                                    Подписчиков
                                    <img style="vertical-align: middle; " src="">
                                </label>
                            </li>
                        </ul>
                    </form>
                </div>
                <br />
                <!-- Link to trigger modal -->
                <div class="form-actions">
                    <a href="#myModal" id="get_html" data-toggle="modal" class="sr-btn sr-btn-default">Получить HTML код</a>
                    <a href="javascript:void(0)" id="create_widget" class="sr-btn sr-btn-default">Создать виджет</a>
                </div>
                <!-- Modal -->
                <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">HTML код формы</h3>
                    </div>
                    <div class="modal-body">
                        <textarea></textarea>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Закрыть</button>
                    </div>
                </div>
            </div>
            <div class="rightCol">
                <div class="ac_div">
                    <section class="ac-container">
                        <div>
                            <input id="ac-1" name="accordion-1" type="radio" checked />
                            <label for="ac-1">Обязательные настройки формы</label>
                            <article class="ac-small">
                                <p><span class="red">1.</span> Форма подписывает на рассылки:</p>
                                <select size="4" multiple="" name="deliveries_select"></select>
                                <p><span class="red">2.</span> Размеры и внешний вид формы:</p>
                                <table border="0" cellspacing="0" cellpadding="0" style="margin-left: 20px;">
                                    <tbody>
                                        <tr>
                                            <td colspan="4">Ширина: <input type="text" name="form_width" maxlength="3" class="textbox" value="250" style="width: 50px;"> в пикселях</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td width="65px">Граница:</td>
                                            <td>
                                                <select name="fBorder" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px;">
                                                    <option value="0">0</option>
                                                    <option value="1" selected>1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                </select>
                                                <input type="checkbox" name="f_dashed" value="1" style="margin-right: 5px; margin-left: 10px; vertical-align: middle; display: inline; " />пунктир
                                            </td>
                                            <td align="right">&nbsp;&nbsp;&nbsp;Цвет:</td>
                                            <td align="left">&nbsp;
                                                <span class="minicolors minicolors-theme-default minicolors-swatch-position-left minicolors-swatch-left minicolors-position-default">
                                                    <input class="minicolors minicolors-input" id="minicolor1" type="text" value="#c8c8c8" size="7" maxlength="7">
                                                    <span class="minicolors-panel minicolors-slider-hue" style="display: none;">
                                                        <span class="minicolors-slider">
                                                            <span class="minicolors-picker" style="top: 67.88461538461539px;"></span>
                                                        </span>
                                                        <span class="minicolors-opacity-slider">
                                                            <span class="minicolors-picker"></span>
                                                        </span>
                                                        <span class="minicolors-grid" style="background-color: rgb(0, 183, 255);">
                                                            <span class="minicolors-grid-inner"></span>
                                                            <span class="minicolors-picker" style="top: 38px; left: 104px;">
                                                                <span></span>
                                                            </span>
                                                        </span>
                                                    </span>
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p><span class="red">3.</span> Фон формы:</p>
                                <table border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                        <tr>
                                            <td style="white-space: nowrap;">
                                                <input type="checkbox" name="bg_color" value="color" checked="checked"> Цвет:
                                            </td>
                                            <td>&nbsp;
                                                <span class="minicolors minicolors-theme-default minicolors-swatch-position-left minicolors-swatch-left minicolors-position-default mc2">
                                                    <input class="minicolors minicolors-input" id="minicolor2" type="text" value="#ffffff" size="7" maxlength="7">
                                                    <span class="minicolors-panel minicolors-slider-hue" style="display: none;">
                                                        <span class="minicolors-slider">
                                                            <span class="minicolors-picker" style="top: 67.88461538461539px;"></span>
                                                        </span>
                                                        <span class="minicolors-opacity-slider">
                                                            <span class="minicolors-picker"></span>
                                                        </span>
                                                        <span class="minicolors-grid" style="background-color: rgb(0, 183, 255);">
                                                            <span class="minicolors-grid-inner"></span>
                                                            <span class="minicolors-picker" style="top: 38px; left: 104px;">
                                                                <span></span>
                                                            </span>
                                                        </span>
                                                    </span>
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </article>
                        </div>
                        <div>
                            <input id="ac-2" name="accordion-1" type="radio" />
                            <label for="ac-2">Дополнительные настройки формы</label>
                            <article class="ac-medium">
                                <p><span class="red">4.</span> Канал подписки, связанный с формой:</p>
                                <select name="trackId">
                                    <option value="0">выбрать →</option>    
                                </select>
                                <p><span class="red">5.</span> Проверка заполнения полей формы:</p>
                                <select name="checksLevel">
                                    <option value="0">не проверять</option>
                                    <option value="1" selected="">минимальная</option>
                                    <option value="2">максимальная</option>
                                </select>
                                <p><span class="red">6.</span> Динамичность формы:</p>
                                <table border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                        <tr class="tr-small">
                                            <td valign="top" width="25px">
                                                <input type="radio" checked="checked" name="openType" value="0" style="display: inline;">
                                            </td>
                                            <td valign="top">перенаправлять на страницу подписки</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td valign="top" width="25px">
                                                <input type="radio" name="openType" value="1" style="display: inline;">
                                            </td>
                                            <td valign="top">отправлять активационное письмо без<br>переадресации </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr class="sr-subscribe-text" style="display: none;">
                                            <td colspan="2">Текст, который появиться вместо кнопки:</td>
                                        </tr>
                                        <tr class="sr-subscribe-text" style="display: none;">
                                            <td colspan="2">
                                                <input type="text" name="subscribe_text" value="Спасибо! Проверьте свой email и подтвердите подписку" maxlength="350" style="margin: 0;">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </article>
                        </div>
                        <div>
                            <input id="ac-3" name="accordion-1" type="radio" />
                            <label for="ac-3">Настройки шапки формы</label>
                            <article class="ac-large">
                                <p><span class="red">7.</span> Элемент формы:</p>
                                <table border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                        <tr>
                                            <td id="form_elements" style="white-space: nowrap;">
                                                <input type="checkbox" name="element_header" checked="checked" style="display: inline;">&nbsp;&nbsp;Хэдер 
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p><span class="red">8.</span> Название шапки:</p>
                                <input type="text" id="title" name="unique_element_header_title" value="Подписка на рассылку" style="margin-left: 20px;">
                                <p><span class="red">9.</span> Форматирование текста шапки:</p>
                                <table border="0" cellspacing="0" cellpadding="0" style="">
                                    <tbody>
                                        <tr>
                                            <td colspan="3">
                                                Шрифт:
                                                <select id="font" name="unique_element_header_font" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px;">
                                                    <option value="arial">Arial</option>
                                                    <option value="courier">Courier</option>
                                                    <option value="times new roman">Times New Roman</option>
                                                    <option value="verdana">Verdana</option>
                                                </select>
                                            </td>
                                            <td align="right" colspan="2">&nbsp;&nbsp;Цвет:</td>                        
                                            <td>&nbsp;
                                                <span class="minicolors minicolors-theme-default minicolors-swatch-position-left minicolors-swatch-left minicolors-position-default">
                                                    <input class="minicolors minicolors-input" id="minicolor3" type="text" value="#000000" size="7" maxlength="7">
                                                    <span class="minicolors-panel minicolors-slider-hue" style="display: none;">
                                                        <span class="minicolors-slider">
                                                            <span class="minicolors-picker" style="top: 67.88461538461539px;"></span>
                                                        </span>
                                                        <span class="minicolors-opacity-slider">
                                                            <span class="minicolors-picker"></span>
                                                        </span>
                                                        <span class="minicolors-grid" style="background-color: rgb(0, 183, 255);">
                                                            <span class="minicolors-grid-inner"></span>
                                                            <span class="minicolors-picker" style="top: 38px; left: 104px;">
                                                                <span></span>
                                                            </span>
                                                        </span>
                                                    </span>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">&nbsp;</td>
                                        </tr>
                                        <tr style="display: table-row;">
                                            <td colspan="6">
                                                Размер:
                                                <select id="size" name="unique_element_header_size" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px;">
                                                    <option value="8px">8</option>
                                                    <option value="9px">9</option>
                                                    <option value="10px">10</option>
                                                    <option value="11px">11</option>
                                                    <option value="12px">12</option>
                                                    <option value="13px">13</option>
                                                    <option value="14px">14</option>
                                                    <option value="15px">15</option>
                                                    <option value="16px" selected>16</option>
                                                    <option value="17px">17</option>
                                                    <option value="18px">18</option>
                                                    <option value="19px">19</option>
                                                    <option value="20px">20</option>
                                                    <option value="21px">21</option>
                                                    <option value="22px">22</option>
                                                    <option value="23px">23</option>
                                                    <option value="24px">24</option>
                                                </select>
                                                &nbsp;&nbsp;
                                                Тип:
                                                <select id="type" name="unique_element_header_type" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px;">
                                                    <option value="normal">Обычный</option>
                                                    <option value="bold" selected>Жирный</option>
                                                    <option value="italic">Курсив</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </article>
                        </div>
                        <div>
                            <input id="ac-4" name="accordion-1" type="radio" />
                            <label for="ac-4">Настройки полей формы</label>
                            <article class="ac-large">
                                <p><span class="red">10.</span> Отображение названия поля:</p>
                                <table cellspacing="0" cellpadding="0" border="0" style="display: table;">
                                    <tbody>
                                        <tr>
                                            <td width="20px">
                                                <input type="radio" value="field" name="edit_type" style="display: inline; ">
                                            </td>
                                            <td>Над полем</td>
                                            <td>&nbsp;&nbsp;&nbsp;</td>
                                            <td width="20px">
                                                <input type="radio" value="initial_field" checked="checked" name="edit_type" style="display: inline; ">
                                            </td>
                                            <td>Внутри поля</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p class="sr_initial_field"><span class="red">11.</span> Форматирование текста в поле:</p>
                                <table class="sr_initial_field" id="under_text-table" border="0" cellspacing="0" cellpadding="0" style="display: table; margin-top: 10px; margin-left: 20px;">
                                    <tbody>
                                        <tr>
                                            <td colspan="3">
                                                Шрифт:
                                                <select id="under_initial_font" name="under_unique_field_initial_font" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; ">
                                                    <option value="arial">Arial</option>
                                                    <option value="courier">Courier</option>
                                                    <option value="times new roman">Times New Roman</option>
                                                    <option value="verdana">Verdana</option>    
                                                </select>
                                            </td>
                                            <td align="right" colspan="2">&nbsp;&nbsp;Цвет:</td>
                                            <td>&nbsp;
                                                <span class="minicolors minicolors-theme-default minicolors-swatch-position-left minicolors-swatch-left minicolors-position-default">
                                                    <input class="minicolors minicolors-input" id="minicolor4" type="text" value="#bdbdbd" size="7" maxlength="7">
                                                    <span class="minicolors-panel minicolors-slider-hue" style="display: none;">
                                                        <span class="minicolors-slider">
                                                            <span class="minicolors-picker" style="top: 67.88461538461539px;"></span>
                                                        </span>
                                                        <span class="minicolors-opacity-slider">
                                                            <span class="minicolors-picker"></span>
                                                        </span>
                                                        <span class="minicolors-grid" style="background-color: rgb(0, 183, 255);">
                                                            <span class="minicolors-grid-inner"></span>
                                                            <span class="minicolors-picker" style="top: 38px; left: 104px;">
                                                                <span></span>
                                                            </span>
                                                        </span>
                                                    </span>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">&nbsp;<td>
                                        </tr>
                                        <tr>
                                            <td colspan="6">
                                                Размер:
                                                <input type="hidden" name="under_field_initial_font" value="Arial">
                                                <input type="hidden" name="under_field_initial_size" value="13px">
                                                <input type="hidden" name="under_field_initial_type" value="bold">
                                                <input type="hidden" name="under_field_initial_color" value="#BDBDBD">
                                                <select id="under_initial_size" name="under_unique_field_initial_size" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; ">
                                                    <option value="8px">8</option>
                                                    <option value="9px">9</option>
                                                    <option value="10px">10</option>
                                                    <option value="11px">11</option>
                                                    <option value="12px">12</option>
                                                    <option value="13px" selected="">13</option>
                                                    <option value="14px">14</option>
                                                    <option value="15px">15</option>
                                                    <option value="16px">16</option>
                                                    <option value="17px">17</option>
                                                    <option value="18px">18</option>
                                                    <option value="19px">19</option>
                                                    <option value="20px">20</option>
                                                    <option value="21px">21</option>
                                                    <option value="22px">22</option>
                                                    <option value="23px">23</option>
                                                    <option value="24px">24</option>
                                                </select>
                                                &nbsp;&nbsp;
                                                Тип:
                                                <select id="under_initial_type" name="under_unique_field_initial_type" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; ">
                                                    <option value="normal">Обычный</option>
                                                    <option value="bold" selected="">Жирный</option>
                                                    <option value="italic">Курсив</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p class="sr_field" style="display: none;"><span class="red">11.</span> Форматирование текста над полем:</p>
                                <table class="sr_field" id="over_text-table" border="0" cellspacing="0" cellpadding="0" style="display: none; margin-top: 10px; margin-left: 20px;">
                                    <tbody>
                                        <tr>
                                            <td colspan="3">
                                                Шрифт:
                                                <select id="over_initial_font" name="over_unique_field_initial_font" class="listbox" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; ">
                                                    <option value="arial">Arial</option>
                                                    <option value="courier">Courier</option>
                                                    <option value="times new roman">Times New Roman</option>
                                                    <option value="verdana">Verdana</option>    
                                                </select>
                                            </td>
                                            <td align="right" colspan="2">&nbsp;&nbsp;Цвет:</td>
                                            <td>&nbsp;
                                                <span class="minicolors minicolors-theme-default minicolors-swatch-position-left minicolors-swatch-left minicolors-position-default">
                                                    <input class="minicolors minicolors-input" id="minicolor7" type="text" value="#000000" size="7" maxlength="7">
                                                    <span class="minicolors-panel minicolors-slider-hue" style="display: none;">
                                                        <span class="minicolors-slider">
                                                            <span class="minicolors-picker" style="top: 67.88461538461539px;"></span>
                                                        </span>
                                                        <span class="minicolors-opacity-slider">
                                                            <span class="minicolors-picker"></span>
                                                        </span>
                                                        <span class="minicolors-grid" style="background-color: rgb(0, 183, 255);">
                                                            <span class="minicolors-grid-inner"></span>
                                                            <span class="minicolors-picker" style="top: 38px; left: 104px;">
                                                                <span></span>
                                                            </span>
                                                        </span>
                                                    </span>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">&nbsp;<td>
                                        </tr>
                                        <tr>
                                            <td colspan="6">
                                                Размер:
                                                <input type="hidden" name="over_field_initial_font_h" value="Arial">
                                                <input type="hidden" name="over_field_initial_size_h" value="12px">
                                                <input type="hidden" name="over_field_initial_type_h" value="normal">
                                                <input type="hidden" name="over_field_initial_color_h" value="#000000">
                                                <select id="initial_size" name="over_unique_field_initial_size" class="listbox" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; ">
                                                    <option value="8px">8</option>
                                                    <option value="9px">9</option>
                                                    <option value="10px">10</option>
                                                    <option value="11px">11</option>
                                                    <option value="12px" selected>12</option>
                                                    <option value="13px">13</option>
                                                    <option value="14px">14</option>
                                                    <option value="15px">15</option>
                                                    <option value="16px">16</option>
                                                    <option value="17px">17</option>
                                                    <option value="18px">18</option>
                                                    <option value="19px">19</option>
                                                    <option value="20px">20</option>
                                                    <option value="21px">21</option>
                                                    <option value="22px">22</option>
                                                    <option value="23px">23</option>
                                                    <option value="24px">24</option>
                                                </select>
                                                &nbsp;&nbsp;
                                                Тип:
                                                <select id="initial_type" name="over_unique_field_initial_type" class="listbox" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; ">
                                                    <option value="normal">Обычный</option>
                                                    <option value="bold">Жирный</option>
                                                    <option value="italic">Курсив</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p><span class="red">12.</span> Форматирование поля:</p>
                                <table border="0" cellspacing="0" cellpadding="0" style="margin-top: 10px; margin-left: 20px;">
                                    <tbody>
                                        <tr>
                                            <td>Граница:&nbsp;</td>
                                            <td>
                                                <select id="border_weight" name="unique_field_border_weight" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; ">
                                                    <option value="0">0</option>
                                                    <option value="1" selected="">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                </select>
                                            </td>
                                            <td style="width: 120px; ">&nbsp;&nbsp;

                                            </td>
                                            <td>
                                                Фон:
                                            </td>
                                            <td>&nbsp;
                                                <span class="minicolors minicolors-theme-default minicolors-swatch-position-left minicolors-swatch-left minicolors-position-default">
                                                    <input class="minicolors minicolors-input" id="minicolor6" type="text" value="#ffffff" size="7" maxlength="7">
                                                    <span class="minicolors-panel minicolors-slider-hue" style="display: none;">
                                                        <span class="minicolors-slider">
                                                            <span class="minicolors-picker" style="top: 67.88461538461539px;"></span>
                                                        </span>
                                                        <span class="minicolors-opacity-slider">
                                                            <span class="minicolors-picker"></span>
                                                        </span>
                                                        <span class="minicolors-grid" style="background-color: rgb(0, 183, 255);">
                                                            <span class="minicolors-grid-inner"></span>
                                                            <span class="minicolors-picker" style="top: 38px; left: 104px;">
                                                                <span></span>
                                                            </span>
                                                        </span>
                                                    </span>
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </article>
                        </div>
                        <div>
                            <input id="ac-5" name="accordion-1" type="radio" />
                            <label for="ac-5">Настройки кнопки формы</label>
                            <article class="ac-large">
                                <p><span class="red">13.</span> Название кнопки:</p>
                                <input type="text" id="title" name="unique_subscribe_title" value="Подписаться" style="margin-left: 20px;">
                                <p><span class="red">14.</span> Форматирование текста кнопки:</p>
                                <table border="0" cellspacing="0" cellpadding="0" style="margin-top: 10px; margin-left: 20px;">
                                    <tbody>
                                        <tr>
                                            <td colspan="3">
                                                Шрифт:
                                                <select id="font" name="unique_subscribe_font" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; ">
                                                    <option value="arial">Arial</option>
                                                    <option value="courier">Courier</option>
                                                    <option value="times new roman">Times New Roman</option>
                                                    <option value="verdana">Verdana</option>    
                                                </select>
                                            </td>
                                            <td align="right" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;Цвет:</td>                      
                                            <td>&nbsp;
                                                <span class="minicolors minicolors-theme-default minicolors-swatch-position-left minicolors-swatch-left minicolors-position-default">
                                                    <input class="minicolors minicolors-input" id="minicolor8" type="text" value="#ffffff" size="7" maxlength="7">
                                                    <span class="minicolors-panel minicolors-slider-hue" style="display: none;">
                                                        <span class="minicolors-slider">
                                                            <span class="minicolors-picker" style="top: 67.88461538461539px;"></span>
                                                        </span>
                                                        <span class="minicolors-opacity-slider">
                                                            <span class="minicolors-picker"></span>
                                                        </span>
                                                        <span class="minicolors-grid" style="background-color: rgb(0, 183, 255);">
                                                            <span class="minicolors-grid-inner"></span>
                                                            <span class="minicolors-picker" style="top: 38px; left: 104px;">
                                                                <span></span>
                                                            </span>
                                                        </span>
                                                    </span>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">&nbsp;</td>
                                        </tr>
                                        <tr style="display: table-row; ">
                                            <td colspan="6">
                                                Размер:
                                                <select id="size" name="unique_subscribe_size" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; ">
                                                    <option value="8px">8</option>
                                                    <option value="9px">9</option>
                                                    <option value="10px">10</option>
                                                    <option value="11px">11</option>
                                                    <option value="12px">12</option>
                                                    <option value="13px">13</option>
                                                    <option value="14px">14</option>
                                                    <option value="15px" selected>15</option>
                                                    <option value="16px">16</option>
                                                    <option value="17px">17</option>
                                                    <option value="18px">18</option>
                                                    <option value="19px">19</option>
                                                    <option value="20px">20</option>
                                                    <option value="21px">21</option>
                                                    <option value="22px">22</option>
                                                    <option value="23px">23</option>
                                                    <option value="24px">24</option>
                                                </select>
                                                &nbsp;&nbsp;Тип:
                                                <select id="type" name="unique_subscribe_type" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; ">
                                                    <option value="normal">Обычный</option>
                                                    <option value="bold" selected="">Жирный</option>
                                                    <option value="italic">Курсив</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p><span class="red">15.</span> Форматирование кнопки:</p>
                                <table border="0" cellspacing="0" cellpadding="0" style="margin-top: 10px; margin-left: 20px;">
                                    <tbody>
                                        <tr>
                                            <td>Граница:&nbsp;</td>
                                            <td>
                                                <select id="border_weight" name="unique_subscribe_border_weight" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; ">
                                                    <option value="0">0</option>
                                                    <option value="1" selected="">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                </select>
                                            </td>
                                            <td style="width: 120px; ">&nbsp;
                                                <span class="minicolors minicolors-theme-default minicolors-swatch-position-left minicolors-swatch-left minicolors-position-default">
                                                    <input class="minicolors minicolors-input" id="minicolor9" type="text" value="#638112" size="7" maxlength="7">
                                                    <span class="minicolors-panel minicolors-slider-hue" style="display: none;">
                                                        <span class="minicolors-slider">
                                                            <span class="minicolors-picker" style="top: 67.88461538461539px;"></span>
                                                        </span>
                                                        <span class="minicolors-opacity-slider">
                                                            <span class="minicolors-picker"></span>
                                                        </span>
                                                        <span class="minicolors-grid" style="background-color: rgb(0, 183, 255);">
                                                            <span class="minicolors-grid-inner"></span>
                                                            <span class="minicolors-picker" style="top: 38px; left: 104px;">
                                                                <span></span>
                                                            </span>
                                                        </span>
                                                    </span>
                                                </span>
                                            </td>
                                            <td>Фон:</td>
                                            <td width="115px">&nbsp;
                                                <span class="minicolors minicolors-theme-default minicolors-swatch-position-left minicolors-swatch-left minicolors-position-default">
                                                    <input class="minicolors minicolors-input" id="minicolor10" type="text" value="#99C030" size="7" maxlength="7">
                                                    <span class="minicolors-panel minicolors-slider-hue" style="display: none;">
                                                        <span class="minicolors-slider">
                                                            <span class="minicolors-picker" style="top: 67.88461538461539px;"></span>
                                                        </span>
                                                        <span class="minicolors-opacity-slider">
                                                            <span class="minicolors-picker"></span>
                                                        </span>
                                                        <span class="minicolors-grid" style="background-color: rgb(0, 183, 255);">
                                                            <span class="minicolors-grid-inner"></span>
                                                            <span class="minicolors-picker" style="top: 38px; left: 104px;">
                                                                <span></span>
                                                            </span>
                                                        </span>
                                                    </span>
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </article>
                        </div>
                        <div>
                            <input id="ac-6" name="accordion-1" type="radio" />
                            <label for="ac-6">Настройки счетчика формы</label>
                            <article class="ac-large">
                                <p><span class="red">16.</span> Элемент формы:</p>
                                <table border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                        <tr>
                                            <td id="form_elements" style="white-space: nowrap;">
                                                <input type="checkbox" name="element_counter" style="display: inline;">&nbsp;&nbsp;Счетчик 
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p><span class="red">17.</span> Форматирование текста счетчика:</p>
                                <table border="0" cellspacing="0" cellpadding="0" style="">
                                    <tbody>
                                        <tr>
                                            <td colspan="3">
                                                Шрифт:
                                                <select id="font" name="unique_element_counter_font" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px;">
                                                    <option value="arial">Arial</option>
                                                    <option value="courier">Courier</option>
                                                    <option value="times new roman">Times New Roman</option>
                                                    <option value="verdana">Verdana</option>
                                                </select>
                                            </td>
                                            <td align="right" colspan="2">&nbsp;&nbsp;Цвет:</td>                        
                                            <td>&nbsp;
                                                <span class="minicolors minicolors-theme-default minicolors-swatch-position-left minicolors-swatch-left minicolors-position-default">
                                                    <input class="minicolors minicolors-input" id="minicolor11" type="text" value="#bdbdbd" size="7" maxlength="7">
                                                    <span class="minicolors-panel minicolors-slider-hue" style="display: none;">
                                                        <span class="minicolors-slider">
                                                            <span class="minicolors-picker" style="top: 67.88461538461539px;"></span>
                                                        </span>
                                                        <span class="minicolors-opacity-slider">
                                                            <span class="minicolors-picker"></span>
                                                        </span>
                                                        <span class="minicolors-grid" style="background-color: rgb(0, 183, 255);">
                                                            <span class="minicolors-grid-inner"></span>
                                                            <span class="minicolors-picker" style="top: 38px; left: 104px;">
                                                                <span></span>
                                                            </span>
                                                        </span>
                                                    </span>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">&nbsp;</td>
                                        </tr>
                                        <tr style="display: table-row;">
                                            <td colspan="6">
                                                Размер:
                                                <select id="size" name="unique_element_counter_size" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px;">
                                                    <option value="8px">8</option>
                                                    <option value="9px">9</option>
                                                    <option value="10px">10</option>
                                                    <option value="11px">11</option>
                                                    <option value="12px">12</option>
                                                    <option value="13px" selected>13</option>
                                                    <option value="14px">14</option>
                                                    <option value="15px">15</option>
                                                    <option value="16px">16</option>
                                                    <option value="17px">17</option>
                                                    <option value="18px">18</option>
                                                    <option value="19px">19</option>
                                                    <option value="20px">20</option>
                                                    <option value="21px">21</option>
                                                    <option value="22px">22</option>
                                                    <option value="23px">23</option>
                                                    <option value="24px">24</option>
                                                </select>
                                                &nbsp;&nbsp;
                                                Тип:
                                                <select id="type" name="unique_element_counter_type" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px;">
                                                    <option value="normal">Обычный</option>
                                                    <option value="bold" selected>Жирный</option>
                                                    <option value="italic">Курсив</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p><span class="red">18.</span> Счетчик подписчиков:</p>
                                <table border="0" cellspacing="0" cellpadding="0" style="">
                                    <tbody>
                                        <tr>
                                            <td colspan="3">
                                                Шрифт:
                                                <select id="number_font" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px;">
                                                    <option value="arial">Arial</option>
                                                    <option value="courier">Courier</option>
                                                    <option value="timesnewroman">Times New Roman</option>
                                                    <option value="verdana" selected>Verdana</option>
                                                </select>
                                            </td>
                                            <td align="right" colspan="2">&nbsp;&nbsp;Цвет:</td>                        
                                            <td>&nbsp;
                                                <span class="minicolors minicolors-theme-default minicolors-swatch-position-left minicolors-swatch-left minicolors-position-default">
                                                    <input class="minicolors minicolors-input" id="minicolor12" type="text" value="#ada6ad" size="7" maxlength="7">
                                                    <span class="minicolors-panel minicolors-slider-hue" style="display: none;">
                                                        <span class="minicolors-slider">
                                                            <span class="minicolors-picker" style="top: 67.88461538461539px;"></span>
                                                        </span>
                                                        <span class="minicolors-opacity-slider">
                                                            <span class="minicolors-picker"></span>
                                                        </span>
                                                        <span class="minicolors-grid" style="background-color: rgb(0, 183, 255);">
                                                            <span class="minicolors-grid-inner"></span>
                                                            <span class="minicolors-picker" style="top: 38px; left: 104px;">
                                                                <span></span>
                                                            </span>
                                                        </span>
                                                    </span>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">&nbsp;</td>
                                        </tr>
                                        <tr style="display: table-row;">
                                            <td colspan="6">
                                                Размер:
                                                <select id="number_size" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px;">
                                                    <option value="8px">8</option>
                                                    <option value="9px">9</option>
                                                    <option value="10px" selected>10</option>
                                                    <option value="11px">11</option>
                                                    <option value="12px">12</option>
                                                    <option value="13px">13</option>
                                                    <option value="14px">14</option>
                                                    <option value="15px">15</option>
                                                    <option value="16px">16</option>
                                                    <option value="17px">17</option>
                                                    <option value="18px">18</option>
                                                    <option value="19px">19</option>
                                                    <option value="20px">20</option>
                                                    <option value="21px">21</option>
                                                    <option value="22px">22</option>
                                                    <option value="23px">23</option>
                                                    <option value="24px">24</option>
                                                </select>
                                                &nbsp;&nbsp;
                                                От надписи:
                                                <select id="number_alignment" name="" class="listbox" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; ">
                                                    <option value="top">Cверху</option>
                                                    <option value="right" selected="">Cправа</option>
                                                    <option value="bottom">Cнизу</option>
                                                    <option value="left">Cлева</option> 
                                                </select>
                                                <br /><br />
                                                Фон:
                                                <input type="checkbox" name="number_bg_color" id="number_bg_color" style="display: inline;">&nbsp;&nbsp;
                                                <span class="minicolors minicolors-theme-default minicolors-swatch-position-left minicolors-swatch-left minicolors-position-default minicolor13" style="display: none; ">
                                                    <input class="minicolors minicolors-input" id="minicolor13" type="text" value="#ffffff" size="7" maxlength="7">
                                                    <span class="minicolors-panel minicolors-slider-hue" style="display: none;">
                                                        <span class="minicolors-slider">
                                                            <span class="minicolors-picker" style="top: 67.88461538461539px;"></span>
                                                        </span>
                                                        <span class="minicolors-opacity-slider">
                                                            <span class="minicolors-picker"></span>
                                                        </span>
                                                        <span class="minicolors-grid" style="background-color: rgb(0, 183, 255);">
                                                            <span class="minicolors-grid-inner"></span>
                                                            <span class="minicolors-picker" style="top: 38px; left: 104px;">
                                                                <span></span>
                                                            </span>
                                                        </span>
                                                    </span>
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </article>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <!-- /Form Generator -->
        <div class="export">
            <br />
            <!-- Modal -->
			<div id="myModal2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h3 id="myModalLabel">Экспорт зарегистрированных пользователей</h3>
				</div>
				<div class="modal-body">
					<table width="100%">
						<tbody>
							<tr>
								<td class="import-request-options">
									<input type="radio" class="get_deliveries" id="get_deliveries" />&nbsp;Выберите рассылку:
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<div class="get_deliveries_select" style="display: none; ">
										<select name="rDestinationId" id="rDestinationId_d" style="width:350px; padding-left:10px; margin-left:1px">
											<option value="0" class="chose">Выбрать ></option>
										</select>
									</div>
								</td>
							</tr>
							<tr>
								<td class="import-request-options">
									<input type="radio" class="get_groups" id="get_groups" />&nbsp;Выберите группу:
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<div class="get_groups_select" style="display: none; ">
										<select name="rDestinationId" id="rDestinationId_g" style="width:350px; padding-left:10px; margin-left:1px">
											<option value="0" class="chose">Выбрать ></option>
										</select>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button class="btn" id="export_sr">Экспортировать</button>
					<button class="btn" data-dismiss="modal" aria-hidden="true">Закрыть</button>
					<span style="display: none;text-align: center; margin-top: 8px;">Подождите пожалуйста...</span>
				</div>
			</div>
			<div class="users_result">			
			<?=smartresponder_renderExport($users, $pages, 1, 100, '', '', $postsTotal[0]->cnt);?>              
            </div>
        </div>
    </div>
</div>
<?php
    
}
function renderUsers($users){
	$str = '';
	if(!empty($users))
		foreach($users as $user){
			$str.= '<tr class="'.$user->id.' wp_users">
				<td>'.$user->id.'</td>
				<td class="is_nickname_'.$user->id.'">'.$user->user_nicename.'</td>
				<td class="is_email_'.$user->id.'">'.$user->user_email.'</td>
				<td>'.$user->user_registered.'</td>
				<td><input type="checkbox" name="'.$user->id.'"></td></tr>';
		}
	return $str;
}
function smartresponder_renderExport($users, $pages, $page, $cnt, $filter, $period, $totalUsers){			
	return '
	<!-- Users Filter -->
	<div id="users_filter">
		<form>
			<fieldset>
				<form class="form-inline">
					Выводить пользователей:&nbsp;
					<select name="search[date_mode]">
						<option '.($period == '' ? 'selected' : '').' value="">За весь период</option>
						<option '.($period == 'TODAY' ? 'selected' : '').' value="TODAY">За сегодня</option>
						<option '.($period == 'YESTERDAY' ? 'selected' : '').' value="YESTERDAY">За вчера</option>
						<option '.($period == 'WEEK' ? 'selected' : '').' value="WEEK">За последнюю неделю</option>
					</select>
					<input type="text" class="input-small" value="'.$filter.'" name="email_filter" placeholder="Фильтр по емайлу">
					<input type="button" class="btn" name="users_filter_btn" value="Сделать выборку">
				</form>
			</fieldset>
		</form>
	</div>
	<a href="#myModal2" id="export_btn" data-toggle="modal" class="sr-btn sr-btn-default">Экспортировать</a>
	<a href="#myModal2" id="export_all_btn" data-toggle="modal" class="sr-btn sr-btn-default">Экспортировать всех ('.$totalUsers.')</a>
	
	<!-- Users table -->
	<table class="table table-hover" id="users_table">
		<thead>
			<tr class="header_row">
				<th>#</th>
				<th>Пользователь</th>
				<th>Email</th>
				<th>Дата регистрации</th>
				<th><input type="checkbox" name="check_all" /></th>
			</tr>			
			'.renderUsers($users).'		
		</thead>
		<tbody></tbody>
	</table>
	<span class="records_on_page">
		Выводить по:&nbsp;
		<select id="records_on_page" name="records_on_page" class="listbox">
			<option '.($cnt == 100 ? 'selected' : '').' value="10">10</option>
			<option '.($cnt == 20 ? 'selected' : '').' value="20">20</option>
			<option '.($cnt == 30 ? 'selected' : '').' value="30">30</option>
			<option '.($cnt == 50 ? 'selected' : '').' value="50">50</option>
			<option '.($cnt == 100 ? 'selected' : '').' value="100">100</option>
		</select>
	</span>
	'.renderPaginator($pages, $page).'
	';	
}

function renderPaginator($pages, $page){
	$str = '';
	if($pages > 1)
	{
		$str .= '<div class="pager">';
			if($page > 1){
			$str .= '<a href="#" alt="First" class="firstPage">Первая</a>&nbsp;
					<a href="#" alt="Previous" class="prevPage">Предыдущая</a>&nbsp;';
			}
			$str .='
			<span class="currentPage">'.$page.'</span> из 
			<span class="totalPages">'.$pages.'</span>&nbsp;';
			if($page != $pages){
			$str .='	
				<a href="#" alt="Next" class="nextPage">Следующая</a>&nbsp;
				<a href="#" alt="Last" class="lastPage">Последняя</a>&nbsp;&nbsp;&nbsp;&nbsp;';
			}	
		$str .='</div>';
	}	
	return $str;
}

add_action('admin_menu',  'smartresponder_wp_plugin_admin_menu' );

?>