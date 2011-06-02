<?php

class FrotelController extends BaseController {
    
    public function __construct() {
        ResponseRegistery::getInstance();
    }

    protected function run() {
        $response = ResponseRegistery::getInstance();
        $controller = $response->controller;
        $ctrl = $this->loadClass(ucfirst($controller) . 'Controller');
        $ctrl->execute();
    }

    protected function getRoueter() {
        return new FrotelRouter();
    }

    protected function getRouter() {
        return new FrotelRouter();
    }

    private function loadClass($className) {
        $class = new ReflectionClass($className);
        if ($class) {
            $base = new ReflectionClass('BaseController');
            if ($class->isSubclassOf($base)) {
                return $class->newInstance();
            } else {
                throw new EAccessDenied("Class {$class} not sub class of {$base}");
            }
        } else {
            throw new EClassNotFound("class :{$className} NotFound");
        }
    }

}