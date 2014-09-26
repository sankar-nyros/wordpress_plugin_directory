<?php

include '../../../wp-config.php';
global $wpdb;

$name =  $_POST['name'];
$contact =  $_POST['contact'];
$id =  get_current_user_id();
$tabname = $wpdb->prefix . "directory";

if (current_user_can( 'manage_options' ))
{
	$sql = "select * from $tabname where name = '$name'";
}
else
{
	$sql = "select * from $tabname where name = '$name' and user_id = $id";
}

$wpdb->get_results($sql);


if($wpdb->num_rows > 0)
{
	echo(json_encode(array('success' => false,'Message' => 'Name already exist.','count'=>$wpdb->num_rows))); 
	exit;
}
else
{
	$wpdb->insert($tabname, array('name' => $name,'contact' =>$contact,'user_id' => $id));
	echo(json_encode(array('success' => true,'Message' => 'Contact saved successfully.')));
	exit;
}
?>
