<?php

require_once 'mardukCore/routingUserPage.php';

$routingPage = new routingUserPage();

$arrayRoutingCodeExecute = $routingPage->willRedirect(10000);

$routingCodeExcute = $arrayRoutingCodeExecute[0];

$routingCodeExcute($arrayRoutingCodeExecute[1], $arrayRoutingCodeExecute[2]);