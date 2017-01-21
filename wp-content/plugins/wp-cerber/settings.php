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


define('CERBER_OPT','cerber-main'); // tab 1
define('CERBER_OPT_H','cerber-hardening'); // tab 2
define('CERBER_OPT_U','cerber-users'); // tab 3
define('CERBER_OPT_C','cerber-recaptcha'); // tab 4
//define('CERBER_OPTIONS','cerberus');


/*
	WP Settings API
*/
add_action('admin_init', 'cerber_settings_init');
function cerber_settings_init(){

	// Main Settings tab

	$tab='main'; // 'cerber-main' settings
	register_setting( 'cerberus-'.$tab, 'cerber-'.$tab );

	add_settings_section('cerber', __('Limit login attempts','wp-cerber'), 'cerberus_section_main', 'cerber-'.$tab);
	add_settings_field('attempts',__('Attempts','wp-cerber'),'cerberus_field_show','cerber-'.$tab,'cerber',array('group'=>$tab,'option'=>'attempts','type'=>'attempts'));
	add_settings_field('lockout',__('Lockout duration','wp-cerber'),'cerberus_field_show','cerber-'.$tab,'cerber',array('group'=>$tab,'option'=>'lockout','type'=>'text','label'=>__('minutes','wp-cerber'),'size'=>3));
	add_settings_field('aggressive',__('Aggressive lockout','wp-cerber'),'cerberus_field_show','cerber-'.$tab,'cerber',array('group'=>$tab,'type'=>'aggressive'));
	add_settings_field('notify',__('Notifications','wp-cerber'),'cerberus_field_show','cerber-'.$tab,'cerber',array('group'=>$tab,'type'=>'notify','option'=>'notify'));
	add_settings_field('proxy',__('Site connection','wp-cerber'),'cerberus_field_show','cerber-'.$tab,'cerber',array('group'=>$tab,'option'=>'proxy','type'=>'checkbox','label'=>__('My site is behind a reverse proxy','wp-cerber')));

	add_settings_section('proactive', __('Proactive security rules','wp-cerber'), 'cerberus_section_proactive', 'cerber-'.$tab);
	add_settings_field('subnet',__('Block subnet','wp-cerber'),'cerberus_field_show','cerber-'.$tab,'proactive',array('group'=>$tab,'option'=>'subnet','type'=>'checkbox','label'=>__('Always block entire subnet Class C of intruders IP','wp-cerber')));
	add_settings_field('nonusers',__('Non-existent users','wp-cerber'),'cerberus_field_show','cerber-'.$tab,'proactive',array('group'=>$tab,'option'=>'nonusers','type'=>'checkbox','label'=>__('Immediately block IP when attempting to login with a non-existent username','wp-cerber')));
	add_settings_field('noredirect',__('Redirect dashboard requests','wp-cerber'),'cerberus_field_show','cerber-'.$tab,'proactive',array('group'=>$tab,'option'=>'noredirect','type'=>'checkbox','label'=>__('Disable automatic redirecting to the login page when /wp-admin/ is requested by an unauthorized request','wp-cerber')));
	add_settings_field('wplogin',__('Request wp-login.php','wp-cerber'),'cerberus_field_show','cerber-'.$tab,'proactive',array('group'=>$tab,'option'=>'wplogin','type'=>'checkbox','label'=>__('Immediately block IP after any request to wp-login.php','wp-cerber')));

	add_settings_section('custom', __('Custom login page','wp-cerber'), 'cerberus_section_custom', 'cerber-'.$tab);
	add_settings_field('loginpath',__('Custom login URL','wp-cerber'),'cerberus_field_show','cerber-'.$tab,'custom',array('group'=>$tab,'option'=>'loginpath','type'=>'text','label'=>__('must not overlap with the existing pages or posts slug','wp-cerber')));
	add_settings_field('loginnowp',__('Disable wp-login.php','wp-cerber'),'cerberus_field_show','cerber-'.$tab,'custom',array('group'=>$tab,'option'=>'loginnowp','type'=>'checkbox','label'=>__('Block direct access to wp-login.php and return HTTP 404 Not Found Error','wp-cerber')));

	add_settings_section('citadel', __('Citadel mode','wp-cerber'), 'cerberus_section_citadel', 'cerber-'.$tab);
	add_settings_field('citadel',__('Threshold','wp-cerber'),'cerberus_field_show','cerber-'.$tab,'citadel',array('group'=>$tab,'type'=>'citadel'));
	add_settings_field('ciduration',__('Duration','wp-cerber'),'cerberus_field_show','cerber-'.$tab,'citadel',array('group'=>$tab,'option'=>'ciduration','type'=>'text','label'=>__('minutes','wp-cerber'),'size'=>3));
	//add_settings_field('ciwhite',__('Whitelist','wp-cerber'),'cerberus_field_show','cerber-'.$tab,'citadel',array('group'=>$tab,'option'=>'ciwhite','type'=>'checkbox','label'=>__('Allow whitelist in Citadel mode','wp-cerber')));
	add_settings_field('cinotify',__('Notifications','wp-cerber'),'cerberus_field_show','cerber-'.$tab,'citadel',array('group'=>$tab,'option'=>'cinotify','type'=>'checkbox','label'=>__('Send notification to admin email','wp-cerber').' (<a href="'.wp_nonce_url(add_query_arg(array('testnotify'=>'citadel')),'control','cerber_nonce').'">'.__('Click to send test','wp-cerber').'</a>)'));

	add_settings_section('notify', __('Notifications','wp-cerber'), 'cerberus_section_activity', 'cerber-'.$tab);
	$def_email = '<b>'.get_site_option('admin_email').'</b>';
	add_settings_field('email',__('Email Address'),'cerberus_field_show','cerber-'.$tab,'notify',array('group'=>$tab,'option'=>'email','type'=>'text','label'=>sprintf(__('if empty, the admin email %s will be used','wp-cerber'),$def_email)));
	add_settings_field('emailrate',__('Notification limit','wp-cerber'),'cerberus_field_show','cerber-'.$tab,'notify',array('group'=>$tab,'option'=>'emailrate','type'=>'text','label'=>__('notification letters allowed per hour (0 means unlimited)','wp-cerber'),'size'=>3));

	add_settings_section('activity', __('Activity','wp-cerber'), 'cerberus_section_activity', 'cerber-'.$tab);
	add_settings_field('keeplog',__('Keep records for','wp-cerber'),'cerberus_field_show','cerber-'.$tab,'activity',array('group'=>$tab,'option'=>'keeplog','type'=>'text','label'=>__('days','wp-cerber'),'size'=>3));
	//$http = _wp_http_get_object();
	//if ($http->block_request(RIPE_HOST)) {}
	add_settings_field('ip_extra',__('Drill down IP','wp-cerber'),'cerberus_field_show','cerber-'.$tab,'activity',array('group'=>$tab,'option'=>'ip_extra','type'=>'checkbox','label'=>__('Retrieve extra WHOIS information for IP','wp-cerber').' <a href="' . cerber_admin_link('help') . '">Know more</a>'));
	add_settings_field('cerberlab',__('Cerber Lab connection','wp-cerber'),'cerberus_field_show','cerber-'.$tab,'activity',array('group'=>$tab,'option'=>'cerberlab','type'=>'checkbox','label'=>__('Send malicious IP addresses to the Cerber Lab','wp-cerber').' <a target="_blank" href="http://wpcerber.com/cerber-laboratory/">Know more</a>'));
	add_settings_field('cerberproto',__('Cerber Lab protocol','wp-cerber'),'cerberus_field_show','cerber-'.$tab,'activity',array('group'=>$tab,'option'=>'cerberproto','type'=>'select','set'=> array('HTTP', 'HTTPS')));
	add_settings_field('usefile',__('Use file','wp-cerber'),'cerberus_field_show','cerber-'.$tab,'activity',array('group'=>$tab,'option'=>'usefile','type'=>'checkbox','label'=>__('Write failed login attempts to the file','wp-cerber')));


	// Hardening tab

	$tab='hardening'; // 'cerber-hardening' settings
	register_setting( 'cerberus-'.$tab, CERBER_OPT_H);
	add_settings_section('hwp', __('Hardening WordPress','wp-cerber'), 'cerberus_section_'.$tab, CERBER_OPT_H);
	add_settings_field('stopenum',__('Stop user enumeration','wp-cerber'),'cerberus_field_show',CERBER_OPT_H,'hwp',array('group'=>$tab,'option'=>'stopenum','type'=>'checkbox','label'=>__('Block access to the pages like /?author=n','wp-cerber')));
	add_settings_field('xmlrpc',__('Disable XML-RPC','wp-cerber'),'cerberus_field_show',CERBER_OPT_H,'hwp',array('group'=>$tab,'option'=>'xmlrpc','type'=>'checkbox','label'=>__('Block access to the XML-RPC server (including Pingbacks and Trackbacks)','wp-cerber')));
	add_settings_field('nofeeds',__('Disable feeds','wp-cerber'),'cerberus_field_show',CERBER_OPT_H,'hwp',array('group'=>$tab,'option'=>'nofeeds','type'=>'checkbox','label'=>__('Block access to the RSS, Atom and RDF feeds','wp-cerber')));
	add_settings_field('norest',__('Disable REST API','wp-cerber'),'cerberus_field_show',CERBER_OPT_H,'hwp',array('group'=>$tab,'option'=>'norest','type'=>'checkbox','label'=>__('Block access to the WordPress REST API','wp-cerber')));
	//add_settings_field('cleanhead',__('Clean up HEAD','wp-cerber'),'cerberus_field_show','cerber-'.$tab,'hwp',array('group'=>$tab,'option'=>'cleanhead','type'=>'checkbox','label'=>__('Remove generator and version tags from HEAD section','wp-cerber')));
	//add_settings_field('ping',__('Disable Pingback','wp-cerber'),'cerberus_field_show','cerber-'.$tab,'hwp',array('group'=>$tab,'option'=>'ping','type'=>'checkbox','label'=>__('Block access to ping functional','wp-cerber')));

	// Users tab

	$tab='users'; // 'cerber-hardening' settings
	register_setting( 'cerberus-'.$tab, CERBER_OPT_U);
	add_settings_section('us', __('User related settings','wp-cerber'), 'cerberus_section_'.$tab, CERBER_OPT_U);
	add_settings_field('prohibited',__('Prohibited usernames','wp-cerber'),'cerberus_field_show',CERBER_OPT_U,'us',array('group'=>$tab,'option'=>'prohibited','type'=>'textarea','label'=>__('Usernames from this list are not allowed to log in or register. Any IP address, have tried to use any of these usernames, will be immediately blocked. Use comma to separate logins.','wp-cerber')));
	add_settings_field('auth_expire',__('User session expire','wp-cerber'),'cerberus_field_show',CERBER_OPT_U,'us',array('group'=>$tab,'option'=>'auth_expire','type'=>'text','label'=>__('in minutes (leave empty to use default WP value)','wp-cerber'),'size' => 6));

	$tab='recaptcha'; // 'cerber-hardening' settings
	register_setting( 'cerberus-'.$tab, CERBER_OPT_C);
	add_settings_section('recap', __('reCAPTCHA settings','wp-cerber'), 'cerberus_section_'.$tab, CERBER_OPT_C);
	add_settings_field('sitekey',__('Site key','wp-cerber'),'cerberus_field_show',CERBER_OPT_C,'recap',array('group'=>$tab,'option'=>'sitekey','type'=>'text','size' => 60));
	add_settings_field('secretkey',__('Secret key','wp-cerber'),'cerberus_field_show',CERBER_OPT_C,'recap',array('group'=>$tab,'option'=>'secretkey','type'=>'text','size' => 60));

	add_settings_field('recapreg',__('Registration form','wp-cerber'),'cerberus_field_show',CERBER_OPT_C,'recap',array('group'=>$tab,'option'=>'recapreg','type'=>'checkbox','label'=>__('Enable reCAPTCHA for WordPress registration form','wp-cerber')));
	add_settings_field('recapwooreg', '' ,'cerberus_field_show',CERBER_OPT_C,'recap',array('group'=>$tab,'option'=>'recapwooreg','type'=>'checkbox','label'=>__('Enable reCAPTCHA for WooCommerce registration form','wp-cerber')));

	add_settings_field('recaplost',__('Lost password form','wp-cerber'),'cerberus_field_show',CERBER_OPT_C,'recap',array('group'=>$tab,'option'=>'recaplost','type'=>'checkbox','label'=>__('Enable reCAPTCHA for WordPress lost password form','wp-cerber')));
	add_settings_field('recapwoolost', '' ,'cerberus_field_show',CERBER_OPT_C,'recap',array('group'=>$tab,'option'=>'recapwoolost','type'=>'checkbox','label'=>__('Enable reCAPTCHA for WooCommerce lost password form','wp-cerber')));

	add_settings_field('recaplogin',__('Login form','wp-cerber'),'cerberus_field_show',CERBER_OPT_C,'recap',array('group'=>$tab,'option'=>'recaplogin','type'=>'checkbox','label'=>__('Enable reCAPTCHA for WordPress login form','wp-cerber')));
	add_settings_field('recapwoologin', '' ,'cerberus_field_show',CERBER_OPT_C,'recap',array('group'=>$tab,'option'=>'recapwoologin','type'=>'checkbox','label'=>__('Enable reCAPTCHA for WooCommerce login form','wp-cerber')));

}
/*
	Generate HTML for every sections on settings pages
*/
function cerberus_section_main($args){
}
function cerberus_section_proactive($args){
	_e('Make your protection smarter!','wp-cerber');
}
function cerberus_section_custom($args){
	if (!get_option('permalink_structure')) {
		echo '<span style="color:#DF0000;">'.__('Please enable Permalinks to use this feature. Set Permalink Settings to something other than Default.','wp-cerber').'</span>';
	}
	else {
		_e('Be careful when enabling this options. If you forget the custom login URL you will not be able to login.','wp-cerber');
	}
}
function cerberus_section_citadel($args){
	_e("In Citadel mode nobody is able to login. Active user's sessions will not be affected.",'wp-cerber');
}
function cerberus_section_activity($args){
}
function cerberus_section_hardening($args){
	echo __("These settings do not affect hosts from the ",'wp-cerber').' '.__('White IP Access List','wp-cerber');
}
function cerberus_section_users($args){
}
function cerberus_section_recaptcha($args){
	_e('Before you can start using reCAPTCHA, you have to obtain Site key and Secret key on the Google website','wp-cerber');
	echo ' <a href="http://wpcerber.com/how-to-setup-recaptcha/">'.__('Know more','wp-cerber').'</a>';
	// https://www.google.com/recaptcha/admin
}

/*
 *
 * Generate HTML for settings page with tabs
 * @since 1.0
 *
 */
function cerber_settings_page(){
	global $wpdb;

	$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'dashboard';

	if (!in_array($active_tab,array('main','acl','activity','lockouts','messages','tools','help','hardening','users','recaptcha'))) $active_tab = 'dashboard';

	?>
	<div class="wrap">

		<h2><?php _e('WP Cerber Security','wp-cerber') ?></h2>

		<?php //cerber_admin_notice(); ?>

		<h2 class="nav-tab-wrapper cerber-tabs">
			<?php

			echo '<a href="' . cerber_admin_link() . '" class="nav-tab ' . ( $active_tab == 'dashboard' ? 'nav-tab-active' : '') . '"><span class="dashicons dashicons-dashboard"></span> ' . __('Dashboard') . '</a>';

			echo '<a href="' . cerber_admin_link('activity') . '" class="nav-tab ' . ( $active_tab == 'activity' ? 'nav-tab-active' : '') . '"><span class="dashicons dashicons-welcome-view-site"></span> ' . __('Activity','wp-cerber') . '</a>';

			$total = $wpdb->get_var('SELECT count(ip) FROM '. CERBER_BLOCKS_TABLE);
			echo '<a href="' . cerber_admin_link('lockouts') . '" class="nav-tab ' . ( $active_tab == 'lockouts' ? 'nav-tab-active' : '') . '"><span class="dashicons dashicons-shield"></span> ' . __('Lockouts','wp-cerber') . ' <sup class="loctotal">' . $total . '</sup></a>';

			echo '<a href="' . cerber_admin_link('main') . '" class="nav-tab ' . ( $active_tab == 'main' ? 'nav-tab-active' : '') . '"><span class="dashicons dashicons-admin-settings"></span> ' . __('Main Settings','wp-cerber') . '</a>';

			$total = $wpdb->get_var('SELECT count(ip) FROM '. CERBER_ACL_TABLE);
			echo '<a href="' . cerber_admin_link('acl') . '" class="nav-tab ' . ( $active_tab == 'acl' ? 'nav-tab-active' : '') . '"><span class="dashicons dashicons-admin-network"></span> ' . __('Access Lists','wp-cerber') . ' <sup class="acltotal">' . $total . '</sup></a>';

			echo '<a href="' . cerber_admin_link('hardening') . '" class="nav-tab ' . ( $active_tab == 'hardening' ? 'nav-tab-active' : '') . '"><span class="dashicons dashicons-shield-alt"></span> ' . __('Hardening','wp-cerber') . '</a>';

			echo '<a href="' . cerber_admin_link('users') . '" class="nav-tab ' . ( $active_tab == 'users' ? 'nav-tab-active' : '') . '"><span class="dashicons dashicons-admin-users"></span> ' . __('Users') . '</a>';
			//echo '<a href="'.cerber_admin_link('messages').'" class="nav-tab '. ($active_tab == 'messages' ? 'nav-tab-active' : '') .'">'. __('Messages','wp-cerber').'</a>';

			echo '<a href="' . cerber_admin_link('recaptcha') . '" class="nav-tab ' . ( $active_tab == 'recaptcha' ? 'nav-tab-active' : '') . '"><span class="dashicons dashicons-marker"></span> ' . __('reCAPTCHA','wp-cerber') . '</a>';

			echo '<a href="' . cerber_admin_link('tools') . '" class="nav-tab ' . ( $active_tab == 'tools' ? 'nav-tab-active' : '') . '"><span class="dashicons dashicons-admin-tools"></span> ' . __('Tools','wp-cerber') . '</a>';

			echo '<a href="' . cerber_admin_link('help') . '" class="nav-tab ' . ( $active_tab == 'help' ? 'nav-tab-active' : '') . '"><span class="dashicons dashicons-editor-help"></span> ' . __('Help','wp-cerber') . '</a>';

			?>
		</h2>
		<?php

		cerber_show_aside($active_tab);

		echo '<div class="crb-main">';
		if ($active_tab == 'acl') cerber_acl_form();
		elseif ($active_tab == 'activity') cerber_show_activity();
		elseif ($active_tab == 'lockouts') cerber_show_lockouts();
		elseif ($active_tab == 'tools') cerber_show_tools();
		elseif ($active_tab == 'help') cerber_show_help();
		elseif ($active_tab == 'dashboard') cerber_show_dashboard();
		else cerber_show_settings($active_tab);
		echo '</div>';

		$pi = get_file_data(cerber_plugin_file(),array('Version' => 'Version'),'plugin');
		$pi ['time'] = time();
		$pi ['user'] = get_current_user_id();
		update_site_option('_cp_tabs_'.$active_tab,serialize($pi));

		?>
	</div>
	<?php
}
/*
 * Display settings screen (one tab)
 *
 */
function cerber_show_settings($active_tab = null){
	if (is_multisite()) $action =  ''; // Settings API doesn't work in multisite. Post data will be handled in the cerber_ms_update()
	else $action ='options.php';
	// Display form with settings fields via Settings API
	echo '<form method="post" action="'.$action.'">';

	settings_fields( 'cerberus-'.$active_tab ); // option group name, the same as used in register_setting().
	do_settings_sections( 'cerber-'.$active_tab ); // the same as used in add_settings_section()	$page

	submit_button();
	echo '</form>';
}
/*
 * Prepare values to display.
 * Generate HTML for one input field on the settings page.
 *
 *
 */
function cerberus_field_show($args){
	$settings = get_site_option('cerber-'.$args['group']);
	//if (is_array($settings)) $settings = array_map('esc_html',$settings); // yes, that's it, API settings is a nightmare!
	if (is_array($settings)) array_walk_recursive($settings,'esc_html'); // yes, that's it, API settings is a nightmare!
	$pre = '';
	$value = '';
	if (!empty($args['label'])) $label = $args['label'];
	else $label = '';
	if (isset($args['option'])){
		if (isset($settings[$args['option']])) $value = $settings[$args['option']];
		if (($args['option'] == 'loginnowp' || $args['option'] == 'loginpath') && !get_option('permalink_structure')) $disabled = ' disabled="disabled" '; else $disabled = '';
		if ($args['option'] == 'loginpath') {
			$pre = rtrim(get_home_url(),'/').'/';
			$value = urldecode($value);
		}
		if ($args['option'] == 'prohibited') {
			if (!empty($value) && is_array($value)) $value = implode(', ',$value);
			else $value = '';
		}
	}
	switch ($args['type']) {
		case 'attempts':
			$html=sprintf(__('%s allowed retries in %s minutes','wp-cerber'),
				'<input type="text" id="attempts" name="cerber-'.$args['group'].'[attempts]" value="'.$settings['attempts'].'" size="3" maxlength="3" />',
				'<input type="text" id="period" name="cerber-'.$args['group'].'[period]" value="'.$settings['period'].'" size="3" maxlength="3" />');
			break;
		case 'aggressive':
			$html=sprintf(__('Increase lockout duration to %s hours after %s lockouts in the last %s hours','wp-cerber'),
				'<input type="text" id="agperiod" name="cerber-'.$args['group'].'[agperiod]" value="'.$settings['agperiod'].'" size="3" maxlength="3" />',
				'<input type="text" id="aglocks" name="cerber-'.$args['group'].'[aglocks]" value="'.$settings['aglocks'].'" size="3" maxlength="3" />',
				'<input type="text" id="aglast" name="cerber-'.$args['group'].'[aglast]" value="'.$settings['aglast'].'" size="3" maxlength="3" />');
			break;
		case 'notify':
			$html= '<input type="checkbox" id="'.$args['option'].'" name="cerber-'.$args['group'].'['.$args['option'].']" value="1" '.checked(1,$value,false).$disabled.' /> '
			       .__('Notify admin if the number of active lockouts above','wp-cerber').
			       ' <input type="text" id="above" name="cerber-'.$args['group'].'[above]" value="'.$settings['above'].'" size="3" maxlength="3" />'.
			       ' (<a href="'.wp_nonce_url(add_query_arg(array('testnotify'=>'lockout')),'control','cerber_nonce').'">'.__('Click to send test','wp-cerber').'</a>)';
			break;
		case 'citadel':
			$html=sprintf(__('Enable after %s failed login attempts in last %s minutes','wp-cerber'),
				'<input type="text" id="cilimit" name="cerber-'.$args['group'].'[cilimit]" value="'.$settings['cilimit'].'" size="3" maxlength="3" />',
				'<input type="text" id="ciperiod" name="cerber-'.$args['group'].'[ciperiod]" value="'.$settings['ciperiod'].'" size="3" maxlength="3" />');
			break;
		case 'checkbox':
			$html='<input type="checkbox" id="'.$args['option'].'" name="cerber-'.$args['group'].'['.$args['option'].']" value="1" '.checked(1,$value,false).$disabled.' />';
			$html.= ' <label for="'.$args['option'].'">'.$args['label'].'</label>';
			break;
		case 'textarea':
			$html='<textarea class="large-text code" id="'.$args['option'].'" name="cerber-'.$args['group'].'['.$args['option'].']" '.$disabled.' />'.$value.'</textarea>';
			$html.= '<br><label for="'.$args['option'].'">'.$args['label'].'</label>';
			break;
		case 'select':
			foreach ($args['set'] as $key => $opt ) {
				if ($value == $key) {
					$s = 'selected';
				}
				else $s = '';
				$options[]= '<option value="'.$key.'" '.$s.'>'.htmlspecialchars($opt).'</option>';
			}
			$html='<select class="" name="cerber-'.$args['group'].'['.$args['option'].']">'.implode("\n",$options).'</select>';
			break;		
		default:
			if (isset($args['size'])) $size=' size="'.$args['size'].'" maxlength="'.$args['size'].'" '; else $size='';
			$html=$pre.'<input type="text" id="'.$args['option'].'" name="cerber-'.$args['group'].'['.$args['option'].']" value="'.$value.'"'.$disabled.$size.'/>';
			$html.= ' <label for="'.$args['option'].'">'.$label.'</label>';
			break;
	}
	echo $html;
}

/*
	Sanitizing users input for Main Settings
*/
add_filter( 'pre_update_option_'.CERBER_OPT, 'cerber_sanitize_options', 10, 3 );
function cerber_sanitize_options($new, $old, $option) { // $option added in WP 4.4.0

	$new['attempts'] = absint( $new['attempts'] );
	$new['period']   = absint( $new['period'] );
	$new['lockout']  = absint( $new['lockout'] );

	$new['agperiod'] = absint( $new['agperiod'] );
	$new['aglocks']  = absint( $new['aglocks'] );
	$new['aglast']   = absint( $new['aglast'] );

	if ( get_option( 'permalink_structure' ) ) {
		$new['loginpath'] = urlencode( str_replace( '/', '', $new['loginpath'] ) );
		if ( $new['loginpath'] && $new['loginpath'] != $old['loginpath'] ) {
			$href = get_home_url() . '/' . $new['loginpath'] . '/';
			$url  = urldecode( $href );
			$msg  = __( 'Attention! You have changed the login URL! The new login URL is', 'wp-cerber' );
			update_site_option( 'cerber_admin_notice', $msg . ': <a href="' . $href . '">' . $url . '</a>' );
			cerber_send_notify( 'newlurl', $msg . ': ' . $url );
		}
	} else {
		$new['loginpath'] = '';
		$new['loginnowp'] = 0;
	}

	$new['ciduration'] = absint( $new['ciduration'] );
	$new['cilimit']    = absint( $new['cilimit'] );
	$new['cilimit']    = $new['cilimit'] == 0 ? '' : $new['cilimit'];
	$new['ciperiod']   = absint( $new['ciperiod'] );
	$new['ciperiod']   = $new['ciperiod'] == 0 ? '' : $new['ciperiod'];
	if ( ! $new['cilimit'] ) {
		$new['ciperiod'] = '';
	}
	if ( ! $new['ciperiod'] ) {
		$new['cilimit'] = '';
	}

	if ( ! empty( $new['email'] ) && ! is_email( $new['email'] ) ) {
		$new['email'] = $old['email'];
		update_site_option( 'cerber_admin_notice', __( '<strong>ERROR</strong>: please enter a valid email address.' ) );
	}
	$new['emailrate'] = absint( $new['emailrate'] );

	if ( absint( $new['keeplog'] ) == 0 ) {
		$new['keeplog'] = '';
	}

	return $new;
}
/*
	Sanitizing users input for User related settings
*/
add_filter( 'pre_update_option_'.CERBER_OPT_U, 'cerber_sanitize_u', 10, 3 );
function cerber_sanitize_u($new, $old, $option) { // $option added in WP 4.4.0
	$list = explode(',',$new['prohibited']);
	$list = array_map('trim', $list);
	$list = array_filter($list);
	$list = array_unique($list);
	$new['prohibited'] = $list;
	return $new;
}
/*
	Sanitizing users input for reCAPTCHA related settings
*/
add_filter( 'pre_update_option_'.CERBER_OPT_C, 'cerber_sanitize_c', 10, 3 );
function cerber_sanitize_c($new, $old, $option) {
	global $wp_cerber;
	// Check abilty to make external HTTP requests
	if (!empty($new['sitekey']) && !empty($new['secretkey'])) {
		if (!$goo = $wp_cerber->reCaptchaRequest()) {
			$labels = cerber_get_labels( 'activity' );
			update_site_option( 'cerber_admin_notice', __( 'ERROR:', 'wp-cerber' ) . ' ' . $labels[42] );
			cerber_log( 42 );
		}
	}
	return $new;
}
/*
 *
 * Process POST Form for settings screens in multisite mode.
 * Because of Settigns API doesn't work in multisite mode!
 *
 */
if (is_multisite())  add_action('admin_init', 'cerber_ms_update'); // allowed only for network
function cerber_ms_update() {
	if ( $_SERVER['REQUEST_METHOD'] != 'POST' || ! isset( $_POST['action'] ) || $_POST['action'] != 'update' ) {
		return;
	}
	if ( ! isset( $_POST['option_page'] ) || false === strpos( $_POST['option_page'], 'cerberus-' ) ) {
		return;
	}
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$opt_name = 'cerber-' . substr( $_POST['option_page'], 9 ); // 8 = length of 'cerberus-'

	$old = (array) get_site_option( $opt_name );
	$new = $_POST[ $opt_name ];
	//$new = cerber_sanitize_options($new,$old);
	$new = apply_filters( 'pre_update_option_' . $opt_name, $new, $old, $opt_name );
	update_site_option( $opt_name, $new );
}

/*
 * 	Default settings
 *
 */
function cerber_get_defaults($field = null) {
	$all_defaults = array(
		CERBER_OPT   => array(
			'attempts' => 3,
			'period'   => 60,
			'lockout'  => 60,
			'agperiod' => 24,
			'aglocks'  => 2,
			'aglast'   => 4,
			'notify'   => 1,
			'above'    => 3,

			'proxy' => 0,

			'subnet'     => 0,
			'nonusers'   => 1,
			'wplogin'    => 0,
			'noredirect' => 1,

			'loginpath' => '',
			'loginnowp' => 0,

			'cilimit'    => 200,
			'ciperiod'   => 30,
			'ciduration' => 60,
			'ciwhite'    => 1,
			'cinotify'   => 1,
			'email'      => '',
			'emailrate'      => 12,

			'keeplog' => 30,
			'ip_extra' => 1,
			'cerberlab' => 0,
			'cerberproto' => 0,
			'usefile' => 0,

		),
		CERBER_OPT_H => array(
			'stopenum' => 1,
			'xmlrpc'   => 0,
			'nofeeds'  => 0,
			'norest'  => 1,
			'cleanhead'  => 1,
		),
		CERBER_OPT_U => array(
			'prohibited' => array(),
			'auth_expire' => '',
		),
		CERBER_OPT_C => array(
			'sitekey' => '',
			'secretkey' => '',
			'recaplogin' => 0,
			'recaplost' => 0,
			'recapreg' => 0,
			'recapwoologin' => 0,
			'recapwoolost' => 0,
			'recapwooreg' => 0,
		),
	);
	if ( $field ) {
		foreach ( $all_defaults as $option ) {
			if ( isset( $option[ $field ] ) ) {
				return $option[ $field ];
			}
		}
		return false;
	} else {
		return $all_defaults;
	}
}

/*
 *
 * Right way to save Cerber settings outside of wp-admin settings page
 * @since 2.0
 *
 */
function cerber_save_options($options){
	foreach ( cerber_get_defaults() as $option_name => $fields ) {
		$save=array();
		foreach ( $fields as $field_name => $def ) {
			if (isset($options[$field_name])) $save[$field_name]=$options[$field_name];
		}
		if (!empty($save)) {
			$result = update_site_option($option_name,$save);
		}
	}
}

/*
	Right way to access to the Cerber settings
*/
function cerber_get_options($option = '') {
	$options = array( CERBER_OPT, CERBER_OPT_H, CERBER_OPT_U, CERBER_OPT_C );
	$united  = array();
	foreach ( $options as $opt ) {
		$o = get_site_option( $opt );
		if (!is_array($o)) continue;
		$united = array_merge( $united, $o );
	}
	$options = $united;
	//$options = get_site_option( CERBER_OPTIONS );
	if ( ! empty( $option ) ) {
		if ( isset( $options[ $option ] ) ) {
			return $options[ $option ];
		} else {
			return false;
		}
	}
	return $options;
}
/*
	Email for notification
*/
function cerber_get_email() {
	if (!$email = cerber_get_options('email'))	$email = get_site_option('admin_email');
	return $email;
}
/*
	Load default settings, except Custom Login URL
*/
function cerber_load_defaults() {
	$save = array();
	foreach ( cerber_get_defaults() as $option_name => $fields ) {
		foreach ( $fields as $field_name => $def ) {
			$save[ $field_name ] = $def;
		}
	}
	$old = cerber_get_options();
	if (!empty($old['loginpath'])) $save['loginpath'] = $old['loginpath'];
	cerber_save_options( $save );
}
/*
	Return link to the Cerber settings page and particular tab if it is specified
*/
function cerber_admin_link($tab = '', $args = array()){
	//return add_query_arg(array('record_id'=>$record_id,'mode'=>'view_record'),admin_url('admin.php?page=storage'));
	if (!is_multisite()) {
		//$base = admin_url('options-general.php');
		$link = admin_url('admin.php?page=cerber-security');
	}
	else {
		$base = network_admin_url('settings.php');
		$link = $base . '?page=cerber-settings';
	}
	if ( $tab ) {
		$link .= '&tab=' . $tab;
	}
	if ( $args ) {
		foreach ( $args as $arg => $value ) {
			$link .= '&' . $arg . '=' . urlencode( $value );
		}
	}

	return $link;
}
function cerber_activity_link($args = array()){
	return cerber_admin_link('activity', $args);
}
/*
function cerber_get_opage($tag = ''){
	if (!is_multisite()) $target = 'options-general.php'; // must use admin_url();
	else $target = 'network/settings.php';	 // must use network_admin_url();
	$opage = $target . '?page=cerber-settings';
	if ($tag) $opage .= '&tab='.$tag;
	return $opage;
}
 */

/*
 * Add per screen settings
 * @since 3.0
 *
 */
function cerber_screen_options() {
	if (!empty($_GET['tab'])) $tab = $_GET['tab'];
	else $tab = 'activity';
	if ( $tab && !in_array( $tab, array( 'lockouts', 'activity' ) ) ) {
		return;
	}
	$args = array(
		'label' => __( 'Number of items per page:' ),
		'default' => 50,
		'option' => 'cerber_screen_'.$tab,
	);
	add_screen_option( 'per_page', $args );
	// add_screen_option( 'layout_columns', array('max' => 2, 'default' => 2) );
}
/*
 * Allows to save options to the user meta
 * @since 3.0
 *
 */
add_filter('set-screen-option', 'cerber_save_screen_option', 10, 3);
function cerber_save_screen_option($status, $option, $value) {
	if (!empty($_GET['tab'])) $tab = $_GET['tab'];
	else $tab = 'activity';
	if ( 'cerber_screen_'.$tab == $option ) return $value;
	return $status;
}
/*
 * Retrieve option for current screen
 * @since 3.0
 *
 */
function cerber_get_per_page(){
	if (is_multisite()) return 50; // temporary workaround
	$screen = get_current_screen();
	$screen_option = $screen->get_option('per_page', 'option');
	if ($screen_option == 'cerber_screen_') $screen_option = 'cerber_screen_activity';
	$per_page = get_user_meta(get_current_user_id(), $screen_option, true);
	if ( empty ( $per_page) || $per_page < 1 ) {
		$per_page = $screen->get_option( 'per_page', 'default' );
	}
	return $per_page;
}
