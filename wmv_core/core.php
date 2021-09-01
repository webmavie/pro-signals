<?php
if (SESSION_START==TRUE) {
    session_start();
}
DEFINE("ERROR_WORD", "<b>Varsayılan görünüm dosyalarını bulamıyorum!</b><br/>Varsayılan index dosya ismi: <b>".DEFAULT_INDEX."</b><br/>Varsayılan 404 hata dosya ismi: <b>".ERROR_PAGE."</b>");

header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('UTC');

require_once("language.php");
require_once("class/pdo.class.php");
require_once("class/wmvsmtp.class.php");

ini_set('display_errors', SHOW_PHP_ERRORS);
ini_set('display_startup_errors', SHOW_PHP_ERRORS);
error_reporting(SHOW_PHP_ERRORS);

if (DB_HOST!==""){
    $db=new wmvpdo(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PERFIX);
}

if (SMTP_HOST!==""){
    $mail=new wmvsmtp(SMTP_HOST, SMTP_USERNAME, SMTP_PASSWORD, SMTP_SECURE, SMTP_PORT, SMTP_SITENAME, SMTP_DEBUG);
}

function base_url($adress=""){
    $adress=ltrim($adress, '/');
    if (SITE_URL == "") {
        return rtrim(url(), '/').'/'.$adress;
    }else {
        return rtrim(SITE_URL, '/').'/'.$adress;
    }   
}

function base_dir($filename=""){
    $fullpath=str_replace(trim(" \ "), "/", dirname(__DIR__));
    return $fullpath.'/'.$filename;
}

function this_url($withoutget=FALSE){
    $request=$withoutget==FALSE?$_SERVER['REQUEST_URI']:$_SERVER['PATH_INFO'];
    if (SITE_URL == "") {
        $siteurl=rtrim(url(), '/');
    }else {
        $siteurl=trim(SITE_URL, '/');
    } 
    return $siteurl.$request;
}

function dist_url($dist=""){
    $dist=ltrim($dist, '/');
    return base_url(rtrim(DIST_FOLDER, '/')).'/'.$dist;
}

function action_url($data=array()){
    $query=http_build_query($data);
    $query_action=base_url('wmv_core/action.php?').$query;
    return rtrim($query_action, '?');
}

function upload_url($upload=""){
    $upload=ltrim($upload, '/');
    return base_url(rtrim(UPLOAD_FOLDER, '/')).'/'.$upload;
}

function upload_dir($filename=""){
    $fullpath=str_replace(trim(" \ "), "/", dirname(__DIR__));
    return $fullpath.'/'.trim(UPLOAD_FOLDER, "/")."/".$filename;
}

function url(){
  return sprintf(
    "%s://%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['SERVER_NAME']
  );
}

function exception_error_handler($errno, $errstr, $errfile, $errline ) {
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
}

?>