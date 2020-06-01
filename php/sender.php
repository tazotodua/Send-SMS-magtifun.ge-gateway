<?php
/* ###### https://github.com/ttodua/Send-SMS-through-magtifun.ge #####
* Usage :
*    echo (new SmsSender_Magtifun($my_username="59xxxxxx", $my_password="xxx"))->send($recipient="59yyyyyy", $text="Hello");
*/




class SmsSender_Magtifun
{
	public function __construct($username, $password)
	{
		$this->username = $username;
		$this->password = $password;
	}
	
	public function send($recipient, $text)
	{
	  try
	  {
		$answer ='';
		$errors =[];
		$ch = curl_init();
			
		curl_setopt($ch, CURLOPT_USERAGENT,"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36");
		//f
		curl_setopt($ch, CURLOPT_URL, "http://www.magtifun.ge/" );
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_COOKIESESSION, true);  $C1=__DIR__."/cookie_sms_1_".rand(1,9999999);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $C1 );
		curl_setopt($ch, CURLOPT_COOKIEFILE,$C1 );
		$answer_1 =curl_exec($ch);			if (curl_error($ch)) { $errors[] = "f_CURL_ERROR:".curl_error($ch)."</br>";	}
		//s
		preg_match('/\"csrf_token\"(.*?)value\=\"(.*?)\"/si',$answer_1, $matches);	$token=$matches[2];
		preg_match('/Set\-Cookie\: User=(.*?)\;/si',$answer_1, $matches);			$user=$matches[1];
		curl_setopt($ch, CURLOPT_URL, "http://www.magtifun.ge/index.php?page=11&lang=ge" );
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "remember=1&csrf_token=".$token."&act=1&user=".$this->username."&password=".$this->password);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_COOKIESESSION, true);	$C2=__DIR__."/cookie_sms_2_".rand(1,9999999);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $C2 );
		curl_setopt($ch, CURLOPT_COOKIEFILE,$C2 );
		$answer_2 =curl_exec($ch);			if (curl_error($ch)) { $errors[] = "s_CURL_ERROR:".curl_error($ch)."</br>";	}
		//t
		$send_form_page =  "http://www.magtifun.ge/index.php?page=2&lang=ge";
		curl_setopt($ch, CURLOPT_URL, $send_form_page  );
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$answer_3 =curl_exec($ch);			if (curl_error($ch)) { $errors[] = "t_CURL_ERROR:".curl_error($ch)."</br>";	}
		//f
		curl_setopt($ch, CURLOPT_REFERER, $send_form_page);
		preg_match('/\"csrf_token\"(.*?)value\=\"(.*?)\"/si', $answer_3, $matches);	$token=$matches[2];
		curl_setopt($ch, CURLOPT_URL, "http://www.magtifun.ge/scripts/sms_send.php");
		curl_setopt($ch, CURLOPT_POSTFIELDS, "csrf_token=".$token."&message_unicode=0&messages_count=1&recipient=".$recipient."&recipients=".$recipient."&total_recipients=1&message_body=".$text);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$answer_4 = curl_exec($ch);			if (curl_error($ch)) { $errors[] = "f_CURL_ERROR:".curl_error($ch)."</br>";	}
		//
		curl_close ( $ch );   
		register_shutdown_function( function() use ($C1, $C2) { (file_exists($C1) && unlink($C1)) || (file_exists($C2) && unlink($C2)) ; } );
		return $answer_4;	//Possible examples:  success | CSRF token validation failed. | not_logged_in
	  }
	  catch(Exception $e)
	  {
		return $e;
	  }
	} 
}

?>
