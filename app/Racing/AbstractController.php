<?php
 
namespace Racing;

use Racing\FlashBag;
use Twig\Environment;
use Twig\Loader\FilsystemLoader;
  
 abstract class AbstractController
 {
     private $templateEngine;
  
     public function __construct() 
     {
         $loader = new \Twig\Loader\FilesystemLoader(dirname(dirname(__DIR__)) . '/templates');
         $this->templateEngine = new \Twig\Environment($loader);
         $this->flashbag = new FlashBag();
     }

    /**
     * Getter pour flashBag
     */

    protected function flash()
    {
        return $this->flashbag;
    }

  
  
     protected function render($view, $vars = [])
     {
         return $this->templateEngine->render($view.'.html.twig', $vars);
     }

     protected function redirectToRoute($url)
     {
         header('location:'.$url);
         exit();
     }
 
 }
 