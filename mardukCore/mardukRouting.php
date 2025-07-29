<?php

class mardukRouting {
    
    public function __construct() {
        $this->runRoutingUserPage();
        $this->autoLoaderInclude();
    } 
    
    private function runRoutingUserPage() {
        
    }
    
    private function autoLoaderInclude() {
        require_once 'autoloading_include.php';
        return new autoloading_include();
    }
    
    
    
}

class autoLoadingException extends \Exception {
    
}