<?php

include '../../../wp-config.php';
global $wpdb;

$name =  $_POST['name'];
$contact =  $_POST['contact'];
$id =  $_POST['id'];
$uid =  get_current_user_id();
$tabname = $wpdb->prefix . "directory";

if (current_user_can( 'manage_options' ))
{
	$sql = "select * from $tabname where name = '$name' and id != $id";
}
else
{
	$sql = "select * from $tabname where name = '$name' and user_id = $uid and id != $id";
}
$wpdb->get_results($sql);


if($wpdb->num_rows > 0)
{
	echo(json_encode(array('success' => false,'Message' => 'Name already exist.'))); 
	exit;
}
else
{
	$wpdb->query("UPDATE $tabname SET name = '$name', contact = '$contact' WHERE id = $id");	
	echo(json_encode(array('success' => true,'Message' => 'Contact Updated'))); 
	exit;
}

?>
