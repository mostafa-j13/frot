<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class DashboardItemService extends Service
{
    public function __construct()
    {
        parent::__construct();
        $this->tmpl = Template::getInstance('userDashboard.tpl');
    }

    private function checkGroups()
    {
        //[FIX_THIS]
        $site_id = 1; //Session::getInstance()->site_id;
        $groups = $this->db->SimpleSelect("sh_groups", "*", "site_id={$site_id}")->fetchAll();
        return $groups;
    }

    private function getGroups()
    {
        $site_id = 1; //Session::getInstance()->site_id;
        fb($this->db->SimpleSelect("sh_groups", "*", "site_id={$site_id}")->fetchAll());
        $groups = $this->db->SimpleSelect("sh_groups", "id,title", "site_id={$site_id}")->fetchAll();

        $group_subgroup = array();
        if(isset ($groups))
        {
            foreach ($groups as $group)
            {
                $subgroups_obj = $this->db->SimpleSelect("sh_subgroups","id,title","group_id={$group->id}")->fetchAll();
                $subgroups = array();
                foreach ($subgroups_obj as $sub)
                {
                    $subgroups[$sub->id] = $sub->title;
                }
                $group_subgroup[$group->title] = $subgroups;
            }
        }
        return $group_subgroup;
    }

    public function newItem()
    {
//        Factory::getUser()->authorise("shop", ResponseRegistery::getInstance()->site_id);
//        $weblog_id = Session::getInstance()->weblog_id;

        $groups = $this->getGroups();
        //print_r($groups);

        $this->tmpl->assign("groups", $groups);
        $this->tmpl->loadPage('newItem');
        $this->reponse->setTitle('درج کالای جدید');

        $this->reponse->setTemplate($this->tmpl);


    }

    public function saveItem()
    {
        $data->title = $this->input->getString('title');
        $data->description = $this->input->getString('desc');
        $data->full_description = $this->input->getString('fdesc');
        $data->price = $this->input->getInt('price');
        $data->off_price = $this->input->getFloat('off_price');
        $data->order = $this->input->getInt('order');
    }
}

?>
