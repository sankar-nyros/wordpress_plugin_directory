<?php

include '../../../wp-config.php';

global $wpdb;

$id =  $_POST['id'];
$tabname = $wpdb->prefix . "directory";

$sql = "Delete from $tabname where id = $id";
$wpdb->query($sql);

echo "1";
exit;
?>
