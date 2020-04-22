<?php
class Util{
	
	public function __construct(){
		global $wpdb;
		$wpdb->query("CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."formularios(
						ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
						dados TEXT NOT NULL,
						tipo_formulario VARCHAR(200)
					);");
		
	}
	
	public static function CadastroFormulario($dados,$formulario){
		global $wpdb;
		$query = $wpdb->query("INSERT INTO ".$wpdb->prefix."formularios(dados ,tipo_formulario) VALUES ('".serialize($dados)."','".$formulario."');");
		return $query;
	}
	
	public static function TempoPublicacao($dataPublicacao){
		date_default_timezone_set('America/Sao_Paulo');
		$dataAtual = date("YmdHis");
		$dataPublicacao;
		$tempo = strtotime($dataAtual) - strtotime($dataPublicacao);
		if($tempo > 60){
			if($tempo > 86400){
				$dias = round(($tempo / 60) / 60 / 24);
				if($dias > 1){
					$retorno = $dias." dias atrás";
				}else{
					$retorno = $dias." dia atrás";
				}
			}else
			if($tempo > 3600){
				$horas = round(($tempo / 60) / 60);
				if($horas > 1){
					$retorno = $horas." horas atrás";
				}else{
					$retorno = $horas." hora atrás";
				}
			}else{
				$minutos = round(($tempo / 60));
				if($minutos > 1){
					$retorno = $minutos." minutos atrás";
				}else{
					$retorno = $minutos." minuto atrás";
				}
			}
		}else{
			$retorno = "Menos de 1 minuto atrás";
		}
		return $retorno;
	}
	public static function ValidaEmail($email) {
		return filter_var($email, FILTER_VALIDATE_EMAIL);
		/*try{
			$regex = '/([a-z0-9_.-]+)'. '@'. '([a-z0-9.-]+){2,255}'. '.'. '([a-z]+){2,10}/i';
			if($email == '') {
				return false;
			}else {
				$eregi = preg_replace($regex, '', $email);
			}
			return empty($eregi) ? true : false;
		}catch(Exception $ex){
			throw $ex;
		}*/
	}
	public static function ValidaCPF($cpf = null) {
		// Verifica se um número foi informado
		if(empty($cpf)) {
			return false;
		}
		// Elimina possivel mascara
		$cpf = ereg_replace('[^0-9]', '', $cpf);
		$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
		// Verifica se o numero de digitos informados é igual a 11 
		if (strlen($cpf) != 11) {
			return false;
		}
		// Verifica se nenhuma das sequências invalidas abaixo 
		// foi digitada. Caso afirmativo, retorna falso
		else if ($cpf == '00000000000' || 
			$cpf == '11111111111' || 
			$cpf == '22222222222' || 
			$cpf == '33333333333' || 
			$cpf == '44444444444' || 
			$cpf == '55555555555' || 
			$cpf == '66666666666' || 
			$cpf == '77777777777' || 
			$cpf == '88888888888' || 
			$cpf == '99999999999') {
			return false;
		 // Calcula os digitos verificadores para verificar se o
		 // CPF é válido
		 } else {   
			for ($t = 9; $t < 11; $t++) {
				 
				for ($d = 0, $c = 0; $c < $t; $c++) {
					$d += $cpf{$c} * (($t + 1) - $c);
				}
				$d = ((10 * $d) % 11) % 10;
				if ($cpf{$c} != $d) {
					return false;
				}
			}
			return true;
		}
	}
	public static function EnviaEmail($email,$assunto,$mensagem,$nomeFrom,$nomeTo){
		@$header .= "Content-type: text/html; charset=iso-8859-1\r\n";
		@$header .= "From: ".$assunto."\r\n";
		$mail = new PHPMailer();
		$mail->IsHTML(true);
		$mail->SetLanguage("en", get_template_directory()."/includes/phpmailer/language/");
		
		$mail->CharSet  = "UTF-8";
		if(get_option('fd_userAutenticSMTP') == "true"){
			$mail->IsSMTP(); 
			$mail->SMTPAuth = true; 
			$mail->Host = get_option('fd_servidorSMTP');
			if(get_option('fd_userPortaSMTP') == "true"){
				$mail->Port = get_option('fd_portaSMTP');
			}
			$mail->Username = get_option('fd_usuarioSMTP'); 
			$mail->Password = get_option('fd_senhaSMTP');
					
			if(get_option('fd_userTlsSMTP') == "true"){
				$mail->SMTPSecure = 'tls';
			}
		
		}else{
			$mail->IsMail(true);
		}
			
		if(get_option('fd_userDebugSMTP') == "true"){
			$mail->SMTPDebug = 1;
		}
		
		$mail->From = get_option('fd_emailFormContato');
		$mail->FromName = $nomeFrom;
		$mail->AddReplyTo(get_option('fd_emailFormContato'),$nomeFrom);
		$mail->AddAddress($email,$nomeTo);
		
		$mail->WordWrap = 50; 
		$mail->Subject = $assunto;
		$mail->Body = $mensagem;
		global $wpdb;
		if(!$mail->Send()){
			$wpdb->query("insert into ".$db_prefixo."logs_erros (acao, erro, data) values ('Disparo de E-mail','".$mail->ErrorInfo."','".date('Y-m-d H:i:s')."')");
		}
	}
}
?>