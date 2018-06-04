<?php
declare(strict_types = 1);
namespace Connexion;
/**
 * Class Mere qui gere la connexion a la base
 */
class Database {
    /**
     * @var object $_instance : contien l'instance de la connexion a la base
     */
    protected static $_instance;
    /**
     * @var string $_typeClass : quel class on utilise pour la connexion
     */
    protected static $_typeClass;
    /**
     * @var int nombre de lignes affectées
     */
    public static $_nbLigne;
    /**
     * @var int identifiant de la derniére ligne insérée ou la valeur d'une séquence
     */
    public static $_lastInsertId;
    /**
     * @var object connexion
     */
    protected $_connexion;
    /**
     * @var string $host
     */
    protected $DB_host     = "";
    /**
     * @var string $driver
     */
    protected $DB_driver   = "";
    /**
     * @var int $port
     */
    protected $DB_port     = "";
    /**
     * @var string $database
     */
    protected $DB_database = "";
    /**
     * @var string $user
     */
    protected $DB_user     = "";
    /**
     * @var string $passwoard
     */
    protected $DB_password = "";
    /**
     * @var string $passwoard
     */
    protected $showMsgError = false;

    /**
     * initialisation de la connexion a la base de donnée
     *
     * @param ConfigDataBase|null $ConfigDataBase
     * @return object connexion base
     */
    public static function init($ConfigDataBase=null) {

        $listTypeConnexion = array('PDODataBase', 'MysqlDataBase', 'MysqliDataBase');
        $typeClass = null;

        if($ConfigDataBase instanceof ConfigDataBase) {
            $typeClass = $ConfigDataBase->getSettings('typeClass');
            if(in_array($typeClass, $listTypeConnexion) === false) {
                $typeClass = null;
            }
            else {
                self::$_typeClass = $typeClass;
            }
        }
        if(empty(self::$_typeClass) === false) {
            switch(self::$_typeClass) {
                case 'PDODataBase' :
                    return PDODataBase::init($ConfigDataBase);
                    break;
                case 'MysqlDataBase' :
                    return MysqlDataBase::init($ConfigDataBase);
                    break;
                case 'MysqliDataBase' :
                    return MysqliDataBase::init($ConfigDataBase);
                    break;
                default :
                    return null;
                    break;
            }
        }
        else {
            return null;
        }
    }

    /**
     * Retourne la connexion a la base
     *
     * @return object $_connexion
     */
    public function connect()  {
        return $this->_connexion ? $this->_connexion : null;
    }

    /**
     * Retourne le nombre de lignes affectées
     * @return bool|int $_nbLigne
     */
    public function getNbLigne() {
        return self::$_nbLigne;
    }

    /**
     * Retourne l'identifiant de la derniére ligne insérée ou la valeur d'une séquence
     * @return bool|int $_lastInsertId
     */
    public function getLastInsertId() {
        return self::$_lastInsertId;
    }

    /**
     * Save l'identifiant de la derniére ligne insérée ou la valeur d'une séquence
     * @param bool|int $_lastInsertId
     */
    public function setLastInsertId($lastInsertId) {
        if(is_numeric($lastInsertId) === true) {
            $lastInsertId = (int)$lastInsertId;
        }
        self::$_lastInsertId = $lastInsertId;
    }

    /**
     * Retoune le code html de l'erreur sql
     * 
     * @param string $req
     * @param array $dataError
     * @return string $codeHtml
     */
    protected function getWarningMsg($req, $dataError) {
        if($this->showMsgError === true) {
            $html = '<div style="font-family:arial;">';
                $html .= '<h3 style="margin-bottom:0;">Erreur dans la requete :</h3>';
                $html .= '<ul style="margin:0;padding:5px;text-align:left;list-style:none;border:2px solid #e08e00;background-color:#ffb22d;border-radius:5px;">';
                    $html .= '<li><b>CODE ERROR  :</b>&nbsp'.$dataError[0].'</li>';
                    $html .= '<li><b>INFOS ERROR :</b>&nbsp;'.$dataError[2].'</li>';
                    $html .= '<li><b>REQUETE :</b><span>&nbsp;'.$req.'</span></li>';
                $html .= '</ul>';
            $html .= '</div>';
        }

        return $html;
    }
}