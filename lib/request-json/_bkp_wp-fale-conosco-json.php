<?php session_start();
$pasta = "../../../../uploads/anexos_formulario/"; 
$permitidos = array(".pdf",".doc",".docx"); 			
require( '../../../../../wp-load.php' );
if(isset($_POST['nome'])){
	$value = "";
	$anexado = true;
		if(!empty($_POST['nome']) && !empty($_POST['email']) && !empty($_POST['assunto']) && !empty($_POST['mensagem'])){
			if(Util::ValidaEmail($_POST['email'])){
				//if (isset($_SESSION['simpleCaptchaAnswer']) && $_POST['captchaSelection'] == $_SESSION['simpleCaptchaAnswer']){
					
					$nome = $_POST['nome'];
					$assunto = (!empty($_POST['assunto']))? $_POST['assunto'] : get_option('assunto_fale_conosco');
					$email = $_POST['email'];
					$como_conheceu = $_POST['como_conheceu'];
					$telefone = $_POST['telefone'];
					$mensagem = $_POST['mensagem'];
								
					@$header .= "Content-type: text/html; charset=iso-8859-1\r\n";
					@$header .= "From: ".$assunto."\r\n";
													
					$mail = new PHPMailer();
					$mail->IsHTML(true);
					$mail->SetLanguage("en", TEMPLATEPATH."/lib/phpmailer/language/");
					$mail->SetLanguage("en");
					$mail->CharSet  = "UTF-8";
					
					if(get_option('envio_email_atutenticado') == "sim"){
						$mail->IsSMTP(); 
						$mail->Host = get_option('servidor_smtp');
						if(get_option('porta_smtp') != ""){
							$mail->Port = get_option('porta_smtp');
						}
						$mail->SMTPAuth = true; 
						$mail->Username = get_option('usuario_smtp'); 
						$mail->Password = get_option('senha_smtp');
					
					}else{
						$mail->IsMail(true);
					}
					
					$mail->From = $_POST['email_destinatario'];
					$mail->FromName = "$nome";
					$mail->AddReplyTo("$email","$nome");
					$mail->AddAddress(get_option('email_receptor_fale_conosco'),"$nome");
					
					
					$anexado = true;
					$nome_anexo = "";
					if(isset($_FILES['anexo']['name'])){
						$nome_anexo = @$_FILES['anexo']['name']; 
						$tamanho_anexo = @$_FILES['anexo']['size']; 
						$ext = strtolower(strrchr($nome_anexo,".")); 
						if(in_array($ext,$permitidos)){ 
							/* converte o tamanho para KB */ 
							$tamanho = round($tamanho_anexo / 1024); 
							if($tamanho < 1024){ 
								$nome_atual = md5(uniqid(time())).$ext; 
								$tmp = $_FILES['anexo']['tmp_name']; 
								if(move_uploaded_file($tmp,$pasta.$nome_atual)){ 
										$mail->AddAttachment($pasta.$nome_atual);
										$nome_anexo = get_bloginfo('url').'/wp-content/uploads/anexos_formulario/'.$nome_atual;
								}else{
									$value = array('msg' => "Falha ao enviar"); 
									$anexado = false;
								} 
							}else{ 
								$value = array('msg' =>"A anexo deve ser de no máximo 1MB"); 
								$anexado = false;
							} 
						}else{ 
							$value = array('msg' =>"Somente são aceitos arquivos PDF e DOC"); 
							$anexado = false;
						}
					}
					
					$mail->WordWrap = 50; 
					$mail->Subject = $assunto;
					$mail->Body = "<b>Nome:</b><br/>
									$nome<br/><br/>
									
									<b>E-mail:</b><br/>
									$email<br/><br/>
									
									<b>Como conheceu a Guide?</b><br/>
									$como_conheceu<br/><br/>
									
									<b>Telefone:</b><br/>
									$telefone<br/><br/>
									
									<b>Mensagem:</b><br/>
									$mensagem<br/>";
					if($anexado){
						if(!$mail->Send()){
							$value = array('sucesso' => false,'msg' => get_option('msg_erro_fale_conosco').' '.$mail->ErrorInfo, 'erro' => $mail->ErrorInfo);
							@unlink($pasta.$nome_atual);
						}else{
							$value = array('msg' => get_option('msg_envio_fale_conosco'), 'sucesso' => 'true');
						}
					}else{
						$value = array('sucesso' => false,'msg' => "Não foi possivel enviar o e-mail com anexo");
					}
					Util::CadastroFormulario(array('nome' => $nome, 'email' => $email, 'assunto' => $assunto, 'como_conheceu' => $como_conheceu, 'telefone' => $telefone, 'mensagem' => $mensagem),'fale-conosco');
				/*} else {
					$value = array('msg' => "Selecione a imagem d".$_POST['imagem_selecionar']);
				}*/
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