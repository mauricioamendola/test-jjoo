<?php
include_once("inc/facebook.php"); //include facebook SDK
######### Facebook API Configuration ##########
$appId = '1623093934676427'; //Facebook App ID
$appSecret = 'f8720d2b5c9343a97edc9ab8c7e8b00f'; // Facebook App Secret
$homeurl = 'http://olympicinfoapp.com/app';  //return to home
$fbPermissions = 'email';  //Required facebook permissions

//Call Facebook API
$facebook = new Facebook(array(
  'appId'  => $appId,
  'secret' => $appSecret

));
$fbuser = $facebook->getUser();
?>
