<?php 

	include_once('../../../../wp-config.php');
	include_once('../../../../wp-load.php');
	include_once('../../../../wp-includes/wp-db.php');
global $wpdb;

$table_name=$wpdb->prefix."cmm_subscriber";



if($_POST['cmmemail'])
{
	$wpuser_result = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE cmm_email='".$_POST['cmmemail']."'");
	
	foreach ( $wpuser_result as $userdetails ) {
	$cmm_email       = $userdetails->cmm_email;
	}
	if($cmm_email!="")
	{
		echo $msg = "Aleardy";
	}
	else
	{   $wpdb->insert( $table_name, array( 'cmm_email' => $_POST['cmmemail'], 'cmm_date' => date('Y:m:d H:i:s')) );
		echo $msg = "Success";
	}
}

					
?>