<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DashboardRouter
 *
 * @author mostafa
 */
class DashboardRouter extends BaseRouter
{
    public function route()
    {
        $input=Request::getInstance();
        ResponseRegistery::getInstance()->service=$input->getString('service');
        ResponseRegistery::getInstance()->task=$input->getString('task');
    }
}
?>
