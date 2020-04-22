<?php session_start();		
require( '../../../../../wp-load.php' );
$value = "";
if(!empty($_POST['email'])){
	if(Util::ValidaEmail($_POST['email'])){
			$nome = '';
			$email = $_POST['email'];
			if(Util::CadastroFormulario(array('nome' => $nome, 'email' => $email,),'newsletter')){
				$value = array('msg' => get_option('msg_cadastro_newsletter'));
			}else{
				$value = array('msg' => get_option('msg_erro_newsletter'));
			}
	}else{
		$value = array('msg' => "Dígite um e-mail válido");
	}
}else{
	$value = array('msg' => get_option('msg_preencimento_newsletter'));
}
$output = json_encode($value);
echo $output;
?>