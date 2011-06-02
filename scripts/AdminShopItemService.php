<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class AdminShopItemService extends Service
{

    public function __construct()
    {
        parent::__construct();
        $this->tmpl = Template::getInstance('adminDashboard.tpl');
        $this->tmpl->assign('admin', 1);
    }

    private function getsubGroups()
    {
        $site_id = ResponseRegistery::getInstance()->site_id;
        $query = "SELECT subgroups.id AS id,concat(groups.title,'--->', subgroups.title) AS title
                    FROM sh_subgroups AS subgroups
                    JOIN sh_groups AS groups ON ( subgroups.group_id = groups.id )
                    ";
        $subgroups_obj = $this->db->query($query)->fetchAll();

        $subgroups = array();
        if (isset($subgroups_obj))
        {
            foreach ($subgroups_obj as $sub)
            {
                $subgroups[$sub->id] = $sub->title;
            }
        }
        return $subgroups;
        /*
          $group_subgroup = array();
          if(isset($groups))
          {
          foreach($groups as $group)
          {
          $subgroups_obj = $this->db->SimpleSelect("sh_subgroups", "id,title", "group_id={$group->id}")->fetchAll();
          $subgroups = array();
          foreach($subgroups_obj as $sub)
          {
          $subgroups[$sub->id] = $sub->title;
          }
          $group_subgroup[$group->title] = $subgroups;
          }
          }
          return $group_subgroup;
         */
    }

    public function showItem()
    {
        Factory::getUser()->authorise("admin", 0);
        $site_id = ResponseRegistery::getInstance()->site_id;
        fb($site_id);
        if ($this->input->getString('search'))
        {
            $search = $this->db->getEscaped($this->input->getString('search'));
            $where = " WHERE items.title LIKE '%{$search}%' or subs.sub_domain='{$search}' ";
        }
        $query = "SELECT items.id, items.title, items.price AS price, subs.sub_domain as sub
                    FROM sh_items AS items
                    JOIN sh_subgroups_items AS sgItem ON ( sgItem.item_id = items.id )
                    JOIN sh_subgroups AS sg ON ( sg.id = sgItem.subgroup_id )
                    JOIN sh_groups AS g ON ( sg.group_id = g.id )
                    JOIN ge_subdomains as subs ON(subs.site_id = g.site_id)
                        $where
                        group by items.title";
        $items = $this->db->query($query)->fetchAll();

        $subgroups = $this->getsubGroups();
        $this->tmpl->assign("subgroups", $this->getsubGroups());

        $this->tmpl->assign('items', $items);


        $this->tmpl->loadPage('adminShowItem');
        $this->reponse->setTitle('لیست کالاها');

        $this->reponse->setTemplate($this->tmpl);
    }

    // show item information
    public function ShowAnItem()
    {
        Factory::getUser()->authorise("admin", 0);
        $site_id = ResponseRegistery::getInstance()->site_id;
        $item_id = $this->input->getInt("id");
        $sql = 'SELECT
			item.*,
			sub.title as subgroup,
			groups.title as `group`,
                        img.url as imgURL,
                        users.*
		    FROM sh_items as item
		    JOIN sh_subgroups_items as si
			ON(si.item_id=item.id)
		    JOIN sh_subgroups as sub
			On(sub.id=si.subgroup_id)
		    JOIN sh_groups as groups
			ON(groups.id=sub.group_id)
                    JOIN sh_images as img
                        ON(img.item_id=item.id)
                    JOIN ge_sites as sites
                        ON(sites.id = groups.site_id)
                    JOIN ge_users_sites as usersite
                        ON(usersite.site_id=sites.id)
                    JOIN ge_users as users
                        ON(users.id = usersite.user_id)
		    WHERE
			item.id=' . $item_id . ' group by item.id';
        $row = $this->db->query($sql)->fetch();
        $this->tmpl->assign('item', $row);
        $this->tmpl->loadPage('adminShowAnItem');
        $this->reponse->setTitle('مشخصات کالا');
        $this->reponse->setTemplate($this->tmpl);
    }

    public function Item()
    {
        Factory::getUser()->authorise("admin", 0);

        $site_id = ResponseRegistery::getInstance()->site_id;

        $subgroups = $this->getsubGroups();
        if (!$subgroups)
        {
            Messages::getInstance()->logWarning("هیچ گروه یا زیرگروهی پیدا نشد");
            $this->tmpl->assign('show_save', 'false');
        }
        else
        {
            $this->tmpl->assign('show_save', 'true');
        }

        $id = $this->input->getInt('id');
        if ($id)
        {
            $query = "SELECT items.id AS id, items.title AS title,
                                items.Price AS price,
                                items.off_price AS offPrice,
                                items.description AS shortDesc,
                                items.full_description AS longDesc,
                                items.order AS itOrder,
                                items.active as activated,
                                items.existed as existed
                    FROM sh_items AS items
                    JOIN sh_subgroups_items AS sgItem ON ( sgItem.item_id = items.id )
                    JOIN sh_subgroups AS sg ON ( sg.id = sgItem.subgroup_id )
                    JOIN sh_groups AS g ON ( sg.group_id = g.id )
                    WHERE  items.id = {$id})";

            $items = $this->db->query($query)->fetch();

            fb($items);
            //get subgroups id
            $subs = $this->db->SimpleSelect("sh_subgroups_items", "subgroup_id", array(item_id => $id))->fetchAll();
            fb($subs);
            $this->tmpl->assign('subs', $subs);
            $this->tmpl->assign("save_button_title", "ذخیره تغییرات");
            $this->tmpl->assign('item', $items);
        }
        else
        {
            $item = new istdClass();
            $item->itOrder = $item->activated = $item->existed = 1;
            $this->tmpl->assign('item', $item);
            $this->tmpl->assign("save_button_title", "درج کالا");
        }



        $this->tmpl->assign('title', 'ثبت کالای جدید');
        $this->tmpl->assign("subgroups", $this->getsubGroups());
        $this->tmpl->loadPage('shopItem');
        $this->reponse->setTitle('درج کالای جدید');

        $this->reponse->setTemplate($this->tmpl);
    }

    public function saveItem()
    {
        Factory::getUser()->authorise("item", 0);
        $done = true;

        $data->title = $this->input->getString('title');
        $data->description = $this->input->getString('shortDesc');
        $data->full_description = $this->input->getString('longDesc');
        $data->price = $this->input->getInt('price');
        $data->off_price = $this->input->getFloat('offPrice');
        $data->order = $this->input->getInt('order');
        $data->active = $this->input->getInt('activated');
        $data->existed = $this->input->getInt('existed');

        if ($this->input->getInt('id'))
        {
            $data->id = $this->input->getInt('id');
            $del_query = "DELETE FROM sh_subgroups_items WHERE item_id = {$data->id}";
            try
            {
                $this->db->execute($del_query);
            }
            catch (Exception $ex)
            {
                fb($ex);
                $done = false;
            }
        }

        try
        {
            $this->db->StoreObject("sh_items", $data);
            if (!$data->id)
                $data->id = $this->db->insert_id();
        }
        catch (Exception $ex)
        {
            fb($ex);
            $done = false;
        }

        $subgArray = $this->input->getArray('subgroups');
        foreach ($subgArray as $sub)
        {
            try
            {
                $data_sgroup->subgroup_id = $sub;
                $data_sgroup->item_id = $data->id;
                $this->db->StoreObject("sh_subgroups_items", $data_sgroup);
            }
            catch (Exception $ex)
            {
                fb($ex);
                if ($ex->getCode() != 1062)
                    $done = false;
            }
        }

        if ($done)
        {
            $fname = md5(time() . rand(10000, 100000));
            $this->input->uploadFile('file', dirname(__FILE__) . '/../blogStorage/images/' . $fname);

            $image->url = 'blogStorage/images' . $fname;
            $image->item_id = $data->id;
            try
            {
                $this->db->StoreObject("sh_images", $image);
            }
            catch (Exception $ex)
            {
                $done = false;
            }
        }

        fb($data);

        if ($done)
            Messages::getInstance()->logSuccess("کالای مورد نظر با موفقیت ثبت شد");
        else
            Messages::getInstance()->logError("هیچ کالای تغییر یا افزوده نشد");

        $this->reponse->redirect(ResponseRegistery::getInstance()->baseURL . "/dashboard/shopItem/showitem");
    }

    public function edit()
    {
        Factory::getUser()->authorise("item", ResponseRegistery::getInstance()->site_id);
        return $this->Item();
    }

    public function delete()
    {
        Factory::getUser()->authorise("item", ResponseRegistery::getInstance()->site_id);
        try
        {
            $item_id = $this->input->getInt('id');
            $query = "DELETE FROM sh_subgroups_items WHERE item_id = {$item_id}";
            $this->db->execute($query);
            $query = "DELETE FROM sh_images WHERE item_id = {$item_id}";
            $this->db->execute($query);
            $query = "DELETE FROM sh_items WHERE id = {$item_id}";
            $this->db->execute($query);

            // [FIXIT] images file not delete

            Messages::getInstance()->logSuccess("کالای مورد نظر با موفقیت حذف شد");
        }
        catch (Exception $e)
        {

            Messages::getInstance()->logError("هیچ کالایی حذف نشد");
            Messages::getInstance()->logError($e);
        }
        $this->reponse->redirect(ResponseRegistery::getInstance()->baseURL . "/dashboard/shopItem/showItem");
    }

}

?>
