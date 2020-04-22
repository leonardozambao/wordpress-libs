<?php session_start();			
require( '../../../../../wp-load.php' );
if(isset($_POST['nome'])){
	$value = "";
	$anexado = true;
		if(!empty($_POST['nome']) && !empty($_POST['email']) && !empty($_POST['assunto']) && !empty($_POST['telefone']) && !empty($_POST['mensagem'])){
			if(Util::ValidaEmail($_POST['email'])){

					$nome = $_POST['nome'];
					$assunto = (!empty($_POST['assunto']))? $_POST['assunto'] : get_option('assunto_fale_conosco');
					$email = $_POST['email'];
					$como_conheceu = $_POST['como_conheceu'];
					$telefone = $_POST['telefone'];
					$mensagem = $_POST['mensagem'];
					
					$value = array('msg' => get_option('msg_envio_fale_conosco'), 'sucesso' => 'true');
			}else{
				$value = array('msg' => "Dígite um e-mail válido");
			}
		}else{
			$value = array('msg' => get_option('msg_preencimento_fale_conosco'));
		}
		
}else{
	$value = array('msg' => get_option('msg_preencimento_fale_conosco'));
}
	$output = json_encode($value);
	echo $output;
?>