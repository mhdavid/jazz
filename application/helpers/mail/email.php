<?php
$Nome		= $_POST["Nome"];	// Pega o valor do campo Nome
$Fone		= $_POST["Fone"];	// Pega o valor do campo Telefone
$Email		= $_POST["Email"];	// Pega o valor do campo Email
$Mensagem	= $_POST["Mensagem"];	// Pega os valores do campo Mensagem

// Variбvel que junta os valores acima e monta o corpo do email

$Vai 		= "Nome: $Nome\n\nE-mail: $Email\n\nTelefone: $Fone\n\nMensagem: $Mensagem\n";

require_once("class.phpmailer.php");

define('GUSER', 'marcio.h.david@gmail.com');	// <-- Insira aqui o seu GMail
define('GPWD', 'pineappleroad66');		// <-- Insira aqui a senha do seu GMail

function smtpmailer($para, $de, $de_nome, $assunto, $corpo) { 
	global $error;
	$mail = new PHPMailer();
	$mail->IsSMTP();		// Ativar SMTP
	$mail->IsHTML(true);
	$mail->SMTPDebug = 0;		// Debugar: 1 = erros e mensagens, 2 = mensagens apenas
	$mail->SMTPAuth = true;		// Autenticaзгo ativada
	$mail->SMTPSecure = 'ssl';	// SSL REQUERIDO pelo GMail
	$mail->Host = 'smtp.gmail.com';	// SMTP utilizado
	$mail->Port = 465;  		// A porta 465 deverб estar aberta em seu servidor
	$mail->Username = GUSER;
	$mail->Password = GPWD;
	$mail->SetFrom($de, $de_nome);
	$mail->Subject = $assunto;
	$mail->Body = $corpo;
	$mail->AddAddress($para);
	if(!$mail->Send()) {
		$error = 'Mail error: '.$mail->ErrorInfo; 
		return false;
	} else {
		$error = 'Mensagem enviada!';
		return true;
	}
}

// Insira abaixo o email que irб receber a mensagem, o email que irб enviar (o mesmo da variбvel GUSER), 
//o nome do email que envia a mensagem, o Assunto da mensagem e por ъltimo a variбvel com o corpo do email.

 if (smtpmailer($Email, 'marcio.h.david@gmail.com', 'Facvest Vestibular', 'Inscriзгo Vestibular de Inverno Facvest', $Vai)) {

	Header("location:http://200.247.83.30/website1/mail/obrigado.php"); // Redireciona para uma pбgina de obrigado.

}
if (!empty($error)) echo $error;
?>