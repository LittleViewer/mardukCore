<?php

class pushContent {

    public function __construct($filename, $content = null, $path = "devForUserFold/") {
        $handle = $this->openFile($filename, $path);
        
        if (!is_null($content) && is_array($content)) {
            echo "Error with content";
            exit();
        } else {
            
            $this->writeFile($handle, $content);
            $this->closeStreamFile($handle);
        }
    }

    private function openFile($filename, $path) {
        $handle = fopen($path . $filename, "a");
        return $handle;
    }

    private function writeFile($handle, $content) {
        fwrite($handle, ($content . "\n"));
    }

    private function closeStreamFile($handle) {
        fclose($handle);
    }
}
