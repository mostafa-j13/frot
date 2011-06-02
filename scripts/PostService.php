<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PostService
 *
 * @author user
 */
class PostService extends Service
{

    /**
     *
     * @var ResponseRegistery
     */
    private $respond;

    public function  __construct() {
        parent::__construct();
        $this->respond=ResponseRegistery::getInstance();
        $this->respond->postPassword=$this->input->getString('postPassword');
        
    }

    public function page()
    {
        $x=$this->respond->limit=$this->getPostPerPage($this->respond->weblog_id);
        $this->respond->limitStart=($this->input->getInt('page',1)-1)*$x;
        $this->loadTemplate('page');
    }

    public function author()
    {
        $this->respond->userName=$this->input->getString('username');
        $this->loadTemplate('author');
    }

    public function post()
    {
        $this->respond->article_id=$this->input->getInt('article_id');
        $this->loadTemplate('post');
    }

    public function tag()
    {
       $this->respond->tag=$this->input->getString('tag');
        $this->loadTemplate('tag');
    }

    public function archive()
    {
        $yy=$this->input->getInt('yy');
        $mm=$this->input->getInt('mm');
        $date=Factory::getDate("{$yy}-{$mm}-01",Date::tyJalali);
        $x=$this->respond->archiveStart=$date->toMySQL();
        $this->respond->archiveEnd=$date->endOfMonth()->toMySQL();
        $this->loadTemplate('archive');
    }

    private function getPostPerPage($id)
    {
        return Factory::getDBO()->SimpleSelect('wb_weblogs','post_in_page','id='.$id)->fetch()->post_in_page;
    }

    private function loadTemplate($task)
    {
       $tmp=new TemplateData($task);
       $tmp_id=$this->getWebLogTemplateId();
       $ads=$this->loadAds();
       if($ads)
	   echo $ads;
       $template=dirname(__FILE__).'/../blogStorage/templates/'.$tmp_id.".php";
       define("__IN_LOADTEMPLATE",1);
       try
       {
       if(file_exists($template))
	    include ($template);
       else
	   die("error in template login in your dashboard");

       }
       catch(Exception $e)
       {
	   fb($e);
       }
    }

    private function loadAds()
    {
	$sql='SELECT
		    *
		 FROM ge_ads
		 WHERE
		    max_visit>visited';
	$ads=$this->db->query($sql)->fetch();
	if($ads->id)
	{
	    $sql='UPDATE ge_ads set visited=visited+1 WHERE id='.$ads->id;
	    $this->db->execute($sql);
	
	    return Module::load('blog_ads',array('ads'=>$ads,'div_id'=>substr(md5(time().rand(100,1000)),20)));
	}
	return false;
    }

    private function getWebLogTemplateId()
    {
	return intval($this->db->SimpleSelect('ge_sites', 'template_id',
			array('id' => $this->respond->site_id))->fetch()->template_id);
    }
}
?>
