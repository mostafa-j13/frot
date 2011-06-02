<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WeblogController
 *
 * @author mostafa
 */
class BlogController extends BaseApplicationController
{
    //put your code here
    protected function run()
    {
        $reg=ResponseRegistery::getInstance();
        $reg->weblog_id=$this->getWeblogId();
        try{
            $service=new ServiceController($reg->service);
            $service->perform($reg->task);
        }
        catch(ReflectionException $e)
        {
               throw new EAccessDenied("service : {$reg->service} not found");
        }
    }

    private function getWeblogId()
    {
	fb('ssss',  FirePHP::TRACE);
        $ob= Factory::getDBO()->SimpleSelect('wb_weblogs','id',
                array("site_id"=>ResponseRegistery::getInstance()->site_id))->fetch();
	fb($ob,'admin');
        if($ob)
            return intval($ob->id);
        else
            return 0;

    }
    protected function getRouter()
    {
        return new BlogRouter();
    }
}
?>
