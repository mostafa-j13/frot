<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ActionController
 *
 *
 *
 *
 *
 *
 *
 *
 *إ
 * @author mostafa
 */
class ServiceController {
    //put your code here
   /**
    *
    * @var WebScript
    */
   private $ctrl;

   private $action;
   
   public function  __construct($action)
   {
       $this->action=ucfirst($action).'Service';
       $this->ctrl=$this->loadClass($this->action);
       
   }

   public function perform($task)
   {
       try
       {
            $method = new ReflectionMethod($this->action, $task);

            $method->invoke($this->ctrl);
       }
       catch(ReflectionException $e)
       {
           throw new EAccessDenied("task not found {$this->action}::{$task}");
       }

   }

   private function loadClass($className)
   {
           $class = new ReflectionClass($className);
           if($class)
           {
                   $base= new ReflectionClass('Service');
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
