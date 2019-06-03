<?php

$appid="jykw_test";
$secret="test";
$time=time();

$url="https://api.jianyu360.com/openkey";
	
$arr=array("appid"=>$appid, "action"=> "getdata","timestamp"=>time());
	
	ksort($arr);
	$str = "";
    foreach ($arr as $k => $v) {
            if ($str != "") {
                $str = $str . "&";
            }
            $str = $str . $k . "=" . $v;
        }
        $str       = urlencode($str);
        $str       = str_replace("%3A", "%253A", str_replace("%7E", "~", str_replace("*", "%2A", str_replace("+", "%20", $str))));
        $signature = base64_encode(hash_hmac('sha1', $str, $secret."&", true));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 300);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
		curl_setopt($ch, CURLOPT_POST, 1);
		$o = "";
       
		$arr['signature']=$signature;
		
		foreach ( $arr as $k => $v ) 
        { 
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
       $postData = substr($o,0,-1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		curl_setopt($ch,CURLOPT_ENCODING , "gzip");
        $res = curl_exec($ch);
   
	    $arr = json_decode($res,true);
		print_r($arr);
?>