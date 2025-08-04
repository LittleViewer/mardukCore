<?php


class deleteFile {
    
    private $contentFile;
    
    public function __construct($path = null, $saveData = true) {
        if ($saveData === true && !is_null($path)) {
            $this->getContent($path);
            $this->deleteFile($path);
        } else {
            exit();
        }
        
    }
    
    private function getContent($path) {
        require_once 'getContent.php';
        $arrayPath = explode("/", $path);
        $getContent = new getContentFile($arrayPath[0]."/", $arrayPath[1]);
        $this->contentFile = $getContent->returnContent();
    }
    
    private function deleteFile($path) {
        unlink($path);
    }


    public function returnContent() {
        if (!is_null($this->contentFile)) {
            echo "No content!";
            exit();
        } else {
            return $this->contentFile;
        }
    }
            
}
