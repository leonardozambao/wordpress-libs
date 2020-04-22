<?php session_start();		
require( '../../../../../wp-load.php' );
if(isset($_POST['nome'])){
    if(isset($_POST['g-recaptcha-response-field']) && !empty($_POST['g-recaptcha-response-field'])) {
        //your site secret key
        $secret = '6LeLOIwUAAAAAEE9ce7CROJUHt2Q81byNAp32IFG';
        //get verify response data
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response-field']);
        $responseData = json_decode($verifyResponse);
        if ($responseData->success) {
            $value = "";

            $nome = $_POST['nome'];
            $assunto = $_POST['assunto'];
            $email = $_POST['email'];
            $telefone = $_POST['telefone'];
            $mensagem = $_POST['mensagem'];

            @$header .= "Content-type: text/html; charset=iso-8859-1\r\n";
            @$header .= "From: " . $assunto . "\r\n";

            $mail = new PHPMailer();
            $mail->IsHTML(true);
            $mail->SetLanguage("en", TEMPLATEPATH . "/lib/phpmailer/language/");
            $mail->SetLanguage("en");
            $mail->CharSet = "UTF-8";

            if (get_option('envio_email_atutenticado') == "sim") {
                $mail->IsSMTP();
                $mail->Host = get_option('servidor_smtp');
                if (get_option('porta_smtp') != "") {
                    $mail->Port = get_option('porta_smtp');
                }
                $mail->SMTPAuth = true;
                $mail->Username = get_option('usuario_smtp');
                $mail->Password = get_option('senha_smtp');

            } else {
                $mail->IsMail(true);
            }
            $receptor = $_POST['email_destinatario'];

            if (get_option('secure_smtp') != '') {
                $mail->SMTPSecure = get_option('secure_smtp');
            }

            $mail->From = get_option('email_envio_smtp');

            $mail->FromName = "$nome";
            $mail->AddReplyTo("$email", "$nome");
            $mail->AddAddress("$receptor", "$nome");

            $mail->WordWrap = 50;
            $mail->Subject = $assunto;
            $mail->Body = "<b>Nome:</b><br/>
					$nome<br/><br/>
					
					<b>E-mail:</b><br/>
					$email<br/><br/>
					
					<b>Telefone:</b><br/>
					$telefone<br/><br/>
					 
					<b>Mensagem:</b><br/>
					$mensagem<br/>";


            if (!$mail->Send() && !Util::CadastroFormulario(array('nome' => $nome, 'email' => $email, 'assunto' => $assunto, 'telefone' => $telefone, 'mensagem' => $mensagem), 'fale-conosco')) {
                $value = array('sucesso' => false, 'msg' => get_option('msg_erro_fale_conosco') . ' ' . $mail->ErrorInfo, 'erro' => $mail->ErrorInfo);
            } else {
                $value = array('msg' => get_option('msg_envio_fale_conosco'), 'sucesso' => 'true');
            }
        }
    }
}

else{
	$value = array('msg' => get_option('msg_preencimento_fale_conosco'));
}
$output = json_encode($value);
echo $output;
?>