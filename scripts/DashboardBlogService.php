<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BlogDashBoard
 *
 * @author mostafa
 */
class DashboardBlogService extends Service
{

    private $tmpl;

    public function __construct()
    {
        parent::__construct();
        $this->tmpl = Template::getInstance( 'userDashboard.tpl' );
    }

    function show()
    {
        $this->reponse->setTitle( 'میز کار وبلاگ' );
        $this->tmpl->loadPage( 'mainDash' );
	if(Factory::getUser()->authorise( "admin", 0 ,false))
	    $this->tmpl->assign('admin', 1);
        $this->reponse->setTemplate( $this->tmpl );

    }

    function settings()
    {
        Factory::getUser()->authorise( "setting", ResponseRegistery::getInstance()->site_id );
        $this->tmpl->loadPage( 'blogsettings' );

        $subjects = $this->db->SimpleSelect( "wb_subjects" )->fetchKeyValue();
        $blog = $this->db->SimpleSelect( "wb_weblogs", "*", array( 'id' => Session::getInstance()->weblog_id ) )->fetch();
	$user=Factory::getUser();
	$blog->cellphone=$user->cellphone;
	$blog->account_no=$user->account_no;

        $this->tmpl->assign( 'subjects', $subjects );
        $this->tmpl->assign( 'blog', $blog );
        $this->reponse->setTitle( 'تنظیمات وبلاگ' );
        $this->reponse->setTemplate( $this->tmpl );
    }

    function saveSettings()
    {
        Factory::getUser()->authorise( "setting", ResponseRegistery::getInstance()->site_id );
        $object = $this->input->get( 'POST' );
        $object[ 'id' ] = Session::getInstance()->weblog_id;
	$user->account_no=$object['account_no'];
	$user->cellphone=$object['cellphone'];
	$user->id=Factory::getUser()->id;
	unset($object['account_no']);
	unset($object['cellphone']);
        $this->db->StoreObject( "wb_weblogs", $object );
	$this->db->StoreObject( "ge_users", $user );
        $this->reponse->redirect( ResponseRegistery::getInstance()->baseURL . '/dashboard/blog/settings' );
    }

}

?>
