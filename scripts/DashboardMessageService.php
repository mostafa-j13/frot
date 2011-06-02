<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mesages
 *
 * @author mostafa
 */
class DashboardMessageService extends Service
{
    //put your code here
    private $tmpl;
    private $pagenumber = 1;

    public function __construct()
    {
        parent::__construct();
        $this->tmpl = Template::getInstance('userDashboard.tpl');
    }
    
    public function send()
    {
	$this->tmpl->loadPage('newMessage');
	$this->reponse->setTemplate($this->tmpl);
    }

    public function save()
    {
	$data= new stdClass();
	$data->title=$this->input->getString('title');
	$data->question=$this->input->getString('question');
	$data->site_id=ResponseRegistery::getInstance()->site_id;
	$this->db->StoreObject("ge_messages", $data);
    }

    public function showList()
    {
	$list=$this->db->SimpleSelect("ge_messages","*",array('site_id'=>  ResponseRegistery::getInstance()->site_id))->fetchAll();
	$this->tmpl->loadPage('listMessage');
	$this->tmpl->assign("list", $list);
	$this->reponse->setTemplate($this->tmpl);
    }

    public function show()
    {
	$sql='SELECT
			msg.*
		FROM ge_messages as msg
		JOIN ge_subdomains as sub
		    USING(site_id)
		WHERE
		    msg.id='.$this->input->getInt('id');
	$data=$this->db->query($sql)->fetch();
	$tmpl = Template::getInstance( 'userDashboard.tpl' );
        $tmpl->loadPage( 'showMessage' );
	fb($data,'data');
        $tmpl->assign( 'data', $data );
	$tmpl->assign( 'admin', false );
        $this->reponse->setTitle( 'لیست درخواست‌ها' );
        $this->reponse->setTemplate( $tmpl );
    }
}
?>
