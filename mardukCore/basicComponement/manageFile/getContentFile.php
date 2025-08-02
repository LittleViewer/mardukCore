<?php

class getContentFile {
    /**
     * Une class qui permet de lire un fichier
     * @author LittleViewer
     * @version 1.0.0 
     */
    
    private $content;
    /**
     * Construct qui gère toute l'instanciation interne et automatise de la classe à sont appel
     * @param string $dir
     * @param string $filename
     */
    public function __construct($dir, $filename) {
        if (is_readable($dir . $filename)) {
            $handle = $this->openStreamFile($dir, $filename);
            $this->getContentFile($handle, $dir, $filename);
            $this->closeStreamFile($handle);
        }
    }
    
    /**
     * Function qui gère l'ouverture du fichier seulement en lecture
     * @param string $dir
     * @param string $filename
     * @return obj
     */
    private function openStreamFile($dir, $filename) {
        $handle = fopen($dir . $filename, "r");
        return $handle;
    }
    
    /**
     * Function qui lit le texte et le mets dans une variable
     * @param obj $handle
     * @param string $dir
     * @param string $filename
     */
    private function getContentFile($handle, $dir, $filename) {
        $content = fread($handle, filesize($dir . $filename));
        $this->content = $content;
    }
    
    /**
     * Function qui ferme le fichier
     * @param obj $handle
     */
    private function closeStreamFile($handle) {
        fclose($handle);
    }
    
    /**
     * Function qui retourne le contenu du fichier
     * string type
     */
    public function returnContent() {
        if (is_null($this->content)) {
            echo "No Content!";
            exit();
        } else {
            return $this->content;
        }
    }
}
