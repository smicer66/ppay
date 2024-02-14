<?php
//include ($_SERVER['DOCUMENT_ROOT']."/".substr(substr($_SERVER['REQUEST_URI'],1,strlen($_SERVER['REQUEST_URI'])), 0, strpos($_SERVER['REQUEST_URI'],'/',1))."plugins/mailer/class.phpmailer.php");

class Email
{
	function __construct()
	{
	
	}
	
	function setEntryError($entryError)
	{
		array_push($this->entryError,$entryError);
	}
	
	
	function sendIt($objClass, $subject=NULL, $body, $receipientArray, $identifier)
	{
		$mail = new phpmailer();
		$mail -> SMTPKeepAlive = 'true';
		$mail->IsSMTP();
		$mail->Host = "penguin.whogohost.com";
		$mail -> SetLanguage('en', 'class/');

		//IF ($smtpauth == 'TRUE')
		//{
			$mail->SMTPAuth = 'true';
			$mail->Username = "mailer@zubafia.com";
			$mail->Password = "8p.w~182Q^DR";
		//}

		$mail->From = "smicer66@gmail.com";
		$mail->FromName = "smicer66@gmail.com";
		$mail->AddReplyTo("smicer66@gmail.com", "smicer66@gmail.com");

		$mail->IsHTML(False);
		$mail->Subject = $subject;

// VERIFY THE EMAIL ADDRESS
		//IF ($makeverify == 'TRUE')
		//{
			$regid = md5($identifier);
		//}
		$mail -> Body = $body;
		//dd($mail);
		//echo $body;

// EMAIL THE USER IF THE CONFIG IS SET TO TRUE
		//originally supposed to use the global $site variable
		try{
			for($countre=0;$countre<sizeof($receipientArray);$countre++)
			{
				//dd($receipientArray[$countre]);
				$mail->AddAddress($receipientArray[$countre], stripslashes($receipientArray[$countre]));
				IF(!$mail -> Send())
				{
					echo $receipientArray[$countre];
					//$obj->setEntryError(ERROR_ERRORSENDMAIL);
					
				}
				else
				{
				
				}
				$mail -> ClearAddresses();
			}
		}catch(Exception $e)
		{
			dd($e);
		}
		

		$mail -> SmtpClose();
	}
}

?>