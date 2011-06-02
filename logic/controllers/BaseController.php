<?php

abstract class BaseController
{

    public function execute()
    {
       
        $this->getRouter()->route();
        $this->run();
    }

    abstract protected function getRouter();

    abstract protected function run();
}