<?php
    $origem = $_POST['origem'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $jaENossoCliente = $_POST['jaENossoCliente'];
    $ddd = $_POST['ddd'];
    $telefone = $_POST['telefone'];
    $assunto = $_POST['assunto'];
    $mensagem = $_POST['mensagem'];
    $recebeInformacoes = $_POST['recebeInformacoes'];
	
	if($_SERVER['SERVER_NAME'] == 'tecnologia2.chleba.net' || $_SERVER['SERVER_NAME'] == 'tecnologia.chleba.net'){
		$url = 'https://indusval-homol.plusoftomni.com.br/api/cst-contact-mail/generate';
	}else{
		$url = 'https://bancoindusval.plusoftomni.com.br/api/cst-contact-mail/generate';
	}
	
	$ch = curl_init($url);
	$jsonData = array(
		'origem' => $origem,
		'nome' => $nome,
		'email' => $email,
		'jaENossoCliente' => $jaENossoCliente,
		'ddd' => $ddd,
		'telefone' => $telefone,
		'assunto' => $assunto,
		'mensagem' => $mensagem,
		'recebeInformacoes' => $recebeInformacoes
	);
	$content = json_encode($jsonData);

	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER,
			array("Content-type: application/json"));
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

	$json_response = curl_exec($curl);



	curl_close($curl);
	echo $json_response;

?>  