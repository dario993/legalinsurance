<?php
session_start();


if(isset($_GET['lang']))
{
	$lang = $_GET['lang'];
	
	// registra la sessione ed effettua il setting dei cookie
	$_SESSION['lang'] = $lang;
	
	setcookie('lang', $lang, time() + (3600 * 24 * 30));
}
else if(isset($_REQUEST['lang'])){
        $lang = $_REQUEST['lang'];
	
	// registra la sessione ed effettua il setting dei cookie
	$_SESSION['lang'] = $lang;
	
	setcookie('lang', $lang, time() + (3600 * 24 * 30));    
}
else if(isset($_SESSION['lang']))
{
	$lang = $_SESSION['lang'];
}
else if(isset($_COOKIE['lang']))
{
	$lang = $_COOKIE['lang'];
}
else
{
	$lang = 'it';
        
        $_SESSION['lang'] = $lang;
	
	setcookie('lang', $lang, time() + (3600 * 24 * 30));
}

switch ($lang) {
  case 'en':
  $lang_file = 'en.php';
  break;

  case 'de':
  $lang_file = 'de.php';
  break;

  case 'it':
  $lang_file = 'it.php';
  break;

  case 'fr':
  $lang_file = 'fr.php';
  break;

  default:
  $lang_file = 'en.php';

}
include ('lingue/'.$lang_file);
?>