<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RewriteEngine
 *
 * @author Mostafa J
 */
class RewriteEngine
{

    public function route()
    {
	$url = $_SERVER['REQUEST_URI'];
	$a = $result = array();
	ResponseRegistery::getInstance()->baseURL = 'http://' . $_SERVER["HTTP_HOST"] . '/frotel';
	//ResponseRegistery::getInstance()->baseURL = 'http://' . $_SERVER["HTTP_HOST"];
	if (preg_match("#^([^.]+)\.valablogg\.com(:\d+)?$#", $_SERVER["HTTP_HOST"], $result) && $result[1] != "www")
	{
            
	    $_GET["subdomain"] = $result[1];

	    if (preg_match("#(blog)/post/(\d+)/.*\.html$#", $url, $a))
	    {
		$_GET["application"] = $a[1];
		$_GET["service"] = "post";
		$_GET["task"] = "post";
		$_GET["article_id"] = $a[2];
		return;
	    }
	    if (preg_match("#(blog)(/?|/page(/?|/(\d+)?/?))?$#", $url, $a))
	    {
		$_GET["application"] = $a[1];
		$_GET["service"] = "post";
		$_GET["task"] = "page";
		$_GET["page"] = isset($a[4]) ? intval($a[4]) : 1;
		return;
	    }
	    if (preg_match("#(blog)/author/([^/]+)/?$#", $url, $a))
	    {
		$_GET["application"] = $a[1];
		$_GET["service"] = "post";
		$_GET["task"] = "author";
		$_GET["username"] = $a[2];
		return;
	    }
	    if (preg_match("#(blog)/tag/([^/]+)/?$#", $url, $a))
	    {
		$_GET["application"] = $a[1];
		$_GET["service"] = "post";
		$_GET["task"] = "tag";
		$_GET["tag"] = $a[2];
		return;
	    }
	    if (preg_match("#(blog)/archive/(\d{2})/(\d{1,2})/?$#", $url, $a))
	    {
		$_GET["application"] = $a[1];
		$_GET["service"] = "post";
		$_GET["task"] = "archive";
		$_GET["yy"] = $a[2];
		$_GET["mm"] = $a[3];
		return;
	    }
	    if (preg_match("#(blog)/comment/(\d+)/?$#", $url, $a))
	    {
		$_GET["application"] = $a[1];
		$_GET["service"] = "comment";
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
		    $_GET["task"] = "save";
		}
		else
		{
		    $_GET["task"] = "show";
		}
		$_GET["article_id"] = $a[2];
		return;
	    }

	    if (preg_match("#(shop)(/?|/page(/?|/(\d+)?/?))?$#", $url, $a))
	    {
		$_GET["application"] = $a[1]='blog';
		$_GET["service"] = "shop";
		$_GET["task"] = "page";
		$_GET["page"] = isset($a[4]) ? intval($a[4]) : 1;
		return;
	    }

	    if (preg_match("#(shop)/item/(\d+)$#", $url, $a))
	    {
		$_GET["application"] = $a[1]='blog';
		$_GET["service"] = "shop";
		$_GET["task"] = "item";
		$_GET["id"] = $a[2];
		return;
	    }

	    if (preg_match("#(shop)/fro/(\d+)$#", $url, $a))
	    {
		$_GET["application"] = $a[1]='blog';
		$_GET["service"] = "shop";
		$_GET["task"] = "fro_item";
		$_GET["id"] = $a[2];
		return;
	    }

	    if (preg_match("#(shop)/card/(\w+)/(\d+)$#", $url, $a))
	    {
		$_GET["application"] = $a[1]='blog';
		$_GET["service"] = "card";
		$_GET["task"] = $a[2];
		$_GET["id"] = $a[3];
		return;
	    }

	    if (preg_match("#(shop)/fcard/(\w+)/(\d+)$#", $url, $a))
	    {
		$_GET["application"] = $a[1]='blog';
		$_GET["service"] = "card";
		$_GET["task"] = 'frotel'.ucfirst($a[2]);
		$_GET["id"] = $a[3];
		return;
	    }

	    if (preg_match("#captcha$#", $url, $a))
	    {
		$_GET["application"] = 'blog';
		$_GET["service"] = "captcha";
		$_GET["task"] = "show";
		return;
	    }
	    else
	    {
		
		Response::getInstance()->redirect(ResponseRegistery::getInstance()->baseURL . '/blog');
		return;
	    }
	    die('عملیات مورد نظر امکان پذیر نیست');
	}
	else if (preg_match("#^(www\.)?valablogg\.com(:\d+)?$#", $_SERVER["HTTP_HOST"], $result))
	{
	    if (preg_match("#admin/(\w+)/(\w+)(/(\d+))?#", $url, $a))
	    {
		$_GET["application"] = 'admin';
		$_GET["service"] = "Admin" . ucfirst($a[1]);
		$_GET["task"] = $a[2];
		$_GET["id"] = isset($a[3]) ? $a[4] : 0;
		return;
	    }
            if (preg_match("#trace/(\w+)(/([a-zA-Z0-9\-]+))?#", $url, $a))
	    {
		$_GET["application"] = 'dashboard';
		$_GET["service"] = "Trace";
		$_GET["task"] = $a[1];
		$_GET["traceID"] = isset($a[3]) ? $a[3] : 0;
		return;
	    }
	    else if (preg_match("#dashboard/(\w+)/(\w+)(/(\d+))?#", $url, $a))
	    {
		$_GET["application"] = 'dashboard';
		$_GET["service"] = "Dashboard" . ucfirst($a[1]);
		$_GET["task"] = $a[2];
		$_GET["id"] = isset($a[3]) ? $a[4] : 0;
		return;
	    }
	    else if (preg_match("#user/(\w+)#", $url, $a))
	    {
		$_GET["application"] = 'dashboard';
		$_GET["service"] = "User";
		$_GET["task"] = $a[1];
		return;
	    }
	    else if (preg_match("#dashboard#", $url, $a))
	    {
		Response::getInstance()->redirect(ResponseRegistery::getInstance()->baseURL . '/dashboard/post/oldpost');
		return;
	    }
	    else if(preg_match("#page/(\w+)#", $url, $a))
	    {
		$_GET["application"] = 'dashboard'; //FIXME chage this
		$_GET["service"] = "Site";
		$_GET["task"] = $a[1];
		
		return;
	    }
	    else if(preg_match("#click/(\w+)#", $url, $a))
	    {
		$_GET["application"] = 'dashboard'; //FIXME chage this
		$_GET["service"] = "ClickAds";
		$_GET["task"] = $a[1];
	    }
	    else
	    {

		$_GET["application"] = 'dashboard'; //FIXME chage this
		$_GET["service"] = "Site";
		if (empty($a[1]))
		{
		    $_GET["task"] = 'firstPage';
		}
		else
		{
		    $_GET["task"] = $a[1];
		}
		return;
	    }
	}
	else
	{
	    die("no");
	    Response::getInstance()->redirect(ResponseRegistery::getInstance()->baseURL . '/error.php');
	    return;
	    die("صفحه مورد نظر پیدا نشد");
	}
    }

}
?>
