<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminMessageService
 *
 * @author mostafa
 */
class AdminMessageService extends Service
{
    public function getList()
    {
	$sql='SELECT
			msg.*
		FROM ge_messages as msg
		JOIN ge_subdomains as sub
		    USING(site_id)
                ORDER BY msg.status';
	$list=$this->db->query($sql)->fetchAll();
	
	$tmpl = Template::getInstance( 'adminDashboard.tpl' );
        $tmpl->loadPage( 'listMessages' );
        $tmpl->assign( 'list', $list );
        $this->reponse->setTitle( 'لیست درخواست‌ها' );
        $this->reponse->setTemplate( $tmpl );
    }

    public function show()
    {
	$sql='SELECT
			msg.*
		FROM ge_messages as msg
		JOIN ge_subdomains as sub
		    USING(site_id)
		WHERE
		    msg.status="open" and
		    msg.id='.$this->input->getInt('id');
	$data=$this->db->query($sql)->fetch();
	$tmpl = Template::getInstance( 'adminDashboard.tpl' );
        $tmpl->loadPage( 'showMessage' );
	fb($data);
        $tmpl->assign( 'data', $data );
	$tmpl->assign( 'admin', 1 );
        $this->reponse->setTitle( 'ارسال پاسخ پیام' );
        $this->reponse->setTemplate( $tmpl );
    }

    public function save()
    {
	$ob->id=$this->input->getInt('id');
	$ob->answer=$this->input->getString('answer');
	$ob->status='close';
	$this->db->StoreObject("ge_messages", $ob);
	$this->reponse->redirect(ResponseRegistery::getInstance()->baseURL.'/admin/message/getlist');
    }
}
?>
