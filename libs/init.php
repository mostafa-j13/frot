<?php
define ( "__DEBUG" , 1 );

require_once 'Core/Loader.php';
if (defined ( "__DEBUG" ))
{
    error_reporting ( E_ALL & ~ E_NOTICE  );
    new FB ( ); //forece load FirePHPCore
	FirePHP::getInstance ( true )->registerErrorHandler ();
	FirePHP::getInstance ()->registerExceptionHandler ();

}