<?php

class metaInformationClass {

    /**
     * Construct qui gère tout l'execution automatiser à l'instanciation de la class
     * @param type $filename
     * @param type $dir
     */
    public function __construct($filename, $dir = "devForUserFold/") {
        $check = $this->checkGoodFile($filename, $dir);
        if ($check === true) {
            $objVerifyKey = $this->requireVerifyKeyContentClass();
            $objGetContentFile = $this->requireGetContentFileClass($objVerifyKey, $dir, $filename);
            $contentFile = $this->getContent($objGetContentFile);
            $checkSum = $this->definedCheckSum($contentFile, $dir, $filename);
            var_dump($checkSum);
        }
    }
    
    /**
     * Function qui instancie la classe generateKey
     * @return \generateKey
     * @see generateKey()
     */
    private function requireVerifyKeyContentClass() {
        require_once __dir__ . '/../generateKey.php';
        $obj = new generateKey();
        return $obj;
    }

    /**
     * Vérifie que le fichier est le bon part rapport à la clés
     * param \generateKey $obj
     * @param string $filename
     * @param string $dir
     * @return string
     * @see generateKey()
     */
    private function checkGoodFile($obj, $filename, $dir) {

        $check = $obj->verifyKey($filename, $dir);
        return $check;
    }

    /**
     * Function qui instancie la classe getContentFile
     * @param type $dir
     * @param type $filename
     * @return \getContentFile
     */
    private function requireGetContentFileClass($dir, $filename) {
        require_once __dir__ . '/../../basicComponement/manageFile/getContentFile.php';
        $obj = new getContentFile($dir, $filename);
        return $obj;
    }
    
    /**
     * Récupére le contenue du fichier
     * @param \getContentFile $obj
     * @return string
     */
    private function getContent($obj) {
        $contentFile = $obj->returnContent();
        return $contentFile;
    } 
    
    /**
     * Génére un checksum combiner contenue du fichier plus le chemin et nom du fichier
     * @param string $content
     * @param string $dir
     * @param string $filename
     * @return integer
     */
    private function definedCheckSum($content, $dir, $filename) {
        if (is_string($content)) {
            $contentCheckSum = crc32($content);
        } else {
            exit();
        }
        if (is_string($dir . $filename)) {
            $filenameCheckSum = crc32($dir . $filename);
        } else {
            exit();
        }
        return $contentCheckSum + $filenameCheckSum;
    }
}
