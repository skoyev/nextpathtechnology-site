<?php
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
$con = mysql_connect($_SESSION['DB_HOST'], $_SESSION['DB_USER'], $_SESSION['DB_PASSWORD']);
mysql_select_db($_SESSION['DB_NAME'],$con);
//initialize variables
$error = 0;
global $wpdb;
$email_regex = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$";
$table_name = $_SESSION['wp_pref']."mn_form_fields";
$table_name1 = $_SESSION['wp_pref']."mn_form_data";
// process form data
$mn_contact_name = trim($_POST['user_name']);
$mn_contact_email = trim($_POST['user_email']);
$mn_contact_message = trim($_POST['user_message']);
	
//setting values
$mn_contact_to = $_POST['admin_email'];

$emailtable = '<table width="100%">';
$insqry = "INSERT INTO $table_name1 SET ";
$query = mysql_query( "SELECT * FROM $table_name WHERE isvisible = '1' ORDER BY sort_order ASC");
while($result = mysql_fetch_array($query)){
	$emailtable.='<tr><th align="left">'.$result['fieldlabel'].'</th><td>'.$_POST[$result['fieldname']].'</td></tr>';
	$insqry.="`".$result['fieldname']."` = '".$_POST[$result['fieldname']]."', ";
	if($result['ismandatory'] == 'true'){
		if(empty($_POST[$result['fieldname']])){
			$msg = $result['error_message'];
			$error++;
			break;
		}
	}
}
$emailtable.='</table>';

$is_sent = false;
if(!$error) {
	if($_POST['mn_captcha'] == '1'){
		if($_POST['mn_answer'] != $_SESSION['ans'] ){
			$msg = 'Invalid Captcha Value';
			$error++;
		}
	}
	if(!$error) {
		$headers  = "From: ".$_POST['user_name']." <".strip_tags($_POST['user_email'])."> \r\n";
		$headers .= "Reply-To: ".$_POST['user_name']." <".strip_tags($_POST['user_email']).">\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$subject = (isset($_POST['user_subject']) && $_POST['user_subject'] != '')? $_POST['user_subject'] : 'Contact me Back';
		$message  = 'Hi, ';
		$message.= 'I am '.$_POST['user_name'].'<br/>';
		$message.= $_POST['user_message'];
		$message.= '<p>Complete Form Information</p>';
		$message.= '<div>'.$emailtable.'</div>';
	
		$is_sent = mail($mn_contact_to, $subject, $message, $headers);
		if($_POST['mn_confirmation_mail'] == '1'){
			$headers  = "From: ".urldecode($_POST['blog_name'])." <".strip_tags($mn_contact_to)."> \r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			$message = 'Hello, '.$_POST['user_name'].'<br/><br/>';
			$message.= urldecode($_POST['mn_conf_mail_msg']);
			$reply_sub = (isset($_POST['user_subject']) && $_POST['user_subject'] != '')? 'Reply: '.$_POST['user_subject'] : urldecode($_POST['mn_conf_mail_sub']);
			mail($mn_contact_email, $reply_sub, $message, $headers);
		}
		if($is_sent) {
			$msg = 'Mail sent successfully.';
		}
		if($_POST['mn_save_data'] == 1){
			$date = date("Y-m-d H:i:s");
			$ip = $_SERVER['REMOTE_ADDR'];
			$uagent = $_SERVER['HTTP_USER_AGENT'];
			$uport = $_SERVER['REMOTE_PORT'];
			$table_name = $_SESSION['wp_pref'].'mn_form_data';
			$insqry.= "`user_ip` = '$ip', `user_port` = '$uport', `user_browser` = '$uagent', `sub_date` = '$date'";
			mysql_query($insqry);
		}
	}
}


$a = rand(1,9);
$b = rand(1,9);
$_SESSION['ans'] = $a + $b;
$result = array("msg" => $msg, "error" => $error, "mn_a" => $a, "mn_b" => $b);

echo json_encode($result);
?>