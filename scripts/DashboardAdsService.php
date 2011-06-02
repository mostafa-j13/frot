<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class DashboardAdsService extends Service
{

    private $tmpl;

    //put your code here
    public function __construct()
    {
        parent::__construct ();
        $this->tmpl = Template::getInstance('userDashboard.tpl');
    }

    public function Show()
    {
        Factory::getUser()->authorise("ads", ResponseRegistery::getInstance()->site_id);

        $pg = $this->tmpl->initPagination();
        $start = $pg->getCurrentIndex();
        $limit = $pg->getLimit();


        $user_id = Factory::getUser()->id;
        $query = "SELECT ads.*, pack.title as pTitle, pack.max_click as maxClk FROM ck_ads AS ads
                        join ck_packages AS pack
                            ON(pack.id = ads.package_id)
                            WHERE ads.user_id=" .$user_id;

        if ($this->input->getString('search'))
        {
            $search = $this->db->getEscaped($this->input->getString('search'));
            $where = " AND ads.title LIKE '%{$search}%' ";
            if ($this->input->getInt("id"))
            {
                $where .= " AND ads.id='" . $this->input->getInt("id") . "'";
            }
        }
        else if ($this->input->getInt("id"))
        {
            $editWhere .= " AND ads.id=" . $this->input->getInt("id");
            $edits = $this->db->query($query . $editWhere)->fetch();
        }

        $limit_q = " LIMIT {$start},{$limit}";
        $pg->setTotal($this->db->query($query.$where)->count());
        fb($query.$where);
        $list = $this->db->query($query.$where . $limit_q)->fetchAll();

        $dbpackages = $this->db->SimpleSelect("ck_packages","*")->fetchAll();
        $packages = array();
        foreach ($dbpackages as $p)
        {
            $packages[$p->id] = $p->title;
        }
        fb($dbpackages);

        $this->tmpl->assign('packages', $packages);
        $this->tmpl->assign('adslist', $list);
        $this->tmpl->assign('ads', $edits);
        $this->tmpl->loadPage('newAds');
        $this->reponse->setTemplate($this->tmpl);
        $this->reponse->setTitle('ثبت تبلیغ');
    }

    public function Save()
    {
        Factory::getUser()->authorise("ads", ResponseRegistery::getInstance()->site_id);

        try
        {
            if ($this->input->getInt("id"))
                $ads->id = $this->input->getInt("id");
            $ads->title = $this->input->getString("title");
            $ads->url = $this->input->getString("url");
            $ads->img = $this->input->getString("img");
            $ads->package_id = $this->input->getInt("package");
            $ads->user_id = Factory::getUser()->id;
            $ads->status = "pending";
            $this->db->StoreObject("ck_ads", $ads);
            Messages::getInstance()->logSuccess('عملیات با موفقیت انجام شد');
        }
        catch (Exception $ex)
        {
            Messages::getInstance()->logError('هیچ تبلیغی ثبت نشد');
        }
        $this->reponse->redirect(ResponseRegistery::getInstance()->baseURL . "/dashboard/ads/show");
    }

    public function edit()
    {
        $this->Show();
    }

    public function Delete()
    {
        Factory::getUser()->authorise("ads", ResponseRegistery::getInstance()->site_id);

        try
        {
            $this->db->delete("ck_ads", $this->input->getInt("id"));
            Messages::getInstance()->logSuccess('تبلیغ مورد نظر  با موفقیت حذف شد');
        }
        catch (Exception $ex)
        {
            Messages::getInstance()->logError('هیچ تبلیغی حذف شد');
        }

        $this->reponse->redirect(ResponseRegistery::getInstance()->baseURL . "/dashboard/ads/show");
    }

}

?>
