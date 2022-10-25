<?php
function is_session_started(){
    if ( php_sapi_name() !== 'cli' ) {
        if ( version_compare(phpversion(), '5.4.0', '>=') ) {
            return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
        } else {
            return session_id() === '' ? FALSE : TRUE;
        }
    }
    return FALSE;
}
if ( is_session_started() === FALSE ) session_start();

$con = mysql_connect($_SESSION['DB_HOST'], $_SESSION['DB_USER'], $_SESSION['DB_PASSWORD']);
mysql_select_db($_SESSION['DB_NAME'],$con);
$error = 0;
if(isset($_POST['mn_action'])){
	if($_POST['mn_action'] == 'delete_frm_data'){
		$table_name = $_SESSION['wp_pref'].'mn_form_data';
		$id = $_POST['row_id'];
		
		if(mysql_query("DELETE FROM $table_name WHERE id='$id'")){
			$result = array("error" => $error);
			echo json_encode($result);
		}
		else{
			$error++;
			$result = array("error" => $error);
			echo json_encode($result);
		}
	}elseif($_POST['mn_action'] == 'sort_field'){
		$table_name = $_SESSION['wp_pref'].'mn_form_fields';
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {
			//echo "UPDATE $table_name SET sort_order = '$i' WHERE `id` ='".$menu[$i]."'";
			mysql_query("UPDATE $table_name SET sort_order = '$i' WHERE `id` ='".$menu[$i]."'");
		}
	}elseif($_POST['mn_action'] == 'save_formfield'){
		
	}
}