<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DashboardLinkService
 *
 * @author mostafa
 */
class DashboardLinkService extends Service
{

    private $tmpl;

    //put your code here
    public function __construct()
    {
        parent::__construct ();
        $this->tmpl = Template::getInstance( 'userDashboard.tpl' );
    }

    private function showLinks( $linkType )
    {
        Factory::getUser()->authorise( "link", ResponseRegistery::getInstance()->site_id );


        $weblog_id = Session::getInstance ()->weblog_id;
        $dailyLinks = $this->db->SimpleSelect( "wb_links", "id,url,title", "weblog_id={$weblog_id} AND type='{$linkType}'" )->fetchAll();
        $this->tmpl->loadPage( "dailyLinks" );
        $this->tmpl->assign( "dailyLinks", $dailyLinks );
        $this->tmpl->assign( "type", $linkType );

        $linkInfo = $this->db->SimpleSelect( "wb_links", "id,url,title", array( "weblog_id" => $weblog_id, "id" => $this->input->getInt( "id" ), "type" => $linkType ) )->fetch();
        if( !$linkInfo )
            $linkInfo = new istdClass ();
        $this->tmpl->assign( "linkInfo", $linkInfo );

        $this->reponse->setTemplate( $this->tmpl );
    }

    public function dailyLinks()
    {
        $this->tmpl->assign( "link_page_title", 'پیوندهای روزانه' );
        $this->reponse->setTitle( 'پیوندهای روزانه' );
        $this->showLinks( "daily" );
    }

    public function staticLinks()
    {
        $this->tmpl->assign( "link_page_title", 'پیوندهای وبلاگ' );
        $this->reponse->setTitle( 'پیوندهای وبلاگ' );
        $this->showLinks( "static" );
    }

    public function save()
    {
        $link->url = $this->input->getString( "url" );
        $link->title = $this->input->getString( "title" );
        $link->type = $this->input->getString( "type" );
        $link->weblog_id = Session::getInstance ()->weblog_id;
        $link->id = $this->input->getInt( "id" );
        //FIXME must be check this id is true
        try
        {
            $this->db->StoreObject( "wb_links", $link );
            Messages::getInstance()->logSuccess( 'لینک مورد نظر با موفقیت ثبت شد' );
        } catch( Exception $ex )
        {
            Messages::getInstance()->logError( 'هیچ لینکی ثبت نشد' );
        }
        $this->reponse->redirect( ResponseRegistery::getInstance()->baseURL . "/dashboard/link/{$link->type}Links" );
    }

    public function dailyEdit()
    {
        $this->showLinks( "daily" );
    }

    public function staticEdit()
    {
        $this->showLinks( "static" );
    }

    public function dailyDelete()
    {
        $query = 'DELETE FROM wb_links WHERE weblog_id=' . Session::getInstance()->weblog_id . ' AND id=' . $this->input->getInt( "id" );
        try
        {
            $this->db->execute( $query );
            Messages::getInstance()->logSuccess( 'لینک مورد نطر با موفقیت حذف شد' );
        } catch( Exception $ex )
        {
            Messages::getInstance()->logError( 'هیچ لینکی حذف نشد' );
        }
        $this->reponse->redirect( ResponseRegistery::getInstance()->baseURL . "/dashboard/link/dailyLinks" );
    }

    public function staticDelete()
    {
        $query = 'DELETE FROM wb_links WHERE weblog_id=' . Session::getInstance()->weblog_id . ' AND id=' . $this->input->getInt( "id" );
        fb( $query );
        try
        {
            $this->db->execute( $query );
            Messages::getInstance()->logSuccess( 'لینک مورد نطر با موفقیت حذف شد' );
        } catch( Exception $ex )
        {
            Messages::getInstance()->logError( 'هیچ لینکی حذف نشد' );
        }
        $this->reponse->redirect( ResponseRegistery::getInstance()->baseURL . "/dashboard/link/staticLinks" );
    }

}

?>
