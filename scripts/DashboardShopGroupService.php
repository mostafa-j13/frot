<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class DashboardShopGroupService extends Service
{

    private $tmpl;

    //put your code here
    public function __construct()
    {
        parent::__construct ();
        $this->tmpl = Template::getInstance( 'userDashboard.tpl' );
    }

    public function showGroups()
    {
        Factory::getUser()->authorise( "group", ResponseRegistery::getInstance()->site_id );
        $this->tmpl->loadPage( 'shopGroups' );
        $site_id = ResponseRegistery::getInstance()->site_id;
        $groups = $this->db->SimpleSelect( "sh_groups", "id,title", array( 'site_id' => ResponseRegistery::getInstance()->site_id ) )->fetchAll();
        $subgroups = $this->db->query( "SELECT g.title AS gTitle,subg.id,subg.title FROM sh_subgroups AS subg
                    JOIN sh_groups AS g ON (subg.group_id = g.id)
                    WHERE (g.site_id = {$site_id})" )->fetchAll();

        $groups_array = array( );
        $groups_array[ 0 ] = "شاخه اصلی";
        foreach( $groups as $group )
        {
            $groups_array[ $group->id ] = $group->title;
        }

        $id = $this->input->getInt( 'id' );
        if( $id )
        {
            $type = $this->input->getString( 'type' );
            if( $type == 'sub' )
            {
                $data = $this->db->SimpleSelect( "sh_subgroups", "*", array( 'id' => $id ) )->fetch();
                $this->tmpl->assign( 'select_group', $data->group_id );
            } else
            {
                $data = $this->db->SimpleSelect( "sh_groups", "*", array( 'id' => $id ) )->fetch();
                $this->tmpl->assign( 'select_group', 0 );
            }
        } else
        {
            $data = new istdClass();
            $this->tmpl->assign( 'select_group', $groups_array[ 0 ] );
        }

        $this->tmpl->assign( "data", $data );
        $this->tmpl->assign( 'groups_option', $groups_array );


        $this->tmpl->assign( 'groups', $groups );
        $this->tmpl->assign( 'subgroups', $subgroups );

        $this->reponse->setTitle( 'تعریف شاخه ها' );
        $this->reponse->setTemplate( $this->tmpl );
    }

    public function saveGroups()
    {
        Factory::getUser()->authorise( "group", ResponseRegistery::getInstance()->site_id );
        $data->title = $this->input->getString( 'title' );

        if( $id = $this->input->getInt( 'id' ) )
            $data->id = $id;

        if( $this->input->getInt( 'groups_option' ) == 0 )
        {
            $data->site_id = ResponseRegistery::getInstance()->site_id;
            try
            {
                $this->db->StoreObject( "sh_groups", $data );
                if( $data->id )
                    Messages::getInstance()->logSuccess( "گروه مورد نظر با موفقیت ویرایش شد" );
                else
                    Messages::getInstance()->logSuccess( "گروه مورد نظر با موفقیت ثبت شد" );
            } catch( Exception $e )
            {
                Messages::getInstance()->logError( "گروه مورد نظر ثبت نشد" );
            }
        } else
        {
            $data->group_id = $this->input->getInt( 'groups_option' );
            try
            {
                $this->db->StoreObject( "sh_subgroups", $data );
                if( $data->id )
                    Messages::getInstance()->logSuccess( "زیر گروه مورد نظر با موفقیت ویرایش شد" );
                else
                    Messages::getInstance()->logSuccess( "زیر گروه مورد نظر با موفقیت ثبت شد" );
            } catch( Exception $e )
            {
                Messages::getInstance()->logError( "زیر گروه مورد نظر ثبت نشد" );
            }
        }

        $this->reponse->redirect( ResponseRegistery::getInstance()->baseURL . "/dashboard/shopGroup/showGroups" );
    }

    public function edit()
    {
        Factory::getUser()->authorise( "group", ResponseRegistery::getInstance()->site_id );

        return $this->showGroups();
    }

    public function deleteGroup()
    {
        Factory::getUser()->authorise( "group", ResponseRegistery::getInstance()->site_id );

        try
        {
            $this->db->delete( "sh_groups", $this->input->getInt( 'group_id' ) );
            Messages::getInstance()->logSuccess( "گروه مورد نظر با موفقیت حذف شد" );
        } catch( Exception $e )
        {
            Messages::getInstance()->logError( "هیچ گروهی حذف نشد" );
        }
        $this->reponse->redirect( ResponseRegistery::getInstance()->baseURL . "/dashboard/shopGroup/showGroups" );
    }

    public function deleteSubgroup()
    {
        Factory::getUser()->authorise( "group", ResponseRegistery::getInstance()->site_id );

        try
        {
            $this->db->delete( "sh_subgroups", $this->input->getInt( 'id' ) );
            Messages::getInstance()->logSuccess( "زیر گروه مورد نظر با موفقیت حذف شد" );
        } catch( Exception $e )
        {
            Messages::getInstance()->logError( "هیچ زیر گروهی حذف نشد" );
        }
        $this->reponse->redirect( ResponseRegistery::getInstance()->baseURL . "/dashboard/shopGroup/showGroups" );
    }

}

?>
