<?php

class directoryRestrictiveConfigure {
    
    /**
     * L'objectif est de mettre clès en mains à l'utilisateur l'activation d'une directive restrictive via mot de passe dans un object de sécurisation ses classe d'intrusion via injectif de fichier empéchent sans le mot de passe l'execution d'un fichier potentiellement malveillant
     * Cette action vas de paire avec la génération de clès authenticité
     * Nota: Nous recommandons fortement à l'utilisateur de l'effectuer avant la première mise en production du projet
     * @author LittleViewer
     * @version 1.0.0 
     * @see generateKey()
     */
    
    /**
     * Fournis clès en mains la mise en place d'une directive Apache empêchent l'acce via web à des sous dossier (nous conseillons se contenant vos classe pour vous protégé d'injection de fichier malveillant executer hors de environnement du framework via lien direct)
     * @param string $directory
     * @param string $authType
     * @param string $authName
     */
    
    public function __construct($directory = 'class/', $authType = 'Basic', $authName = 'Restrictive Access') {
        $dirWithNotBackSlash = $this->dirWithNotBackSlash($directory);
        $filename = $dirWithNotBackSlash . "DirectoryRestrectiveByMardukCore.conf";
        $checkNotExist = $this->scanDirVerifyDoNotExist($filename);
        if ($checkNotExist[0] === false) {
            exit();
        } else {
            $handleFile = $this->createFile($filename, $checkNotExist);
            $this->pushContentInFile($handleFile, $authType, $authName, $dirWithNotBackSlash);
            $this->closeConnectionWithFile($handleFile, $filename);
        }
    }
    
    /**
     * Supprime le slash inverser du lien du fichier
     * @param string $dir
     * @return string
     */
    private function dirWithNotBackSlash($dir) {
        if (is_string($dir)) {
            return explode("/", $dir)[0];
        } else {
            echo "Bad format :" . gettype($dir) . " !";
            exit();
        }
    }
    
    /**
     * Vérifie que le fichier n'existe pas dans le fichier destination : /etc/apache2/conf-available/
     * string type $filename
     * @return array
     */
    private function scanDirVerifyDoNotExist($filename) {
        $arrayDirectory = scandir("/etc/apache2/conf-available/");
        if (array_search($filename, $arrayDirectory) === false) {
            return [true, "fileNotExist"];
        } else {
            echo "The restriction file exists!";
            return [false, "fileExist"];
        }
    }
    
    /**
     * Créée le fichier dans un fichier d'attente
     * @param string $filename
     * @param array $checkNotExist
     * @return stream
     */
    private function createFile($filename, $checkNotExist = false) {
        if ($checkNotExist[0] === true) {
            $handle = fopen(__dir__ . "/directoryAwaitMove/$filename", 'w');
            return $handle;
        }
    }
    /**
     * Envoie le contenue de la directory dans le fichier créée
     * @param stream $handle
     * @param string $authType
     * @param string $authName
     * @param string $dir
     */
    private function pushContentInFile($handle, $authType, $authName, $dir) {
        $content = "<Directory /var/www/html/mardukCore/$dir>\nAuthType $authType\nAuthName '$authName'\n" .
                "AuthUserFile /etc/apache2/mardukCoreClassDev.htpasswd\nRequire valid-user\n</Directory>";
        fwrite($handle, $content);
    }
    
    /**
     * Ferme la liaison avec le fichier et fournit à l'utilisateur un commande à executer en console
     * Nota: Veuillez noter que l'execution dans le shell via une ligne de commande envoyer part l'utilisateur à était préféré afin de ne pas avoir à étendre les droit root à www-data d'une manière qui aurait créée de sérieuse faille pour de potentielle intru
     * @param stream $handle
     * @param string $filename
     */
    private function closeConnectionWithFile($handle, $filename) {
        fclose($handle);
        echo "Please execute this command in shell:<br>".
             "sudo mv ".__DIR__."/directoryAwaitMove/".$filename." /etc/apache2/conf-available/".$filename." && ".
             "sudo a2enconf $filename && ".
             "sudo systemctl reload apache2";
    }
    
    
    /**
     * Permet si l'utilisateur le souhaite de revoir les instruction necessaire pour finaliser l'initialisation de la directory
     * @param string $filename
     * @see closeConnectionWithFile()
     */
    public function informationLaunchDirectoryRestrictive($filename) {
        echo "Please execute this command in shell:<br>".
             "sudo mv ".__DIR__."/directoryAwaitMove/".$filename." /etc/apache2/conf-available/".$filename." && ".
             "sudo a2enconf $filename && ".
             "sudo systemctl reload apache2";
    }
}
