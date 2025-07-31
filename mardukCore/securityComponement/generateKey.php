<?php

require_once '/var/www/html/mardukCore/vendor/autoload.php';

use Dotenv\Dotenv;

class generateKey {

    /**
     * Classe contenent un processus visant assurer de l'authencité de fichier de votre projet auprès des composant fonctionelle de notre framework
     * Ainsi une clès d'authenticité mixer entre nom du fichier et mot de pass définis dans les variable d'environnement, inséré dans le nom du fichier nous permettra de valider que se fichier est valide
     * Nous permettans d'éviter que les automatisme du framwork soit exploiter part des attaquant utilisant des injections part upload de fichier
     * Nota: Se mécanisme et tout se du framework ne doivent pas être seule sécurité mais aussi combiner à la protection du serveur de plus, nous recommandons que votre mot de passe dans les variable d'environnement suivent les recommandation en vigeur de l'ANSSI voir les dépasse largement
     * PS: Veuillez ne pas changer votre password sans retirer les clès des nom des fichier authentifier et d'en regénéré de nouvelle.
     * @author LittleViewer
     * @version 1.0.0
     * @see 
     */
    
    private $encryptionKey;

    /**
     * Gère tout la première partie de la classe composer de function privé
     * @param string $stringUnchiffred
     */
    public function __construct($stringUnchiffred = null) {

        if (!is_null($stringUnchiffred)) {
            $this->findEnvKey();
            $this->chiffredPageDev($stringUnchiffred);
        }
    }

    /**
     * Récupére la clès de l'utilisateur qu'i l'as définit dans sont variable d'environonnement dans le fichier enfant de se fichier thisdir/env,
     * La récupéré de la variables/clès est géré part Dotenv pour des question de simplificité et efficacité
     * @todo Internaliser la récupéré de manière sécurisé et privé de la variables d'environnement afin d'exclure la dépendance
     * @throws Exception
     */
    private function findEnvKey() {

        $dotenv = Dotenv::createImmutable(__DIR__ . "/env");
        $dotenv->safeLoad();
        $encryptionKey = $_ENV['APP_SECRET'] ?? throw new Exception("Clé manquante");
        $this->encryptionKey = $encryptionKey;
    }

    /**
     * Génération de la clès [nomfichier].dev.php+[clès issue des variable d'environnement]
     * @todo Ajouter une vérification de la clès quant à sa supériotité des recommandation de l'ANSSI
     * @param string $stringUnchiffred
     * @return string
     */
    private function chiffredString($stringUnchiffred) {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

        $textChiffred = openssl_encrypt($stringUnchiffred, 'aes-256-cbc', $this->encryptionKey, 0, $iv);

        $textEncode = base64_encode($iv."thisnotgoodofattemptodecryptthistext".$textChiffred);
        return $textEncode;
    }

    /**
     * Insertion de clès vérification du fichier au nom [nom en clair].[nom chiffrer].dev.php
     * @param string $stringUnchiffred
     */
    public function chiffredPageDev($stringUnchiffred) {
        $explodePath = explode("/", $stringUnchiffred);
        if (count($explodePath) === 2) {
            $arrayPath = explode(".", $explodePath[1]);
            if ($arrayPath[2] === "php" && count($arrayPath) === 3) {
                $stringChiffred = $this->chiffredString($stringUnchiffred);
                $pathNewNotFolder = $arrayPath[0] . "." . $stringChiffred . ".dev.php";
                $pathNew = $explodePath[0] . "/" . $pathNewNotFolder;

                $keyPossible = array_search($explodePath[1], scandir($explodePath[0] . "/"));

                if ($keyPossible != false) {

                    rename($stringUnchiffred, "$explodePath[0]/" . $pathNewNotFolder);
                } else {
                    echo "Clés déjà inséré!";
                }
            }
        }
    }
    
    /**
     * Vérifie la clès dans le nom du fichier afin de s'assurer de sa validité
     * @param stirng $nameEncrypted
     * @param string $dir
     * @return bool
     */
    public function verifyKey($nameEncrypted,$dir="devForUserFold/",) {
        $this->findEnvKey();
        $arrayNameEncrypted = explode(".", $nameEncrypted);
        
        if (count($arrayNameEncrypted) === 4 && $arrayNameEncrypted[2] === "dev" && $arrayNameEncrypted[3] === "php") {
            $ivAndKey = explode("thisnotgoodofattemptodecryptthistext",(base64_decode($arrayNameEncrypted[1])));
            $uncryptKey = openssl_decrypt($ivAndKey[1], 'aes-256-cbc', $this->encryptionKey,0,$ivAndKey[0]);
            if($uncryptKey === $dir.$arrayNameEncrypted[0].".dev".".php") {
                unset($uncryptKey);
                return true;
            } else{
                unset($uncryptKey);
            }
            
            
        } else {
            echo "Bad file format!";
        }
    }
}
