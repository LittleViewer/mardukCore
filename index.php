<?php


require_once 'mardukCore/securityComponement/generateKey.php';
//$generateKey = new generateKey("devForUserFold/utilitary_class.dev.php");


require_once 'mardukCore/autoloading_include.php';

$autoloader = new autoloading_include("devForUserFold/");

$codeClass = $autoloader->executeInstance();
var_dump($codeClass);

$test = new $codeClass[1];




 

