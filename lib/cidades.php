<?php
//require_once( ABSPATH . 'wp-load.php' );
$id = $_POST['id'];

require_once('../../../../wp-config.php');
global $wpdb;
$listaCidades = $wpdb->get_results("select * from ".$wpdb->prefix."cidade WHERE estado = ".$id);
foreach($listaCidades as $cidades){
	echo ('<option value="'.$cidades->nome.'">'.$cidades->nome.'</option>');
}