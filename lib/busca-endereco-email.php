<?php 
require( '../../../../wp-load.php' );
$assunto = $_POST['assuntoId'];
$email = get_post_meta($assunto, 'email_dest', true );
	if ($email != ''){
		echo $email;
	}else{
		echo get_option('email_receptor_fale_conosco');
	}
?>