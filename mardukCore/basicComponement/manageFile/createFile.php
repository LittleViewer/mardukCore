<?php

class createFile {

    private $nameFile;

    /**
     * Construct automatise l'ensemble de la classes des sont appel
     * @param string $filename
     * @param string $willExtension
     * @param string $usageFile
     * @param string $dir
     */
    public function __construct($filename, $willExtension = "null", $usageFile = "userDevelopment", $dir = "devForUserFold/") {
        $arrayExtensionAllow = $this->extensionAllow();
        $isValidateFormat = $this->validateExtension($willExtension, $arrayExtensionAllow);
        if ($isValidateFormat[1] === false) {
            echo $isValidateFormat[0];
            exit();
        } else {
            $formlizeExtension = $this->formatExtension($usageFile, $isValidateFormat[0]);

            if ($formlizeExtension[2] === false) {
                echo $formlizeExtension[0];
                exit();
            } else {
                $isExistFile = $this->isFileExist($dir, $filename);
                if ($isExistFile[1] === false) {
                    exit();
                } else {
                    if (count(explode(".", $filename)) === 1) {
                        echo count(explode(".", $filename))."<br>";
                    } else {
                        $this->createFile($dir . $filename . $formlizeExtension[0]);
                    }
                }
            }
        }
    }

    /**
     * Function qui définit dans un array les extension autoriser part le framework 
     * @return array
     */
    private function extensionAllow() {
        return ["php", 'html', "css", "json", "xlm", "md", "txt"];
    }

    /**
     * Function si la function voulu part l'autorisateur est accepter part le framework
     * @param string $userWillExtension
     * @param array $arrayExtensionAllow
     * @return array
     */
    private function validateExtension($userWillExtension, $arrayExtensionAllow) {
        $arrayExtensionWill = explode(".", $userWillExtension);
        foreach ($arrayExtensionAllow as $extensionWill) {
            if (array_search($extensionWill, $arrayExtensionWill) === false) {
                
            } else {
                return [$extensionWill, true];
            }
        }
        return ["Bad Format!", false];
    }

    /**
     * Function qui mets en place la formalisation .[sous extension (définit sont usage)].[extension du fichier]
     * @param string $usageFile
     * @param string $extensionSimple
     * @return array
     */
    private function formatExtension($usageFile, $extensionSimple) {
        if ($usageFile === "userDevelopment") {
            $subExtension = "dev";
            return [".$subExtension.$extensionSimple", $subExtension, true];
        } elseif ($usageFile === "metaData" && $extensionSimple === "json") {
            $subExtension = "mdt";
            return [".mdt.$extensionSimple", $subExtension, true];
        } else {
            return ["No Defined Use", null, false];
        }
    }

    /**
     * Vérifie que le fichier n'existe déjà pas dans le dossier où il doit être créée quelque soit l'extension et la sous extension
     * Evite dans le fichier voulu le masquage d'un fichier malveillant derrière un fichier légitime
     * @param array $arrayExtensionAllow
     * @param string $dir
     * @param string $filname
     * @param string $subExtension
     * @return array
     * @todo étendre la vérification à tout les dossier du framework
     */
    public function isFileExist($dir, $filename) {
        if (!is_dir($dir)) {
            return ["File Not Exist!", true];
        } else {
            $arrayDirFile = scandir($dir);
            foreach ($arrayDirFile as $file) {
                $arrayFile = explode(".", $file);
                if ($arrayFile[0] === $filename) {
                    return ["File Exist!", false];
                }
            }
            return ["File Not Exist!", true];
        }
    }

    /**
     * Function qui créé le fichier et gère sont authentification auprès du système
     * @param string $dir
     * @param string $nameFile
     * @param string $extension
     */
    private function createFile($path) {
        include_once __dir__ . '/../../securityComponement/generateKey.php';
        fopen($path, "a");
        
        $this->nameFile = $path;
    }

    public function returnNameFile() {
        return $this->nameFile;
    }
}
