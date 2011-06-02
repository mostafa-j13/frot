<?php

class MainController extends BaseController
{

    protected function run()
    {
        $reg = ResponseRegistery::getInstance();
        $application = $reg->application;
        try
        {
            $ctrl = $this->loadClass(ucfirst($application) . 'Controller');
        }
        catch (ReflectionException $e)
        {
            throw new EAccessDenied("application not found '{$application}'");
        }
        $ctrl->execute();
    }

    /**
     * @return MainRouter
     */
    protected function getRouter()
    {
        return $router = New MainRouter();
    }

    private function loadClass($className)
    {
        $class = new ReflectionClass($className);
        if ($class)
        {
            $base = new ReflectionClass('BaseApplicationController');
            if ($class->isSubclassOf($base))
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