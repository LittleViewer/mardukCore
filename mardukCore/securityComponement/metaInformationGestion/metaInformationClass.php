<?php

class metaInformationClass {

    /**
     * Construct qui gère tout l'execution automatiser à l'instanciation de la class
     * PS: Si vous souhaiter ouvrir le fichier veuillez le faire via shell afin de ne pas corrompre avec votre IDE les droit des fichier dynamiquement définis
     * @param type $filename
     * @param type $dir
     */
    public function __construct($filename, $dir = "devForUserFold/") {
        $objVerifyKey = $this->requireVerifyKeyContentClass();
        $check = $this->checkGoodFile($objVerifyKey, $filename, $dir);
        if ($check === true) {
            $objGetContentFile = $this->requireGetContentFileClass($dir, $filename);
            $contentFile = $this->getContent($objGetContentFile);
            $checkSum = $this->definedCheckSum($contentFile, $dir, $filename);
            $objParaphrase = $this->requireGetPrivateParaphrase();
            $keyAuthentified = $this->keyVerifyChecksum($objParaphrase, $checkSum, $dir, $filename);
            $jsonEncode = $this->jsonEncode($dir, $filename, $checkSum, $keyAuthentified);
            $filenameWithKey = $this->createFile($filename);
            $this->pushContent($filenameWithKey, $jsonEncode);
        }
    }

    /**
     * Function qui instancie la classe generateKey
     * @return \generateKey
     * @see generateKey()
     * @todo remplace part l'autoload des fichier du framework
     */
    private function requireVerifyKeyContentClass() {
        require_once __dir__ . '/../generateKey.php';
        $obj = new generateKey();
        return $obj;
    }

    /**
     * Function qui vérifie que le fichier est le bon part rapport à la clés
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
     * Function qui retient le contenue du fichier
     * @param \getContentFile $obj
     * @return string
     * @todo remplace part l'autoload des fichier du framework
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

    /**
     * Function qui appel generateKey() pour récupéré la paraphrase utilisateur dans .env
     * @return \generateKey
     * @todo remplace part l'autoload des fichier du framework
     */
    private function requireGetPrivateParaphrase() {
        require_once __dir__ . '/../generateKey.php';
        $obj = new generateKey();
        return $obj;
    }

    /**
     * Function qui génére une clès authenticité 
     * clès = ckeksum + path/filename
     * @param \generateKey $objParaphrase
     * @param integer $checkSum
     * @param string $dir
     * @param string $filename
     * @return string
     */
    private function keyVerifyChecksum($objParaphrase, $checkSum, $dir, $filename) {
        $paraphrase = $objParaphrase->returnDotEnv();
        return hash_hmac('sha3-512', $checkSum . 'thisIsAPrivateKeyThatMustNotBeDecoded' . $dir . $filename, $paraphrase);
    }

    /**
     * Function qui retourne une chaine encoder en JSON
     * @param string $dir
     * @param string $filename
     * @param string $checkSum
     * @param string $keyVerify
     * @return string
     */
    private function jsonEncode($dir, $filename, $checkSum, $keyVerify) {
        return json_encode(["dir" => $dir, "filename" => $filename, "path" => $dir . $filename, "checksum" => $checkSum, "keyVerify" => $keyVerify, "datePlainText" => date("Y-m-d H:i:s"), "dateUnix" => time(), "version" => 1, "describeVersion" => "createFile", "isUse" => true]);
    }

    /**
     * Function qui permet la créatiion du fichier
     * @param string $fileName
     * @param string $dir
     * @return string
     */
    private function createFile($fileName, $dir = "stockageFileMetaInformationDevFold/") {
        require_once __dir__ . '/../../basicComponement/manageFile/createFile.php';
        $arrayfileName = explode(".", $fileName);
        $createFile = new createFile($arrayfileName[0] . '.' . $arrayfileName[1], "json", "metaData", __dir__ . "/" . $dir);
        $createFile->isFileExist(__dir__ . "/" . $dir, $fileName);
        return $createFile->returnNameFile();
    }

    /**
     * Function qui mets la ligne JSON dans le le fichier voulu
     * @param string $fileName
     * @param string $content
     */
    public function pushContent($fileName, $content) {
        require_once __dir__ . '/../../basicComponement/manageFile/pushContent.php';
        $arrayPath = explode("/", $fileName);
        new pushContent($arrayPath[9], $content, __dir__ . "/stockageFileMetaInformationDevFold/");
    }
}
