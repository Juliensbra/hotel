<?php

namespace App\Controller;
use Racing\AbstractController;

class Home extends AbstractController
{

    public function print() 
    {
        //include dirname(dirname(__DIR__)) . '/templates/home.html.twig';
        return $this->render('home');
    }
}
