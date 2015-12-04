<?php
	$to = 'fabio_cl93_@hotmail.com';
	$subject = 'Mensagem de teste PHP';
	$message ='Olá!! Este é um email enviado com PHP!! :P';
	$envia = mail($to , $subject , $message);
	if(!$envia)
	{
		echo 'Erro de envio! :(';
	}
	else
	{
		echo 'Mensagem enviada! :D';
	}





?>