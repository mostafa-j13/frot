<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CommentService
 *
 * @author user
 */
class CommentService extends Service
{

    /**
     *
     * @var ResponseRegistery
     */
    private $respond;

    function __construct()
    {
	parent::__construct();
	$this->respond = ResponseRegistery::getInstance();
    }

    function show()
    {

	$this->respond->article_id = $this->input->getInt("article_id");

	$query = "SELECT name, content, time, email FROM wb_comment
					WHERE (article_id={$this->respond->article_id}
					AND private=0  AND status='approve')";
	fb($query);
	$result = $this->db->query($query)->fetchAll();

	$article_query = "SELECT title FROM wb_articles
							WHERE id={$this->respond->article_id}";
	$article_title = $this->db->query($article_query)->fetch()->title;
	fb($result, 'comments');
	$tmpl = Template::getInstance('empty.tpl');
	$tmpl->loadPage('comment');
	$tmpl->assign('comment_list', $result);
	$tmpl->assign('article_title', $article_title);
	$tmpl->assign('post_id', $this->respond->article_id);
	//require 'temp/comment_template.php';
	Session::getInstance()->Captcha = $this->randomString();
	Response::getInstance()->setTemplate($tmpl);
    }

    function save()
    {
	if (Session::getInstance()->Captcha && Session::getInstance()->Captcha == $_POST["captcha"])
	{

	    Session::getInstance()->Captcha = null;
	    $ob->article_id = $this->input->getInt('article_id');
	    $ob->name = $this->input->getString('name');
	    $ob->email = $this->input->getString('email');
	    $ob->website = "http://" + $this->input->getString('website');
	    $ob->content = nl2br($this->input->getString('content'));
	    $ob->private = $this->input->getInt('private');
	    $ob->ip = $_SERVER['REMOTE_ADDR'];
	    $this->db->StoreObject("wb_comment", $ob);

	    Messages::getInstance()->logSuccess('نظر شما ذخیره شد');
	    fb($ob);
	}
	else
	    Messages::getInstance ()->logError ('عکس امنیتی اشتباه است');
	$this->show();
    }

    private function randomString()
    {
	$str = '';
	$len = rand(5, 9);
	while ($len--)
	{
	    $type = rand(1, 3);
	    if ($type == 1)
	    {
		$ch = rand(1, 9);
	    }
	    else if ($type == 2)
	    {
		$ch = chr(0x61 + rand(0, 25));
	    }
	    else if ($type == 3)
	    {
		$ch = chr(0x41 + rand(0, 25));
	    }
	    $str.=$ch;
	}


	return $str;
    }

}
?>
