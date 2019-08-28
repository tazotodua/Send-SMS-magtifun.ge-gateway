<?php
/*
    ###### https://github.com/tazotodua/Send-SMS-magtifun.ge-gateway #####
Usage: 

    send_sms_magtifun("599xxxxxx", "my_password", "599yyyyyy", "Hello world");
*/

function send_sms_magtifun($username, $password, $to, $text)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_USERAGENT,"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36");
        //f
        curl_setopt($ch, CURLOPT_URL, "http://www.magtifun.ge/" );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIESESSION, true);  $a="cookie_name_smsINFO2".rand(1,9999);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $a );
        curl_setopt($ch, CURLOPT_COOKIEFILE,$a);
        $answer=curl_exec($ch);				if (curl_error($ch)) {	echo "f_CURL_ERROR:".curl_error($ch)."</br>";	}
        //s
        preg_match('/\"csrf_token\"(.*?)value\=\"(.*?)\"/si',$answer,$na);	$token=$na[2];
        preg_match('/Set\-Cookie\: User=(.*?)\;/si',$answer,$nb);			$user=$nb[1];
        curl_setopt($ch, CURLOPT_URL, "http://www.magtifun.ge/index.php?page=11&lang=ge" );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "remember=1&csrf_token=".$token."&act=1&user=".$username."&password=".$password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIESESSION, true);	$b="cookie_name_smsINFO".rand(1,9999);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $b );
        curl_setopt($ch, CURLOPT_COOKIEFILE, $b);
        $answer=curl_exec($ch);				if (curl_error($ch)) {	echo "s_CURL_ERROR:".curl_error($ch)."</br>";	}
            
        //t
        $send_form_page =  "http://www.magtifun.ge/index.php?page=2&lang=ge";
        curl_setopt($ch, CURLOPT_URL, $send_form_page  );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $answer=curl_exec($ch);				if (curl_error($ch)) {	echo "t_CURL_ERROR:".curl_error($ch)."</br>";	}

        //f
        curl_setopt($ch, CURLOPT_REFERER, $send_form_page);
        preg_match('/\"csrf_token\"(.*?)value\=\"(.*?)\"/si',$answer,$nc);	$token=$nc[2];
        curl_setopt($ch, CURLOPT_URL, "http://www.magtifun.ge/scripts/sms_send.php");
        curl_setopt($ch, CURLOPT_POSTFIELDS, "csrf_token=".$token."&message_unicode=0&messages_count=1&recipient=".$to."&recipients=".$to."&total_recipients=1&message_body=".$text);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $answer = curl_exec($ch);			if (curl_error($ch)) {	echo "f_CURL_ERROR:".curl_error($ch)."</br>";	}

    //
    curl_close ( $ch ); @unlink($a); @unlink($b); 
    return $answer;
}
?>
