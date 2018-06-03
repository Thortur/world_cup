<?php
declare(strict_types = 1);
namespace Connexion;

/**
 * Auto require des class et interface Dossier
 */
class Autoloader {
    /**
     * Lancement de l'autoloader
     */
    public static function register() {
        spl_autoload_register(array(__CLASS__, 'autoLoad'));
    }

    /**
     * Code a executé lors d'une demande de chargement de fichier
     * 
     * @param string $class
     */
    public static function autoLoad($class) {
        $t      = explode('\\', $class);
        $nbElem = count($t);
        $class  = $t[$nbElem-1];
        
        $t = explode('/', $_SERVER['PHP_SELF']);
        unset($t[0]);
        $root = './';
        if($t[1] !== 'zz_christophe') {
            for($i = 1; $i < count($t); $i++) {
                $root .= '../';
            }
        }
        unset($t, $i);

        if($class === 'ConfigDataBase') {
            $file = $root.'fonctions/'.__NAMESPACE__.'/'.$class.'.php';
            if($file !== false) {
                require_once $file;
            }
        }
        else {
            $file = $root.'fonctions/'.__NAMESPACE__.'/class/'.$class.'.class.php';
            if(file_exists($file) === false) {
                $file = $root.'fonctions/'.__NAMESPACE__.'/interface/'.$class.'.interface.php';
                if(file_exists($file) === false) {
                    $file = false;
                }
            }
            if($file !== false) {
                require_once $file;
            }
        }
    }
}