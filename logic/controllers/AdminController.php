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
class AdminController extends BaseApplicationController
{

    protected function run()
    {
        $reg = ResponseRegistery::getInstance();
        //$reg->weblog_id = $this->getWeblogId();
        try
        {
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
        return new AdminRouter();
    }
}
?>
