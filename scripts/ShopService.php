<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ShopService
 *
 * @author mostafa
 */
class ShopService extends Service{

    private $respond;

    public function  __construct() {
        parent::__construct();
        $this->respond=ResponseRegistery::getInstance();

    }

    public function page()
    {
        $x=$this->respond->limit=$this->getItemPerPage($this->respond->weblog_id);
        $this->respond->limitStart=($this->input->getInt('page',1)-1)*$x;
        $this->loadTemplate('page');
    }

    private function loadTemplate($task,$file='')
    {
       $tmp=new TemplateData($task);
       $tmp_id=$this->getWebLogTemplateId();
       $template=dirname(__FILE__).'/../blogStorage/templates/'.$tmp_id."_shop{$file}.php";
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


    public function item()
    {
	 $this->respond->item_id=$this->input->getInt('id');
	 $this->loadTemplate('item','_item');
    }

    private function getItemPerPage($id)
    {
	return 50;
        return Factory::getDBO()->SimpleSelect('wb_weblogs','post_in_page','id='.$id)->fetch()->post_in_page;
    }

    private function getWebLogTemplateId()
    {
	return intval($this->db->SimpleSelect('ge_sites', 'template_id',
			array('id' => $this->respond->site_id))->fetch()->template_id);
    }
}
?>
