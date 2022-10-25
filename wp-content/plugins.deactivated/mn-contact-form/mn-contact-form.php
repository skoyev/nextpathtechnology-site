<?php
/*
	*Plugin Name: MN Contact Form
	*Plugin URI: http://mnthemes.com/plugins/mncontacts
	*Description: This is simple widget and [short-code] based contact form Plugin. use the Wordpress widget ( MN Contact form ) to embed it to any sidebar region or use Shortcode [mn_contact_free] to embed it into your page. Also has option to save contacts to Database.
	*Version: 1.4
	*Author: MN Themes
	*Author Email: support@mnthemes.com
	*License: GPLv2 or later
	*License URI: http://www.gnu.org/licenses/gpl-2.0.html
  
*/
	add_action('init', 'mnLoadPluginTextdomain');

	/**
	* Load the language files for this plugin
	* @param void
	* @return void
	*/
	function mnLoadPluginTextdomain() {
		load_plugin_textdomain('mn-contact-form', false, 'mn-contact-form/lang');
	}

	function is_session_started()
	{
		if ( php_sapi_name() !== 'cli' ) {
			if ( version_compare(phpversion(), '5.4.0', '>=') ) {
				return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
			} else {
				return session_id() === '' ? FALSE : TRUE;
			}
		}
		return FALSE;
	}
	
	// Example
	if ( is_session_started() === FALSE ) session_start();
		
	add_filter('plugin_action_links', 'mn_contact_free_add_settings_link', 10, 2);
	function mn_contact_free_add_settings_link($links, $file) {
		static $this_plugin;
		if (!$this_plugin) {
		$this_plugin = plugin_basename(__FILE__);
		}
		if ($file == $this_plugin) {
			// The "page" query string value must be equal to the slug
			// of the Settings admin page we defined earlier, which in
			// this case equals "myplugin-settings".
			$settings_link = '<a href="'.admin_url( 'admin.php?page=mn_contact_settings' ).'">Settings</a>';
			array_unshift($links, $settings_link);
		}
		return $links;
	}
	
  
	/**
	 * Runs when the plugin is activated
	 */ 
	register_activation_hook( __FILE__, 'install_mn_contact_form' ); 
	add_action('init', 'install_mn_contact_form');
	function install_mn_contact_form() {
		global $wpdb;
		$table_name = $wpdb->prefix . "mn_form_data";
		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `user_name` varchar(200) NOT NULL,
				  `user_email` varchar(100) NOT NULL,
				  `user_message` text NOT NULL,
				  `user_ip` varchar(100) NOT NULL,
				  `user_port` varchar(100) NOT NULL,
				  `user_browser` varchar(100) NOT NULL,
				  `sub_date` varchar(100) NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		
		if(mysql_query("SELECT * FROM information_schema.COLUMNS WHERE COLUMN_NAME='user_phone' AND TABLE_NAME='$table_name'")){
			mysql_query("ALTER TABLE $table_name ADD user_phone varchar(100) NOT NULL DEFAULT '';");
		}
		if(mysql_query("SELECT * FROM information_schema.COLUMNS WHERE COLUMN_NAME='user_address' AND TABLE_NAME='$table_name'")){
			mysql_query("ALTER TABLE $table_name ADD user_address varchar(100) NOT NULL DEFAULT '';");
		}
		if(mysql_query("SELECT * FROM information_schema.COLUMNS WHERE COLUMN_NAME='user_website' AND TABLE_NAME='$table_name'")){
			mysql_query("ALTER TABLE $table_name ADD user_website varchar(100) NOT NULL DEFAULT '';");
		}
		if(mysql_query("SELECT * FROM information_schema.COLUMNS WHERE COLUMN_NAME='user_subject' AND TABLE_NAME='$table_name'")){
			mysql_query("ALTER TABLE $table_name ADD user_subject varchar(100) NOT NULL DEFAULT '';");
		}
		
		$table_name1 = $wpdb->prefix . "mn_form_fields";
		$sql = "CREATE TABLE IF NOT EXISTS $table_name1 (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `fieldlabel` varchar(200) NOT NULL,
				  `fieldplaceholder` varchar(500) NOT NULL,
				  `fieldname` varchar(100) NOT NULL,
				  `fieldtype` varchar(100) NOT NULL,
				  `fieldicon` varchar(200) NOT NULL,
				  `fieldid` varchar(100) NOT NULL,
				  `fieldclass` varchar(100) NOT NULL,
				  `isvisible` varchar(100) NOT NULL,
				  `ismandatory` varchar(250) NOT NULL,
				  `error_message` varchar(250) NOT NULL,
				  `mod_date` varchar(100) NOT NULL,
				  `sort_order` int(11) NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
		
		dbDelta( $sql );

		$qry = mysql_query("SELECT * FROM $table_name1");
		$nooftable = $wpdb->get_row( "SELECT * FROM `$table_name1`");
		if($nooftable == 0){
			global $wpdb;
			$table_name1 = $wpdb->prefix . "mn_form_fields";
			$wpdb->insert($table_name1, array('fieldlabel' => 'Name', 'fieldplaceholder' => 'Name', 'fieldname' => 'user_name', 'fieldtype' => 'text', 'fieldicon' => '<i class="fa fa-user"></i>', 'fieldid' => 'user_name', 'fieldclass' => '', 'isvisible' => '1', 'ismandatory' => 'true', 'error_message' => 'Please enter your Name', 'mod_date' => date("Y-m-d H:i:s"), 'sort_order' => 1));
			$wpdb->insert($table_name1, array('fieldlabel' => 'Email', 'fieldplaceholder' => 'Email', 'fieldname' => 'user_email', 'fieldtype' => 'text', 'fieldicon' => '<i class="fa fa-envelope-o"></i>', 'fieldid' => 'user_email', 'fieldclass' => '', 'isvisible' => '1', 'ismandatory' => 'true', 'error_message' => 'Please enter Email', 'mod_date' => date("Y-m-d H:i:s"), 'sort_order' => 2));
			$wpdb->insert($table_name1, array('fieldlabel' => 'Phone', 'fieldplaceholder' => 'Phone', 'fieldname' => 'user_phone', 'fieldtype' => 'text', 'fieldicon' => '<i class="fa fa-phone"></i>', 'fieldid' => 'user_phone', 'fieldclass' => '', 'isvisible' => '1', 'ismandatory' => 'true', 'error_message' => 'Please enter Phone', 'mod_date' => date("Y-m-d H:i:s"), 'sort_order' => 3));
			$wpdb->insert($table_name1, array('fieldlabel' => 'Address', 'fieldplaceholder' => 'Address', 'fieldname' => 'user_address', 'fieldtype' => 'textarea', 'fieldicon' => '<i class="fa fa-map-marker"></i>', 'fieldid' => 'user_address', 'fieldclass' => '', 'isvisible' => '1', 'ismandatory' => 'true', 'error_message' => 'Please enter Address', 'mod_date' => date("Y-m-d H:i:s"), 'sort_order' => 4));
			$wpdb->insert($table_name1, array('fieldlabel' => 'Website', 'fieldplaceholder' => 'Website', 'fieldname' => 'user_website', 'fieldtype' => 'text', 'fieldicon' => '<i class="fa fa-globe"></i>', 'fieldid' => 'user_website', 'fieldclass' => '', 'isvisible' => '1', 'ismandatory' => 'true', 'error_message' => 'Please enter Website', 'mod_date' => date("Y-m-d H:i:s"), 'sort_order' => 5));
			$wpdb->insert($table_name1, array('fieldlabel' => 'Subject', 'fieldplaceholder' => 'Subject', 'fieldname' => 'user_subject', 'fieldtype' => 'text', 'fieldicon' => '<i class="fa fa-book"></i>', 'fieldid' => 'user_subject', 'fieldclass' => '', 'isvisible' => '1', 'ismandatory' => 'true', 'error_message' => 'Please enter Subject', 'mod_date' => date("Y-m-d H:i:s"), 'sort_order' => 6));
			$wpdb->insert($table_name1, array('fieldlabel' => 'Message', 'fieldplaceholder' => 'Message', 'fieldname' => 'user_message', 'fieldtype' => 'textarea', 'fieldicon' => '<i class="fa fa-envelope"></i>', 'fieldid' => 'user_message', 'fieldclass' => '', 'isvisible' => '1', 'ismandatory' => 'true', 'error_message' => 'Please enter Message', 'mod_date' => date("Y-m-d H:i:s"), 'sort_order' => 7));
		}
		add_option('mn_contact_to_email', get_option('admin_email'), '', yes);
		add_option('mn_captcha', 1, '', yes);
		add_option('mn_confirmation_mail', 1, '', yes);
		add_option('mn_conf_mail_sub', 'Confirmation Mail', '', yes);
		add_option('mn_conf_mail_msg', 'Thank you for contacting us.', '', yes);
		add_option('mn_contact_form_title', 'Contact Us', '', yes);
		add_option('mn_is_save_form_data', 0, '', yes);
		add_option('mn_form_style', 'mn-default-style', '', yes);
		add_option('mn_submitbtn-bg', '#41A62A', '', yes);
		add_option('mn_submitbtn_hover-bg', '#41A62A', '', yes);
		add_option('mn_resetbtn_hover-bg', '#C5C5C5', '', yes);
		add_option('mn_resetbtn-bg', '#C5C5C5', '', yes);
		//wp_redirect(get_bloginfo('admin_url')."admin.php?page=mn_contact_settings");
	}
	
	/**
	 * Run when the Plugin is uninstalled
	 */
	register_uninstall_hook(__FILE__, 'uninstall_mn_contact_form');
	register_deactivation_hook( __FILE__, 'uninstall_mn_contact_form' );
	function uninstall_mn_contact_form() {
		global $wpdb;
	 	$table_name = $wpdb->prefix."mn_form_data";
		//$sql = "DROP TABLE IF EXISTS $table_name;";
		$wpdb->query($sql);
		$table_name = $wpdb->prefix."mn_form_fields";
		$sql = "DROP TABLE IF EXISTS $table_name;";
		//$wpdb->query($sql);
		delete_option('mn_contact_to_email');
		delete_option('mn_captcha');
		delete_option('mn_confirmation_mail');
		delete_option('mn_conf_mail_sub');
		delete_option('mn_conf_mail_msg');
		delete_option('mn_contact_form_title');
		delete_option('mn_is_save_form_data');
		delete_option('mn_form_style');
		delete_option('mn_submitbtn-bg');
		delete_option('mn_resetbtn-bg');
		delete_option('mn_submitbtn_hover-bg');
		delete_option('mn_resetbtn_hover-bg');
	}
	
	add_action('admin_init', 'mn_contact_form_reg_setting');
	function mn_contact_form_reg_setting() {
		//registering the settings
		register_setting( 'mn_contact_form_options', 'mn_contact_to_email' );
		register_setting( 'mn_contact_form_options', 'mn_captcha' );
		register_setting( 'mn_contact_form_options', 'mn_confirmation_mail' );
		register_setting( 'mn_contact_form_options', 'mn_conf_mail_sub' );
		register_setting( 'mn_contact_form_options', 'mn_conf_mail_msg' );
		register_setting( 'mn_contact_form_options', 'mn_contact_form_title' );
		register_setting( 'mn_contact_form_options', 'mn_is_save_form_data' );
		register_setting( 'mn_contact_form_options', 'mn_form_style' );
		register_setting( 'mn_contact_form_options', 'mn_submitbtn-bg' );
		register_setting( 'mn_contact_form_options', 'mn_resetbtn-bg' );
		register_setting( 'mn_contact_form_options', 'mn_submitbtn_hover-bg' );
		register_setting( 'mn_contact_form_options', 'mn_resetbtn_hover-bg' );
	}
	
	/**
	 *  Admin Panel Form settings
	 */
	add_action( 'admin_menu', 'register_mn_contact_custom_menu_page' );
	function register_mn_contact_custom_menu_page(){
		add_menu_page( 'MN Contact Form Settings', 'MN Contact Form', 'manage_options', 'mn_contact_settings', 'mn_contact_form_admin_panel_view', plugins_url( 'mn-contact-form/images/logomenu.png' )); 
		add_submenu_page('mn_contact_settings', 'MN Contact Form Setting', 'General Setting', 'manage_options', 'mn_contact_settings', 'mn_contact_form_admin_panel_view');
		add_submenu_page('mn_contact_settings', 'MN Contact Form Fields', 'Field Setting', 'manage_options', 'mn_contact_form_field_view', 'mn_contact_form_field_view');
		add_submenu_page('mn_contact_settings', 'MN Contact Form Submitted Data List', 'Form Data', 'manage_options', 'mn_form_data_view', 'mn_form_data_view');
	}
	
	function mn_contact_form_admin_panel_view(){
		$mn_captcha_val = get_option('mn_captcha');
		$mn_confirmation_mail_val = get_option('mn_confirmation_mail');
	?>
	<div class="wrap">
        <div class="mn_section1">
            <h2><?php echo __("MN Contact Form Settings", 'mn-contact-form'); ?></h2>
            <p class="adminBluBar"><?php echo __("Use Shortcode", 'mn-contact-form'); ?> <strong>[mn_contact_free]</strong> <?php echo __("to embed it into your page/post or use the Wordpress widget", 'mn-contact-form'); ?><strong>(MN Contact form)</strong> <?php echo __("to embed it to any sidebar region", 'mn-contact-form'); ?>.
            <div class="adminSettingsContainer">
				<form method="post" action="options.php">
					<?php settings_fields( 'mn_contact_form_options' ); ?>
					<?php do_settings_sections( 'mn_contact_form_options' ); ?>
					<table class="form-table">
						<tr valign="top">
						<th scope="row"><?php echo __("Contact Form To Email", 'mn-contact-form'); ?></th>
						<td><input type="text" name="mn_contact_to_email" value="<?php echo get_option('mn_contact_to_email'); ?>" /></td>
						</tr>
						<tr valign="top">
						<th scope="row"><?php echo __("Captcha", 'mn-contact-form'); ?></th>
						<td>
						<input type="radio" name="mn_captcha" value="1" <?php echo ($mn_captcha_val == 1)? 'checked="checked"' : ''; ?> /> <?php echo __("Enable", 'mn-contact-form'); ?>&nbsp;
						<input type="radio" name="mn_captcha" value="0" <?php echo ($mn_captcha_val == 0)? 'checked="checked"' : ''; ?> /> <?php echo __("Disable", 'mn-contact-form'); ?>
						</td>
						</tr>
						<tr valign="top">
						<th scope="row"><?php echo __("Reply Mail", 'mn-contact-form'); ?></th>
						<td>
						<input type="radio" name="mn_confirmation_mail" class="mn_confirmation_mail" value="1" <?php echo ($mn_confirmation_mail_val == 1)? 'checked="checked"' : ''; ?> /> <?php echo __("Enable", 'mn-contact-form'); ?>&nbsp;
						<input type="radio" name="mn_confirmation_mail" class="mn_confirmation_mail" value="0" <?php echo ($mn_confirmation_mail_val == 0)? 'checked="checked"' : ''; ?>/> <?php echo __("Disable", 'mn-contact-form'); ?><br>
						
						<div class="mn_sub_msg" <?php echo ($mn_confirmation_mail_val == 1)? '' : 'style="display:none;"';?> id="mn_sub_msg">
							<input type="text" name="mn_conf_mail_sub" placeholder="Write your Subject Here" value="<?php echo get_option('mn_conf_mail_sub');?>" id="mn_conf_mail_sub" style="width:100%" /><br><br>
							<?php echo __("Hello [Contact Name]", 'mn-contact-form'); ?><br>
		
							<textarea name="mn_conf_mail_msg" id="mn_conf_mail_msg" placeholder="Write Only Message Here" style="width:100%;margin-top:10px; padding:10px;"><?php echo get_option('mn_conf_mail_msg');?></textarea>
						</div>
						</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php echo __("Do you want to save Form Submitted data", 'mn-contact-form'); ?>.</th>
							<td>
								<input type="radio" name="mn_is_save_form_data" value="1"  <?php echo (get_option('mn_is_save_form_data') == 1)? 'checked="checked"':'';?> /> &nbsp;<?php echo __("Yes", 'mn-contact-form'); ?>&nbsp;&nbsp;&nbsp;
								<input type="radio" name="mn_is_save_form_data" value="0"  <?php echo (get_option('mn_is_save_form_data') == 0)? 'checked="checked"':'';?> />&nbsp;<?php echo __("No", 'mn-contact-form'); ?>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php echo __("Form Style", 'mn-contact-form'); ?></th>
							<td>
								<select name="mn_form_style" id="mn_form_style">
									<option value="mn-default-style"<?php echo (get_option('mn_form_style') == 'mn-default-style')? ' selected="selected"':'';?>><?php echo __("Default", 'mn-contact-form'); ?></option>
									<option value="mn-stryle1"<?php echo (get_option('mn_form_style') == 'mn-stryle1')? ' selected="selected"':'';?>><?php echo __("Style 1", 'mn-contact-form'); ?></option>
									<option value="mn-stryle2"<?php echo (get_option('mn_form_style') == 'mn-stryle2')? ' selected="selected"':'';?>><?php echo __("Style 2", 'mn-contact-form'); ?></option>
									<option value="mn-stryle4"<?php echo (get_option('mn_form_style') == 'mn-stryle4')? ' selected="selected"':'';?>><?php echo __("Style 3", 'mn-contact-form'); ?></option>
                                    <option value="mn-stryle5"<?php echo (get_option('mn_form_style') == 'mn-stryle5')? ' selected="selected"':'';?>><?php echo __("Style 4", 'mn-contact-form'); ?></option>
                                    <option value="mn-stryle6"<?php echo (get_option('mn_form_style') == 'mn-stryle6')? ' selected="selected"':'';?>><?php echo __("Style 5", 'mn-contact-form'); ?></option>
                                    <option value="mn-stryle8"<?php echo (get_option('mn_form_style') == 'mn-stryle8')? ' selected="selected"':'';?>><?php echo __("Style 6", 'mn-contact-form'); ?></option>
								</select><br />
								<small><?php echo __("N.B.- This style options will not affect on sidebar form style. This is for pages only using through shortcode", 'mn-contact-form'); ?></small>
							</td>
						</tr>
                        <tr valign="top">
                        	<td scope="row"><?php echo __("Submit Button Background color", 'mn-contact-form'); ?></td>
                            <td><input type="text" name="mn_submitbtn-bg" id="mn_submitbtn-bg" value="<?php echo get_option('mn_submitbtn-bg');?>" /> <div class="intext">on mouseover</div> <input type="text" name="mn_submitbtn_hover-bg" id="mn_submitbtn_hover-bg" value="<?php echo get_option('mn_submitbtn_hover-bg');?>" /></td>
                        </tr>
                        <tr valign="top">
                        	<td scope="row"><?php echo __("Reset Button Background color", 'mn-contact-form'); ?></td>
                            <td><input type="text" name="mn_resetbtn-bg" id="mn_resetbtn-bg" value="<?php echo get_option('mn_resetbtn-bg');?>" /> <div class="intext">on mouseover</div> <input type="text" name="mn_resetbtn_hover-bg" id="mn_resetbtn_hover-bg" value="<?php echo get_option('mn_resetbtn_hover-bg');?>" /></td>
                        </tr>
					</table>
					<?php submit_button(); ?>
				</form>
                
                <form name="customcss" id="customcss" action="">
                	<p>Write CSS for both sidebar form and default contact form style</p>
                    <p><textarea name="customcsstext" id="customcsstext"><?php echo $content = file_get_contents(plugin_dir_path(__FILE__).'css/custom.css');?></textarea></p>
                    <p id="mns_frm_status" style="display:none;"></p>
                    <?php submit_button(); ?>
                </form>
                <script type="text/javascript">
					
				 </script>
			</div>
        </div>
        <div class="mn_section2">
			<div class="block">
			<img src="http://mnthemes.com/promo/images/mnc_promo1.jpg" alt="MN Contact Form Pro" />
			</div>
			<div class="postbox">
				<h3 class="hndle"><span class="inner"><?php echo __("Support / Manual / Upgradation", 'mn-contact-form'); ?></span></h3>
				<div class="inside">
					<p style="margin:15px 0px;"><?php echo __("For any suggestion / query / issue / requirement, please feel free to drop an email to", 'mn-contact-form'); ?> <a href="mailto:support@mnthemes.com?subject=MN Contact Form">support@mnthemes.com</a>.</p>
					<div style="display:none;"><p style="margin:15px 0px;"><?php echo __("Get the", 'mn-contact-form'); ?> <a target="_blank" href="http://www.mnthemes.com/mn-contact-form-manual"><?php echo __("Lite Manual here", 'mn-contact-form'); ?></a>.</p>
					<p style="margin:15px 0px;"><?php echo __("Get the", 'mn-contact-form'); ?> <a target="_blank" href="http://www.mnthemes.com/mn-contact-pro/"><?php echo __("PRO Version here", 'mn-contact-form'); ?></a> <?php echo __("for more advanced features", 'mn-contact-form'); ?>.</p>
					<p style="margin:15px 0px;"><?php echo __("Get the", 'mn-contact-form'); ?> <a target="_blank" href="http://www.mnthemes.com/mn-contact-form-manual"><?php echo __("PRO Manual here", 'mn-contact-form'); ?></a> <?php echo __("for a complete list of features", 'mn-contact-form'); ?>.</p></div>
				</div>
			</div>
			<div class="postbox">
				<h3 class="hndle"><span class="inner"><?php echo __("Review / Donation", 'mn-contact-form'); ?></span></h3>
				<div class="inside">
					<p style="margin:15px 0px;">
						<?php echo __("Please feel free to add your reviews on", 'mn-contact-form'); ?>
						<a href="http://wordpress.org/support/view/plugin-reviews/mn-contact-form" target="_blank">Wordpress</a>
					</p>
					<p style="margin:15px 0px;">
						<?php echo __("There has been a lot of effort put behind the development of this plugin. Please consider donating towards this plugin development.", 'mn-contact-form'); ?>
						<form method="post" action="https://www.paypal.com/cgi-bin/webscr" target="_blank">
							<?php echo __("Amount", 'mn-contact-form'); ?> $ <input type="text" value="" title="Other donate" size="5" name="amount"><br />
							<input type="hidden" value="_xclick" name="cmd" />
							<input type="hidden" value="girija@myneedz.org" name="business" />
							<input type="hidden" value="MN Contact Form" name="item_name" />
							<input type="hidden" value="USD" name="currency_code" />
							<input type="hidden" value="0" name="no_shipping" />
							<input type="hidden" value="1" name="no_note" />
							<input type="hidden" value="3FWGC6LFTMTUG" name="mrb" />
							<input type="hidden" value="IC_Sample" name="bn" />
							<input type="hidden" value="http://www.mnthemes.com/donation-thanks/" name="return" />
							<input type="image" alt="Make payments with payPal - it's fast, free and secure!" name="submit" src="https://www.paypal.com/en_US/i/btn/x-click-but11.gif" />
						</form>
					</p>
				</div>
			</div>
            <div class="preview">
            	<img id="mnfrmstyledef" src="<?php echo plugin_dir_url(__FILE__);?>images/default.png" alt="" style="width:100%; display:none;" class="mnpreview" />
                <img id="mnfrmstyle1" src="<?php echo plugin_dir_url(__FILE__);?>images/style1.png" alt="" style="width:100%; display:none;" class="mnpreview" />
                <img id="mnfrmstyle2" src="<?php echo plugin_dir_url(__FILE__);?>images/style2.png" alt="" style="width:100%; display:none;" class="mnpreview" />
                <img id="mnfrmstyle3" src="<?php echo plugin_dir_url(__FILE__);?>images/style3.png" alt="" style="width:100%; display:none;" class="mnpreview" />
				<img id="mnfrmstyle4" src="<?php echo plugin_dir_url(__FILE__);?>images/style4.png" alt="" style="width:100%; display:none;" class="mnpreview" />
                <img id="mnfrmstyle5" src="<?php echo plugin_dir_url(__FILE__);?>images/style5.png" alt="" style="width:100%; display:none;" class="mnpreview" />
				<img id="mnfrmstyle6" src="<?php echo plugin_dir_url(__FILE__);?>images/style6.png" alt="" style="width:100%; display:none;" class="mnpreview" />
            </div>
        </div>
    </div>
	<?php
	}
	function mn_contact_form_field_view(){
		global $wpdb;
		$_SESSION['DB_NAME'] = DB_NAME;
		$_SESSION['DB_USER'] = DB_USER;
		$_SESSION['DB_PASSWORD'] = DB_PASSWORD;
		$_SESSION['DB_HOST'] = DB_HOST;
		$_SESSION['wp_pref'] = $wpdb->prefix;
	?>
	<div class="wrap">
        <div class="mn_section1">
            <h2><?php echo __("MN Contact Form Settings", 'mn-contact-form'); ?></h2>
            <p class="adminBluBar"><?php echo __("Use Shortcode", 'mn-contact-form'); ?> <strong>[mn_contact_free]</strong> <?php echo __("to embed it into your page/post or use the Wordpress widget", 'mn-contact-form'); ?><strong>(MN Contact form)</strong> <?php echo __("to embed it to any sidebar region", 'mn-contact-form'); ?>.
            <div class="adminSettingsContainer">
				<?php
					global $wpdb;
					$table_name = $wpdb->prefix . "mn_form_fields";
					$result = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY sort_order ASC"); 		
					$restrictedinput = array("user_email","user_message");			
					echo '<ul id="sortable">';
					foreach($result as $row)
					{
					//$close = (in_array($row->input_name, $restrictedinput))? '' : '<a href="#" class="mn_close" id="mn_'.$row->id.'" title="Delete this Item">X</a>';
					//echo '<li id="menu_'.$row->id.'">'.$row->fieldlabel.'</li>';
					?>
                    <li id="menu_<?php echo $row->id;?>">
                    	<h3 class="headinglabel"><?php echo $row->fieldlabel;?> - <small><?php echo $row->fieldname;?></small> <span class="mn-showhide-btn"><i class="fa fa-plus"></i></span> <span class="mn-visibility"><?php echo ($row->isvisible == '0')? '<i class="fa fa-eye-slash"></i>' : '<i class="fa fa-eye"></i>';?></span></h3>
                        <div class="mn-showhide-container">
                            <div class="controlsgroup">
                                <div class="editfields">
                                    <label for="fieldlabel">Field Label</label>
                                    <div class="control">
                                        <input type="text" name="fieldlabel" class="fieldlabel" value="<?php echo $row->fieldlabel;?>" />
                                    </div>
                                </div>
                                <?php
                                if(!in_array($row->fieldname, $restrictedinput)){
                                ?>
                                <div class="editfields">
                                    <label for="isvisible">Is Visible ?</label>
                                    <div class="control">
                                        <select name="isvisible<?php echo $row->id;?>" class="isvisible">
                                            <option <?php echo ($row->isvisible == '1')? 'selected="selected"' : '';?> value="1">Yes</option>
                                            <option <?php echo ($row->isvisible == '0')? 'selected="selected"' : '';?> value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="editfields">
                                    <label for="ismandatory">Is Mandatory ?</label>
                                    <div class="control">
                                        <select name="ismandatory<?php echo $row->id;?>" class="ismandatory">
                                            <option <?php echo ($row->ismandatory == 'true')? 'selected="selected"' : '';?> value="true">Yes</option>
                                            <option <?php echo ($row->ismandatory == 'false')? 'selected="selected"' : '';?> value="false">No</option>
                                        </select>
                                    </div>
                                </div>
                                <?php
                                }else{
								?>
                                <input type="hidden" name="ismandatory<?php echo $row->id;?>" class="ismandatory" value="true" />
                                <input type="hidden" name="isvisible<?php echo $row->id;?>" class="isvisible" value="1" />
                                <?php
								}
                                ?>
                                <div class="editfields">
                                    <label for="error_message">Placeholder</label>
                                    <div class="control">
                                        <input type="text" name="fieldplaceholder<?php echo $row->id;?>" class="fieldplaceholder" value="<?php echo $row->fieldplaceholder;?>" />
                                    </div>
                                </div>
                                <div class="editfields">
                                    <label for="error_message">Error Message</label>
                                    <div class="control">
                                        <input type="text" name="error_message<?php echo $row->id;?>" class="error_message" value="<?php echo $row->error_message;?>" />
                                    </div>
                                </div>
                            </div>
                            <input type="button" class="btn-primary savebtn" value="Save" />
                        </div>
                    </li>
                    <?php
					}
					echo '</ul>';
				?>
			</div>
        </div>
        <div class="mn_section2">
			<div class="block">
			<img src="http://mnthemes.com/promo/images/mnc_promo1.jpg" alt="MN Contact Form Pro" />
			</div>
			<div class="postbox">
				<h3 class="hndle"><span class="inner"><?php echo __("Support / Manual / Upgradation", 'mn-contact-form'); ?></span></h3>
				<div class="inside">
					<p style="margin:15px 0px;"><?php echo __("For any suggestion / query / issue / requirement, please feel free to drop an email to", 'mn-contact-form'); ?> <a href="mailto:support@mnthemes.com?subject=MN Contact Form">support@mnthemes.com</a>.</p>
					<div style="display:none;"><p style="margin:15px 0px;"><?php echo __("Get the", 'mn-contact-form'); ?> <a target="_blank" href="http://www.mnthemes.com/mn-contact-form-manual"><?php echo __("Lite Manual here", 'mn-contact-form'); ?></a>.</p>
					<p style="margin:15px 0px;"><?php echo __("Get the", 'mn-contact-form'); ?> <a target="_blank" href="http://www.mnthemes.com/mn-contact-pro/"><?php echo __("PRO Version here", 'mn-contact-form'); ?></a> <?php echo __("for more advanced features", 'mn-contact-form'); ?>.</p>
					<p style="margin:15px 0px;"><?php echo __("Get the", 'mn-contact-form'); ?> <a target="_blank" href="http://www.mnthemes.com/mn-contact-form-manual"><?php echo __("PRO Manual here", 'mn-contact-form'); ?></a> <?php echo __("for a complete list of features", 'mn-contact-form'); ?>.</p></div>
				</div>
			</div>
			<div class="postbox">
				<h3 class="hndle"><span class="inner"><?php echo __("Review / Donation", 'mn-contact-form'); ?></span></h3>
				<div class="inside">
					<p style="margin:15px 0px;">
						<?php echo __("Please feel free to add your reviews on", 'mn-contact-form'); ?>
						<a href="http://wordpress.org/support/view/plugin-reviews/mn-contact-form" target="_blank">Wordpress</a>
					</p>
					<p style="margin:15px 0px;">
						<?php echo __("There has been a lot of effort put behind the development of this plugin. Please consider donating towards this plugin development.", 'mn-contact-form'); ?>
						<form method="post" action="https://www.paypal.com/cgi-bin/webscr" target="_blank">
							<?php echo __("Amount", 'mn-contact-form'); ?> $ <input type="text" value="" title="Other donate" size="5" name="amount"><br />
							<input type="hidden" value="_xclick" name="cmd" />
							<input type="hidden" value="girija@myneedz.org" name="business" />
							<input type="hidden" value="MN Contact Form" name="item_name" />
							<input type="hidden" value="USD" name="currency_code" />
							<input type="hidden" value="0" name="no_shipping" />
							<input type="hidden" value="1" name="no_note" />
							<input type="hidden" value="3FWGC6LFTMTUG" name="mrb" />
							<input type="hidden" value="IC_Sample" name="bn" />
							<input type="hidden" value="http://www.mnthemes.com/donation-thanks/" name="return" />
							<input type="image" alt="Make payments with payPal - it's fast, free and secure!" name="submit" src="https://www.paypal.com/en_US/i/btn/x-click-but11.gif" />
						</form>
					</p>
				</div>
			</div>
            <div class="preview">
            	<img id="mnfrmstyle1" src="<?php echo plugin_dir_url(__FILE__);?>images/style1.png" alt="" style="width:100%; display:none;" class="mnpreview" />
                <img id="mnfrmstyle2" src="<?php echo plugin_dir_url(__FILE__);?>images/style2.png" alt="" style="width:100%; display:none;" class="mnpreview" />
                <img id="mnfrmstyle3" src="<?php echo plugin_dir_url(__FILE__);?>images/style3.png" alt="" style="width:100%; display:none;" class="mnpreview" />
				<img id="mnfrmstyle4" src="<?php echo plugin_dir_url(__FILE__);?>images/style4.png" alt="" style="width:100%; display:none;" class="mnpreview" />
            </div>
        </div>
    </div>
	<?php
	}
	function mn_form_data_view(){
		global $wpdb;
		$table_name = $wpdb->prefix . "mn_form_data";
		$table_name1 = $wpdb->prefix . "mn_form_fields";
		$total_rows = $wpdb->get_row( "SELECT * FROM `$table_name`");
		include_once ('inc/pagination.php');
    	$page = (int) (!isset($_GET["sheet"]) ? 1 : $_GET["sheet"]);
    	$limit = 10;
    	$startpoint = ($page * $limit) - $limit;
        //to make pagination
        $statement = "`$table_name`";
	?>

    <div class="wrap">
        <div class="mn_frm_add_field" style="width:100%;">
            <h2><?php echo __("Submitted Form Data", 'mn-contact-form'); ?></h2>
            <?php
            if($total_rows > 0){
            ?>
            <table class="wp-list-table widefat fixed posts">
                <thead>
                    <tr>
                    	<th width="5%"><?php echo __("Sl No", 'mn-contact-form'); ?></th>
                    	<th width="85%"><?php echo __("Name & Email", 'mn-contact-form'); ?></th>
                        <th width="10%"><?php echo __("Action", 'mn-contact-form'); ?></th>
                    </tr>
                 </thead>
                 <tbody>
                <?php
                $result = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY id DESC LIMIT {$startpoint} , {$limit}");					$i=1;
                foreach($result as $row){
                ?>
                    <tr id="<?php echo $row->id; ?>">
                        <td width="5%" class="table_id"><?php echo $i; ?></td>
						<td>
                        	<p><b>
                        <?php
							echo $row->user_name.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
							echo $row->user_email;
                        ?>
                        	</b></p>
                            <div class="mn_form_data_more">
                            	<p><b><?php echo __("Phone", 'mn-contact-form'); ?></b>: <?php echo $row->user_phone;?></p>
                                <p><b><?php echo __("Address", 'mn-contact-form'); ?></b> <?php echo $row->user_address;?></p>
                                <p><b><?php echo __("Website", 'mn-contact-form'); ?></b> <?php echo $row->user_website;?></p>
                                <p><b><?php echo __("Subject", 'mn-contact-form'); ?></b> <?php echo $row->user_subject;?></p>
                                <p><b><?php echo __("Message", 'mn-contact-form'); ?></b> <?php echo $row->user_message;?></p>
                                <p><b><?php echo __("IP Address", 'mn-contact-form'); ?></b> <?php echo $row->user_ip;?></p>
                            </div>
						</td>
                        <td class="actBtn">
                        <span class="mn_expand"><i class="fa fa-plus"></i></span>
                        <button name="btndelete_mn_frmdata" class="btndelete_mn_frmdata"><i class="fa fa-trash-o"></i></button>
                        </td>
                    </tr>
                <?php					$i++;
                }
                ?>
                </tbody>
                <tfoot>
                    <tr>
                    	<th><?php echo __("Sl No", 'mn-contact-form'); ?></th>
                    	<th><?php echo __("Name & Email", 'mn-contact-form'); ?></th>
                        <th><?php echo __("Action", 'mn-contact-form'); ?></th>
                    </tr>
                 </tfoot>
            </table>
            <?php
            }else{
				echo '<p>No Form records are available.</p>';
			}
            echo pagination($statement,$limit,$page,$url = '?page=mn_form_data_view&');
            ?>
        </div>
    </div>	
    <?php
	}
/* HTML OUTPUT for USER */
	function mn_contact_form_html(){
		global $wpdb;
		$_SESSION['DB_NAME'] = DB_NAME;
		$_SESSION['DB_USER'] = DB_USER;
		$_SESSION['DB_PASSWORD'] = DB_PASSWORD;
		$_SESSION['DB_HOST'] = DB_HOST;
		$_SESSION['wp_pref'] = $wpdb->prefix;
		$a = rand(1,9);
		$b = rand(1,9);
		$_SESSION['ans'] = $a + $b;
		$mnstyle = get_option('mn_form_style');
	?>
    <style type="text/css">
	#mn_contact_submit:hover{
		background-color:<?php echo get_option('mn_submitbtn_hover-bg');?> !important;
	}
	#mnreset:hover{
		background-color:<?php echo get_option('mn_resetbtn_hover-bg');?> !important;
	}
	</style>
    <div class="mn_contact_form container" id="<?php echo $mnstyle;?>">
	    <form name="mncontactfrm" id="mncontactfrm" action="" method="post">
    <?php
		$table_name = $wpdb->prefix . "mn_form_fields";
		$result = $wpdb->get_results( "SELECT * FROM $table_name WHERE isvisible = '1' ORDER BY sort_order ASC"); 
		foreach($result as $row){
			$req = ($row->ismandatory == 'true')? '' : '';
	?>
    	<div class="mn-control-group">
        	<div class="mn-control-label">
            	<label for="<?php echo $row->fieldname.$row->id;?>"><?php echo $row->fieldlabel;?></label>
            </div>
            <div class="mn-control-input">
            	<?php
				echo '<span class="mn-icon">'.$row->fieldicon.'</span>';
				if($row->fieldtype == 'text'){
					echo '<input type="text" name="'.$row->fieldname.'" id="'.$row->fieldname.$row->id.'" placeholder="'.$row->fieldplaceholder.'" value="" '.$req.' />';
				}elseif($row->fieldtype == 'textarea'){
					echo '<textarea name="'.$row->fieldname.'" id="'.$row->fieldname.$row->id.'" '.$req.' placeholder="'.$row->fieldplaceholder.'"></textarea>';
				}
				echo '<span class="mn-placeholdertext">'.$row->fieldplaceholder.'</span>';
				?>
            </div>
        </div>
            
    <?php
		}
		if(get_option('mn_captcha') == 1){
	?>
    		<p>
                <label for="answer"><?php echo __("Write Your answer", 'mn-contact-form'); ?>: </label>
                <span id="mn_a"><?php echo $a;?></span>+<span id="mn_b"><?php echo $b;?></span>=<input type="text" name="mn_answer" id="mn_answer" value="" style="width:40px; margin:0 5px;" required="required" /><small><?php echo __("Math Captcha", 'mn-contact-form'); ?>.</small>
            </p>
            <?php
		}
		?>
        <p id="mn_contact_sending_status" style="display:none;"></p>
        <p>
            <input type="hidden" name="mn_save_data" id="" value="<?php echo get_option('mn_is_save_form_data');?>" />
            <input type="submit" name="mn_contact_submit" id="mn_contact_submit" value="<?php echo __("Send", 'mn-contact-form'); ?>" style="background-color:<?php echo get_option('mn_submitbtn-bg');?>" />
            <input type="reset" name="reset" id="mnreset" value="<?php echo __("Reset", 'mn-contact-form'); ?>" style="background-color:<?php echo get_option('mn_resetbtn-bg');?>" onMouseOver="this.bgColor='<?php echo get_option('mn_resetbtn_hover-bg');?>'" />
        </p>
        </form>
    </div>
    <?php
	}
	
	/**
	 * Runs when the plugin is initialized
	 */
	//Hook up to the init action
	add_action('init', 'init_mn_contact_form', 10);
	function init_mn_contact_form() {
		// Setup localization
		load_plugin_textdomain( 'mn_contact_form', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
		// Load JavaScript and stylesheets
		mn_register_scripts_and_styles();

		// Register the shortcode [mn_contact_free]
		add_shortcode( 'mn_contact_free', 'mn_contact_form_html' );
		if(is_admin()){
			//this will run when in the WordPress admin
		}else{
			
		}
		function mn_creating_sidebar_form(){
			$title = get_option('mn_contact_form_title');
			global $wpdb;
			$_SESSION['DB_NAME'] = DB_NAME;
			$_SESSION['DB_USER'] = DB_USER;
			$_SESSION['DB_PASSWORD'] = DB_PASSWORD;
			$_SESSION['DB_HOST'] = DB_HOST;
			$_SESSION['wp_pref'] = $wpdb->prefix;
			$a = rand(1,9);
			$b = rand(1,9);
			$_SESSION['sideans'] = $a + $b;
			$mnstyle = get_option('mn_form_style');
			$mnfrmstyleclass = '';
			echo '<aside id="mn_sidebar" class="widget">';
			echo '<h1 class="widget-title">'.$title.'</h1>';
			?>
            <div class="mn_contact_form container" id="mn_contact_sidebar">
                <form name="mncontactfrm" id="mncontactfrm_sidebar" action="" method="post">
            <?php
                $table_name = $wpdb->prefix . "mn_form_fields";
                $result = $wpdb->get_results( "SELECT * FROM $table_name WHERE isvisible = '1' ORDER BY sort_order ASC"); 
                foreach($result as $row){
                    $req = ($row->ismandatory == 'true')? '' : '';
            ?>
                <div class="mn-control-group">
                    <div class="mn-control-label">
                        <label for="<?php echo $row->fieldname.$row->id;?>"><?php echo $row->fieldlabel;?></label>
                    </div>
                    <div class="mn-control-input">
                        <?php
                        if($row->fieldtype == 'text'){
                            echo '<input type="text" name="'.$row->fieldname.'" id="'.$row->fieldname.$row->id.'" placeholder="'.$row->fieldplaceholder.'" value="" '.$req.' />';
                        }elseif($row->fieldtype == 'textarea'){
                            echo '<textarea name="'.$row->fieldname.'" id="'.$row->fieldname.$row->id.'" '.$req.' placeholder="'.$row->fieldplaceholder.'"></textarea>';
                        }
                        ?>
                    </div>
                </div>
                    
            <?php
                }
                if(get_option('mn_captcha') == 1){
            ?>
                    <p>
                        <label for="answer"><?php echo __("Write Your answer", 'mn-contact-form'); ?>: </label>
                        <span id="mns_a"><?php echo $a;?></span>+<span id="mns_b"><?php echo $b;?></span>=<input type="text" name="mn_answer" id="mns_answer" value="" style="width:40px; margin:0 5px;" required="required" /><small><?php echo __("Math Captcha", 'mn-contact-form'); ?>.</small>
                    </p>
                    <?php
                }
                ?>
                <p id="mns_contact_sending_status" style="display:none;"></p>
                <p>
                    <input type="hidden" name="mn_save_data" id="" value="<?php echo get_option('mn_is_save_form_data');?>" />
                    <input type="submit" name="mns_contact_submit" id="mns_contact_submit" value="<?php echo __("Send", 'mn-contact-form'); ?>" style="background-color:<?php echo get_option('mn_submitbtn-bg');?>" />
                    <input type="reset" name="reset" id="mnsreset" value="<?php echo __("Reset", 'mn-contact-form'); ?>" style="background-color:<?php echo get_option('mn_resetbtn-bg');?>" onMouseOver="this.bgColor='<?php echo get_option('mn_resetbtn_hover-bg');?>'" />
                </p>
                </form>
            </div>
            <?php
			echo '</aside>';
		}
		wp_register_sidebar_widget('mn_contact_form', 'MN Contact Form', 'mn_creating_sidebar_form');
		
		function mn_creating_sidebar_controil_form() {
			$mn_title_option = get_option('mn_contact_form_title');
			//processing the option settings for the widget
			if (isset($_POST['mn_change_title'])) {
				$options = htmlspecialchars($_POST['mn_contact_form_title']);
				update_option("mn_contact_form_title", $options);
			}
          //widget option setting fields
		?>
			<p>
				<label for="mn_contact_form_title"><?php _e('Title', 'mn_contact_form'); ?>:<br />
				<input class="widefat" type="text" id="mn_contact_form_title" name="mn_contact_form_title" value="<?php echo $mn_title_option;?>" /></label>
			</p>
			<input type="hidden" id="mn_change_title" name="mn_change_title" value="1" />
		<?php
		}
		wp_register_widget_control('mn_contact_form', 'MN Contact Form', 'mn_creating_sidebar_controil_form');
	}

	/**

	 * Registers and enqueues stylesheets for the administration panel and the

	 * public facing site.

	 */

	add_action('init', 'mn_register_scripts_and_styles', 10);
	function mn_register_scripts_and_styles() {
		if ( is_admin() ) {
			mn_contact_load_file( 'mn_contact_form-admin-script', '/js/mn-admin.js', true );
			mn_contact_load_file( 'mn_contact_form-admin-style', '/css/mn-admin.css' );
			mn_contact_load_file( 'mn_contact_form-admin-style1', '/css/pagination.css' );
			mn_contact_load_file( 'mn_contact_form-admin-style2', '/css/grey.css' );
			wp_register_script( 'jQuery-ui-Plugin', 'http://code.jquery.com/ui/1.10.3/jquery-ui.js', array('jquery') ); //depends on jquery
			wp_enqueue_script('jQuery-ui-Plugin');
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'mn_contact-admin-script', plugins_url('/js/script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
		} else {
			mn_contact_load_file( 'mn_contact_form-script', '/js/mn-contact-form.js', true );
			mn_contact_load_file( 'mn_contact_form-style', '/css/mn-contact-form.css' );
		} 
	} 

	/**
	 * Helper function for registering and enqueueing scripts and styles.
	 *
	 * @name	The 	ID to register with WordPress
	 * @file_path		The path to the actual file
	 * @is_script		Optional argument for if the incoming file_path is a JavaScript source file.
	 */
	function mn_contact_load_file( $name, $file_path, $is_script = false ) {
		global $wpdb;
		$url = plugins_url($file_path, __FILE__);
		$file = plugin_dir_path(__FILE__) . $file_path;
		if( file_exists( $file ) ) {
			if( $is_script ) {
				wp_register_script( $name, $url, array('jquery') ); //depends on jquery
				wp_enqueue_script( $name );
				wp_localize_script( $name, 'mn_ajax', array(
					'ajax_url' => admin_url( 'admin-ajax.php' ),
					'ajaxurl' => plugin_dir_url(__FILE__).'ajaxreq/ajax_requests.php',
					'ajaxurl1' => plugin_dir_url(__FILE__).'ajaxreq/ajax_request1.php',
					'admin_ajaxurl' => plugin_dir_url(__FILE__).'ajaxreq/admin_ajax_requests.php',
					'admin_email' => get_option('mn_contact_to_email'),
					'mn_captcha' => get_option('mn_captcha'),
					'mn_confirmation_mail' => get_option('mn_confirmation_mail'),
					'mn_conf_mail_sub' => urlencode(get_option('mn_conf_mail_sub')),
					'mn_conf_mail_msg' => urlencode(get_option('mn_conf_mail_msg')),
					'blog_name' => urlencode(get_bloginfo('name')),
					'mn_save_data' => urlencode(get_option('mn_is_save_form_data'))
					)
				);
			} else {
				wp_register_style( $name, $url );
				wp_enqueue_style( $name );
			} // end if
		} // end if
	} // end load_file
	// Send a mail to the Site admin upon plugin activation

	add_action( 'wp_ajax_adding_custom_css', 'adding_custom_css' );
	function adding_custom_css() {
		global $wpdb;

		$error = 0;
		$html ='';
		$file = plugin_dir_path(__FILE__).'css/custom.css';
		if(file_put_contents($file, $_POST['customcsstext'])){
			file_put_contents($file, $_POST['customcsstext']);
			$result = array("error" => $error, "msg" => 'CSS Saved Successfully');
			echo json_encode($result);die();
		}else{
			$error++;
			$result = array("error" => $error, "msg" => 'CSS not saved !');
			echo json_encode($result);die();
		}
	}
	
	add_action( 'wp_ajax_saving_field_setting', 'saving_field_setting' );
	function saving_field_setting() {
		global $wpdb;

		$error = 0;
		$html ='';
		$table_name = $wpdb->prefix.'mn_form_fields';
		$id = $_POST['fieldid'];
		$fieldlabel = $_POST['fieldlabel'];
		$isvisible = $_POST['isvisible'];
		$ismandatory = $_POST['ismandatory'];
		$error_message = $_POST['error_message'];
		$fieldplaceholder = $_POST['fieldplaceholder'];
		mysql_query("UPDATE $table_name SET `fieldlabel` = '$fieldlabel', `fieldplaceholder` = '$fieldplaceholder', `isvisible` = '$isvisible', `ismandatory` = '$ismandatory', `error_message` = '$error_message' WHERE `id` ='".$id."'");
		$result = array("error" => $error);
		echo json_encode($result);
		die();
	}