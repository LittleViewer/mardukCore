<?php
#use for test if your use for really create project
require_once 'mardukCore/extendExceptionMarduk.php';
require_once 'mardukCore/securityComponement/generateKey.php';

$extendException = new extendExceptionMarduk();

$extendException->unknowException();

