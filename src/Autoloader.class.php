<?php
declare(strict_types = 1);
namespace AppApiRest;

/**
 * Auto require des class et interface Dossier
 */
class Autoloader {
    /**
     * Lancement de l'autoloader
     */
    public static function register() {
        spl_autoload_register(array(__CLASS__, 'goAutoload'));
    }

    /**
     * Code a executé lors d'une demande de chargement de fichier
     * 
     * @param string $class
     */
    public static function goAutoload($class) {
       
        $t      = explode('\\', $class);
        $nbElem = count($t);
        $class  = $t[$nbElem-1];
        
        $t = explode('/', $_SERVER['PHP_SELF']);
        unset($t[0]);
        $root = './';
        for($i = 1; $i < count($t); $i++) {
            $root .= '../';
        }
        
        // $chemin = $root.'foot/src/';
        $chemin = $root.'world_cup/src/';
        Autoloader::autoload($chemin, $class, false);
    }

    /**
     * Code 
     */
    public static function autoload($chemin, $class, $trouvee) {
        
       
        $listDossier = scandir($chemin);
        if(is_array($listDossier) === true) {
            foreach($listDossier as $nameDir) {
                if(in_array($nameDir, array('.','..')) === false) {
                    if(is_dir($nameDir) === false) {
                        if(in_array($nameDir,array($class.'.php', $class.'.class.php', $class.'.interface.php'))) {
                            require_once $chemin.$nameDir;
                        }
                    }
                }
            }
            foreach($listDossier as $nameDir) {
                if(in_array($nameDir, array('.','..')) === false) {
                    $cheminBis = $chemin.$nameDir.'/';
                    if(is_dir($cheminBis)) {
                        Autoloader::autoload($cheminBis, $class, $trouvee);
                    }
                }
            }
        }
    }
}