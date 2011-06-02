<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DashboardController
 *
 * @author mostafa
 */
class DashboardController extends BaseApplicationController
{

    protected function run()
    {
         fb(Session::getInstance()->site_id,'site_id');
         ResponseRegistery::getInstance()->site_id=  Session::getInstance()->site_id;
        $reg = ResponseRegistery::getInstance();
        //$reg->weblog_id = $this->getWeblogId();
        try
        {
            $reg->sub_domain=$this->findWeblogAddress();
            $service = new ServiceController($reg->service);
            $service->perform($reg->task);
        }
        catch (ReflectionException $e)
        {
            throw new EAccessDenied("service : {$reg->service} not found");
        }
    }

    protected function getRouter()
    {
        return new DashboardRouter();
    }

    public function findWeblogAddress()
    {
        $db=Factory::getDBO();
        $sql='SELECT
		    site.id,
                    sub_domain
                 FROM ge_subdomains sub
                 JOIN ge_sites as site
                    ON(sub.site_id=site.id)
                 JOIN ge_users_sites as us
                    ON(site.id=us.site_id)
                 WHERE
                    us.user_id='.intval(Factory::getUser()->id);
	fb(Factory::getUser()->id,'user_id');
        $sub=$db->query($sql)->fetch();
        if($sub)
	{
	    ResponseRegistery::getInstance()->site_id=$sub->id;
            return $sub->sub_domain;
	}

        return false;
    }

}
?>
