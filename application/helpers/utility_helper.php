<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function app_url(){
    return str_replace('icchhaadmin/','',base_url());
}

function app_asset_url(){
    return str_replace('icchhaadmin/','',base_url()).'assets/';
}

function card_asset_url(){
    return str_replace('icchhaadmin/','',base_url()).'assets/';
 }

function asset_url(){
   return base_url().'assets/';
}
function admin_url(){
    return str_replace('partner','icchhaadmin',base_url());
 }


if (!function_exists('sqftEncrypt')) {   
function icchaEncrypt($string) {        
        $secret_key = 'iccha';
        $secret_iv = 'icchav1';  
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash( 'sha256', $secret_key );
        $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );        
        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
        return $output;
    }
}

if (!function_exists('sqftDcrypt')) {   
    function icchaDcrypt($string) {     
        $secret_key = 'iccha';
        $secret_iv = 'icchav1';   
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash( 'sha256', $secret_key );
        $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );    
        return $output;
    }
}

?>