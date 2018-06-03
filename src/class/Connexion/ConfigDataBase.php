<?php
declare(strict_types = 1);
namespace Connexion;

class ConfigDataBase {
    /**
     * @var array $settings
     */
	private $settings = [];
    /**
     * @var object $_instance
     */
    private static $_instance;

    /**
     * getInstance permet de retourne toujour la meme instance
     * 
     * return Object Config
     */
    public static function getInstance() {
        if(self::$_instance === null) {
            self::$_instance = new Config();
        }
        return self::$_instance;
    }
    
    /**
     * initialisation de la class
	 * @param string $bdd
	 * @param string $root
     */
    public function __construct($bdd='', $root='') {

        //on charge les parametres de connexion a la base
		switch($bdd) {
            case 'netfocus' :
				$this->settings = require $root.'/config/netfocus.php';
				break;
			default :
				$this->settings = [];
		}
    }

    /**
     * Retourne me settings demandé  
     * @var string $var
     * @return string|int|bool
     */
    public function getSettings($var) {
        if(isset($this->settings[$var]) === true) {
            return $this->settings[$var];
        }
        else {
            return false;
        }
    }
}