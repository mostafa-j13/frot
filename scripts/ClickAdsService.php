<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClickAdsService
 *
 * @author mostafa
 */

class ClickAdsService extends Service
{
    public function js()
    {
	$row=$this->input->getInt('row');
	$col=$this->input->getInt('col');
	$uid=$this->input->getInt('uid');

	$count=$row*$col;
	$sql='SELECT
		    ads.*
		  FROM ck_ads as ads
		  JOIN ck_packages as pack
		    ON(ads.package_id=pack.id)
		  WHERE
		    ads.status="approve"   AND
		    ads.clicked < pack.max_click
		  ORDER BY RAND()
		  LIMIT '.$count;
	$query=$this->db->query($sql);
	$tmpl = Template::getInstance('empty.tpl');
	$tmpl->loadPage('jsAds');
	fb($col,'row');
	for($i = 0 ; $i < $row; ++$i)
	{
	    $tmp=array();
	    for($j = 0 ; $j < $col ; ++$j)
	    {
		$tmp[]=$query->fetch();
	    }
	    $data[]=$tmp;
	}
	fb($data);
	$tmpl->assign('uid', $uid);
	$tmpl->assign('row', $row);
	$tmpl->assign('col', $col);
	$tmpl->assign('data', $data);
	Response::getInstance()->setTemplate($tmpl);
    }

    public function  go()
    {
	$id=$this->input->getInt('id');
	$data=$this->db->SimpleSelect("ck_ads","id,url",array('id'=>$id,'status'=>'approve'))->fetch();
	$user=$this->db->SimpleSelect("ge_users","id",array('id'=>$this->input->getInt('uid')))->fetch();
	if($data->id && $user->id)
	{
	    $ob= new stdClass();
	    $ob->id=$id;
	    $ob->clicked='clicked+1';
	    $this->db->StoreObject("ck_ads", $ob, array('clicked'));

	    $ob= new stdClass();
	    $ob->user_id=$id;
	    $ob->clicked='clicked+1';
	    $this->db->StoreObject("ck_customers", $ob, array('clicked'),'user_id');

	    $this->reponse->redirect($data->url);
	}
	else{
	    throw new EAccessDenied("FIle not Found", 404);
	}
    }
}
?>
