<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class AdminAdsService extends Service
{

    private $tmpl;

    //put your code here
    public function __construct()
    {
        parent::__construct ();
        $this->tmpl = Template::getInstance('adminDashboard.tpl');
    }

    public function Show()
    {
        Factory::getUser()->authorise("admin", ResponseRegistery::getInstance()->site_id);

        $pg = $this->tmpl->initPagination();
        $start = $pg->getCurrentIndex();
        $limit = $pg->getLimit();


        $query = "SELECT * FROM ge_ads AS ads";

        if ($this->input->getString('search'))
        {
            $search = $this->db->getEscaped($this->input->getString('search'));
            $where = " WHERE title LIKE '%{$search}%' ";
            if ($this->input->getInt("id"))
            {
                $where .= " AND id='" . $this->input->getInt("id") . "'";
            }
        }
        else if ($this->input->getInt("id"))
        {
            $editWhere .= " WHERE id=" . $this->input->getInt("id");
            $edits = $this->db->query($query . $editWhere)->fetch();
        }

        $limit_q = " LIMIT {$start},{$limit}";
        $pg->setTotal($this->db->query($query)->count());
        fb($query);
        $list = $this->db->query($query . $limit_q)->fetchAll();

        $this->tmpl->assign('adslist', $list);
        $this->tmpl->assign('ads', $edits);
        $this->tmpl->loadPage('adminAds');
        $this->reponse->setTemplate($this->tmpl);
        $this->reponse->setTitle('پیوندهای روزانه');
    }

    public function Save()
    {
        Factory::getUser()->authorise("admin", ResponseRegistery::getInstance()->site_id);

        try
        {
            if ($this->input->getInt("id"))
                $ads->id = $this->input->getInt("id");
            $ads->title = $this->input->getString("title");
            $ads->url = $this->input->getString("url");
            $ads->img = $this->input->getString("img");
            $ads->max_visit = $this->input->getInt("maxShow");
            fb($ads, "ksdjakldjas");
            $this->db->StoreObject("ge_ads", $ads);
            Messages::getInstance()->logSuccess('عملیات با موفقیت انجام شد');
        }
        catch (Exception $ex)
        {
            Messages::getInstance()->logError('هیچ تبلیغی ثبت نشد');
        }
        $this->reponse->redirect(ResponseRegistery::getInstance()->baseURL . "/admin/ads/show");
    }

    public function edit()
    {
        $this->Show();
    }

    public function Delete()
    {
        Factory::getUser()->authorise("admin", ResponseRegistery::getInstance()->site_id);

        try
        {
            $this->db->delete("ge_ads", $this->input->getInt("id"));
            Messages::getInstance()->logSuccess('تبلیغ مورد نظر  با موفقیت حذف شد');
        }
        catch (Exception $ex)
        {
            Messages::getInstance()->logError('هیچ تبلیغی حذف شد');
        }

        $this->reponse->redirect(ResponseRegistery::getInstance()->baseURL . "/admin/ads/show");
    }

}

?>
