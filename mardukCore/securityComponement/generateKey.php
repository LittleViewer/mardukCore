<?php

require_once '/var/www/html/mardukCore/vendor/autoload.php';

use Dotenv\Dotenv;

class generateKey {

    private $encryptionKey;

    public function __construct($stringUnchiffred = null) {

        if (!is_null($stringUnchiffred)) {
            $this->findEnvKey();
            $this->chiffredPageDev($stringUnchiffred);
        }
    }

    private function findEnvKey() {

        $dotenv = Dotenv::createImmutable(__DIR__ . "/env");
        $dotenv->safeLoad();
        $encryptionKey = $_ENV['APP_SECRET'] ?? throw new Exception("Clé manquante");
        $this->encryptionKey = $encryptionKey;
    }

    private function chiffredString($stringUnchiffred) {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

        $textChiffred = openssl_encrypt($stringUnchiffred, 'aes-256-cbc', $this->encryptionKey, 0, $iv);

        $textEncode = base64_encode($iv . $textChiffred);
        return $textEncode;
      
    }
    
    public function chiffredPageDev($stringUnchiffred) {
        $explodePath = explode("/", $stringUnchiffred);
        if (count($explodePath) === 2) {
            $arrayPath = explode(".", $explodePath[1]);
            if ($arrayPath[2] === "php" && count($arrayPath) === 3) {
                $stringChiffred = $this->chiffredString($stringUnchiffred);
                $pathNewNotFolder = $arrayPath[0].".".$stringChiffred.".dev.php";
                $pathNew = $explodePath[0]."/".$pathNewNotFolder;
                
                
                $keyPossible = array_search($explodePath[1], scandir($explodePath[0]."/"));

                
                if ($keyPossible != false) {

                    rename($stringUnchiffred, "$explodePath[0]/".$pathNewNotFolder);
                } else {
                    echo "Clés déjà inséré!";
                }

                
            }
        }
    }
}
