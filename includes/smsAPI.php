<?php
/*
Created on 16/Mar/2007
Main changes:
1. Uses CURL (Client URL) API for sending Messages
2. The server URL has now been changed to api.whizsms.com
*/
class sendSms
{
	//var $serverURL = 'http://203.212.70.200/smpp/sendsms';
	//var $serverURL = 'http://smsalert.dmudra.com/api/smsapi.aspx';
	var $serverURL = 'http://bulksms.abhinavinfo.com/sendSMS';
  
 //    var $apikey ='14c61f69-3b78-4f36-898f-154f18759036';
	// var $route='TRANS';
 //    var $sender = 'SRTBLR';//Write your Sender ID for CDMA here
 //    var $uid ='SRTBLR';
	// var $password = 'Sankara@057#';

      var $apikey ='1fc9a179-067d-487b-aaff-dc763b7a0c43';
    var $route='TRANS';
    var $sender = 'PDLKNI';//Write your Sender ID for CDMA here
    var $uid ='PDLKNI';
    var $password = 'Sankara@057#';



    
    
  /*  function GetSenderID()
    {
        return $this->cdmaNumber;
        
    }
    
    function GetSenderApiKey()
    {
        return $this->gsmSender;
        
    }*/
	
	/* function postdata($url)
    {
         //The function uses CURL for posting data to server
        $objURL = curl_init($url);
        curl_setopt($objURL, CURLOPT_RETURNTRANSFER, 1);
        $retval = trim(curl_exec($objURL));
        curl_close($objURL);
        return $retval;
    }
	function sendSmsToUser( $content='', $to='')
    {
		if( $content!='' )
        {
            $content = htmlentities($content,ENT_COMPAT);
            
            $data = sprintf('username=%s&password=%s&from=%s&to=%s&message=%s&code=2',$this->uid,htmlentities($this->pwd),$this->GetSenderID(),$to,str_replace("amp%3B","",str_replace("%250A","%0A",urlencode($content))),"");
           
            $str_request = $this->serverURL.'?'.$data.'&dlr-m';
            //echo $str_request;exit;
			$str_response = $this->postdata($str_request); 
            if ($str_response=="")
            {
                $str_response = "REQUEST FAILED \t";
            }
           
            if( $fp=fopen('smsmessagesResponse.txt','a+') ){	
                fwrite($fp, $str_response . "\t" . date ("l dS of F Y h:i:s A")."\n".$str_request."\n" );
                fclose($fp);
            }
            return $str_response;
		}
        else
        {
			return '';
		}
	}*/
	   function GetSenderID()
    {
        return $this->sender;
        
    }
    
    function GetApiKey()
    {
        return $this->apikey;
        
    }
	 function postdata($url)
    {
         //The function uses CURL for posting data to server
        $objURL = curl_init($url);
        curl_setopt($objURL, CURLOPT_RETURNTRANSFER, 1);
        $retval = trim(curl_exec($objURL));
        curl_close($objURL);
        return $retval;
    }
	function sendSmsToUser( $content='', $to='')
    {
		if( $content!='' )
        {
            $content = htmlentities($content,ENT_COMPAT);
		   // $data = sprintf('apikey=%s&route=%s&sender=%s&mobileno=%s&text=%s',$this->apikey,$this->route,$this->sender,$to,str_replace("amp%3B","",str_replace("%250A","%0A",urlencode($content))));
			
           $data = sprintf('username=%s&message=%s&sendername=%s&smstype=%s&numbers=%s&apikey=%s',urlencode($this->uid),str_replace("amp%3B","",str_replace("%250A","%0A",urlencode($content))),$this->sender,$this->route,$to,$this->apikey);
		   
		   
            $str_request = $this->serverURL.'?'.$data;
			//echo $str_request;exit;
			$str_response = $this->postdata($str_request); 
			//echo $str_response;exit;
            if ($str_response=="")
            {
                $str_response = "REQUEST FAILED \t";
            }
           
                if( $fp=fopen('smsmessagesResponse.txt','a+') ){	
                    fwrite($fp, $str_response . "\t" . date ("l dS of F Y h:i:s A")."\n".$str_request."\n" );
                    fclose($fp);
                }
            /*	RECORDING OF THE MESSAGE EVENT FINISHED	*/
            return $str_response;
		}
        else
        {
			return '';
		}
	}
    
   
	
	
}
?>