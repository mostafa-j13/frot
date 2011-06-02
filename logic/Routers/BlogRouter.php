<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WeblogRouter
 *
 * @author mostafa
 */
class BlogRouter extends BaseRouter
{
    //put your code here
    public function route()
    {
        $input=Request::getInstance();
        ResponseRegistery::getInstance()->service=$input->getString('service');
        ResponseRegistery::getInstance()->task=$input->getString('task');
    }
}
?>
