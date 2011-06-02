<?php

try
{

    require_once 'libs/init.php';


    Session::getInstance();
    $rewriteEng = new RewriteEngine();
    $rewriteEng->route();
    if( Request::getInstance()->getInt( 'dologin' ) )
    {
        Session::getInstance()->Clear();
    }
    $controller = new FrotelController();
    $response = Response::getInstance();
    $controller->execute();
    $response->flush();
} catch( Exception $e )
{
    include 'erroraccess.php';
    if( defined( "__DEBUG" ) )
    {
        throw $e;
    }
}