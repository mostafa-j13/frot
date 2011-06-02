<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SiteController
 *
 * @author mostafa
 */
class SiteController extends BaseController
{
    //put your code here
    protected function run()
    {
       $reg=ResponseRegistery::getInstance();
       $application = $reg->application;
       try
       {
       $ctrl=$this->loadClass(ucfirst($application).'Controller');
       }
       catch (ReflectionException $e)
       {
           throw new EAccessDenied("application not found '{$application}'");
       }
       $ctrl->execute();
    }


    /**
     *
     * @return SiteRouter
     */

    protected function getRouter()
    {
        return new SiteRouter();
    }


    private function loadClass($className)
	{
		$class = new ReflectionClass($className);
		if($class)
		{
			$base= new ReflectionClass('BaseApplicationController');
			if($class->isSubclassOf($base))
			{
				return $class->newInstance();
			}
			else
			{
				throw new EAccessDenied("Class {$class} not sub class of {$base}");
			}
		}
		else
		{
			throw new EClassNotFound("class :{$className} NotFound");
		}
	}
}
?>
