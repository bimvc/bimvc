<?php
/*
 	Copyright (C) 2015-17 Gregory Markov, http://wpcerber.com

    Licenced under the GNU GPL

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*

*========================================================================*
|                                                                        |
|	       ATTENTION!  Do not change or edit this file!                  |
|                                                                        |
*========================================================================*

*/










// If this file is called directly, abort executing.
if ( ! defined( 'WPINC' ) ) { exit; }

/*
	Display lockouts in dashboard for admins
*/
function cerber_show_lockouts($args = array(), $echo = true){
	global $wpdb;

	cerber_block_garbage_collector();

	//$per_page = cerber_get_per_page();
	if (!empty($args['per_page'])) $per_page = $args['per_page'];
	else $per_page = cerber_get_per_page();

	$limit = (cerber_get_pn() - 1) * $per_page.','.$per_page;

	if ($rows = $wpdb->get_results('SELECT * FROM '. CERBER_BLOCKS_TABLE . ' ORDER BY block_until DESC LIMIT '.$limit)) {
		$total=$wpdb->get_var('SELECT count(ip) FROM '. CERBER_BLOCKS_TABLE);
		$list=array();
		$base_url = cerber_admin_link('activity');
		$assets_url = plugin_dir_url(CERBER_FILE).'assets/';
		foreach ($rows as $row) {
			$ip = '<a href="'.$base_url.'&filter_ip='.$row->ip.'">'.$row->ip.'</a>';
			$ip_info = cerber_get_ip_info($row->ip,true);
			if (isset($ip_info['hostname'])) $hostname = $ip_info['hostname'];
			else {
				$ip_id = cerber_get_id_ip($row->ip);
				$hostname = '<img data-ip-id="'.$ip_id .'" class="crb-no-hn" src="'.$assets_url.'ajax-loader-ip.gif" />'."\n";
			}

			$list[]='<td>'.$ip.'</td><td>'.$hostname.'</td><td>'.cerber_date($row->block_until).'</td><td>'.$row->reason.'</td><td><a href="'.wp_nonce_url(add_query_arg(array('lockdelete'=>$row->ip)),'control','cerber_nonce').'">'.__('Remove','wp-cerber').'</a></td>';

		}
		$titles = '<tr><th>'.__('IP','wp-cerber').'</th><th>'.__('Hostname','wp-cerber').'</th><th>'.__('Expires','wp-cerber').'</th><th>'.__('Reason','wp-cerber').'</th><th>'.__('Action','wp-cerber').'</th></tr>';
		$table = '<table class="widefat crb-table cerber-margin"><thead>'.$titles.'</thead><tfoot>'.$titles.'</tfoot>'.implode('</tr><tr>',$list).'</tr></table>';

		if (empty($args['no_navi'])) $table .= cerber_page_navi($total,$per_page);

		//echo '<h3>'.sprintf(__('Showing last %d records from %d','wp-cerber'),count($rows),$total).'</h3>';
		$showing = '<h3>'.sprintf(__('Showing last %d records from %d','wp-cerber'),count($rows),$total).'</h3>';

		$view = '<p><b>'.__('Hint','wp-cerber').':</b> ' . __('To view activity, click on the IP','wp-cerber').'</p>';
	}
	else {
		$table = '';
		$view = '<p>'.sprintf(__('No lockouts at the moment. The sky is clear.','wp-cerber')).'</p>';
	}
	$ret = $table.'<div class="cerber-margin">'.$view.'</div>';

	if ($echo) echo $ret;
	else return $ret;
}

/*
	ACL management form in dashboard
*/
function cerber_acl_form(){
	global $wp_cerber;
	echo '<h2>'.__('White IP Access List','wp-cerber').'</h2><p><span style="color:green;" class="dashicons-before dashicons-thumbs-up"></span> '.__('These IPs will never be locked out','wp-cerber').' - <a target="_blank" href="http://wpcerber.com/using-ip-access-lists-to-protect-wordpress/">Know more</a></p>'.
	     cerber_acl_get_table('W');
	echo '<h2>'.__('Black IP Access List','wp-cerber').'</h2><p><span style="color:red;" class="dashicons-before dashicons-thumbs-down"></span> '.__('Nobody can log in or register from these IPs','wp-cerber').' - <a target="_blank" href="http://wpcerber.com/using-ip-access-lists-to-protect-wordpress/">Know more</a></p>'.
	     cerber_acl_get_table('B');
	echo '<p><b><span class="dashicons-before dashicons-star-filled"></span> '.__('Your IP','wp-cerber').': '.$wp_cerber->getRemoteIp().'</b></p>';
	echo '<h4 style="margin-top: 2em;"><span class="dashicons-before dashicons-info"></span> Possible values for entries in the access lists with examples</h4>
	<p>Single IPv6 address: <b>2001:0db8:85a3:0000:0000:8a2e:0370:7334</b>
	<p>Single IPv4 address: <b>192.168.5.22</b>
	<p>IPv4 addresses range with dash: <b>192.168.1.45 - 192.168.22.165</b>
	<p>IPv4 CIDR: <b>192.168.128.0/24</b>
	<p>IPv4 subnet Class A: <b>192.*.*.*</b>
	<p>IPv4 subnet Class B: <b>192.168.*.*</b>
	<p>IPv4 subnet Class C: <b>192.168.77.*</b>';
	//echo '<p>'.__('Note: You can add a subnet Class C with the format like this: xxx.xxx.xxx.*','wp-cerber').'</p>';
}
/*
	Create HTML to display ACL area: table + form
*/
function cerber_acl_get_table($tag){
	global $wpdb;
	$activity_url = cerber_admin_link('activity');
	if ($rows = $wpdb->get_results('SELECT * FROM '. CERBER_ACL_TABLE . " WHERE tag = '".$tag."' ORDER BY ip_long_begin, ip")) {
		foreach ($rows as $row) $list[]='<td>'.$row->ip.'</td><td><a class="delete_entry" href="javascript:void(0)" data-ip="'.$row->ip.'">'.__('Remove','wp-cerber').'</a></td><td><a href="'.$activity_url.'&filter_ip='.urlencode($row->ip).'">'.__('Check for activity','wp-cerber').'</a></td>';
		$ret = '<table id="acl_'.$tag.'" class="acl-table"><tr>'.implode('</tr><tr>',$list).'</tr></table>';
	}
	else $ret='<p style="text-align: center;">- <i>'.__('List is empty','wp-cerber').'</i> -</p>';
	$ret = '<div class="acl-wrapper"><div class="acl-items">'
	       .$ret.'</div><form action="" method="post">
	       <table><tr><td><input type="text" name="add_acl_'.$tag.'" required placeholder="Enter IP address, IPv4 addresses range or subnet"> 
	       </td><td><input type="submit" class="button button-primary" value="'.__('Add IP to the list','wp-cerber').'" ></td></tr></table>'
	       .wp_nonce_field('cerber_dashboard','cerber_nonce')
	       .'</form></div>';
	return $ret;
}
/*
	Handle actions with items in ACLs in the dashboard
*/
add_action('admin_init','cerber_acl_form_process');
function cerber_acl_form_process(){
	if (!current_user_can('manage_options')) return;
	if (!isset($_POST['cerber_nonce']) || !wp_verify_nonce($_POST['cerber_nonce'],'cerber_dashboard')) return;
	if ($_SERVER['REQUEST_METHOD']=='POST') {
		if (!empty($_POST['add_acl_W'])) {
			$ip = cerber_parse_ip($_POST['add_acl_W']);
			if (!$ip) update_site_option('cerber_admin_notice', __('Incorrect IP address or IP range','wp-cerber'));
			elseif (cerber_add_white($ip)) {
				if (is_array($ip)) $ip = $ip['range'];
				update_site_option('cerber_admin_message',sprintf(__('Address %s was added to White IP Access List','wp-cerber'),$ip));
			}
		}
		if (!empty($_POST['add_acl_B'])) {
			$ip = cerber_parse_ip($_POST['add_acl_B']);
			if (!$ip) update_site_option('cerber_admin_notice', __('Incorrect IP address or IP range','wp-cerber'));
			else {
				if ( cerber_is_myip( $ip ) || cerber_is_ip_in_range( $ip ) ) {
					if (is_array($ip)) $ip = $ip['range'];
					update_site_option( 'cerber_admin_notice', __( "You can't add your IP address", 'wp-cerber' ) . ' ' . $ip );
				}
				elseif (cerber_add_black($ip)) {
					if (is_array($ip)) $ip = $ip['range'];
					update_site_option('cerber_admin_message',sprintf(__('Address %s was added to Black IP Access List','wp-cerber'),$ip));
				}
			}
		}
	}
}
/*
	Get all entries from access lists
*/
function cerber_acl_all($fields='*'){
	global $wpdb;
	return $wpdb->get_results('SELECT '.$fields.' FROM '. CERBER_ACL_TABLE , ARRAY_N);
}

/*
	AJAX admin requests is landing here
*/
add_action('wp_ajax_cerber_ajax', 'cerber_admin_ajax');
function cerber_admin_ajax() {
	global $wpdb;
	if (!current_user_can('manage_options')) return;
	$response = array();
	if (isset($_REQUEST['acl_delete'])){
		check_ajax_referer('delete-ip','ajax_nonce');
		$ip = $_REQUEST['acl_delete'];
		if (!$ip = cerber_parse_ip($ip)) wp_die();
		if (cerber_acl_remove($ip)) {
			if (is_string($ip)) $deleted = $ip;
			else $deleted = $ip['range'];
			$response['deleted_ip'] = $deleted;
		}
	}
	elseif (isset($_REQUEST['get_hostnames'])){
		$list = array_unique($_REQUEST['get_hostnames']);
		foreach ($list as $ip_id) {
			$ip = cerber_get_ip_id($ip_id);
			$ip_info = cerber_get_ip_info($ip);
			$response[$ip_id] = $ip_info['hostname'];
		}
	}
	elseif (isset($_REQUEST['dismiss_info'])){
		if (isset($_REQUEST['button_id']) && ($_REQUEST['button_id'] == 'lab_ok' || $_REQUEST['button_id'] == 'lab_no')){
			lab_user_opt_in($_REQUEST['button_id']);
		}
		else update_site_option('cerber_admin_info','');
	}
	echo json_encode($response);
	wp_die();
}
/*
 * Retrieve extended IP information
 * @since 2.2
 *
 */
function cerber_get_ip_info($ip, $cache_only = false){

	//$ip_id = str_replace('.','-',$ip);
	//$ip_id = str_replace(':','_',$ip_id); // IPv6

	$ip_id = cerber_get_id_ip($ip);

	$ip_info = @unserialize(get_transient($ip_id)); // lazy way
	if ($cache_only) return $ip_info;

	if (empty($ip_info['hostname'])) {
		$ip_info = array();
		$hostname = @gethostbyaddr( $ip );
		if ( $hostname ) {
			$ip_info['hostname'] = $hostname;
		} else {
			$ip_info['hostname'] = __( 'unknown', 'wp-cerber' );
		}
		set_transient( $ip_id, serialize( array( 'hostname' => $hostname ) ), 24 * 3600 );
	}
	return $ip_info;
}


/*
	Admin's actions with GET requests is handled here
*/
add_action('admin_init','cerber_admin_request');
function cerber_admin_request(){
	global $wpdb;
	if (!current_user_can('manage_options')) return;
	if ($_SERVER['REQUEST_METHOD']!='GET' || !isset($_GET['cerber_nonce']) || !wp_verify_nonce($_GET['cerber_nonce'],'control')) return;

	if (isset($_GET['testnotify'])) {
		if (cerber_send_notify($_GET['testnotify'])) {
			update_site_option( 'cerber_admin_message', __( 'Message has been sent to ', 'wp-cerber' ) . ' ' . cerber_get_email() );
		}
		else update_site_option('cerber_admin_notice',__('Unable to send notification email','wp-cerber').' '.cerber_get_email());
		wp_safe_redirect(remove_query_arg('testnotify')); // mandatory!
		exit; // mandatory!
	}
	if (isset($_GET['lockdelete'])) {
		$ip = $_GET['lockdelete'];
		if (cerber_block_delete($ip)) update_site_option('cerber_admin_message',sprintf(__('Lockout for %s was removed','wp-cerber'),$ip));
	}
	if (isset($_GET['citadel']) && $_GET['citadel']=='deactivate') {
		cerber_disable_citadel();
	}
	if (isset($_GET['load_settings']) && $_GET['load_settings']=='default') {
		cerber_load_defaults();
		update_site_option('cerber_admin_message',__('Settings saved','wp-cerber'));
		wp_safe_redirect(remove_query_arg(array('load_settings','cerber_nonce'))); // mandatory!
		exit; // mandatory!
	}
	if (isset($_GET['force_upgrade_db'])) {
		cerber_upgrade_db(true);
		update_site_option('cerber_admin_message','Cerber\'s tables has been upgraded');
		wp_safe_redirect(remove_query_arg(array('force_upgrade_db','cerber_nonce'))); // mandatory!
		exit; // mandatory!
	}
	if (isset($_GET['force_check_nodes'])) {
		$best = lab_check_nodes(true);
		update_site_option('cerber_admin_message','Cerber Lab\'s nodes has been checked. The closest node: '.$best);
		wp_safe_redirect(remove_query_arg(array('force_check_nodes','cerber_nonce'))); // mandatory!
		exit; // mandatory!
	}
}

/*
 * Display activities in dashboard for admins
 * @since 1.0
 *
 */
function cerber_show_activity($args = array(), $echo = true){
	global $wpdb;

	$labels = cerber_get_labels('activity');
	$base_url = cerber_admin_link('activity');

	if (!empty($args['per_page'])) $per_page = $args['per_page'];
	else $per_page = cerber_get_per_page();

	$where = array();
	$falist = array();
	$filter = null;

	if (!empty($args['filter_activity'])) $filter = $args['filter_activity'];
	elseif (isset($_GET['filter_activity'])) $filter = $_GET['filter_activity'];

	if ($filter) { // Multiple activities can be requested this way: &filter_activity[]=11&filter_activity[]=7
		//$filter = $_GET['filter_activity'];
		if (is_array($filter)) {
			$falist = array_filter(array_map('absint',$filter));
			$filter = implode(',',$falist);
		}
		else {
			$filter = absint($filter);
			$falist = array($filter); // for further using in links
		}
		$where[] = 'activity IN ('.$filter.')';
	}

	$ip_text='';
	if (isset($_GET['filter_ip'])) {
		$filter = trim($_GET['filter_ip']);
		if (strrchr($filter,'*')) {  // * means subnet, so we need LIKE
			$where[] = $wpdb->prepare('ip LIKE %s',str_replace('*','%',$filter));
			// TODO: use cerber_wildcard2range instead - convert into net range

		}
		else {
			$range = cerber_any2range($filter);
			if (is_array($range)){
				$where[] = $wpdb->prepare( '(ip_long >= %d AND ip_long <= %d)', $range['begin'], $range['end'] );
			}
			elseif (cerber_is_ip_or_net($filter)) {
				$where[] = $wpdb->prepare( 'ip = %s', $filter );
				$ip_text = cerber_ip_extra_view( $filter );
			}
			else $where[] = "ip = 'produce-no-result'";
		}
	}

	if (isset($_GET['filter_login'])) {
		$where[] = $wpdb->prepare('user_login = %s',$_GET['filter_login']);
	}
	if (isset($_GET['filter_user'])) {
		$where[] = $wpdb->prepare('user_id= %d',$_GET['filter_user']);
	}
	if (!empty($where)) $where = 'WHERE '.implode(' AND ',$where); 
	else $where = '';

	$per_page = absint($per_page);
	$limit = (cerber_get_pn() - 1) * $per_page.','.$per_page;

	if ($rows = $wpdb->get_results('SELECT SQL_CALC_FOUND_ROWS * FROM '. CERBER_LOG_TABLE . " $where ORDER BY stamp DESC LIMIT $limit")) {
		$total=$wpdb->get_var("SELECT FOUND_ROWS()");
		$assets_url = plugin_dir_url(CERBER_FILE).'assets/';
		$list=array();
		foreach ($rows as $row) {
			if ($row->user_id && ($u = get_userdata($row->user_id))) {
				//$u = get_userdata($row->user_id);
				$name = '<a href="'.$base_url.'&filter_user='.$row->user_id.'">'.$u->display_name.'</a>';
			}
			else $name='';

			$ip = '<a href="'.$base_url.'&filter_ip='.$row->ip.'">'.$row->ip.'</a>';
			$username = '<a href="'.$base_url.'&filter_login='.urlencode($row->user_login).'">'.$row->user_login.'</a>';

			$ip_info = cerber_get_ip_info($row->ip,true);
			if (isset($ip_info['hostname'])) $hostname = $ip_info['hostname'];
			else {
				$ip_id = cerber_get_id_ip($row->ip);
				$hostname = '<img data-ip-id="'.$ip_id .'" class="crb-no-hn" src="'.$assets_url.'ajax-loader-ip.gif" />'."\n";
			}

			$tip='';

			$acl = cerber_acl_check($row->ip);
			if ($acl == 'W') $tip = __('White IP Access List','wp-cerber');
			elseif ($acl == 'B') $tip = __('Black IP Access List','wp-cerber');

			if ( cerber_block_check( $row->ip ) ) {
				$block = ' color-blocked ';
				$tip .= ' ' . __( 'Locked out', 'wp-cerber' );
			}
			else $block='';


			//cerber_ago_time
			//$date = cerber_date($row->stamp);
			if (!empty($args['date']) && $args['date'] == 'ago') $date = cerber_ago_time($row->stamp);
			else $date = cerber_date($row->stamp);
			$list[]='<td><div class="act-icon ip-acl'.$acl.' '.$block.'" title="'.$tip.'"></div>'.$ip.'</td><td>'.$hostname.'</td><td>'.$date.'</td><td><span class="actv'.$row->activity.'">'.$labels[$row->activity].'</span></td><td>'.$name.'</td><td>'.$username.'</td>';
		}

		$titles = '<tr><th><div class="act-icon"></div>'.__('IP','wp-cerber').'</th><th>'.__('Hostname','wp-cerber').'</th><th>'.__('Date','wp-cerber').'</th><th>'.__('Activity','wp-cerber').'</th><th>'.__('Local User','wp-cerber').'</th><th>'.__('Username used','wp-cerber').'</th></tr>';
		$table='<table id="crb-activity" class="widefat crb-table cerber-margin"><thead>'.$titles.'</thead><tfoot>'.$titles.'</tfoot><tbody><tr>'.implode('</tr><tr>',$list).'</tr></tbody></table>';

		if (empty($args['no_navi'])) $table .= cerber_page_navi($total,$per_page);

		//$legend  = '<p>'.sprintf(__('Showing last %d records from %d','wp-cerber'),count($rows),$total);

		$info = $ip_text;
	}
	else {
		$info = '<p>'.__('No activity has been logged.','wp-cerber').'</p>';
		$table = '';
	}

	if (empty($args['no_navi'])) {
		// Navigation bar: Filter activity by ...
		$labels = array_slice( $labels, 0, 11, true );
		foreach ( $labels as $tag => $label ) {
			if ( in_array( $tag, (array) $falist ) ) {
				$links[] = '<b>' . $label . '</b>';
			} else {
				$links[] = '<a href="' . $base_url . '&filter_activity=' . $tag . '">' . $label . '</a>';
			}
		}
		$filters = '<p id = "activity-filter"><b>' . __( 'Show only', 'wp-cerber' ) . ':</b> ' . implode( ' | ', $links ) . '</p>';
	}
	else $filters = '';

	$ret = '<div class="cerber-margin">' . $filters . $info . '</div>'.$table;

	if ($echo) echo $ret;
	else return $ret;

	// echo '<div class="cerber-margin">' . $filters . $info . '</div>';
	// echo $table;

}
/*
 * Detailed information about IP address
 * @since 2.7
 *
 */
function cerber_ip_extra_view($ip){
	global $wp_cerber;
	if (!cerber_is_ip_or_net($ip)) return '';
	$tip = ' ';
	$acl = cerber_acl_check( $ip );
	if ( $acl == 'W' ) {
		$tip .= '<span class="color-green ip-info-label">'.__( 'White IP Access List', 'wp-cerber' ).'</span> ';
	} elseif ( $acl == 'B' ) {
		$tip .= '<span class="color-black ip-info-label">'.__( 'Black IP Access List', 'wp-cerber' ).'</span> ';
	}
	if ( cerber_block_check( $ip ) ) {
		$tip .= '<span class="color-blocked ip-info-label">'.__( 'Locked out', 'wp-cerber' ).'</span> ';
	}

	// Filter activity by ...

	/*$labels = cerber_get_labels('activity');
	foreach ($labels as $tag => $label) {
		//if (in_array($tag,$falist)) $links[] = '<b>'.$label.'</b>';
		$links[] = '<a href="'.$base_url.'&filter_activity='.$tag.'">'.$label.'</a>';
	}
	$filters = implode(' | ',$links);*/

	$whois = '';
	$country = '';
	$abuse = '';
	$network = '';
	$network_info = '';

	if (cerber_get_options('ip_extra')) {
		$ip_info = cerber_ip_whois_info($ip);
		if (isset($ip_info['whois'])) $whois = '<div id="whois">' . $ip_info['whois'] . '</div>';
		if (isset($ip_info['error'])) $whois = '<div id="whois">' . $ip_info['error'] . '</div>';
		if (isset($ip_info['country'])) $country = $ip_info['country'];
		if (!empty($ip_info['data']['abuse-mailbox'])) $abuse = '<p>'.__('Abuse email:','wp-cerber').' <a href="mailto:'.$ip_info['data']['abuse-mailbox'].'">'.$ip_info['data']['abuse-mailbox'].'</a></p>';
		if (!empty($ip_info['data']['network'])) {
			$network = $ip_info['data']['network'];
			$range = cerber_any2range($network);
			$network_info = '<p>'.__('Network:','wp-cerber').' '.$network.' &nbsp; <a href="'.cerber_activity_link(array('filter_ip'=>$range['range'])).'">'.__('Check for activity','wp-cerber').'</a></p>';
		}
	}

	$form = '';
	//if (!cerber_is_myip($ip) && !cerber_acl_check($ip)) $form = '<form action="" method="post"><input type="hidden" name="add_acl_B" value="'.$ip.'"><input type="submit" class="button button-primary cerber-button" value="'.__('Add IP to the Black List','wp-cerber').'" >'.wp_nonce_field('cerber_dashboard','cerber_nonce').'</form>';

	if (!cerber_is_myip($ip) && !cerber_acl_check($ip)) {

		if ( $network ) {
			$net_button = '<button type="submit" value="' . $network . '" class="button button-primary cerber-button">';
		} else {
			$net_button = '<button disabled="disabled" class="button button-secondary cerber-button">';
		}
		$net_button .= '<span class="dashicons-before dashicons-networking"></span> ' . __( 'Add network to the Black List', 'wp-cerber' ) . '</button> ';

		$form = '<form id="add-acl-black" action="" method="post">
				<input type="hidden" name="add_acl_B" value="">
				<button type="submit" value="'.$ip.'" class="button button-primary cerber-button"><span class="dashicons-before dashicons-desktop"></span> '.__('Add IP to the Black List','wp-cerber').'</button> '.
		        $net_button.
		        wp_nonce_field('cerber_dashboard','cerber_nonce').
		        '</form>';
	}

	$ret = '<div id="ip-extra">
			<table>
			<tr><td><p><span id = "ip-address">' . $ip . '</span><span id = "ip-country">' . $country .'</span>'. $tip .'</p>' . $network_info . $abuse . '</td><td>' . $form . '</td></tr>
			</table>
			</div>';

	return $ret.$whois;
}

/*
	Add admin menu & network admin bar link
*/
if (!is_multisite()) add_action('admin_menu', 'cerber_admin_menu');
else add_action('network_admin_menu', 'cerber_admin_menu'); // only network wide menu allowed in multisite mode
function cerber_admin_menu(){
	global $cerber_screen;
	if (!is_multisite()) {
		// old way via Settings
		$target = 'options-general.php';
		$cerber_screen = add_submenu_page($target,__('WP Cerber Settings','wp-cerber'),__('WP Cerber','wp-cerber'),'manage_options','cerber-settings', 'cerber_settings_page');
		// @since 3.1
		$hook = add_menu_page( __('WP Cerber Security','wp-cerber'), __('WP Cerber','wp-cerber'), 'manage_options', 'cerber-security', 'cerber_settings_page' ,'dashicons-shield', '100');
		add_action('load-'.$hook, "cerber_screen_options");
	}
	else {
		$target = 'settings.php';
		$cerber_screen = add_submenu_page($target,__('WP Cerber Settings','wp-cerber'),__('WP Cerber','wp-cerber'),'manage_options','cerber-settings', 'cerber_settings_page');
	}
}
/*
 * Redirect from old admin page
 *
 * */
add_action('admin_init',function(){
	if (is_multisite()) return;
	if (!empty($_GET['page']) && $_GET['page'] == 'cerber-settings'){
		$tab = '';
		if (!empty($_GET['tab'])){
			$tab = '&tab='.$_GET['tab'];
		}
		wp_safe_redirect( admin_url( 'admin.php?page=cerber-security'.$tab ) );
	}
});

add_action( 'admin_bar_menu', 'cerber_admin_bar' );
function cerber_admin_bar( $wp_admin_bar ) {
	if (!is_multisite()) return;
	$args = array(
		'parent' => 'network-admin',
		'id'    => 'cerber_admin',
		'title' => __('WP Cerber','wp-cerber'),
		'href'  => cerber_admin_link(),
	);
	$wp_admin_bar->add_node( $args );
}
/*
	Check if on the WP Cerber dashboard page
*/
function cerber_is_admin_page($force = true){
	if (isset($_GET['page']) && $_GET['page'] == 'cerber-security') return true;
	if (!$force) return false;
	$screen = get_current_screen();
	if ($screen->base == 'plugins') return true;
	/*
	if ($screen->parent_base == 'options-general') return true;
	if ($screen->parent_base == 'settings') return true;
	*/
	return false;
}

/*
 *
 * United options 2.0. Looks crazy? Because of Settings API! :-(
 * @since 2.0
 *
 *
 */
//add_action('admin_init', 'cerber_united_update');
/*
function cerber_united_update() {
	if ($_SERVER['REQUEST_METHOD']!='POST' || !isset($_POST['action']) || $_POST['action'] != 'update') return;
	if (false === strpos($_POST['option_page'],'cerberus-')) return;
	if (!current_user_can('manage_options')) return;

	// preparing some data...
	//$options=array('cerber-main','cerber-hardening'); // list of tabs (sections/groups of Settings API used with register_setting())
	$options=array(CERBER_OPT,CERBER_OPT_H); // list of tabs (sections/groups of Settings API used with register_setting())
	$opt_name = 'cerber-'.substr($_POST['option_page'],9); // 8 = length of 'cerberus-'
	unset($options[array_search($opt_name,$options)]);
	$default = cerber_get_defaults();
	$version = $default['version'];
	$default = array_map(function(){ return false; },$default);
	$default['version'] = $version; // preserve version

	// preparing is finished, we are ready to go
    $united = array_merge($default,$_POST[$opt_name]);

    foreach ($options as $opt) {
        $o = get_site_option($opt);
        if (!is_array($o)) continue;
        $united = array_merge($united,$o); // add old values from other sections/tabs to preserve it
    }
    if (is_multisite()) { // Settings API doesn't work here!
        $old = (array)get_site_option(CERBER_OPTIONS);
        $united = cerber_sanitize_options($united,$old);
        update_site_option($opt_name,$_POST[$opt_name]);
    }
    update_site_option(CERBER_OPTIONS,$united);
}
*/
/*
	Add custom columns to the Users screen
*/
add_filter('manage_users_columns' , 'cerber_u_columns');
function cerber_u_columns($columns) {
	return array_merge( $columns,
          	array('cbcc' => __('Comments','wp-cerber'),
          	'cbla' => __('Last login','wp-cerber') ,
          	'cbfl' => __('Failed attempts in last 24 hours','wp-cerber'),
          	'cbdr' => __('Date of registration','wp-cerber')) );
}
add_filter( 'manage_users_sortable_columns','cerber_u_sortable');
function cerber_u_sortable($sortable_columns) {
	$sortable_columns['cbdr']='user_registered';
	return $sortable_columns;
}
/*
	Display custom columns on the Users screen
*/
add_filter( 'manage_users_custom_column' , 'cerber_show_u_columns', 10, 3 );
function cerber_show_u_columns($value, $column, $user_id) {
	global $wpdb,$current_screen,$user_login;
	$ret = $value;
	switch ($column) {
		case 'cbcc' : // to get this work we need add filter 'preprocess_comment'
			if ($com = get_comments(array('author__in' => $user_id)))	$ret = count($com);
			else $ret = 0;
		break;
		case 'cbla' :
			$ret = $wpdb->get_var('SELECT MAX(stamp) FROM '.CERBER_LOG_TABLE.' WHERE user_id = '.$user_id);
			if ($ret) {
				$act_link = cerber_activity_link();
				$ret = '<a href="'.$act_link.'&filter_user='.$user_id.'">'.cerber_date($ret).'</a>';
			}
			else $ret=__('Never','wp-cerber');
		break;
		case 'cbfl' :
			$act_link = cerber_admin_link('activity');
			$u=get_userdata($user_id);
			$failed = $wpdb->get_var('SELECT count(user_id) FROM '.CERBER_LOG_TABLE.' WHERE user_login = \''.$u->user_login.'\' AND activity = 7 AND stamp > ' . (time() - 24 * 3600));
			$ret = '<a href="'.$act_link.'&filter_login='.$u->user_login.'&filter_activity=7">'.$failed.'</a>';
		break;
		case 'cbdr' :
			$time = strtotime($wpdb->get_var("SELECT user_registered FROM  $wpdb->users WHERE id = ".$user_id));
			$ret = cerber_date($time);
		break;
	}
	return $ret;
}

/*
	Show Tools screen
*/
function cerber_show_tools(){
	global $wpdb;
	$form = '<h3>'.__('Export settings to the file','wp-cerber').'</h3>';
	$form .= '<p>'.__('When you click the button below you will get a configuration file, which you can upload on another site.','wp-cerber').'</p>';
	$form .= '<p>'.__('What do you want to export?','wp-cerber').'</p><form action="" method="get">';
	$form .= '<input id="exportset" name="exportset" value="1" type="checkbox" checked> <label for="exportset">'.__('Settings','wp-cerber').'</label>';
	$form .= '<p><input id="exportacl" name="exportacl" value="1" type="checkbox" checked> <label for="exportacl">'.__('Access Lists','wp-cerber').'</label>';
	$form .= '<p><input type="submit" name="cerber_export" id="submit" class="button button-primary" value="'.__('Download file','wp-cerber').'"></form>';

	$form .= '<h3 style="margin-top:2em;">'.__('Import settings from the file','wp-cerber').'</h3>';
	$form .= '<p>'.__('When you click the button below, file will be uploaded and all existing settings will be overridden.','wp-cerber').'</p>';
	$form .= '<p>'.__('Select file to import.','wp-cerber').' '. sprintf( __( 'Maximum upload file size: %s.'), esc_html(size_format(wp_max_upload_size())));
	$form .= '<form action="" method="post" enctype="multipart/form-data">'.wp_nonce_field( 'crb_import', 'crb_field');
	$form .= '<p><input type="file" name="ifile" id="ifile" required="required">';
	$form .= '<p>'.__('What do you want to import?','wp-cerber').'</p><p><input id="importset" name="importset" value="1" type="checkbox" checked> <label for="importset">'.__('Settings','wp-cerber').'</label>';
	$form .= '<p><input id="importacl" name="importacl" value="1" type="checkbox" checked> <label for="importacl">'.__('Access Lists','wp-cerber').'</label>';
	$form .= '<p><input type="submit" name="cerber_import" id="submit" class="button button-primary" value="'.__('Upload file').'"></form>';
	echo $form;

	?>
	<h3 style="margin-top: 2em;">Diagnostic</h3>
	<input type="button" class="button button-primary" value="Show diagnostic information"
	       onclick="toggle_visibility('diagnostic'); return false;"/><p>
	<form id="diagnostic" style="display: none; margin-top: 2em;">
		<div>
			<h3>Cerber's database info</h3>
			<?php echo cerber_db_diag(); ?>
			<?php echo '<p style="text-align: right;"><a href="'.wp_nonce_url(add_query_arg(array('force_upgrade_db'=>1)),'control','cerber_nonce').'">Force upgrade tables</a></p>'; ?>
		</div>
		<div>
			<h3>System info</h3>
			<textarea name="dia"><?php
				global $wp_version;
				echo 'WordPress version: ' . $wp_version . "\n";
				echo 'PHP version: ' . phpversion() . "\n";
				foreach ( $_SERVER as $key => $value ) {
					if ( $key == 'HTTP_COOKIE' ) {
						continue;
					}
					//echo '['.$key.'] => '. htmlspecialchars($value)."\n";
					echo '[' . $key . '] => ' . strip_tags( $value ) . "\n";
				}
				?>
			</textarea>
		</div>
		<div>
			<h3>Cerber Lab status</h3>
			<?php
			echo lab_status();
			echo '<p style="text-align: right;"><a href="'.wp_nonce_url(add_query_arg(array('force_check_nodes'=>1)),'control','cerber_nonce').'">Force recheck nodes</a></p>';
			?>
		</div>
	</form>
	<script type="text/javascript">
	function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
    }
	</script>
	<?php
}
/*
	Create export file
*/
add_action('admin_init','cerber_export');
function cerber_export(){
	global $wpdb;
	if ($_SERVER['REQUEST_METHOD']!='GET' || !isset($_GET['cerber_export'])) return;
	if (!current_user_can('manage_options')) wp_die('Error!');
	$p = cerber_plugin_data();
	$data = array('cerber_version' => $p['Version'],'home'=> get_home_url(),'date'=>date('d M Y H:i:s'));
	//if ($_GET['exportset']) $data ['options'] = (array)get_site_option(CERBER_OPTIONS);
	if ($_GET['exportset']) $data ['options'] = cerber_get_options(); // @since 2.0
	if ($_GET['exportacl'])	$data ['acl'] = cerber_acl_all('ip,tag,comments');
	$file = json_encode($data);
	$file .= '==/'.strlen($file).'/'.crc32($file).'/EOF';
	header($_SERVER["SERVER_PROTOCOL"].' 200 OK');
	header("Content-type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Disposition: attachment; filename=wpcerber.config");
	echo $file;
	exit;
}
/*
	Load and Parse file and then import settings
*/
add_action('admin_init','cerber_import');
function cerber_import(){
	global $wpdb;
	if (!isset($_POST['cerber_import']) || $_SERVER['REQUEST_METHOD']!='POST') return;
	check_admin_referer('crb_import','crb_field');
	if (!current_user_can('manage_options')) wp_die('Upload failed.');
	$ok = true;
	if (!is_uploaded_file($_FILES['ifile']['tmp_name'])) {
		update_site_option('cerber_admin_notice',__('No file was uploaded or file is corrupted','wp-cerber'));
		return;
	}
	elseif ($file = file_get_contents($_FILES['ifile']['tmp_name'])) {
		$p = strrpos($file,'==/');
		$data = substr($file,0,$p);
		$sys = explode('/',substr($file,$p));
		if ($sys[3] == 'EOF' && crc32($data) == $sys[2] && ($data = json_decode($data, true))) {

			if ($_POST['importset'] && $data['options'] && is_array($data['options']) && !empty($data['options'])) {
				$data['options']['loginpath'] = urldecode($data['options']['loginpath']); // needed to work filter cerber_sanitize_options()
				cerber_save_options($data['options']); // @since 2.0
			}

			if ($_POST['importacl'] && $data['acl'] && is_array($data['acl']) && !empty($data['acl'])) {
				$acl_ok = true;
				if (false === $wpdb->query("DELETE FROM ".CERBER_ACL_TABLE)) $acl_ok = false;
				foreach($data['acl'] as $row) {
					// if (!$wpdb->query($wpdb->prepare('INSERT INTO '.CERBER_ACL_TABLE.' (ip,tag,comments) VALUES (%s,%s,%s)',$row[0],$row[1],$row[2]))) $acl_ok = false;
					// @since 3.1 if (!$wpdb->insert(CERBER_ACL_TABLE,array('ip'=>$row[0],'tag'=>$row[1],'comments'=>$row[2]),array('%s','%s','%s'))) $acl_ok = false;
					$ip = cerber_parse_ip($row[0]);
					if (!cerber_acl_add($ip,$row[1])){
						$acl_ok = false;
						break;
					}
				}
				if (!$acl_ok) update_site_option('cerber_admin_notice',__('Error while updating','wp-cerber').' '.__('Access Lists','wp-cerber'));
			}

			update_site_option('cerber_admin_message',__('Settings has imported successfully from','wp-cerber').' '.$_FILES['ifile']['name']);
		}
		else $ok = false;
	}
	if (!$ok) update_site_option('cerber_admin_notice',__('Error while parsing file','wp-cerber'));
}

/*
 	Registering widgets
*/
if (!is_multisite()) add_action( 'wp_dashboard_setup', 'cerber_widgets' );
else add_action( 'wp_network_dashboard_setup', 'cerber_widgets' );
function cerber_widgets() {
	if (!current_user_can('manage_options')) return;
	if (current_user_can( 'manage_options')) {
		wp_add_dashboard_widget( 'cerber_quick', __('Cerber Quick View','wp-cerber'), 'cerber_quick_w');
	}
}
/*
	Cerber Quick View widget
*/
function cerber_quick_w(){
	global $current_user,$wpdb;
	$set = cerber_admin_link();
	$act = cerber_admin_link('activity');
	$acl = cerber_admin_link('acl');
	$loc = cerber_admin_link('lockouts');
	//$midnight = strtotime('today');
	$opt = cerber_get_options();
	$failed = $wpdb->get_var('SELECT count(ip) FROM '. CERBER_LOG_TABLE .' WHERE activity IN (7) AND stamp > '.(time() - 24 * 3600));
	$failed_prev = $wpdb->get_var('SELECT count(ip) FROM '. CERBER_LOG_TABLE .' WHERE activity IN (7) AND stamp > '.(time() - 48 * 3600).' AND stamp < '.(time() - 24 * 3600));

	$failed_ch = cerber_percent($failed_prev,$failed);

	$locked = $wpdb->get_var('SELECT count(ip) FROM '. CERBER_LOG_TABLE .' WHERE activity IN (10,11) AND stamp > '.(time() - 24 * 3600));
	$locked_prev = $wpdb->get_var('SELECT count(ip) FROM '. CERBER_LOG_TABLE .' WHERE activity IN (10,11) AND stamp > '.(time() - 48 * 3600).' AND stamp < '.(time() - 24 * 3600));

	$locked_ch = cerber_percent($locked_prev,$locked);

	$lockouts = $wpdb->get_var('SELECT count(ip) FROM '. CERBER_BLOCKS_TABLE);
	if ($last = $wpdb->get_var('SELECT MAX(stamp) FROM '.CERBER_LOG_TABLE.' WHERE  activity IN (10,11)')) {
		$last = cerber_date($last);
	}
	else $last = __('Never','wp-cerber');
	$w_count = $wpdb->get_var('SELECT count(ip) FROM '. CERBER_ACL_TABLE .' WHERE tag ="W"' );
	$b_count = $wpdb->get_var('SELECT count(ip) FROM '. CERBER_ACL_TABLE .' WHERE tag ="B"' );

	if (cerber_is_citadel()) $citadel = '<span style="color:#FF0000;">'.__('active','wp-cerber').'</span> (<a href="'.wp_nonce_url(add_query_arg(array('citadel' => 'deactivate')),'control','cerber_nonce').'">'.__('deactivate','wp-cerber').'</a>)';
	else {
		if (cerber_get_options('ciperiod')) $citadel = __('not active','wp-cerber');
		else $citadel = __('disabled','wp-cerber');
	}

	echo '<div class="cerber-widget">';

	echo '<table style="width:100%;"><tr><td style="width:50%; vertical-align:top;"><table><tr><td class="bigdig">'.$failed.'</td><td class="per">'.$failed_ch.'</td></tr></table><p>'.__('failed attempts','wp-cerber').' '.__('in 24 hours','wp-cerber').'<br/>(<a href="'.$act.'&filter_activity=7">'.__('view all','wp-cerber').'</a>)</p></td>';
	echo '<td style="width:50%; vertical-align:top;"><table><tr><td class="bigdig">'.$locked.'</td><td class="per">'.$locked_ch.'</td></tr></table><p>'.__('lockouts','wp-cerber').' '.__('in 24 hours','wp-cerber').'<br/>(<a href="'.$act.'&filter_activity[]=10&filter_activity[]=11">'.__('view all','wp-cerber').'</a>)</p></td></tr></table>';

	echo '<table id="quick-info"><tr><td>'.__('Lockouts at the moment','wp-cerber').'</td><td>'.$lockouts.'</td></tr>';
	echo '<tr><td>'.__('Last lockout','wp-cerber').'</td><td>'.$last.'</td></tr>';
	echo '<tr><td style="padding-top:15px;">'.__('White IP Access List','wp-cerber').'</td><td style="padding-top:15px;"><b>'.$w_count.' '._n('entry','entries',$w_count,'wp-cerber').'</b></td></tr>';
	echo '<tr><td>'.__('Black IP Access List','wp-cerber').'</td><td><b>'.$b_count.' '._n('entry','entries',$b_count,'wp-cerber').'</b></td></tr>';
	echo '<tr><td style="padding-top:15px;">'.__('Citadel mode','wp-cerber').'</td><td style="padding-top:15px;"><b>'.$citadel.'</b></td></tr>';
	echo '</table></div>';

	echo '<div class="wilinks">
	<a href="'.$act.'"><span class="dashicons dashicons-welcome-view-site"></span> ' . __('Activity','wp-cerber').'</a> |
	<a href="'.$loc.'"><span class="dashicons dashicons-shield"></span> ' . __('Lockouts','wp-cerber').'</a> |
	<a href="'.$acl.'"><span class="dashicons dashicons-admin-network"></span> ' . __('Access Lists','wp-cerber').'</a> |
	<a href="'.$set.'"><span class="dashicons dashicons-admin-settings"></span> ' . __('Settings','wp-cerber').'</a>
	</div>';
	if ($msg = cerber_update_check())	echo '<div class="up-cerber">'.$msg.'</div>';
}

/*
	Show Help tab screen
*/
function cerber_show_help() {

	$assets_url = plugin_dir_url( CERBER_FILE ) . 'assets';

	?>
	<div style="margin: 10px;">

		<h3>What is Drill down IP?</h3>

		<p>
			To get extra information like country, company, network info, abuse contact etc. for specific IP address the plugin makes requests to a limited set of external WHOIS servers which are maintained by appropriate Registry. All Registry are accredited by ICANN, so there are no reasons for security concerns. Retrieved information isn't storing in the database, but it is caching for 24 hours to avoid excessive requests and get faster response.
		</p>
		<p><a href="http://wpcerber.com?p=194">Read more in the Security Blog</a></p>

		<h3>What is Cerber Lab?</h3>

		<p>
			Cerber Laboratory is a forensic team behind the WP Cerber security plugin. The team studies and analyzes patterns of hacker and botnet attacks, malware, vulnerabilities in major plugins and how are they exploitable on WordPress powered websites.
			 <a href="http://wpcerber.com/cerber-laboratory/">Know more</a>
		</p>

		<h3>Do you have a question or need help?</h3>

		<p>Support is provided on the WordPress forums for free, though please note that it is free support hence it is
			not always possible to answer all questions on a timely manner, although I do try.</p>

		<p><a href="http://wordpress.org/support/plugin/wp-cerber">Get answer on support forum</a>.</p>

		<h3>Do you have an idea for a cool new feature that you would love to see in WP Cerber?</h3>

		<p>
			Feel free to submit your ideas here: <a href="http://wpcerber.com/new-feature-request/">New Feature Request</a>.
		</p>

		<h3>Are you ready to translate this plugin into your language?</h3>

		<p>I would appreciate that! Please, <a href="http://wpcerber.com/support/">notify me</a></p>

		<h3 style="margin: 40px 0 40px 0;">Check out other plugins from the trusted author</h3>

		<div>

			<a href="https://wordpress.org/plugins/plugin-inspector/">

				<img src="<?php echo $assets_url . '/inspector.png' ?>"
				     style="float: left; width: 128px; margin-right: 20px;"/>
			</a>
			<h3>Plugin for inspecting code of plugins on your site: <a href="https://wordpress.org/plugins/plugin-inspector/">Plugin Inspector</a></h3>
			<p style="font-size: 110%">The Plugin Inspector plugin is an easy way to check plugins installed on your WordPress and make sure
				that plugins does not use deprecated WordPress functions and some unsafe functions like eval,
				base64_decode, system, exec etc. Some of those functions may be used to load malicious code (malware)
				from the external source directly to the site or WordPress database.
			</p>
			<p style="font-size: 110%">Plugin Inspector allows you to view all the deprecated functions complete with path, line number,
				deprecation function name, and the new recommended function to use. The checks are run through a simple
				admin page and all results are displayed at once. This is very handy for plugin developers or anybody
				who want to know more about installed plugins.
			</p>
		</div>

		<div style="margin: 40px 0 40px 0;">
			<a href="https://wordpress.org/plugins/goo-translate-widget/">
				<img src="<?php echo $assets_url . '/goo-translate.png' ?>"
				     style="float: left; width: 128px; margin-right: 20px;"/>
			</a>

			<h3>Plugin to quick translate site: <a href="https://wordpress.org/plugins/goo-translate-widget/">Google
					Translate Widget</a></h3>
			<p style="font-size: 110%">Google Translate Widget expands your global reach quickly and easily. Google Translate is a free
				multilingual machine translation service provided by Google to translate websites. And now you can allow
				visitors around of the world to get your site in their native language. Just put widget on the sidebar
				with one click.</p>

		</div>

	</div>
	<?php
}

/**
 *
 * Dashboard v.1
 *
 * @since 4.0
 *
 */
function cerber_show_dashboard() {
	global $wpdb;

	$num = 10;

	echo '<div style="padding-right: 30px;">';

	//$total = $wpdb->get_var( 'SELECT count(ip) FROM ' . CERBER_LOG_TABLE );
	//if ($total > $num) $l1 = 'Last ' . $num . ' suspect events are displayed';

	$view = '<a href="' . cerber_admin_link( 'activity' ) . '">' . __( 'View all', 'wp-cerber' ) . '</a>';
	echo '<table class="cerber-margin"><tr><td><h2 style="margin-bottom:0.5em;">' . __( 'Activity', 'wp-cerber' ) . '</h2></td><td> | ' . $view . '</td></tr></table>';

	cerber_show_activity( array(
		'filter_activity' => array( 1, 2, 5, 10, 12, 11, 41, 42, 50, 51, 52 ),
		'per_page'        => $num,
		'no_navi'         => true,
		'date'            =>'ago'
	) );


	//$total = $wpdb->get_var( 'SELECT count(ip) FROM ' . CERBER_BLOCKS_TABLE );
	//if ($total > $num) $l2 = '<p>Last ' . $num . ' lockouts of '.$total.' are displayed</p>';

	$view = '<a href="' . cerber_admin_link( 'lockouts' ) . '">' . __( 'View all', 'wp-cerber' ) . '</a>';
	echo '<table class="cerber-margin" style="margin-top:2em;"><tr><td><h2 style="margin-bottom:0.5em;">' . __( 'Recently locked out IP addresses', 'wp-cerber' ) . '</h3></td><td> | ' . $view . '</td></tr></table>';

	cerber_show_lockouts( array(
		'per_page' => $num,
		'no_navi'  => true
	) );

	echo '</div>';
}


/*
	Admin aside bar
*/
function cerber_show_aside($page){

	if (in_array($page,array('activity','lockouts'))) return;

	$aside = array();

	if (in_array($page,array('main'))) {
		$aside[]='<div class="crb-box">
			<h3>'.__('Confused about some settings?','wp-cerber').'</h3>'
			.__('You can easily load default recommended settings using button below','wp-cerber').'
			<p style="text-align:center;">
				<input type="button" class="button button-primary" value="'.__('Load default settings','wp-cerber').'" onclick="button_default_settings()" />
				<script type="text/javascript">function button_default_settings(){
					if (confirm("'.__('Are you sure?','wp-cerber').'")) {
						click_url = "'.wp_nonce_url(add_query_arg(array('load_settings'=>'default')),'control','cerber_nonce').'";
						window.location = click_url.replace(/&amp;/g,"&");
					}
				}</script>
			</p>
			<p><i>* '.__("doesn't affect Custom login URL and Access Lists",'wp-cerber').'</i></p>
		</div>';
	}

	$aside[] = '<div class="crb-box" id = "crb-subscribe">
			<div class="crb-box-inner">
			<h3>Be in touch with developer</h3>
			<p>Receive updates and helpful ideas to protect your website, blog, or business online.</p>
			<p>
			<span class="dashicons-before dashicons-email-alt"></span> &nbsp; <a href="http://wpcerber.com/subscribe-newsletter/" target="_blank">Subscribe to Cerber\'s newsletter</a></br>
			<span class="dashicons-before dashicons-twitter"></span> &nbsp; <a href="https://twitter.com/wpcerber">Follow Cerber on Twitter</a></br>
			<span class="dashicons-before dashicons-facebook"></span> &nbsp; <a href="https://www.facebook.com/wpcerber/">Follow Cerber on Facebook</a>
			</p>
			</div>
			</div>
	';

	$aside[] = '<div class="crb-box" id = "crb-donate">
			<div class="crb-box-inner">
			<h3>'.__('Donate','wp-cerber').'</h3>
			<p>Hi! It\'s Gregory. I am an author of this plugin. Please consider making a donation to support the continued development and free support of this plugin because I spend my free time for that. Any help is greatly appreciated. Thanks!</p>
			
			<div style="text-align:center;">
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="SR8RJXFU35EW8">
			<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG_global.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online.">
			<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
			</form>
			</div>
			
			</div>
			</div>';

	$aside[] = '<div class="crb-box" id = "crb-jetflow">
			<div class="crb-box-inner">
			<h3>Automate WordPress</h3>
			<p>Create automation scenarios without coding knowledge with the jetFlow.io plugin. Customize your WordPress in no time. No programming knowledge needed anymore.</p>
			<p><span class="dashicons-before dashicons-layout"></span> &nbsp; <a href="http://jetflow.io/" target="_blank">Download the jetFlow.io plugin</a></p>
			</div>
			</div>
	';

	$aside[] = '<div class="crb-box" id = "crb-blog">
			<div class="crb-box-inner">
			<!-- <h3><span class="dashicons-before dashicons-lightbulb"></span> Read Cerber\'s blog</h3> --> 
			<h3>WordPress security explained</h3>
			<p><a href="http://wpcerber.com/why-we-need-to-use-custom-login-url/" target="_blank">Why you need to use Custom login URL</a>
			<p><a href="http://wpcerber.com/using-ip-access-lists-to-protect-wordpress/" target="_blank">How IP Access Lists works</a>
			<p><a href="http://wpcerber.com/hardening-wordpress-with-wp-cerber/" target="_blank">Hardening WordPress with WP Cerber</a>
			<p><a href="http://wpcerber.com/know-more-about-intruder-ip-address/" target="_blank">Know more about intruder IP address</a>
			<p><a href="http://wpcerber.com/how-to-protect-wordpress-with-fail2ban/" target="_blank">How to protect WordPress with Fail2Ban</a>
			<p><a href="http://wpcerber.com/hardening-wordpress-with-wp-cerber-and-nginx/" target="_blank">Hardening WordPress with WP Cerber and NGINX</a>
		
		</div>
		</div>';

	echo '<div id="crb-aside">'.implode(' ',$aside).'</div>';
}

/*
	Just notices in dashboard
*/
add_action( 'admin_notices', 'cerber_admin_notice' , 999 );
add_action( 'network_admin_notices', 'cerber_admin_notice' , 999 );
function cerber_admin_notice(){
	global $cerber_shown;
	$cerber_shown = false;

	if (cerber_is_citadel() && current_user_can('manage_options')) {
		echo '<div class="update-nag crb-alarm"><p>'.
		__('Attention! Citadel mode is now active. Nobody is able to log in.','wp-cerber').
		' &nbsp; <a href="'.wp_nonce_url(add_query_arg(array('citadel' => 'deactivate')),'control','cerber_nonce').'">'.__('Deactivate','wp-cerber').'</a>'.
		' | <a href="' . cerber_admin_link('activity') . '">' . __('View Activity','wp-cerber') . '</a>' .
		     '</p></div>';
	}

	if (!cerber_is_admin_page()) return;

	cerber_update_check();

	//if ($notices = get_site_option('cerber_admin_notice'))
	//	echo '<div class="update-nag crb-note"><p>'.$notices.'</p></div>'; // class="updated" - green, class="update-nag" - yellow and above the page title,
	//if ($notices = get_site_option('cerber_admin_message'))
	//	echo '<div class="updated" style="overflow: auto;"><p>'.$notices.'</p></div>'; // class="updated" - green, class="update-nag" - yellow and above the page title,

	$all = array();
	if ( ! empty( $_GET['settings-updated'] ) ) {
		$all[] = array( __( 'Settings saved', 'wp-cerber' ), 'updated' );
	}

	if ( $notice = get_site_option( 'cerber_admin_notice' ) ) {
		$all[] = array( $notice, 'error' ); // red
	}
	if ( $notice = get_site_option( 'cerber_admin_message' ) ) {
		$all[] = array( $notice, 'updated' ); // green
	}


	// yellow #ffb900;
	if ($all) {
		$cerber_shown = true;
		foreach ( $all as $notice ) {
			echo '<div id="setting-error-settings_updated" class="' . $notice[1] . ' settings-error notice is-dismissible"> 
		<p>' . $notice[0] . '</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
		}
	}

	update_site_option('cerber_admin_notice', null);
	update_site_option('cerber_admin_message', null);

	if ($notice = get_site_option('cerber_admin_info')) { // need to be dismissed manually
		$cerber_shown = true;
		echo '<div class="updated cerber-msg" style="overflow: auto;"><p>'.$notice.'</p></div>';
	}
}

/*
	Check for a new version of plugin and create message if needed
*/
function cerber_update_check() {
	$ret = false;
	if ( $updates = get_site_transient( 'update_plugins' ) ) {
		$key = cerber_plug_in();
		if ( isset( $updates->checked[ $key ] ) && isset( $updates->response[ $key ] ) ) {
			$old = $updates->checked[ $key ];
			$new = $updates->response[ $key ]->new_version;
			if ( 1 === version_compare( $new, $old ) ) {
				// current version is lower than latest
				$ret = __( 'New version is available', 'wp-cerber' ) . ' <span class="dashicons dashicons-arrow-right"></span>';
				if ( is_multisite() ) {
					$href = network_admin_url( 'plugins.php?plugin_status=upgrade' );
				} else {
					$href = admin_url( 'plugins.php?plugin_status=upgrade' );
				}
				$msg = '<b>' . $ret . '</b> <a href="' . $href . '">' . sprintf( __( 'Update to version %s of WP Cerber', 'wp-cerber' ), $new ) . '</a>';
				update_site_option( 'cerber_admin_message', $msg );
				$ret = '<a href="' . $href . '">' . $ret . '</a>';

				// TODO: implement as a cron task, daily
				//update_site_option('cerber_new_version',array($new, time()));
				//cerber_send_notify('new_version');
			}
		}
	}
	return $ret;
}

/*
	Pagination
*/
function cerber_page_navi($total,$per_page = 20){
	$max_links = 10;
	$page = cerber_get_pn();
	$last_page = ceil($total / $per_page);
	$ret = '';
	if($last_page > 1){
		$start =1 + $max_links * intval(($page-1)/$max_links);
		$end = $start + $max_links - 1;
		if ($end > $last_page) $end = $last_page;
		if ($start > $max_links) $links[]='<a disabled="disabled" href="'.esc_url(add_query_arg('pagen',$start - 1)).'" >&laquo;</a>';
		for ($i=$start; $i <= $end; $i++) {
			if($page!=$i) $links[]='<a href="'.esc_url(add_query_arg('pagen',$i)).'" >'.$i.'</a>';
			else $links[]='<span class="cupage" style="font-size: 16px;">'.$i.'</span> ';
		}
		if($end < $last_page) $links[]='<a href="'.esc_url(add_query_arg('pagen',$i)).'" >&raquo;</a>';
		$ret = '<div class="tablenav"><div class="tablenav-pages cerber-margin" style="float:left;">'.$total.' '._n('entry','entries',$total,'wp-cerber').' &nbsp; '.implode(' ',$links).'</div></div>';
	}
	return $ret;
}
function cerber_get_pn(){
	$page = 1;
	if (isset($_GET['pagen'])) {
		$page = (int)$_GET['pagen'];
		if(!$page) $page = 1;
	}
	return $page;
}
/*
	Plugins screen links
*/
add_filter('plugin_action_links','cerber_action_links',10,4);
function cerber_action_links($actions, $plugin_file, $plugin_data, $context){
	if($plugin_file == cerber_plug_in()){
		$link[] = '<a href="' . cerber_admin_link() . '">' . __('Settings') . '</a>';
		$link[] = '<a href="' . cerber_admin_link('acl') . '">' . __('Access Lists','wp-cerber') . '</a>';
		$actions = array_merge ($link,$actions);
	}
	return $actions;
}
/*
 * Checks state of the art
 * @since 2.7.2
 *
 */
function cerber_db_diag(){
    global $wpdb,$wp_cerber;
	$ret = array();
	$ret[]= cerber_table_info(CERBER_LOG_TABLE);
	$ret[]= cerber_table_info(CERBER_ACL_TABLE);
	$ret[]= cerber_table_info(CERBER_BLOCKS_TABLE);
    if ($wp_cerber->getRemoteIp() == '127.0.0.1') $ret[] = '<p style="color: #DF0000;">It seems that we are unable to get IP addresses.</p>';

	if ($errors = get_site_option( '_cerber_db_errors')){
		$err = '<p style="color: #DF0000;">Some database errors were detected</p><textarea>'.print_r($errors,1).'</textarea>';
		update_site_option( '_cerber_db_errors', '');
	}
	else $err = '';

	return $err.implode('<p>',$ret);
}
function cerber_table_info($table){
	global $wpdb;
	if (!$wpdb->get_row("SHOW TABLES LIKE '".$table."'")) return '<p style="color: #DF0000;">ERROR. Database table '.$table.' not found! Deactivate and activate WP Cerber again.</p>';
	$columns = $wpdb->get_results("SHOW FULL COLUMNS FROM ".$table); 
	$info = '<tr><th style="width: 30%">Field</th><th style="width: 30%">Type</th><th style="width: 30%">Collation</th></tr>';
	foreach ($columns as $column) {
		$column = obj_to_arr_deep($column);
		$field = array_shift($column);
		$type = array_shift($column);
		$collation = array_shift($column);
		$info .= '<tr><td><b>'.$field.'<b></td><td>'.$type.'</td><td>'.$collation.'</td></tr>';
	}
	$rows = absint($wpdb->get_var('SELECT COUNT(*) FROM '.$table));
	return '<p>Table: '.$table.', rows: '.$rows.'</p><table cellpadding="5">'.$info.'</table>';
}
/*
function add_some_pointers() {
	?>
	<script type="text/javascript">
		jQuery(document).ready( function($) {
			var options = {'content':'<h3>Info</h3><p>Cerber will require RIPE database for extra information when you will click on IP.</p>','position':{'edge':'left','align':'center'}};
			if ( ! options ) return;
			options = $.extend( options, {
				close: function() {
					//to do
				}
			});
			$("#ip_extra").click(function(){
				$(this).pointer( options ).pointer('open');
			});
		});
	</script>
	<?php
}
add_action('admin_enqueue_scripts', 'cerber_admin_enqueue');
function cerber_admin_enqueue($hook) {
	wp_enqueue_style( 'wp-pointer' );
	wp_enqueue_script( 'wp-pointer' );
}
*/

/*
	Some admin styles & JS
*/
add_action('admin_head','cerber_admin_head');
function cerber_admin_head(){
	$assets_url = plugin_dir_url(CERBER_FILE).'assets';

	if ( cerber_is_admin_page() ) {
		?>
		<style type="text/css" media="all">
			.update-nag { display: none; } /* Aliens */
			div.wrap .update-nag { display: initial; } /* Cerber's */
		</style>
		<?php
	}

	?>
	<style type="text/css" media="all">

		/* Common */
		.crb-main {
			width: auto;
			overflow: hidden;
			padding-top: 1em;
		}

		.crb-main h2, .crb-main h3, .crb-main p{
			margin-top: 0.5em;
		}

		.cerber-margin {
			margin-left: 10px;
		}

		.cupage {
			padding: 10pt;
			font-weight: bold;
		}

		#crb-aside {
			float: right;
			width: 290px;
			margin: 1em 0;
		}

		@media (max-width: 1000px) {
			#crb-aside {
				display: none;
			}
		}

		/* Aside bar */

		#crb-aside .crb-box {
			background-color: #fff;
			border: 1px solid #E5E5E5;
			box-shadow: 0 1px 1px rgba(0, 0, 0, 0.04);
			padding: 0 1em 2em 1em;
			margin-bottom: 1em;
		}
		.crb-box-inner {
			position: relative;
			z-index: 2;
		}

		#crb-subscribe {
			position: relative;
		}
		#crb-subscribe:after {
			font-family: "dashicons";
			content: "\f507";
			position: absolute;
			font-size: 150px;
			color: lightblue;
			opacity: 0.5;
			top: 55%;
			left: 22%;
			z-index: 1;
		}
		#crb-jetflow {
			position: relative;
		}
		#crb-jetflow:after {
			font-family: "dashicons";
			content: "\f311";
			position: absolute;
			font-size: 150px;
			color: darkred;
			opacity: 0.2;
			top: 55%;
			left: 22%;
			z-index: 1;
		}
		#crb-blog {
			position: relative;
		}
		#crb-blog:after {
			font-family: "dashicons";
			content: "\f331";
			position: absolute;
			font-size: 150px;
			color: grey;
			opacity: 0.2;
			top: 55%;
			left: 22%;
			z-index: 1;
		}
		#crb-donate {
			position: relative;
		}
		#crb-donate:after {
			font-family: "dashicons";
			content: "\f487";
			position: absolute;
			font-size: 150px;
			color: red;
			opacity: 0.25;
			top: 35%;
			left: 22%;
			z-index: 1;
		}


		/* Messages */
		.crb-alarm {
			display: block;
			border-left: 6px solid #ff0000;
			/*
			background-color:#FF5E3C;
			color:#fff;*/
		}

		.crb-alarm a {
			font-weight: bold;
		}

		.crb-note > p::before { /*  content: "\e62e";  content: "\f339";  */
		}

		.cerber-msg td {
			vertical-align: top;
		}

		.cerber-msg td:nth-child(2) {
			padding-top: 6px;
		}

		.cerber-msg ul {
			margin-left: 1.3em;
		}

		.cerber-msg li {
			list-style-type: square;
		}

		.cerber-msg h3 {
			margin-top: 0;
		}

		.cerber-msg {
			font-size: 110%;
		}

		/* Tables */

		.crb-table {
			/*margin-top: 1em;*/
		}

		.crb-table tr:nth-child(even) {
			background: #f9f9f9
		}

		.crb-table tr:nth-child(odd) {
			background: #FFF
		}

		.crb-table td {
			vertical-align: middle;
		}

		/* IP info like WHOIS details */

		.ip-info-label {
			padding: 1px 6px 1px 6px;
			margin-left: 4px;
		}

		/* Activity */

		#activity-filter a{
			text-decoration: none;
		}

		.act-icon {
			display: inline-block;
			vertical-align: middle;
			width: 1em;
			height: 1em;
			margin-right: 1em;
			background-color: inherit;
		}

		.ip-aclB,.color-black {
			background-color: #000;
			color: #ffffff;
		}

		.ip-aclW,.color-green {
			background-color: #83CE77;
			color: #ffffff;
		}

		.color-blocked {
			background-color: #FF5733;
			color: #ffffff;
		}

		.green_label, .actv5 {
			display: inline-block;
			padding: 3px 5px 3px 5px;
			margin: 1px;
			background-color: #83CE77;
			color: #000;
			/*border-radius: 5px;*/
			border-left: 4px solid rgba(0, 0, 0, 0);
			border-right: 4px solid rgba(0, 0, 0, 0);
		}

		.red_label, .actv10, .actv11, .actv12, .actv41, .actv42 {
			display: inline-block;
			padding: 3px 5px 3px 5px;
			margin: 1px;
			background-color: #FF5733;
			color: #000;
			/*border-radius: 5px;*/
			border-left: 4px solid rgba(0, 0, 0, 0);
			border-right: 4px solid rgba(0, 0, 0, 0);
		}

		.yellow_label, .actv13, .actv14 {
			display: inline-block;
			padding: 3px 5px 3px 5px;
			margin: 1px;
			background-color: #FFFF80;
			color: #000;
			/*border-radius: 5px;*/
			border-left: 4px solid rgba(0, 0, 0, 0);
			border-right: 4px solid rgba(0, 0, 0, 0);
		}

		.actv10, .actv11, .actv12 {
			border-left: 4px solid rgba(0, 0, 0, .25);
		}

		/* ACL */
		.acl-wrapper {
			margin-bottom: 30px;
			width: 100%;
			max-width: 700px;
		}

		.acl-wrapper table td:first-child {
			width: 60%;
		}

		.acl-wrapper form table {
			margin-top: 1em;
			width: 100%;
			border-collapse: collapse;
		}
		.acl-wrapper form table td {
			padding: 0;
		}
		.acl-wrapper form input[type="text"]{
			width:100%;
		}

		.acl-items {
			border: 1px solid #aaa;
			background-color: #fff;

			max-height:400px;
			overflow: auto;
		}

		.acl-table {
			/*border: 1px solid #aaa;
			background-color: #fff;*/
			width: 100%;
		}
		.acl-table td:first-child {
			white-space: pre;
			font-family: Consolas, Monaco, monospace;
			font-size: 110%;
		}
		.acl-table td {
			padding: 6px;
			background-color: #f5f5f5;
		}
		.acl-table tr td:not(:first-child) {
		/*.acl-table tr td:nth-child(2) {*/
			/*width: 20%;*/
			text-align: center;
		}


		/* Tabs */
		.cerber-tabs span.dashicons {
			display: inline-block;
			vertical-align: middle;
			line-height: 18px;
		}

		.cerber-tabs .nav-tab-active {
			color: #804040;
			color: rgb(0, 103, 153);
		}

		/* Preserve line-height for tabs */

		.cerber-tabs sup,
		.cerber-tabs sub {
			height: 0;
			line-height: 1;
			vertical-align: baseline;
			_vertical-align: bottom;
			position: relative;
		}

		.cerber-tabs sup {
			bottom: 1ex;
		}

		.cerber-tabs sub {
			top: .5ex;
		}

		/* Users admin page */

		#cbcc, .cbcc, #cbfl, .cbfl {
			text-align: center;
		}

		/* Widgets */
		#cerber_quick .inside {
			padding: 0;
			background-image: url("<?php echo $assets_url; ?>/bgwidget.png");
			background-repeat: no-repeat;
			background-position: right top;
		}

		.cerber-widget {
			border-bottom-width: 1px;
			border-bottom-style: solid;
			border-bottom-color: #eeeeee;
			padding: 4px 12px 12px;

		}

		.cerber-widget .bigdig {
			font-size: 250%;
		}

		#quick-info td {
			padding: 0 8px 6px 0;
			font-size: 110%;
		}

		.cerber-widget td.per {
			vertical-align: middle;
			padding-left: 5px;
		}

		.wilinks, .up-cerber {
			padding: 12px;
			text-align: center;
		}

		.wilinks a {
			white-space: nowrap;
		}

		.up-cerber {
			background-color: #804040;
			font-size: 110%;
			color: #fff;
		}

		.up-cerber a {
			color: #fff;
			display: block;
		}

		/* Ip extra, whois */
		div#ip-extra {
			overflow: auto;
			padding: 10px 25px;
			background-color: #f8f8f8;
			border: solid 1px #ddd;
			border-bottom: none;
			vertical-align: middle;
		}
		div#ip-extra table{
			border-collapse: collapse;
			width: 100%;
		}
		div#ip-extra table td:nth-child(2){
			text-align: right;
		}
		div#ip-extra p{
			line-height: 0.7em !important;
		}
		/*div#ip-extra p:first-child {*/
		div#ip-extra span#ip-address,
		div#ip-extra span#ip-country{
			font-size: 115%;
			font-weight: bold;
		}
		div#ip-extra span#ip-address{
			margin-right: 1em;
		}
		div#ip-extra #ip-details {
			float: left;
			max-width: 30%;
		}
		div#ip-extra #acl-buttons{
			float:right;
			max-width: 30%;
		}
/*
		#acl-buttons form{
			position: absolute;
			top: 50%;
			transform: translateY(-50%);
		}*/

		div#whois {
			border: solid 1px #ddd;
			background-color: #fff;
			margin-bottom: 50px;
			padding: 15px 25px;
			overflow: auto;
			max-height: 200px;
			transition: max-height 0.2s ease-in;
		}
		div#whois:hover {
			max-height: 500px;
			transition: max-height 0.2s ease-out;
		}

		.whois-object {
			min-width: 20%;
			max-width: 50%;
			float: left;
			margin-right: 20px;
			background-color: #fff;
			border-left: #ddd solid 2px;
		}

		.whois-object tr td:first-of-type {
			padding-left: 10px;
		}

		.whois-object tr td:last-child {
			padding-right: 10px;
		}

		.raw pre {
			line-height: initial;
			white-space: pre-wrap; /* css-3 */
		}

		/* Diagnostic */

		#diagnostic div {
			border: 2px solid #ccc;
			width: 100%;
			max-width:800px;
			margin-top: 1em;
			padding: 0 1em;
		}
		#diagnostic table {
			background-color: #fff;
			width:100%;
			margin-bottom: 1em;
			border: 1px solid #ddd;
		}
		#diagnostic table th {
			text-align: left;
		}
		#diagnostic textarea {
			width: 100%;
			height: 400px;
			margin-bottom: 1em;
		}

		.cerber-button span.dashicons-before {
			display: inline-block;
			line-height: 18px;
			margin-left: 0.5em;
			margin-right: 0.5em;
		}

		@font-face {
			font-family: "cerber-icon";
			src:  url('<?php echo $assets_url; ?>/fonts/cerber.eot');
			src:  url('<?php echo $assets_url; ?>/fonts/cerber.eot#iefix') format('embedded-opentype'),
			url('<?php echo $assets_url; ?>/fonts/cerber.ttf') format('truetype'),
			url('<?php echo $assets_url; ?>/fonts/cerber.woff') format('woff');
			font-weight: normal;
			font-style: normal;
		}

		#adminmenu .toplevel_page_cerber-security div.wp-menu-image::before {
			font-family: "cerber-icon" !important;
			content: '\10ffff';
			-webkit-font-smoothing: antialiased;
			-moz-osx-font-smoothing: grayscale;
			padding: 4px 0 !important;
			margin-left: -0.6em !important;
			font-size: 23px !important;
		}


	</style>
	<?php
}
/*
 * Stuff for the footer
 *
 */
add_action('admin_footer','cerber_basement');
function cerber_basement(){
	//add_some_pointers();
	$assets_url = plugin_dir_url(CERBER_FILE).'assets';
	$ajax_nonce = wp_create_nonce('delete-ip');
	?>
	<script type="text/javascript">

		jQuery(document).ready(function($) {

			$(".delete_entry").click(function() {
				/* if (!confirm('<?php _e('Are you sure?','wp-cerber') ?>')) return; */
				$.post(ajaxurl,{
						action: 'cerber_ajax',
						acl_delete: $(this).data('ip'),
						ajax_nonce: '<?php echo $ajax_nonce; ?>'
					},
					onDeleteSuccess
				);
				/*$(this).parent().parent().fadeOut(500);*/
				/* $(this).closest("tr").FadeOut(500); */
			});
			function onDeleteSuccess(server_data) {
				var cerber_response =  $.parseJSON(server_data);
				$('.delete_entry[data-ip="'+cerber_response['deleted_ip']+'"]').parent().parent().fadeOut(300);
			}

			if ($(".crb-table").length) {
				function setHostNames(server_data) {
					var hostnames =  $.parseJSON(server_data);
					$(".crb-table .crb-no-hn").each(function(index) {
						$(this).replaceWith(hostnames[$(this).data('ip-id')]);
					});
				}
				var ip_list = $(".crb-table .crb-no-hn").map(
					function () {
						return $(this).data('ip-id');
					}
				);
				if (ip_list.length != 0) $.post(ajaxurl,{ action:'cerber_ajax', get_hostnames:ip_list.toArray() }, setHostNames);

			}

			$('#add-acl-black').submit(function( event ) {
				$(this).find('[name="add_acl_B"]').val($(this).find("button:focus").val());
			});
			
			$(".cerber-dismiss").click(function() {
				$(this).closest('.cerber-msg').fadeOut(500);

				$.get(ajaxurl,{
						action: 'cerber_ajax',
						dismiss_info: 1,
						button_id: $(this).attr('id'),
					}
				);
			});

		});
	</script>
	<?php
}
