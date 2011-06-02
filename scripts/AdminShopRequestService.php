<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class AdminShopRequestService extends Service
{

    private $tmpl;

    //put your code here
    public function __construct()
    {
        parent::__construct ();
        $this->tmpl = Template::getInstance( 'adminDashboard.tpl' );
	$this->tmpl->assign('admin', 1);
    }

    public function ShowRequest()
    {
        Factory::getUser()->authorise( "admin", ResponseRegistery::getInstance()->site_id );
        $this->tmpl->loadPage( 'showRequest' );
        $site_id = ResponseRegistery::getInstance()->site_id;

        $query = "SELECT items.title AS item_name, 
                         items.price AS item_price,
                         reqs.name AS name,
                         reqs.tel AS tel,
                         reqs.register_date AS date,
                         reqs.code AS code,
                         reqs.city AS city,
                         reqs.address AS address,
                         reqs.status AS status,
                         reqs.id AS id
                         FROM sh_requests AS reqs
                         JOIN sh_items_requests AS it_reqs ON (it_reqs.request_id = reqs.id)
                         JOIN sh_items AS items ON (items.id = it_reqs.item_id)
                         JOIN sh_subgroups_items AS sgItem ON ( sgItem.item_id = items.id )
                         JOIN sh_subgroups AS sg ON ( sg.id = sgItem.subgroup_id )
                         JOIN sh_groups AS g ON ( sg.group_id = g.id )
                        WHERE (g.site_id ={$site_id})";
        $res = $this->db->query( $query );
	$retC=QueryResult::$returnClass;
	QueryResult::$returnClass='stdClass';
	$requests=$res->fetchAll();
	QueryResult::$returnClass=$retC;
	fb($requests);

	foreach ($requests as $req)
	{
	    fb($req,'b');
	    $req->date = Factory::getDate( $req->date )->format( "d-m-Y" );
	    if(!isset($ret[$req->id]))
	    {

		$ret[$req->id]=clone $req;
		//$ret[$req->id]->requests=array();
	    }
	    $x=$ret[$req->id];
	    $x->requests[]=clone $req;
	    fb($req,'a');
	}

	foreach ($ret as & $req)
	{
	    foreach ($req->requests as & $item)
	    {
		$item=new istdClass($item);
		
	    }
	    $req= new istdClass($req);
	}
        
        fb( $ret,'ffffff' );

        $status_options = array('pending' => 'در دست بررسی','sent' => 'ارسال شده','cancel' => 'لغو شده','return' => 'برگشت خورده');

        $this->tmpl->assign( 'status_options', $status_options);
        $this->tmpl->assign( 'requests', $ret);
        $this->reponse->setTitle( 'سفارشات' );
        $this->reponse->setTemplate( $this->tmpl );
    }

    public function saveStatus()
    {
        Factory::getUser()->authorise( "admin", ResponseRegistery::getInstance()->site_id );

        fb($this->input->getInt( 'RequestID'));
        if($this->input->getInt( 'RequestID') != 0)
        {
            $data->id = $this->input->getInt('RequestID');
            $data->status = $this->input->getString('status');
            try
            {
                $this->db->StoreObject("sh_requests", $data);
                Messages::getInstance()->logSuccess('تغییر مورد نظر با موفقیت انجام شد');
            }
            catch(Exception $ex)
            {
                Messages::getInstance()->logError('در انجام عملیات خطایی رخ داده است');
            }
        }

        $this->reponse->redirect( ResponseRegistery::getInstance()->baseURL . "/dashboard/shopRequest/showrequest" );
    }

}

?>
