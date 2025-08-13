<?php

class extendExceptionMarduk {

        private $messageForUser;
        private $filename;
        private $dir;
        
    public function __construct($filename = "exceptionLog", $dir = "exceptionLog") {
        
        if (strpos($dir, "/") === false) {
            $dir = $dir."/";
        }
        $this->dir = $dir;
        $this->messageForUser = "Une erreur indépendante de notre volonté est survenu, veuillez nous en excuser!";
        $result = $this->isExist($dir, $filename);
        if ($result[1] === false) {
            $this->filename = $this->createFile($filename, __DIR__."/$dir");
        } else {
            $this->filename = $filename.".lg.php";
        }
    }
    
    private function isExist($dir, $filename) {
        require_once 'utilsClass.php';
        return utilsClass::verifyFileIsDir($dir, $filename);
        
    }
    
    private function createFile($filename, $dir) {
        require_once __dir__.'/basicComponement/manageFile/createFile.php';
        $createFile = new createFile($filename, "txt", "log", $dir);
        return $createFile->returnNameFile();
    }
    
    public function unknowException() {
        $unknowException = new unknowException();
        try {
            throw $unknowException; 
        } catch (Exception) {
            
            $this->appendNewExceptionInFile($unknowException->getCode(), $unknowException->getMessage(), $unknowException->getTraceAsString());
        }
    }
    
    private function appendNewExceptionInFile($code, $text, $stringPile){
        date_default_timezone_set('Europe/Paris');
        require_once __dir__.'/basicComponement/manageFile/pushContent.php';
        new pushContent($this->filename, "[".date("Y-m-d H:i:s")."(UTC+2)] $code, $text, $stringPile",null);
    }
    
    
}



/**
 * Convention Error code :
 * 0/null -> Unknow/Not Define
 * 1 - 99 -> file/dir
 * 100 - 199 -> data
 * 200 - 299 -> user
 * 300 - 499 -> security
 * 500 - 999 -> other
 */


class unknowException extends Exception {
    /**
     * Erreur inconnu ou non définis
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     * @code 0 -> Unknow/Not Define
     */
    public function __construct(string $message = "Unknow Error.", int $code = 0, ?\Throwable $previous = null) {
        return parent::__construct($message, $code, $previous);
    }
}

class fileExist extends Exception {
    /**
     * Erreur en cas d'existence du fichier 
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     * @code 1 -> file/dir
     */
    public function __construct(string $message = "File Exist.", int $code =  1, ?\Throwable $previous = null) {
        return parent::__construct($message, $code, $previous);
    }
}
