<?php

class routingUserPage {

    private $arrayDevPage;
    private $numberDevPage;
    private $extendException;

    public function __construct($dir = "devForUserFold/") {
        require_once 'extendExceptionMarduk.php';
        $this->extendException = new extendExceptionMarduk();
        $this->dirScanSelect($dir);
        $this->numberDevPage();
    }

    private function dirScanSelect($dir) {
        $arrayDir = scandir($dir);
        $goodDevPage = [];
        foreach ($arrayDir as $pageSingle) {

            $arrayPageSingle = explode(".", $pageSingle);
            if (count($arrayPageSingle) === 3 && $arrayPageSingle[2] === "php") {
                array_push($goodDevPage, $dir . $pageSingle);
            }
        }
        $this->arrayDevPage = $goodDevPage;
    }

    private function numberDevPage() {

        $this->numberDevPage = count($this->arrayDevPage);
    }

    public function willRedirect($will) {

        $willIntegerCheck = $this->extendException->isNotInteger($will);
        if ($willIntegerCheck[1] === false) {
            exit();
        } else {
            $willPossible = $this->extendException->isPointerArrayPossible($willIntegerCheck, $this->arrayDevPage);
        }

        if ($willPossible[1] === false) {
            exit();
        } else {
            $redirectWill = function ($arrayDevPage, $willPossible) {
                include $arrayDevPage[$willPossible[0]];
            };
        }

        return [$redirectWill, $this->arrayDevPage, $willPossible];
    }

    public function returnArrayDevPage() {
        return $this->returnArrayDevPage();
    }
}
