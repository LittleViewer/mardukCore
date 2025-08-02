<?php

class routingUserPage {
    
    /**
     * Un routeur qui vient automatiquement cherche tout les fichier autoriser à être include selon le format [nom][clès].dev.php et à l'utilisateur de choisir quelle fichier il souhaite inclure
     * @author LittleViewer
     * @version 1.0.0 
     */
    
    private $arrayDevPage;
    private $numberDevPage;
    private $extendException;

    
    /**
     * Vise à executer l'ensemble du projet sans pour autant l'executer
     * @param string $dir
     */
    public function __construct($dir = "devForUserFold/") {
        require_once 'extendExceptionMarduk.php';
        $this->extendException = new extendExceptionMarduk();
        $this->dirScanSelect($dir);
        $this->numberDevPage();
    }
    
    
    /**
     * Function qui selectionne tout les fichier vous qui sont dans la formalisation voulu pour les fichier développeur [nom][clès].dev.php
     * @param type $dir
     */
    private function dirScanSelect($dir) {
        $arrayDir = scandir($dir);
        $goodDevPage = [];
        foreach ($arrayDir as $pageSingle) {
            $arrayPageSingle = explode(".", $pageSingle);
            if (count($arrayPageSingle) === 4 && $arrayPageSingle[2] === "dev" && $arrayPageSingle[3] === "php") {
                array_push($goodDevPage, $dir . $pageSingle);
            }
        }
        $this->arrayDevPage = $goodDevPage;
    }
    
    /** 
     * Function qui calcul le nombre de fichier possibles
     */
    private function numberDevPage() {

        $this->numberDevPage = count($this->arrayDevPage);
    }

    
    /**
     * Function qui permet à l'utilisateur de choisir qu'elle redirection il souhaite est vérifie que la requête utilisateur est possible/
     * Et retourne une fonction closer ainsi que les parametre à lui intégré pour lancer le require
     * @param integer $will
     * @return array
     */
    public function willRedirect($will) {
        $willIntegerCheck = $this->extendException->isNotInteger($will);
        if ($willIntegerCheck[1] === false) {
            echo "Bad Format!";
            exit();
        } else {
            $willPossible = $this->extendException->isPointerArrayPossible($willIntegerCheck, $this->arrayDevPage);
        }

        if ($willPossible[1] === false) {
            echo "File not exist";
            exit();
        } else {
            $redirectWill = function ($arrayDevPage, $willPossible) {
                include $arrayDevPage[$willPossible[0]];
            };
        }

        return [$redirectWill, $this->arrayDevPage, $willPossible];
    }
    
    /**
     * Funciton qui retourne pour information utilisateur les fichier qu'il est autoriser à include
     * @return array
     */
    public function returnArrayPageAccept() {
        return $this->arrayDevPage;
    }
}
