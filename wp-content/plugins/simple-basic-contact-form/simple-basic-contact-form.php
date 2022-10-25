<?php
/*
	Plugin Name: Simple Basic Contact Form
	Plugin URI: https://wordpress.org/plugins/simple-basic-contact-form/
	Description: A secure contact form that&rsquo;s fast and flexible.
	Tags: contact, form, contact form, email, mail,  captcha, spam, anti spam, anti-spam, antispam
	Author: WPKube
	Author URI: https://www.wpkube.com/
	Contributors: WPKube
	Requires at least: 4.1
	Tested up to: 5.9
	Version: 20220207
	Requires PHP: 5.2
	Text Domain: scf
	Domain Path: /languages
	License: GPL v2 or later
*/

/*
	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version
	2 of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	with this program. If not, visit: https://www.gnu.org/licenses/

	Copyright 2017 Monzilla Media. All rights reserved.
*/

if (!function_exists('add_action')) die();



$scf_wp_vers = '4.1';
$scf_version = '20220207';
$scf_plugin  = esc_html__('Simple Basic Contact Form', 'scf');
$scf_options = get_option('scf_options');
$scf_path    = plugin_basename(__FILE__); // 'simple-basic-contact-form/simple-basic-contact-form.php';
$scf_homeurl = 'https://wordpress.org/plugins/simple-basic-contact-form/';

if ( ! isset( $scf_options['scf_input_confirm_email'] ) ) {
    $scf_options['scf_input_confirm_email'] = '';
}

if ( ! isset( $scf_options['scf_confirm_mailtext'] ) ) {
    $scf_options['scf_confirm_mailtext'] = '';
}

if ( ! isset( $scf_options['scf_input_name'] ) ) {
    $scf_options['scf_input_name'] = '';
}

if ( ! isset( $scf_options['scf_input_email'] ) ) {
    $scf_options['scf_input_email'] = '';
}

if ( ! isset( $scf_options['scf_input_subject'] ) ) {
    $scf_options['scf_input_subject'] = '';
}

if ( ! isset( $scf_options['scf_input_captcha'] ) ) {
    $scf_options['scf_input_captcha'] = '';
}

if ( ! isset( $scf_options['scf_input_message'] ) ) {
    $scf_options['scf_input_message'] = '';
}

if ( ! isset( $scf_options['default_options'] ) ) {
    $scf_options['default_options'] = '';
}

function scf_i18n_init() {

	load_plugin_textdomain('scf', false, dirname(plugin_basename(__FILE__)) .'/languages/');

}
add_action('plugins_loaded', 'scf_i18n_init');



function scf_require_wp_version() {

	global $scf_path, $scf_plugin, $scf_wp_vers;

	if (isset($_GET['activate']) && $_GET['activate'] == 'true') {

		$wp_version = get_bloginfo('version');

		if (version_compare($wp_version, $scf_wp_vers, '<')) {

			if (is_plugin_active($scf_path)) {

				deactivate_plugins($scf_path);

				$msg  = '<strong>'. $scf_plugin .'</strong> ';
				$msg .= esc_html__('requires WordPress ', 'scf') . $scf_wp_vers;
				$msg .= esc_html__(' or higher, and has been deactivated! Please return to the', 'scf');
				$msg .= ' <a href="'. admin_url() .'">'. esc_html__('WP Admin Area', 'scf') .'</a> ';
				$msg .= esc_html__('to upgrade WordPress and try again.', 'scf');

				wp_die($msg);

			}

		}

	}

}
add_action('admin_init', 'scf_require_wp_version');



$scf_value_name     = isset($_POST['scf_name'])     ? esc_attr($_POST['scf_name'])        : '';
$scf_value_email    = isset($_POST['scf_email'])    ? sanitize_text_field($_POST['scf_email']) : '';
$scf_value_confirm_email = isset($_POST['scf_confirm_email']) ? sanitize_text_field($_POST['scf_confirm_email']) : '';
$scf_value_subject  = isset($_POST['scf_subject'])  ? esc_attr($_POST['scf_subject'])     : '';
$scf_value_response = isset($_POST['scf_response']) ? esc_attr($_POST['scf_response'])    : '';
$scf_value_message  = isset($_POST['scf_message'])  ? esc_textarea($_POST['scf_message']) : '';

$scf_strings = array(
	'name' 	   => '<input name="scf_name" id="scf_name" type="text" size="33" maxlength="99" value="'. $scf_value_name .'" placeholder="' . $scf_options['scf_input_name'] . '" />',
    'email'    => '<input name="scf_email" id="scf_email" type="text" size="33" maxlength="99" value="'. $scf_value_email .'" placeholder="' . $scf_options['scf_input_email'] . '" />',
    'confirm_email' => '<input name="scf_confirm_email" id="scf_confirm_email" type="text" size="33" maxlength="99" value="'. $scf_value_confirm_email .'" placeholder="' . $scf_options['scf_input_confirm_email'] . '" />',
	'subject'  => '<input name="scf_subject" id="scf_subject" type="text" size="33" maxlength="99" value="'. $scf_value_subject .'" placeholder="' . $scf_options['scf_input_subject'] . '" />',
	'response' => '<input name="scf_response" id="scf_response" type="text" size="33" maxlength="99" value="'. $scf_value_response .'" placeholder="' . $scf_options['scf_input_captcha'] . '" />',
	'message'  => '<textarea name="scf_message" id="scf_message" cols="33" rows="7" placeholder="' . $scf_options['scf_input_message'] . '">'. $scf_value_message .'</textarea>',
	'error'    => ''
);



function scf_input_filter() {

	global $scf_options, $scf_strings, $scf_value_name, $scf_value_email, $scf_value_confirm_email, $scf_value_subject, $scf_value_message, $scf_value_response;

	global $scf_processed;

	$input_name     = $scf_value_name;
    $input_email    = $scf_value_email;
    $input_confirm_email = $scf_value_confirm_email;
	$input_subject  = $scf_value_subject;
	$input_message  = $scf_value_message;
	$input_response = $scf_value_response;

	$name    = isset($scf_options['scf_input_name'])    ? $scf_options['scf_input_name']    : '';
    $email   = isset($scf_options['scf_input_email'])   ? $scf_options['scf_input_email']   : '';
    $confirm_email   = isset($scf_options['scf_input_confirm_email']) ? $scf_options['scf_input_confirm_email']   : '';
	$subject = isset($scf_options['scf_input_subject']) ? $scf_options['scf_input_subject'] : '';
	$message = isset($scf_options['scf_input_message']) ? $scf_options['scf_input_message'] : '';
	$captcha = isset($scf_options['scf_input_captcha']) ? $scf_options['scf_input_captcha'] : '';
	$style   = isset($scf_options['scf_style'])         ? $scf_options['scf_style']         : '';
	$error   = isset($scf_options['scf_error'])         ? $scf_options['scf_error']         : '';
	$spam    = isset($scf_options['scf_spam'])          ? $scf_options['scf_spam']          : '';

	$show_subject = isset($scf_options['scf_subject'])        ? $scf_options['scf_subject']        : false;
	$show_message = isset($scf_options['scf_enable_message']) ? $scf_options['scf_enable_message'] : true;
	$show_captcha = isset($scf_options['scf_captcha'])        ? $scf_options['scf_captcha']        : true;
	$show_honeypot = isset($scf_options['scf_honeypot'])      ? $scf_options['scf_honeypot']       : true;

	// recaptcha
	$recaptcha = isset($scf_options['scf_recaptcha']) ? $scf_options['scf_recaptcha'] : false;
	$recaptcha_version = isset($scf_options['scf_recaptcha_version']) ? $scf_options['scf_recaptcha_version'] : 'v2';
	$recaptcha_site_key = isset($scf_options['scf_recaptcha_site_key']) ? $scf_options['scf_recaptcha_site_key'] : '';
	$recaptcha_secret_key = isset($scf_options['scf_recaptcha_secret_key']) ? $scf_options['scf_recaptcha_secret_key'] : '';

	$include_additional_information = isset($scf_options['scf_include_additional_information']) ? $scf_options['scf_include_additional_information'] : true;

	$nonce = isset($_POST['scf-nonce']) ? sanitize_text_field($_POST['scf-nonce']) : false;
	$key   = isset($_POST['scf-key'])   ? sanitize_text_field($_POST['scf-key'])   : false;

	$pass = true;

	if (empty($key)) return false;

	if ( ! empty( $_POST['website3dhhsy3'] ) ) {

		$pass = false;
		$notice = esc_html__( 'Invalid submission.', 'scf' );
		$scf_strings['error'] = '<p class="scf_error">'. $notice .'</p>';

	}

	if (!wp_verify_nonce($nonce, 'scf-nonce')) {

		$pass = false;
		$notice = esc_html__('Invalid nonce value! Please try again or contact the administrator for help.', 'scf');
		$scf_strings['error'] = '<p class="scf_error">'. $notice .'</p>';

	}

	if (scf_malicious_input($input_name) || scf_malicious_input($input_email) || scf_malicious_input($input_subject)) {

		$pass = false;
		$notice  = esc_html__('Please do not include any of the following in the Name, Email, or Subject fields: ', 'scf');
		$notice .= esc_html__('line breaks, &ldquo;mime-version&rdquo;, &ldquo;content-type&rdquo;, &ldquo;cc:&rdquo; &ldquo;to:&rdquo;', 'scf');
		$scf_strings['error'] = '<p class="scf_error">'. $notice .'</p>';

	}

	if (empty($input_name)) {

		$pass = false;
		$scf_strings['error'] = $error;
		$scf_strings['name']  = '<input class="scf_error" name="scf_name" id="scf_name" type="text" size="33" maxlength="99" ';
		$scf_strings['name'] .= 'value="'. $input_name .'" '. $style .' placeholder="'. $name .'" />';
	}

	if (!is_email($input_email)) {

		$pass = false;
		$scf_strings['error'] = $error;
		$scf_strings['email']  = '<input class="scf_error" name="scf_email" id="scf_email" type="text" size="33" maxlength="99" ';
		$scf_strings['email'] .= 'value="'. $input_email .'" '. $style .' placeholder="'. $email .'" />';

    }

    if ( ! empty( $scf_options['scf_input_confirm_email'] ) && ! empty( $scf_options['scf_confirm_mailtext'] ) && $input_email != $input_confirm_email ) {

        $pass = false;
        $scf_strings['error'] = '<p class="scf_error">' . esc_html__('Confirmation email needs to match email. ', 'scf') . '</p>';
        $scf_strings['confirm_email']  = '<input class="scf_error" name="scf_confirm_email" id="scf_confirm_email" type="text" size="33" maxlength="99" ';
        $scf_strings['confirm_email'] .= 'value="'. $input_confirm_email .'" '. $style .' placeholder="'. $confirm_email .'" />';

    }

	if (empty($show_subject) && empty($input_subject)) {

		$pass = false;
		$scf_strings['error'] = $error;
		$scf_strings['subject']  = '<input class="scf_error" name="scf_subject" id="scf_subject" type="text" size="33" maxlength="99" ';
		$scf_strings['subject'] .= 'value="'. $input_subject .'" '. $style .' placeholder="'. $subject .'" />';

	}

	if ($show_message && empty($input_message)) {

		$pass = false;
		$scf_strings['error'] = $error;
		$scf_strings['message']  = '<textarea class="scf_error" name="scf_message" id="scf_message" cols="33" rows="7" ';
		$scf_strings['message'] .= $style .' placeholder="' . $message .'">'. $input_message .'</textarea>';

	}

	if ($show_captcha && (empty($input_response) || !scf_spam_question($input_response))) {

		$pass = false;
		$scf_strings['error'] = $spam;
		$scf_strings['response']  = '<input class="scf_error" name="scf_response" id="scf_response" type="text" size="33" maxlength="99" ';
		$scf_strings['response'] .= 'value="'. $input_response .'" '. $style .' placeholder="'. $captcha .'" />';

	}

	if ( $recaptcha && ! $scf_processed ) {

		// recaptcha v2
		if ( $recaptcha_version == 'v2' ) {

			if ( isset( $_POST['g-recaptcha-response'] ) ) {

				$captcha = $_POST['g-recaptcha-response'];
				$captcha_result = wp_remote_post( 'https://www.google.com/recaptcha/api/siteverify', array(
					'method' => 'POST',
					'body' => array(
						'secret' => $recaptcha_secret_key,
						'response' => $captcha,
					)
				));
				if ( is_wp_error( $captcha_result ) ) {
					$pass = false;
					$scf_strings['error'] = '<p class="scf_error">' . esc_html__('reCAPTCHA not filled in. ', 'scf') . '</p>';
				} else {
					$captcha_response = json_decode( $captcha_result['body'], true );
					if ( ! $captcha_response['success'] ) {
						$pass = false;
						$scf_strings['error'] = '<p class="scf_error">' . esc_html__('reCAPTCHA not filled in. ', 'scf') . '</p>';
					}
				}

			} else {

				$pass = false;
				$scf_strings['error'] = '<p class="scf_error">' . esc_html__('reCAPTCHA not filled in. ', 'scf') . '</p>';

			}

		} elseif ( $recaptcha_version == 'v3' ) {

			if ( isset( $_POST['token'] ) ) {

				$captcha = $_POST['token'];
				$action = $_POST['action'];

				$captcha_result = wp_remote_post( 'https://www.google.com/recaptcha/api/siteverify', array(
					'method' => 'POST',
					'body' => array(
						'secret' => $recaptcha_secret_key,
						'response' => $captcha,
					)
				));
				if ( is_wp_error( $captcha_result ) ) {
					$pass = false;
					$scf_strings['error'] = '<p class="scf_error">' . esc_html__('reCAPTCHA not passed [error 1]. ', 'scf') . '</p>';
				} else {
					$captcha_response = json_decode( $captcha_result['body'], true );
					if ( ! $captcha_response['success'] || ! $captcha_response['action'] == $action || $captcha_response['score'] < 0.5 ) {
						$pass = false;
						$scf_strings['error'] = '<p class="scf_error">' . esc_html__('reCAPTCHA not passed [error 2]. ', 'scf') . '</p>';
					}
				}

			} else {

				$pass = false;
				$scf_strings['error'] = '<p class="scf_error">' . esc_html__('reCAPTCHA not filled in. ', 'scf') . '</p>';

			}

		}

	}

	if ($pass == true) return true;

	return false;

}



function scf_malicious_input($input) {

	$maliciousness = false;

	$denied_inputs = array("\r", "\n", "mime-version", "content-type", "cc:", "to:");

	foreach($denied_inputs as $denied_input) {

		if (strpos(strtolower($input), strtolower($denied_input)) !== false) {

			$maliciousness = true;

			break;

		}

	}

	return $maliciousness;

}



function scf_spam_question($input) {

	global $scf_options;

	$casing   = $scf_options['scf_casing'];
	$response = $scf_options['scf_response'];
	$response = sanitize_text_field($response);

	if ($casing == false) return (strtoupper($input) == strtoupper($response));

	else return ($input == $response);

}



function scf_get_ip_address() {

	if (isset($_SERVER)) {

		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];

		} elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];

		} else {
			$ip_address = $_SERVER['REMOTE_ADDR'];

		}

	} else {

		if (getenv('HTTP_X_FORWARDED_FOR')) {
			$ip_address = getenv('HTTP_X_FORWARDED_FOR');

		} elseif (getenv('HTTP_CLIENT_IP')) {
			$ip_address = getenv('HTTP_CLIENT_IP');

		} else {
			$ip_address = getenv('REMOTE_ADDR');

		}

	}

	return $ip_address;

}



function scf_shortcode() {

	if (scf_input_filter()) return scf_process_contact_form();

	return scf_display_contact_form();

}
add_shortcode('simple_contact_form','scf_shortcode');

/**
 * Shortcode for inputs
 *
 * @since 20191009
 */
function scf_input_shortcode( $atts = array() ) {

    $settings = shortcode_atts( array(
		'type' => 'text',
        'name' => '',
        'value' => '',
        'required' => '',
        'checked' => '',
    ), $atts );

    $extra_atts = '';

    if ( ! empty( $settings['required'] ) ) {
        $extra_atts .= ' required';
    }

    if ( ! empty( $settings['checked'] ) ) {
        $extra_atts .= ' checked';
    }

	return '<input type="' . esc_attr( $settings['type'] ) . '" name="' . esc_attr( $settings['name'] ) . '" value="' . esc_attr( $settings['value'] ) . '"' . $extra_atts .' />';

} add_shortcode('simple_contact_form_input', 'scf_input_shortcode');

/**
 * Shortcode for date
 *
 * @since 20191024
 */
function scf_date_shortcode( $atts = array(), $content = '' ) {

    if ( empty( $content ) ) {
        $content = get_option( 'date_format' );
    }

	return current_time( $content );

} add_shortcode('simple_contact_form_date', 'scf_date_shortcode');

function simple_contact_form() {

	if (scf_input_filter()) {

		echo scf_process_contact_form();

	} else {

		echo scf_display_contact_form();

	}

}



function scf_process_contact_form() {

	global $scf_options;
	global $scf_processed;

	$recipient = $scf_options['scf_email'];
	$recipfrom = $scf_options['scf_from'];
	$recipname = $scf_options['scf_name'];
	$recipsite = $scf_options['scf_website'];
	$success   = $scf_options['scf_success'];
	$subject   = $scf_options['scf_subject'];
	$prepend   = $scf_options['scf_prepend'];
	$append    = $scf_options['scf_append'];
	$carbon    = $scf_options['scf_carbon'];
	$custom    = $scf_options['scf_css'];
	$messdisp  = $scf_options['scf_enable_message'];
	$mailfunc  = $scf_options['scf_mail_function'];
    $verbose   = $scf_options['scf_success_details'];

	if ( ! empty( $scf_options['scf_include_additional_information'] ) ) {
		$include_additional_information = $scf_options['scf_include_additional_information'];
	} else {
		$include_additional_information = false;
    }

    if ( ! empty( $scf_options['scf_blacklist'] ) ) {
		$blacklist = explode( ',', $scf_options['scf_blacklist'] );
	} else {
		$blacklist = false;
	}

	if ( ! empty( $scf_options['scf_recaptcha'] ) ) {
		$recaptcha = $scf_options['scf_recaptcha'];
	} else {
		$recaptcha = false;
	}

	if ( ! empty( $scf_options['scf_recaptcha_version'] ) ) {
		$recaptcha_version = $scf_options['scf_recaptcha_version'];
	} else {
		$recaptcha_version = 'v2';
	}

	if ( ! empty( $scf_options['scf_recaptcha_site_key'] ) ) {
		$recaptcha_site_key = $scf_options['scf_recaptcha_site_key'];
	} else {
		$recaptcha_site_key = '';
	}

	if ( ! empty( $scf_options['scf_recaptcha_secrey_key'] ) ) {
		$recaptcha_secret_key = $scf_options['scf_recaptcha_secrey_key'];
	} else {
		$recaptcha_secret_key = '';
    }

	$charset = get_option('blog_charset', 'UTF-8');

	$date    = date_i18n(get_option('date_format'), current_time('timestamp')) .' @ '. date_i18n(get_option('time_format'), current_time('timestamp'));

    $topic   = (isset($_POST['scf_subject']) && !empty($_POST['scf_subject'])) ? stripslashes(strip_tags(trim($_POST['scf_subject']))) : $subject;
    $topic   = do_shortcode( $topic );

	$name    = isset($_POST['scf_name']) ? stripslashes(strip_tags(trim($_POST['scf_name']))) : '';
	$topic = str_replace( '{name}', $name, $topic );

	$message = isset($_POST['scf_message']) ? stripslashes(trim($_POST['scf_message'])) : '';

	$email   = isset($_POST['scf_email']) ? sanitize_text_field($_POST['scf_email']) : '';

	$agent   = isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field($_SERVER['HTTP_USER_AGENT']) : esc_html__('[ undefined ]', 'scf');

	$form    = isset($_SERVER['HTTP_REFERER']) ? sanitize_text_field($_SERVER['HTTP_REFERER']) : esc_html__('[ undefined ]', 'scf');

	$host    = isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field(gethostbyaddr($_SERVER['REMOTE_ADDR'])) : esc_html__('[ undefined ]', 'scf');

	$from    = !empty($recipfrom) ? $recipfrom : $email;

	$ip      = sanitize_text_field(scf_get_ip_address());

	$style   = !empty($custom) ? '<style type="text/css">'. $custom .'</style>' : '';

	$copy    = ($carbon) ? '<p class="scf_carbon">'. esc_html__('A copy of this message was sent to your email address.', 'scf') .'</p>' : '';

	$headers  = 'X-Mailer: Simple Basic Contact Form'. "\n";
	$headers .= 'From: '. $name .' <'. $from .'>'. "\n";
	$headers .= 'Reply-To: '. $name .' <'. $email .'>'. "\n";
	$headers .= 'Content-Type: text/plain; charset='. $charset . "\n";

	$message_encode = htmlentities($message, ENT_QUOTES, $charset);

	$message_plain = ($messdisp) ? "\n" . esc_html__('Message: ', 'scf') . "\n\n" . $message : '';
	$message_front = ($messdisp) ? "\n" . esc_html__('Message: ', 'scf') . "\n\n" . $message_encode : '';

	$custom_content = apply_filters( 'scf_custom_email_content', '' );
	if ( empty( $custom_content ) ) {
		$custom_content = '';
	}

	$message_send = esc_html__('Hello ', 'scf') . $recipname .', '. "\n\n" .
					esc_html__('You are being contacted via ', 'scf') . $recipsite .': '. "\n\n" .

					esc_html__('Name:     ', 'scf') . $name  . "\n" .
					esc_html__('Email:    ', 'scf') . $email . "\n" .
					esc_html__('Subject:  ', 'scf') . $topic . "\n" .
					esc_html__('Date:     ', 'scf') . $date  . "\n" .

					$custom_content . $message_plain . "\n\n";

	// additional information
	if ( $include_additional_information ) {

		$message_send .= esc_html__('-----------------------', 'scf') . "\n\n";
		$message_send .= esc_html__('Additional Information:', 'scf') . "\n\n";
		$message_send .= esc_html__('Site:     ', 'scf') . $recipsite . "\n";
		$message_send .= esc_html__('URL:      ', 'scf') . $form      . "\n";
		$message_send .= esc_html__('IP:       ', 'scf') . $ip        . "\n";
		$message_send .= esc_html__('Host:     ', 'scf') . $host      . "\n";
		$message_send .= esc_html__('Agent:    ', 'scf') . $agent     . "\n\n";

	}

	$message_send = apply_filters('scf_full_message', $message_send);

    // check if message contains blacklisted words
    $valid_submission = true;
    if ( is_array( $blacklist ) ) {
        foreach ( $blacklist as $blacklist_item ) {
			if ( ! empty( trim( $blacklist_item) ) ) {
				if (stripos( $message_plain, trim( $blacklist_item ) ) !== false) {
					$valid_submission = false;
				}
			}
        }
    }

    if ( $valid_submission && ! $scf_processed ) {

        if ($mailfunc) {

            if ($carbon) mail($email,     $topic, $message_send, $headers);
                        mail($recipient, $topic, $message_send, $headers);

        } else {

            if ($carbon) wp_mail($email,     $topic, $message_send, $headers);
                        wp_mail($recipient, $topic, $message_send, $headers);

		}

    }

	do_action('scf_send_email', $recipient, $topic, $message_send, $headers, $email);

	$reset_link  = '<p class="scf_reset">'. esc_html__('[ ', 'scf');
	$reset_link .= '<a href="'. $form .'">'. esc_html__('Click here to reset the form', 'scf') .'</a>';
	$reset_link .= esc_html__(' ]', 'scf') .'</p></div>'. $style . do_shortcode( $append );

	$short_results  = do_shortcode( $prepend ) .'<div id="scf_success" class="scf">'. $success;
	$short_results .= ($messdisp) ? '<pre><code>'. esc_html__('Message: ', 'scf') . "\n\n" . $message_encode .'</code></pre>' : '';
	$short_results .= $copy . $reset_link;

	$full_results = do_shortcode( $prepend ) .'<div id="scf_success" class="scf">'. $success .'<pre><code>'.
								esc_html__('Name:     ', 'scf') . $name  . "\n" .
								esc_html__('Email:    ', 'scf') . $email . "\n" .
								esc_html__('Subject:  ', 'scf') . $topic . "\n" .
								esc_html__('Date:     ', 'scf') . $date  . $message_front .'</code></pre>'. $copy . $reset_link;

	$full_results = '<div id="simple-contact-form-wrap">' . $full_results . '</div>';
	$short_results = '<div id="simple-contact-form-wrap">' . $short_results . '</div>';

	$short_results = apply_filters('scf_short_results', $short_results);
	$full_results  = apply_filters('scf_full_results',  $full_results);

	$scf_processed = true;

	if ($verbose) return $full_results;

	return $short_results;

}



function scf_display_contact_form() {

	global $scf_options, $scf_strings;

	$question = $scf_options['scf_question'];
	$nametext = $scf_options['scf_nametext'];
	$subjtext = $scf_options['scf_subjtext'];
    $mailtext = $scf_options['scf_mailtext'];
	$messtext = $scf_options['scf_messtext'];
	$submittext = $scf_options['scf_submittext'];
	$captcha  = $scf_options['scf_captcha'];
	$preform  = $scf_options['scf_preform'];
    $appform  = $scf_options['scf_appform'];
	$custom   = $scf_options['scf_css'];
	$error    = $scf_strings['error'];
	$subject  = $scf_options['scf_subject'];

	if ( ! empty( $scf_options['scf_honeypot'] ) ) {
		$honeypot = $scf_options['scf_honeypot'];
	} else {
		$honeypot = false;
	}

	if ( ! empty( $scf_options['scf_include_additional_information'] ) ) {
		$include_additional_information = $scf_options['scf_include_additional_information'];
	} else {
		$include_additional_information = false;
    }

    if ( ! empty( $scf_options['scf_before_button'] ) ) {
        $before_button = $scf_options['scf_before_button'];
    } else {
        $before_button = '';
    }

    if ( ! empty( $scf_options['scf_blacklist'] ) ) {
        $blacklist = $scf_options['scf_blacklist'];
    } else {
        $blacklist = '';
    }

	if ( ! empty( $scf_options['scf_gdpr_position'] ) ) {
		$gdpr_position = $scf_options['scf_gdpr_position'];
	} else {
		$gdpr_position = 'after_submit';
	}

	if ( ! empty( $scf_options['scf_recaptcha'] ) ) {
        $recaptcha = $scf_options['scf_recaptcha'];
    } else {
        $recaptcha = false;
	}

	if ( ! empty( $scf_options['scf_recaptcha_version'] ) ) {
        $recaptcha_version = $scf_options['scf_recaptcha_version'];
    } else {
        $recaptcha_version = 'v2';
	}

	if ( ! empty( $scf_options['scf_recaptcha_site_key'] ) ) {
        $recaptcha_site_key = $scf_options['scf_recaptcha_site_key'];
    } else {
        $recaptcha_site_key = '';
	}

	if ( ! empty( $scf_options['scf_recaptcha_secret_key'] ) ) {
        $recaptcha_secret_key = $scf_options['scf_recaptcha_secret_key'];
    } else {
        $recaptcha_secret_key = '';
	}

	$styles = !empty($custom) ? '<style>.scf-confirm-checkbox { margin-top: 15px; } .scf-website3dhhsy3 { display: none; } #simple-contact-form .scf-row { width: 100%; overflow: hidden; margin: 5px 0; padding: 5px 0; border: 0; } #simple-contact-form .scf-row input { box-sizing: border-box; float: left; clear: none; width: 75%; margin: 0; } #simple-contact-form .scf-row label { box-sizing: border-box; float: left; clear: both; width: 25%; margin-top: 5px; font-size: 90%; } #simple-contact-form .scf-row textarea { box-sizing: border-box; float: left; clear: both; width: 100%; margin-top: 2px; }' . $custom . '</style>' : '';

	$scf_subject = '';
	$scf_captcha = '';
	$scf_honeypot = '';
	$scf_message = '';
	$scf_recaptcha = '';

	if (empty($subject)) {
		$scf_subject = '
				<div class="scf-row scf-subject">
					<label for="scf_subject">'. $subjtext .'</label>
					'. $scf_strings['subject'] .'
				</div>';
	}

	if ($captcha) {
		$scf_captcha = '
				<div class="scf-row scf-response">
					<label for="scf_response">'. $question .'</label>
					'. $scf_strings['response'] .'
				</div>';
	}

	if ((!isset($scf_options['scf_enable_message'])) || (isset($scf_options['scf_enable_message']) && $scf_options['scf_enable_message'])) {
		$scf_message = '
				<div class="scf-row scf-message">
					<label for="scf_message">'. $messtext .'</label>
					'. $scf_strings['message'] .'
				</div>';
	}

	if ( $honeypot ) {
		$scf_honeypot = '
			<div class="scf-row scf-website3dhhsy3">
				<label for="website3dhhsy3">' . esc_html__( 'Leave this field empty', 'scf' ) . '</label>
				<input type="text" name="website3dhhsy3" tabindex="-1" autocomplete="off" />
			</div>';
	}

	//
	if ( $recaptcha ) {
		if ( $recaptcha_version == 'v2' ) {
			$scf_recaptcha = '
			<div class="scf-recaptcha">
				<script src="https://www.google.com/recaptcha/api.js"></script>
				<div class="g-recaptcha" data-sitekey="' . $recaptcha_site_key . '"></div>
			</div>';
		} elseif ( $recaptcha_version == 'v3' ) {
			ob_start();
			?>
				<div class="scf-recaptcha">
					<script src="https://www.google.com/recaptcha/api.js?render=<?php echo esc_attr( $recaptcha_site_key ); ?>"></script>
					<script>
						jQuery(document).ready(function(){
							jQuery('.scf form').on( 'submit', function(event) {

								event.preventDefault();
								var scfForm = jQuery(this);
								var scfEmail = jQuery(this).find('#scf_email').val();

								grecaptcha.ready(function() {
									grecaptcha.execute('<?php echo esc_attr( $recaptcha_site_key ); ?>', {action: 'contact'}).then(function(token) {
										scfForm.prepend('<input type="hidden" name="token" value="' + token + '">');
										scfForm.prepend('<input type="hidden" name="action" value="contact">');
										scfForm.unbind('submit').submit();
									});
								});

							});
						});
					</script>
				</div>
			<?php
			$scf_recaptcha = ob_get_contents();
			ob_end_clean();
		}
	}
	//

	$scf_custom_fields = apply_filters( 'scf_custom_fields', '' );
	if ( empty( $scf_custom_fields ) ) {
		$scf_custom_fields = '';
    }

    $scf_confirm_email = '';
    if ( ! empty( $scf_options['scf_input_confirm_email'] ) && ! empty( $scf_options['scf_confirm_mailtext'] ) ) {
        $scf_confirm_email = '
		<div class="scf-row scf-confirm-email">
			<label for="scf_confirm_email">'. $scf_options['scf_confirm_mailtext'] .'</label>
			' . $scf_strings['confirm_email'] . '
		</div>';
    }

	$scf_form = '<div id="simple-contact-form-wrap">' . do_shortcode( $preform ) . $error . '
		<div id="simple-contact-form" class="scf">
			<form action="#simple-contact-form-wrap" method="post">
				<div class="scf-row scf-name">
					<label for="scf_name">'. $nametext .'</label>
					'. $scf_strings['name'] .'
				</div>
				<div class="scf-row scf-email">
					<label for="scf_email">'. $mailtext .'</label>
					'. $scf_strings['email'] .'
				</div>';

				$scf_form .= $scf_confirm_email;
				$scf_form .= $scf_subject;
				$scf_form .= $scf_custom_fields;
				$scf_form .= $scf_captcha;
				$scf_form .= $scf_honeypot;
				$scf_form .= $scf_message;
				$scf_form .= $scf_recaptcha;
				$scf_form .= do_shortcode( $before_button );

				if ( $gdpr_position == 'before_submit' ) {
					$scf_form .= scf_confirm_checkbox();
				}

				$scf_form .= '<div class="scf-submit">
					<input type="submit" id="scf-button" value="'. $submittext .'">
					<input type="hidden" id="scf-key" name="scf-key" value="process">
					'. wp_nonce_field('scf-nonce', 'scf-nonce', false, false) .'
				</div>';

				if ( $gdpr_position == 'after_submit' ) {
					$scf_form .= scf_confirm_checkbox();
				}

			$scf_form .= '</form>
		</div>
		'. $styles . do_shortcode( $appform ) . '</div>';

	return apply_filters('scf_filter_contact_form', $scf_form);

}



function scf_default_styles() {

	return '#simple-contact-form form { max-width: 700px; padding: 5px; }
#simple-contact-form .scf-row { width: 100%; overflow: hidden; margin: 5px 0; padding: 5px 0; border: 0; }
#simple-contact-form .scf-row input { box-sizing: border-box; float: left; clear: none; width: 75%; margin: 0; }
#simple-contact-form .scf-row label { box-sizing: border-box; float: left; clear: both; width: 25%; margin-top: 5px; font-size: 90%; }
#simple-contact-form .scf-row textarea { box-sizing: border-box; float: left; clear: both; width: 100%; margin-top: 2px; }
#scf_success pre { white-space: pre-wrap; }
p.scf_error, p.scf_spam { color: #cc0000; }
div.scf-submit { margin-top: 10px; }
p.scf_success { color: #669966; }
.scf-confirm-checkbox { margin-top: 15px; }
.scf-website3dhhsy3 { display: none; }';

}



function scf_plugin_action_links($links, $file) {

	global $scf_path;

	if ($file == $scf_path) {

		$scf_links = '<a href="'. get_admin_url() .'options-general.php?page='. $scf_path .'">'. esc_html__('Settings', 'scf') .'</a>';

		array_unshift($links, $scf_links);

	}

	return $links;

}
add_filter ('plugin_action_links', 'scf_plugin_action_links', 10, 2);



function add_scf_links($links, $file) {

	if ($file == plugin_basename(__FILE__)) {

		$href  = 'https://wordpress.org/support/plugin/simple-basic-contact-form/reviews/?rate=5#new-post';
		$title = esc_html__('Give us a 5-star rating at WordPress.org', 'scf');
		$text  = esc_html__('Rate this plugin', 'scf') .'&nbsp;&raquo;';

		$links[] = '<a target="_blank" href="'. $href .'" title="'. $title .'">'. $text .'</a>';

	}

	return $links;

}
add_filter('plugin_row_meta', 'add_scf_links', 10, 2);



function scf_init() {

	register_setting('scf_plugin_options', 'scf_options', 'scf_validate_options');

}
add_action ('admin_init', 'scf_init');



function scf_delete_plugin_options() {

	delete_option('scf_options');

}
if ($scf_options['default_options'] == 1) {

	register_uninstall_hook (__FILE__, 'scf_delete_plugin_options');

}



function scf_add_defaults() {

	$user_info = get_userdata(1);

	$admin_name = $user_info->user_login;

	if (!$admin_name) $admin_name = 'Awesome Person';

	$site_title = get_bloginfo('name');
	$admin_mail = get_bloginfo('admin_email');
	$tmp        = get_option('scf_options');

	if ( ! is_array( $tmp ) || $tmp['default_options'] == '1' ) {

		$arr = array(

			'default_options'     => 0,

			// General
			'scf_name'            => $admin_name,
			'scf_email'           => $admin_mail,
			'scf_from'            => $admin_mail,
			'scf_website'         => $site_title,
			'scf_subject'         => esc_html__('Message sent from your contact form.', 'scf'),
			'scf_enable_message'  => 1,
			'scf_carbon'          => 1,
			'scf_success_details' => 1,
			'scf_gdpr_message'    => __('I consent to having this website store my submitted information so they can respond to my inquiry. See our privacy policy to learn more how we use data.', 'scf'),
			'scf_gdpr_position'   => 'after_submit',
			'scf_mail_function'   => 0,

			// Captcha
			'scf_honeypot'        => 0,
			'scf_captcha'         => 1,
			'scf_question'        => esc_html__('1 + 1 =', 'scf'),
			'scf_response'        => esc_attr__('2', 'scf'),
			'scf_casing'          => 0,
			'scf_recaptcha'       => 0,
			'scf_recaptcha_site_key' => '',
			'scf_recaptcha_secret_key' => '',

			// Styles
			'scf_css'             => scf_default_styles(),

			// Labels
			'scf_nametext'        => esc_html__('Your Name', 'scf'),
			'scf_input_name'      => esc_attr__('Your Name', 'scf'),
            'scf_mailtext'        => esc_html__('Your Email', 'scf'),
            'scf_confirm_mailtext'=> esc_html__('Confirm Your Email', 'scf'),
            'scf_input_email'     => esc_attr__('Your Email', 'scf'),
            'scf_input_confirm_email' => esc_attr__('Confirm Your Email', 'scf'),
			'scf_subjtext'        => esc_html__('Email Subject', 'scf'),
			'scf_input_subject'   => esc_attr__('Email Subject', 'scf'),
			'scf_messtext'        => esc_html__('Your Message', 'scf'),
			'scf_submittext'      => esc_attr__('Send email', 'scf'),
			'scf_input_message'   => esc_attr__('Your Message', 'scf'),
			'scf_input_captcha'   => esc_attr__('Correct Response', 'scf'),

			// Errors
			'scf_success'         => '<p class="scf_success"><strong>'. esc_html__('Success!', 'scf') .'</strong> '. esc_html__('Your message has been sent.', 'scf') .'</p>',
			'scf_error'           => '<p class="scf_error">'. esc_html__('Please complete the required fields.', 'scf') .'</p>',
			'scf_style'           => 'style="border: 2px solid #cc0000;"',
            'scf_spam'            => '<p class="scf_spam">'. esc_html__('Incorrect response for challenge question. Please try again.', 'scf') .'</p>',

			// Custom
			'scf_preform'         => '',
			'scf_appform'         => '<div style="clear:both;">&nbsp;</div>',
			'scf_prepend'         => '',
            'scf_append'          => '',
            'scf_before_button'   => '',

            // blacklist
            'scf_blacklist'       => '',

		);

		update_option('scf_options', $arr);

	}

}
register_activation_hook(__FILE__, 'scf_add_defaults');



function scf_validate_options($input) {

	if (!isset($input['default_options'])) $input['default_options'] = null;
	$input['default_options'] = ($input['default_options'] == 1 ? 1 : 0);

	// General
	$input['scf_name']     = esc_attr($input['scf_name']);
	$input['scf_email']    = sanitize_text_field($input['scf_email']);
	$input['scf_website']  = esc_attr($input['scf_website']);
	$input['scf_subject']  = esc_attr($input['scf_subject']);

	if (!isset($input['scf_enable_message'])) $input['scf_enable_message'] = null;
	$input['scf_enable_message'] = ($input['scf_enable_message'] == 1 ? 1 : 0);

	if (!isset($input['scf_carbon'])) $input['scf_carbon'] = null;
	$input['scf_carbon'] = ($input['scf_carbon'] == 1 ? 1 : 0);

	if (!isset($input['scf_success_details'])) $input['scf_success_details'] = null;
	$input['scf_success_details'] = ($input['scf_success_details'] == 1 ? 1 : 0);

	if (!isset($input['scf_mail_function'])) $input['scf_mail_function'] = null;
	$input['scf_mail_function'] = ($input['scf_mail_function'] == 1 ? 1 : 0);

	// Captcha
	if (!isset($input['scf_captcha'])) $input['scf_captcha'] = null;
	$input['scf_captcha'] = ($input['scf_captcha'] == 1 ? 1 : 0);

	// Honepot
	if (!isset($input['scf_honeypot'])) $input['scf_honeypot'] = null;
	$input['scf_honeypot'] = ($input['scf_honeypot'] == 1 ? 1 : 0);

	$input['scf_question'] = esc_attr($input['scf_question']);
	$input['scf_response'] = esc_attr($input['scf_response']);

	// recaptcha
	if (!isset($input['scf_recaptcha'])) $input['scf_recaptcha'] = null;
	$input['scf_recaptcha'] = ($input['scf_recaptcha'] == 1 ? 1 : 0);
	$input['scf_recaptcha_version'] = esc_attr($input['scf_recaptcha_version']);
	$input['scf_recaptcha_site_key'] = esc_attr($input['scf_recaptcha_site_key']);
	$input['scf_recaptcha_secret_key'] = esc_attr($input['scf_recaptcha_secret_key']);

	if (!isset($input['scf_casing'])) $input['scf_casing'] = null;
	$input['scf_casing'] = ($input['scf_casing'] == 1 ? 1 : 0);

	// Styles
	$input['scf_css'] = sanitize_text_field($input['scf_css']);

	// Labels
	$input['scf_nametext']      = esc_attr($input['scf_nametext']);
	$input['scf_input_name']    = esc_attr($input['scf_input_name']);
    $input['scf_mailtext']      = esc_attr($input['scf_mailtext']);
    $input['scf_confirm_mailtext'] = esc_attr($input['scf_confirm_mailtext']);
    $input['scf_input_email']   = esc_attr($input['scf_input_email']);
    $input['scf_input_confirm_email'] = esc_attr($input['scf_input_confirm_email']);
	$input['scf_subjtext']      = esc_attr($input['scf_subjtext']);
	$input['scf_input_subject'] = esc_attr($input['scf_input_subject']);
	$input['scf_messtext']      = esc_attr($input['scf_messtext']);
	$input['scf_submittext']    = esc_attr($input['scf_submittext']);
	$input['scf_input_message'] = esc_attr($input['scf_input_message']);
	$input['scf_input_captcha'] = esc_attr($input['scf_input_captcha']);

	// Errors
	$input['scf_success'] = wp_kses_post($input['scf_success']);
	$input['scf_error']   = wp_kses_post($input['scf_error']);
	$input['scf_style']   = wp_kses_post($input['scf_style']);
	$input['scf_spam']    = wp_kses_post($input['scf_spam']);

	// Custom
	$input['scf_preform'] = wp_kses_post($input['scf_preform']);
	$input['scf_appform'] = wp_kses_post($input['scf_appform']);
	$input['scf_prepend'] = wp_kses_post($input['scf_prepend']);
    $input['scf_append']  = wp_kses_post($input['scf_append']);
    $input['scf_before_button']  = wp_kses_post($input['scf_before_button']);

    // blacklist
    $input['scf_blacklist']  = wp_kses_post($input['scf_blacklist']);

	return $input;

}



function scf_add_options_page() {

	global $scf_plugin;

	add_options_page($scf_plugin, esc_html__('Contact Form', 'scf'), 'manage_options', __FILE__, 'scf_render_form');

}
add_action ('admin_menu', 'scf_add_options_page');



function scf_render_form() {

	global $scf_plugin, $scf_options, $scf_path, $scf_homeurl, $scf_version; ?>

	<?php
		if ( ! isset( $scf_options['scf_gdpr_message'] ) ) {
			$scf_options['scf_gdpr_message'] = __('I consent to having this website store my submitted information so they can respond to my inquiry. See our privacy policy to learn more how we use data.', 'scf');
		}

		if ( ! isset( $scf_options['scf_gdpr_position'] ) ) {
			$scf_options['scf_gdpr_position'] = 'after_submit';
		}

		if ( ! isset( $scf_options['scf_submittext'] ) ) {
			$scf_options['scf_submittext'] = esc_attr__('Send email', 'scf');
		}

		if ( ! isset( $scf_options['scf_include_additional_information'] ) ) {
			$scf_options['scf_include_additional_information'] = false;
        }

        if ( ! isset( $scf_options['scf_before_button'] ) ) {
			$scf_options['scf_before_button'] = '';
        }

        if ( ! isset( $scf_options['scf_blacklist'] ) ) {
			$scf_options['scf_blacklist'] = '';
		}

		if ( ! isset( $scf_options['scf_recaptcha_version'] ) ) {
			$scf_options['scf_recaptcha_version'] = 'v2';
		}

		if ( ! isset( $scf_options['scf_recaptcha_site_key'] ) ) {
			$scf_options['scf_recaptcha_site_key'] = false;
		}

		if ( ! isset( $scf_options['scf_recaptcha_secret_key'] ) ) {
			$scf_options['scf_recaptcha_secret_key'] = false;
		}

	?>

	<style type="text/css">
		.mm-panel-overview {
			padding: 0 15px 15px 150px;
			background-image: url(<?php echo plugins_url('/simple-basic-contact-form/sbcf-icon.png'); ?>);
			background-repeat: no-repeat; background-position: 15px 0; background-size: 130px 130px;
			}
		#mm-plugin-options h1 small { line-height: 12px; font-size: 12px; color: #bbb; }
		#mm-plugin-options h2 { margin: 0; padding: 12px 15px; font-size: 16px; cursor: pointer; }
		#mm-plugin-options h3 { margin: 20px 15px; font-size: 14px; }
		#mm-plugin-options p { margin: 15px; }
		#mm-plugin-options ul { margin: 15px 15px 20px 40px; }
		#mm-plugin-options li { margin: 8px 0; list-style-type: disc; }
		#mm-plugin-options textarea { width: 90%; }
		#mm-plugin-options .button-primary { margin: 0 0 15px 15px; }

		.mm-table-wrap { margin: 15px; }
		.mm-table-wrap table { padding: 10px 0; }
		.mm-table-wrap td, .mm-table-wrap th { padding: 10px 15px; vertical-align: middle; }
		.mm-item-caption { font-size: 12px; color: #777; }
		span.mm-item-caption { display: inline-block; vertical-align: middle; }
		.mm-item-caption code { margin: 0; padding: 3px 3px 2px 3px; font-size: 12px; }
		.mm-code { padding: 6px 5px 5px 5px; background-color: #fafae0; color: #333; font-size: 14px; }

		#setting-error-settings_updated { margin: 8px 0 15px 0; }
		#setting-error-settings_updated p { margin: 7px 0; }

		#mm-panel-toggle { margin: 5px 0; }
		#mm-credit-info { margin: -5px 0 0 2px; }

	</style>

	<div id="mm-plugin-options" class="wrap">

		<h1><?php echo $scf_plugin; ?> <small><?php echo 'v'. $scf_version; ?></small></h1>
		<div id="mm-panel-toggle"><a href="<?php get_admin_url() .'options-general.php?page='. $scf_path; ?>"><?php esc_html_e('Toggle all panels', 'scf'); ?></a></div>

		<form method="post" action="options.php">
			<?php settings_fields('scf_plugin_options'); ?>

			<div class="metabox-holder">
				<div class="meta-box-sortables ui-sortable">

					<div id="mm-panel-overview" class="postbox">
						<h2><?php esc_html_e('Overview', 'scf'); ?></h2>
						<div class="toggle<?php if (isset($_GET["settings-updated"])) { echo ' default-hidden'; } ?>">
							<div class="mm-panel-overview">
								<p>
									<strong><?php echo $scf_plugin; ?></strong> <?php esc_html_e('is a secure contact form that&rsquo;s fast and flexible.', 'scf'); ?>
									<?php esc_html_e('To display the form on any WP Post or Page, add the shortcode:', 'scf'); ?>  <code>[simple_contact_form]</code>.
								</p>
								<ul>
									<li><a id="mm-panel-primary-link" href="#mm-panel-primary"><?php esc_html_e('Plugin Settings', 'scf'); ?></a></li>
									<li><a id="mm-panel-secondary-link" href="#mm-panel-secondary"><?php esc_html_e('Shortcode &amp; Template Tag', 'scf'); ?></a></li>
									<li><a target="_blank" href="https://wordpress.org/plugins/simple-basic-contact-form/"><?php esc_html_e('Plugin Homepage', 'scf'); ?>&nbsp;&raquo;</a></li>
								</ul>
								<p>
									<?php esc_html_e('If you like this plugin, please', 'scf'); ?>
									<a target="_blank" href="https://wordpress.org/support/plugin/simple-basic-contact-form/reviews/?rate=5#new-post" title="<?php esc_attr_e('THANK YOU for your support!', 'scf'); ?>"><?php esc_html_e('give it a 5-star rating', 'scf'); ?>&nbsp;&raquo;</a>
								</p>
							</div>
						</div>
					</div>

					<div id="mm-panel-primary" class="postbox">
						<h2><?php esc_html_e('Plugin Options', 'scf'); ?></h2>
						<div class="toggle<?php if (!isset($_GET["settings-updated"])) { echo ' default-hidden'; } ?>">
							<p><?php esc_html_e('Configure and customize the contact form.', 'scf'); ?></p>

							<h3><?php esc_html_e('General Options', 'scf'); ?></h3>
							<div class="mm-table-wrap">
								<table class="widefat mm-table">
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_name]"><?php esc_html_e('Your Name', 'scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="scf_options[scf_name]" value="<?php echo $scf_options['scf_name']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('Name of person that will receive messages', 'scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_email]"><?php esc_html_e('Your Email', 'scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="scf_options[scf_email]" value="<?php echo $scf_options['scf_email']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('Email of person that will receive messages', 'scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_from]"><?php esc_html_e('From Address', 'scf'); ?></label></th>
										<td><input type="text" size="50" maxlength="200" name="scf_options[scf_from]" value="<?php echo $scf_options['scf_from']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('Here you may customize the address used for the &ldquo;From&rdquo; header (see plugin FAQs for info)', 'scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_website]"><?php esc_html_e('Your Website', 'scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="scf_options[scf_website]" value="<?php echo $scf_options['scf_website']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('The name of your website', 'scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_subject]"><?php esc_html_e('Default Subject', 'scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="scf_options[scf_subject]" value="<?php echo $scf_options['scf_subject']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('Default subject (or leave blank to display the subject field). {name} will be dynamically replaced by the value of the name field.', 'scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_gdpr_message]"><?php esc_html_e('GDPR Message', 'scf'); ?></label></th>
										<td>
											<textarea class="large-text code" rows="3" cols="50" name="scf_options[scf_gdpr_message]"><?php echo esc_textarea($scf_options['scf_gdpr_message']); ?></textarea>
										<div class="mm-item-caption"><?php esc_html_e('GDPR message ( or leave blank not to display it )', 'scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_gdpr_position]"><?php esc_html_e('GDPR Message - Position', 'scf'); ?></label></th>
										<td>
											<select name="scf_options[scf_gdpr_position]">
												<option value="before_submit" <?php selected( 'before_submit', sanitize_text_field( $scf_options['scf_gdpr_position'] ), true ); ?>><?php esc_html_e('Before Submit Button', 'scf'); ?></option>
												<option value="after_submit" <?php selected( 'after_submit', sanitize_text_field( $scf_options['scf_gdpr_position'] ), true ); ?>><?php esc_html_e('After Submit Button', 'scf'); ?></option>
											</select>
										<div class="mm-item-caption"><?php esc_html_e('The location/position of the GDPR message.', 'scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_enable_message]"><?php esc_html_e('Show Message Field', 'scf'); ?></label></th>
										<td><input type="checkbox" name="scf_options[scf_enable_message]" value="1" <?php if (isset($scf_options['scf_enable_message'])) { checked('1', $scf_options['scf_enable_message']); } ?> />
										<span class="mm-item-caption"><?php esc_html_e('Enable/display the message field', 'scf'); ?></span></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_carbon]"><?php esc_html_e('Enable Carbon Copies', 'scf'); ?></label></th>
										<td><input type="checkbox" name="scf_options[scf_carbon]" value="1" <?php if (isset($scf_options['scf_carbon'])) { checked('1', $scf_options['scf_carbon']); } ?> />
										<span class="mm-item-caption"><?php esc_html_e('Send a carbon copy to the sender', 'scf'); ?></span></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_success_details]"><?php esc_html_e('Success Message', 'scf'); ?></label></th>
										<td><input type="checkbox" name="scf_options[scf_success_details]" value="1" <?php if (isset($scf_options['scf_success_details'])) { checked('1', $scf_options['scf_success_details']); } ?> />
										<span class="mm-item-caption"><?php esc_html_e('Display verbose success message', 'scf'); ?></span></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_mail_function]"><?php esc_html_e('Mail Function', 'scf'); ?></label></th>
										<td><input type="checkbox" name="scf_options[scf_mail_function]" value="1" <?php if (isset($scf_options['scf_mail_function'])) { checked('1', $scf_options['scf_mail_function']); } ?> />
										<span class="mm-item-caption"><?php esc_html_e('Use PHP&rsquo;s', 'scf'); ?> <code>mail()</code> <?php esc_html_e('instead of WP&rsquo;s', 'scf'); ?> <code>wp_mail()</code></span></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_include_additional_information]"><?php esc_html_e('Additional Information', 'scf'); ?></label></th>
										<td><input type="checkbox" name="scf_options[scf_include_additional_information]" value="1" <?php if (isset($scf_options['scf_include_additional_information'])) { checked('1', $scf_options['scf_include_additional_information']); } ?> />
										<span class="mm-item-caption"><?php esc_html_e('Includes additional information in the email such as IP, browser...', 'scf' ); ?></span></td>
									</tr>
								</table>
							</div>

							<h3><?php esc_html_e('Antispam', 'scf'); ?></h3>
							<div class="mm-table-wrap">
								<table class="widefat mm-table">
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_honeypot]"><?php esc_html_e('Enable Honeypot', 'scf'); ?></label></th>
										<td><input type="checkbox" name="scf_options[scf_honeypot]" value="1" <?php if (isset($scf_options['scf_honeypot'])) { checked('1', $scf_options['scf_honeypot']); } ?> />
										<span class="mm-item-caption"><?php esc_html_e('Enable Honeypot', 'scf'); ?></span></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_captcha]"><?php esc_html_e('Enable Challenge Question', 'scf'); ?></label></th>
										<td><input type="checkbox" name="scf_options[scf_captcha]" value="1" <?php if (isset($scf_options['scf_captcha'])) { checked('1', $scf_options['scf_captcha']); } ?> />
										<span class="mm-item-caption"><?php esc_html_e('Enable the Challenge Question', 'scf'); ?></span></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_question]"><?php esc_html_e('Challenge Question', 'scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="scf_options[scf_question]" value="<?php echo $scf_options['scf_question']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('Question that must be answered correctly', 'scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_response]"><?php esc_html_e('Challenge Response', 'scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="scf_options[scf_response]" value="<?php echo $scf_options['scf_response']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('The *only* correct answer to the challenge question', 'scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_casing]"><?php esc_html_e('Case Sensitivity', 'scf'); ?></label></th>
										<td><input type="checkbox" name="scf_options[scf_casing]" value="1" <?php if (isset($scf_options['scf_casing'])) { checked('1', $scf_options['scf_casing']); } ?> />
										<span class="mm-item-caption"><?php esc_html_e('The challenge response should be case-sensitive', 'scf'); ?></span></td>
									</tr>
                                    <tr>
										<th scope="row"><label class="description" for="scf_options[scf_blacklist]"><?php esc_html_e('Blacklisted Words', 'scf'); ?></label></th>
										<td><textarea class="large-text code" rows="3" cols="55" name="scf_options[scf_blacklist]"><?php echo esc_textarea($scf_options['scf_blacklist']); ?></textarea>
										<div class="mm-item-caption"><?php esc_html_e('If message contains a word/term on the list it will show the succesfully sent message but it will actually NOT be sent. Separate words or terms with a comma. Example: casino, some term, pills', 'scf'); ?></div></td>
									</tr>
									<!-- reCAPTCHA start -->
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_recaptcha]"><?php esc_html_e('Enable reCAPTCHA', 'scf'); ?></label></th>
										<td><input type="checkbox" name="scf_options[scf_recaptcha]" value="1" <?php if (isset($scf_options['scf_recaptcha'])) { checked('1', $scf_options['scf_recaptcha']); } ?> />
										<span class="mm-item-caption"><?php esc_html_e('Enable reCAPTCHA', 'scf'); ?></span></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_recaptcha_version]"><?php esc_html_e('reCAPTCHA Version', 'scf'); ?></label></th>
										<td>
											<select name="scf_options[scf_recaptcha_version]">
												<option value="v2" <?php selected( 'v2', sanitize_text_field( $scf_options['scf_recaptcha_version'] ), true ); ?>><?php esc_html_e('V2', 'scf'); ?></option>
												<option value="v3" <?php selected( 'v3', sanitize_text_field( $scf_options['scf_recaptcha_version'] ), true ); ?>><?php esc_html_e('V3', 'scf'); ?></option>
											</select>
										<div class="mm-item-caption"><?php esc_html_e('reCAPTCHA version', 'scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_recaptcha_site_key]"><?php esc_html_e('reCAPTCHA site key', 'scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="scf_options[scf_recaptcha_site_key]" value="<?php echo $scf_options['scf_recaptcha_site_key']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('reCAPTCHA site key', 'scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_recaptcha_secret_key]"><?php esc_html_e('reCAPTCHA secret key', 'scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="scf_options[scf_recaptcha_secret_key]" value="<?php echo $scf_options['scf_recaptcha_secret_key']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('reCAPTCHA secret key', 'scf'); ?></div></td>
									</tr>
									<!-- reCAPTCHA end -->
								</table>
							</div>

							<h3><?php esc_html_e('Field Labels &amp; Placeholders', 'scf'); ?></h3>
							<div class="mm-table-wrap">
								<table class="widefat mm-table">
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_nametext]"><?php esc_html_e('Name Label', 'scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="scf_options[scf_nametext]" value="<?php echo $scf_options['scf_nametext']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('Label for the Name field', 'scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_input_name]"><?php esc_html_e('Name Placeholder', 'scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="scf_options[scf_input_name]" value="<?php echo $scf_options['scf_input_name']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('Placeholder for the Name field', 'scf'); ?></div></td>
									</tr>

									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_mailtext]"><?php esc_html_e('Email Label', 'scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="scf_options[scf_mailtext]" value="<?php echo $scf_options['scf_mailtext']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('Label for the Email field', 'scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_input_email]"><?php esc_html_e('Email Placeholder', 'scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="scf_options[scf_input_email]" value="<?php echo $scf_options['scf_input_email']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('Placeholder for the Email field', 'scf'); ?></div></td>
									</tr>

                                    <tr>
										<th scope="row"><label class="description" for="scf_options[scf_confirm_mailtext]"><?php esc_html_e('Confirm Email Label', 'scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="scf_options[scf_confirm_mailtext]" value="<?php echo $scf_options['scf_confirm_mailtext']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('Label for the Confirm Email field. Leave empty to not display the field.', 'scf'); ?></div></td>
									</tr>
                                    <tr>
										<th scope="row"><label class="description" for="scf_options[scf_input_confirm_email]"><?php esc_html_e('Confirm Email Placeholder', 'scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="scf_options[scf_input_confirm_email]" value="<?php echo $scf_options['scf_input_confirm_email']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('Placeholder for the Confirm Email field. Leave empty to not display the field.', 'scf'); ?></div></td>
									</tr>

									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_subjtext]"><?php esc_html_e('Subject Label', 'scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="scf_options[scf_subjtext]" value="<?php echo $scf_options['scf_subjtext']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('Label for the Subject field', 'scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_input_subject]"><?php esc_html_e('Subject Placeholder', 'scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="scf_options[scf_input_subject]" value="<?php echo $scf_options['scf_input_subject']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('Placeholder for the Subject field', 'scf'); ?></div></td>
									</tr>

									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_messtext]"><?php esc_html_e('Message Label', 'scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="scf_options[scf_messtext]" value="<?php echo $scf_options['scf_messtext']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('Label for the Message field', 'scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_submittext]"><?php esc_html_e('Submit Label', 'scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="scf_options[scf_submittext]" value="<?php echo $scf_options['scf_submittext']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('Label for the submit button', 'scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_input_message]"><?php esc_html_e('Message Placeholder', 'scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="scf_options[scf_input_message]" value="<?php echo $scf_options['scf_input_message']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('Placeholder for the Message field', 'scf'); ?></div></td>
									</tr>

									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_input_captcha]"><?php esc_html_e('Captcha Placeholder', 'scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="scf_options[scf_input_captcha]" value="<?php echo $scf_options['scf_input_captcha']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('Placeholder for the Captcha field', 'scf'); ?></div></td>
									</tr>
								</table>
							</div>

							<h3><?php esc_html_e('Appearance', 'scf'); ?></h3>
							<div class="mm-table-wrap">
								<table class="widefat mm-table">
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_css]"><?php esc_html_e('Custom CSS', 'scf'); ?></label></th>
										<td>
											<textarea class="large-text code" rows="8" cols="50" name="scf_options[scf_css]"><?php echo esc_textarea($scf_options['scf_css']); ?></textarea>
											<div class="mm-item-caption">
												<?php esc_html_e('Optional CSS to style the contact form. Do not include any', 'scf'); ?> <code>&lt;style&gt;</code> <?php esc_html_e('tags.', 'scf'); ?>
											</div>
										</td>
									</tr>
								</table>
							</div>

							<h3><?php esc_html_e('Success &amp; Error Messages', 'scf'); ?></h3>
							<div class="mm-table-wrap">
								<table class="widefat mm-table">
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_success]"><?php esc_html_e('Success Message', 'scf'); ?></label></th>
										<td><textarea class="large-text code" rows="3" cols="55" name="scf_options[scf_success]"><?php echo esc_textarea($scf_options['scf_success']); ?></textarea>
										<div class="mm-item-caption"><?php esc_html_e('Message displayed when the form is submitted successfully', 'scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_error]"><?php esc_html_e('Error Message', 'scf'); ?></label></th>
										<td><textarea class="large-text code" rows="3" cols="55" name="scf_options[scf_error]"><?php echo esc_textarea($scf_options['scf_error']); ?></textarea>
										<div class="mm-item-caption"><?php esc_html_e('Message displayed when a required field is empty', 'scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_spam]"><?php esc_html_e('Incorrect Response', 'scf'); ?></label></th>
										<td><textarea class="large-text code" rows="3" cols="55" name="scf_options[scf_spam]"><?php echo esc_textarea($scf_options['scf_spam']); ?></textarea>
										<div class="mm-item-caption"><?php esc_html_e('Message displayed when the challenge question is answered incorrectly', 'scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_style]"><?php esc_html_e('Error Field Attributes', 'scf'); ?></label></th>
										<td><textarea class="large-text code" rows="3" cols="55" name="scf_options[scf_style]"><?php echo esc_textarea($scf_options['scf_style']); ?></textarea>
										<div class="mm-item-caption"><?php esc_html_e('Optional custom attributes for any field that returns an error', 'scf'); ?></div></td>
									</tr>
								</table>
							</div>

							<h3><?php esc_html_e('Custom Content', 'scf'); ?></h3>
							<div class="mm-table-wrap">
								<table class="widefat mm-table">
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_preform]"><?php esc_html_e('Before Form', 'scf'); ?></label></th>
										<td><textarea class="large-text code" rows="3" cols="55" name="scf_options[scf_preform]"><?php echo esc_textarea($scf_options['scf_preform']); ?></textarea>
										<div class="mm-item-caption"><?php esc_html_e('Optional markup to appear *before* the contact form', 'scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_appform]"><?php esc_html_e('After Form', 'scf'); ?></label></th>
										<td><textarea class="large-text code" rows="3" cols="55" name="scf_options[scf_appform]"><?php echo esc_textarea($scf_options['scf_appform']); ?></textarea>
										<div class="mm-item-caption"><?php esc_html_e('Optional markup to appear *after* the contact form', 'scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_prepend]"><?php esc_html_e('Before Results', 'scf'); ?></label></th>
										<td><textarea class="large-text code" rows="3" cols="55" name="scf_options[scf_prepend]"><?php echo esc_textarea($scf_options['scf_prepend']); ?></textarea>
										<div class="mm-item-caption"><?php esc_html_e('Optional markup to appear *before* the success message', 'scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="scf_options[scf_append]"><?php esc_html_e('After Results', 'scf'); ?></label></th>
										<td><textarea class="large-text code" rows="3" cols="55" name="scf_options[scf_append]"><?php echo esc_textarea($scf_options['scf_append']); ?></textarea>
										<div class="mm-item-caption"><?php esc_html_e('Optional markup to appear *after* the success message', 'scf'); ?></div></td>
									</tr>
                                    <tr>
										<th scope="row"><label class="description" for="scf_options[scf_before_button]"><?php esc_html_e('Before Submit Button', 'scf'); ?></label></th>
										<td><textarea class="large-text code" rows="3" cols="55" name="scf_options[scf_before_button]"><?php echo esc_textarea($scf_options['scf_before_button']); ?></textarea>
										<div class="mm-item-caption"><?php esc_html_e('Optional markup to appear *before* the submit button', 'scf'); ?></div></td>
									</tr>
								</table>
							</div>

							<input type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'scf'); ?>" />
						</div>
					</div>

					<div id="mm-restore-settings" class="postbox">
						<h2><?php esc_html_e('Restore Defaults', 'scf'); ?></h2>
						<div class="toggle<?php if (!isset($_GET["settings-updated"])) { echo ' default-hidden'; } ?>">
							<p>
								<input name="scf_options[default_options]" type="checkbox" value="1" id="mm_restore_defaults" <?php if (isset($scf_options['default_options'])) { checked('1', $scf_options['default_options']); } ?> />
								<label class="description" for="scf_options[default_options]"><?php esc_html_e('Restore default options upon plugin deactivation/reactivation.', 'scf'); ?></label>
							</p>
							<p>
								<small>
									<strong><?php esc_html_e('Tip:', 'scf'); ?></strong>
									<?php esc_html_e('leave this option unchecked to remember your settings.', 'scf'); ?>
									<?php esc_html_e('Or, to go ahead and restore all default options, check the box, save your settings, and then deactivate/reactivate the plugin.', 'scf'); ?>
								</small>
							</p>
							<input type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'scf'); ?>" />
						</div>
					</div>

					<div id="mm-panel-secondary" class="postbox">
						<h2><?php esc_html_e('Shortcode &amp; Template Tag', 'scf'); ?></h2>
						<div class="toggle default-hidden">

							<h3><?php esc_html_e('Shortcode', 'scf'); ?></h3>
							<p><?php esc_html_e('Use this shortcode to display the contact form on any WP Post or Page:', 'scf'); ?></p>
							<p><code class="mm-code">[simple_contact_form]</code></p>

							<h3><?php esc_html_e('Template tag', 'scf'); ?></h3>
							<p><?php esc_html_e('Use this template tag to display the form anywhere in your theme template:', 'scf'); ?></p>
							<p><code class="mm-code">&lt;?php if (function_exists('simple_contact_form')) simple_contact_form(); ?&gt;</code></p>

						</div>
					</div>

					<?php /*
					<div id="mm-panel-current" class="postbox">
						<h2><?php esc_html_e('Show Support', 'scf'); ?></h2>
						<div class="toggle">
							<?php require_once('support-panel.php'); ?>
						</div>
					</div> */ ?>

				</div>
			</div>

			<div id="mm-credit-info">
				<a target="_blank" href="<?php echo $scf_homeurl; ?>" title="<?php esc_attr_e('Plugin Homepage', 'scf'); ?>"><?php echo $scf_plugin; ?></a> <?php esc_html_e('by', 'scf'); ?>
				<a target="_blank" href="https://twitter.com/wpkube" title="<?php esc_attr_e('WPKube on Twitter', 'scf'); ?>">WPKube</a> @
				<a target="_blank" href="https://www.wpkube.com/" title="<?php esc_attr_e('WPKube', 'scf'); ?>">WPKube</a>
			</div>

		</form>
	</div>

	<script type="text/javascript">
		jQuery(document).ready(function(){
			// toggle panels
			jQuery('.default-hidden').hide();
			jQuery('#mm-panel-toggle a').click(function(){
				jQuery('.toggle').slideToggle(300);
				return false;
			});
			jQuery('h2').click(function(){
				jQuery(this).next().slideToggle(300);
			});
			jQuery('#mm-panel-primary-link').click(function(){
				jQuery('.toggle').hide();
				jQuery('#mm-panel-primary .toggle').slideToggle(300);
				return true;
			});
			jQuery('#mm-panel-secondary-link').click(function(){
				jQuery('.toggle').hide();
				jQuery('#mm-panel-secondary .toggle').slideToggle(300);
				return true;
			});
			jQuery('#mm-restore-settings-link').click(function(){
				jQuery('.toggle').hide();
				jQuery('#mm-restore-settings .toggle').slideToggle(300);
				return true;
			});
			// prevent accidents
			if(!jQuery("#mm_restore_defaults").is(":checked")){
				jQuery('#mm_restore_defaults').click(function(event){
					var r = confirm("<?php esc_html_e('Are you sure you want to restore all default options? (this action cannot be undone)', 'scf'); ?>");
					if (r == true){
						jQuery("#mm_restore_defaults").attr('checked', true);
					} else {
						jQuery("#mm_restore_defaults").attr('checked', false);
					}
				});
			}
		});
	</script>

<?php }

function scf_confirm_checkbox() {

	global $scf_options;

	if ( ! isset ( $scf_options['scf_gdpr_message'] ) ) {
		$scf_options['scf_gdpr_message'] = __('I consent to having this website store my submitted information so they can respond to my inquiry. See our privacy policy to learn more how we use data.', 'scf');
	}

	if ( empty( $scf_options['scf_gdpr_message'] ) ) {
		return '';
	}

	ob_start();
	?>
	<div class="scf-confirm-checkbox">
		<label><input type="checkbox" required> <?php echo $scf_options['scf_gdpr_message']; ?></label>
	</div><!-- .scf-confirm-checkbox -->
	<?php
	$output = ob_get_contents();
	ob_end_clean();

	return $output;

} add_action( 'scf_before_form_close', 'scf_confirm_checkbox' );

function scf_get_field_value( $name ) {

	$message = isset($_POST[$name]) ? stripslashes(trim($_POST[$name])) : '';
	return $message;

}
