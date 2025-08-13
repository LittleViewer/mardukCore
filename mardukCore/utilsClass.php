<?php

class utilsClass {
    
    public static function verifyFileIsDir($dir, $filename) {
        $result = ["not Exist", False];
        
        if (is_readable($dir.$filename)) {
             return ["Exist", true];
        } else {
             $arrayFilename = explode(".", $filename);
             $arrayDir = scandir(__DIR__."/$dir");
        }
        
       
        
        if (count($arrayFilename) === 4) {
            foreach ($arrayDir as $file) {
                $fileArray = explode(".", $file);
                if ($fileArray[0] === $arrayFilename[0]) {
                    return ["Exist", true];
                }
            }
        }
        return $result;
    }
}
