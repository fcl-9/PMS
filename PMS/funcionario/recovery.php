<?php

require('../common/database.php');
require('../common/common.php');


if(isset($_POST['numerotel'])){
	$numerotel = mysql_real_escape_string($_POST['numerotel']);

	$numerotel = stripslashes($numerotel);

	$numerotel = telefone($numerotel);

	$queryVerTelem = "SELECT * FROM cliente WHERE telefone = '$numerotel'";
	$result = mysqli_query($link, $queryVerTelem);
	//$emailSendInfo = $result['email'];
	
	
	
		if (mysqli_num_rows($result) == 0)
		{	
	       echo "O número de telefone não é válido. Verifique e volte a tentar";	
		}
		else{
				while($array_result = mysqli_fetch_array($result))
				{
					$emailSendInfo = $array_result["email"];
					$passe= $array_result['password'];
					echo $array_result["nome"]." enviamos um e-mail para ".$array_result["email"]." para recuperares a tua senha.";
                   
				   
$assunto = "Recuperar a sua senha\n"."A sua palavra passe de acesso é <strong>".$passe."</strong> utilize a nossa área de login se desejar efetuar alterações.\n"."Agradecemos a sua preferência.";

function mailConfima($assunto,$corpoMsg,$emailSendInfo)
	{
		$mail = new PHPMailer(); // create a new object
		$mail->CharSet = 'UTF-8';
		$mail->IsSMTP(); // enable SMTP
		$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true; // authentication enabled
		$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 465; // or 587
		$mail->Username = "dompetisco.pms@gmail.com";
		$mail->Password = "12345678nao";
		$mail->SetFrom("dompetisco.pms@gmail.com","Dom Petisco");
		$mail->AddReplyTo("dompetisco.pms@gmail.com","Dom Petisco");
		$mail->Subject = $assunto;
		$mail->Body = $corpoMsg;
		$mail->IsHTML(true);
		$mail->AddAddress($emailSendInfo);

	 	if(!$mail->Send()) {
		    echo "Erro ao gerar o email de confirmação. Por favor contacte a gerência " . $mail->ErrorInfo;
		} else {
		    echo "Foi enviado um email com um link de confirmação.";
		}
	}	
				   
						// echo $array_listareserva["password"]; 
				
				}
		}
	}
	
?>