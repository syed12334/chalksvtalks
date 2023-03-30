<?php defined('BASEPATH') OR exit('No direct script access allowed');



class Notify {

   

     public function sendNotificationIOS($gcm_id, $message,$type)

    {

        $registrationIds = '';

        if(count($gcm_id)>0)

        {

            $registrationIds = implode(",", $gcm_id);

        }

        $notification = array(

		    'sound' => 'default',

			'body' => $message,

            'title' =>'' ,

            'content_available'=>true,

            'priority'=>'high'

            //'badge' => '1'

        );

		$data = array(

		    'sound' => 'default',

			'body' => $message,

            'title' =>'' ,

            'content_available'=>true,

            'priority'=>'high'

            //'badge' => '1'

        );

        

        $arrayToSend = array('to' => $registrationIds, 'notification' => $notification,'data'=>$data);

        $json = json_encode($arrayToSend);

        $headers = array();

        $headers[] = 'Content-Type: application/json';

        $headers[] = 'Authorization: key='. API_ACCESS_KEY;

        set_time_limit(40);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/fcm/send");

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");

        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);

        //Send the request

        $response = curl_exec($ch);

        //Close request

        if ($response === FALSE) {

            die('FCM Send Error: ' . curl_error($ch));

        }

        return $response;

        //curl_close($ch);

    }

    

     /*****- Global function to send Notification-*****/

    public function sendNotification($gcm_id, $message,$type,$image)

    {

        #API access key from Google API's Console

        

        $registrationIds = $gcm_id;

        

        $msg =$message;

        

       

        

        $fields = array

        (

            'registration_ids' => $registrationIds,

            'data'	=> $msg,

            'priority' => 'high'

        );

       

	   

        $headers = array

        (

            'Authorization: key=AAAAbFBTTWg:APA91bH3V72cjTq26Su6FFwf85xyeT-1VbYZk-Jnq-n6LZSZLpH_Vm24vWhBOgYzhrsFRr5yjyZ648U_pty0zqPVoNO6hiVw80mPid4zwuUHElGRUkA5RyBhM4gs_GkursMEgk0Ak6Wd',

            'Content-Type: application/json'

        );

        

        

        set_time_limit(40);

        #Send Reponse To FireBase Server

        $ch = curl_init();

        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );

        curl_setopt( $ch,CURLOPT_POST, true );

        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );

        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );

        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );

        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );

        $result = curl_exec($ch );

        return $result;

    }



}