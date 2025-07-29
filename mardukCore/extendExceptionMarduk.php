<?php

class extendExceptionMarduk {

    public function __construct() {
        
    }

    public function isNotInteger($value) {
        if (is_integer($value)) {
            return [$value, true];
        } else {

            try {
                throw new isNotInteger();
            } catch (Exception) {
                return [null, false];
            }
        }
    }
    
    public  function isPointerArrayPossible($pointerWillArray, $array) {
        if ($pointerWillArray >= 0 && $pointerWillArray[0] < count($array)) {
            return [$pointerWillArray[0], true];
        } else {
            try {
                throw new isNotPointerArrayPossible;
            } catch (Exception) {
                return [null, false];
            }
        }
    }
}

class isNotInteger extends \Exception {
    
}

class isNotPointerArrayPossible extends \Exception {
    
}
