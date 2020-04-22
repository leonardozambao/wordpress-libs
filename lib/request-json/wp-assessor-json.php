<?php session_start();
$pasta = "../../../../uploads/anexos_formulario/"; 
$permitidos = array(".pdf",".doc",".docx"); 			
require( '../../../../../wp-load.php' );
if(isset($_POST['nome'])){
	$value = "";
	$anexado = true;
		if(!empty($_POST['nome']) && !empty($_POST['email']) && !empty($_POST['data']) && !empty($_POST['cpf']) && !empty($_POST['experienciaMF']) && !empty($_POST['cod_estados']) && !empty($_POST['cod_cidades']) && !empty($_POST['telefone']) && !empty($_POST['indicacao']) && !empty($_POST['interesse_atuacao'])){
			if ($_POST['cod_cidades'] != 'estado' && $_POST['cod_cidades'] != 'aguarde' && $_POST['cod_cidades'] != 'selecione'){
				if(Util::ValidaEmail($_POST['email'])){
					if(Util::ValidaCPF($_POST['cpf'])){
					//if (isset($_SESSION['simpleCaptchaAnswer']) && $_POST['captchaSelection'] == $_SESSION['simpleCaptchaAnswer']){

						$nome = $_POST['nome'];
						$assunto = (!empty($_POST['assunto']))? $_POST['assunto'] : get_option('assunto_assessor');
						$email = $_POST['email'];
						$telefone = $_POST['telefone'];
						$experienciaMF = $_POST['experienciaMF'];
						$vinculo_instituicao = $_POST['vinculo_instituicao'];
						$estadoE = $_POST['cod_estados'];
						$cidades = $_POST['cod_cidades'];
						$indicacao = $_POST['indicacao'];
						$quem_indicou = $_POST['indicacao_quem'];
						$outra_indicacao = $_POST['indicacao_qual'];
						$interesse_atuacao = $_POST['interesse_atuacao'];
						$agenteAutonomo = $_POST['agenteAutonomo'];
						$gestorCarteiras = $_POST['gestorCarteiras'];
						$cpa_10 = $_POST['cpa-10'];
						$cpa_20 = $_POST['cpa-20'];
						$cea = $_POST['cea'];
						$cfp = $_POST['cfp'];
						$cfa = $_POST['cfa'];

						if ($interesse_atuacao == 'interesse_atuacao_proprio'){
							$interesse_atuacao = 'Escritório próprio';
						};
						if ($interesse_atuacao == 'interesse_atuacao_parte'){
							$interesse_atuacao = 'Fazer parte de um escritório';
						};
						if ($experienciaMF == 'nao'){
							$experienciaMF = 'Não';
						};
						if ($experienciaMF == 'sim_sem_certificado'){
							$experienciaMF = 'Sim, mas não sou certificado pela Ancordão';
						};
						if ($experienciaMF == 'sim_com_certificado'){
							$experienciaMF = 'Sim. Também sou certificado pela Ancord';
						};
						if ($vinculo_instituicao == 'nao_checkbox'){
							$vinculo_instituicao = 'Não';
						};
						if ($vinculo_instituicao == 'sim_checkbox'){
							$vinculo_instituicao = 'Sim';
							$qual_vinculo = $_POST['instvinc'];
						};
						if ($agenteAutonomo == 'agenteAutonomo_checkbox'){
							$agenteAutonomo = 'S';
						}else{
							$agenteAutonomo = 'N';						
						};
						if ($gestorCarteiras == 'gestorCarteiras_checkbox'){
							$gestorCarteiras = 'S';
						}else{
							$gestorCarteiras = 'N';						
						};
						if ($cpa_10 == 'cpa-10_checkbox'){
							$cpa_10 = 'S';
						}else{
							$cpa_10 = 'N';						
						};
						if ($cpa_20 == 'cpa-20_checkbox'){
							$cpa_20 = 'S';
						}else{
							$cpa_20 = 'N';						
						};
						if ($cea == 'cea_checkbox'){
							$cea = 'S';
						}else{
							$cea = 'N';						
						};
						if ($cfp == 'cfp_checkbox'){
							$cfp = 'S';
						}else{
							$cfp = 'N';						
						};
						if ($cfa == 'cfa_checkbox'){
							$cfa = 'S';
						}else{
							$cfa = 'N';						
						};

						global $wpdb;
						$estadoB = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."estado WHERE id = ".$estadoE );
						$estado = $estadoB->uf;


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

						//$mail->From = get_option('email_receptor_assessor');

						if(get_option('secure_smtp') != ''){
							$mail->SMTPSecure = get_option('secure_smtp');
						}

						$mail->From = get_option('email_envio_smtp');

						$mail->FromName = "$nome";
						$mail->AddReplyTo("$email","$nome");
						$mail->AddAddress(get_option('email_receptor_assessor'),"$nome");


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

										<b>Estado</b><br/>
										$estado<br/><br/>

										<b>Cidade</b><br/>
										$cidades<br/><br/>

										<b>Telefone:</b><br/>
										$telefone<br/><br/>

										<b>Possui Experiencia no mercado financeiro</b><br/>
										$experienciaMF<br/><br/>

										<b>Tem vinculo com outra instituição:</b><br/>
										$vinculo_instituicao<br/>
										<b>Qual:</b>$qual_vinculo<br/><br/>

										<b>Certificações:</b><br />
										<p>Agente Autônomo de Investimentos - Ancord: $agenteAutonomo</p>
										<p>Gestor de Carteiras - CVM: $gestorCarteiras</p>
										<p>CPA-10 - Anbima: $cpa_10</p>
										<p>CPA-20 - Anbima: $cpa_20</p>
										<p>CEA: $cea</p>
										<p>CFP: $cfp</p>
										<p>CFA: $cfa</p><br />

										<b>Como Conheceu a Guide:</b><br/>
										$indicacao<br/>
										<b>Qual indicação:</b>$outra_indicacao<br/><br/>
										<b>Quem indicou:</b>$quem_indicou<br/>

										";
						if($anexado){
							if(!$mail->Send()){
								$value = array('sucesso' => false,'msg' => get_option('msg_erro_assessor').' '.$mail->ErrorInfo, 'erro' => $mail->ErrorInfo);
								@unlink($pasta.$nome_atual);
							}else{
								$value = array('msg' => get_option('msg_envio_assessor'), 'sucesso' => 'true');
							}
						}else{
							$value = array('sucesso' => false,'msg' => "Não foi possivel enviar o e-mail com anexo");
						}

						Util::CadastroFormulario(array('nome' => $nome, 'email' => $email, 'assunto' => $assunto, 'estado' => $estado, 'cidade' => $cidades, 'telefone' => $telefone, 'experienciaMF' => $experienciaMF, 'vinculo_instituicao' => $vinculo_instituicao, 'qual_vinculo' => $qual_vinculo, 'indicacao' => $indicacao, 'quem_indicou' => $quem_indicou, 'outra_indicacao' => $outra_indicacao, 'interesse_atuacao' => $interesse_atuacao, 'agenteAutonomo' => $agenteAutonomo, 'gestorCarteiras' => $gestorCarteiras, 'cpa_10' => $cpa_10, 'cea' => $cea, 'cfp' => $cfp, 'cfa' => $cfa),'assessor');
					/*} else {
						$value = array('msg' => "Selecione a imagem d".$_POST['imagem_selecionar']);
					}*/
					}else{
						$value = array('msg' => "Dígite um CPF válido");
					}
				}else{
					$value = array('msg' => "Dígite um e-mail válido");
				}
			}else{
				$value = array('msg' => "Selecione uma cidade");
			}
		}else{
			$value = array('msg' => get_option('msg_preencimento_assessor'));
		}
		
}else{
	$value = array('msg' => get_option('msg_preencimento_assessor'));
}
	$output = json_encode($value);
	echo $output;
?>