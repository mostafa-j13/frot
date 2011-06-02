<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SiteRouter
 *
 * @author mostafa
 */
class SiteRouter extends BaseRouter
{
    //put your code here
    public function route()
    {
        $reg=ResponseRegistery::getInstance();
        $application=Request::getInstance()->getString('application');
        $reg->application=$application;
    }
}
?>
