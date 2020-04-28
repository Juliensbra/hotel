<?php

namespace Racing;

class Kernel 
{
    private $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    public function run()
    {
        $dispatcher = $this->router->setRoutes();
        
        $this->router->runRoute($dispatcher);
    }

}