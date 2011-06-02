<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MainRouter
 *
 * @author mostafa
 */
class MainRouter extends BaseRouter
{

    public function route()
    {
        $reg = ResponseRegistery::getInstance();
        $application = Request::getInstance()->getString('application');
        $reg->application = $application;
    }

}
?>
