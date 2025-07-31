<?php


require_once 'mardukCore/securityComponement/generateKey.php';

$keyGestion = new generateKey("");
$keyGestion->verifyKey("page1.nu1kYYrd9Hw3y9y7rf0QoXRoaXNub3Rnb29kb2ZhdHRlbXB0b2RlY3J5cHR0aGlzdGV4dGxzcEh1WTdBcUhSdlJNQ2FIR2FZcWlGRVRwZFBXTXo1Q0EwYThtYUo4K009.dev.php"); echo "  <br>";

require_once 'mardukCore/autoloading_include.php';

$autoloadingGestion = new autoloading_include("devForUserFold");

$a = new ($autoloadingGestion->executeInstance()[0]);

$a->hello();
