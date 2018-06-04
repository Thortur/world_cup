<?php
declare(strict_types = 1);
namespace Connexion;
use \PDO;
/**
 * Class qui gere la connexion a la base via PDO
 */
class PDODataBase extends Database implements iDatabase {

    /**
	 * initialisation de la connexion a la base de donnée
	 *
	 * @param ConfigDataBase|null $ConfigDataBase
	 * @return object Retourne l'instance de la connexion a la base
     */
    public static function init($ConfigDataBase=null) {
        try {
            if (is_null(self::$_instance) || empty(self::$_instance)) {
                self::$_instance = new self($ConfigDataBase);
                return self::$_instance;
			}
			else {
                return self::$_instance;
            }
		}
		catch (Exception $e) {
            return __CLASS__;
        }
    }

	/**
	 * Lors d'un var_dump ou print_r, on affichage pas les variable de connexion a la base
	 */
	public function __debugInfo() {
		$arrayObj = array();
		foreach($this as $var => $value) {
			if(in_array($var, array('DB_host', 'DB_driver', 'DB_port', 'DB_database', 'DB_user', 'DB_password')) === false) {
				$arrayObj[$var] = $value;
			}
		}
		return $arrayObj;
	}

    /**
	 * Constuct de la class
	 * Sauvegarde les donnes pour la connexion a la base,
	 * et etablie la connexion a la base
	 *
	 * @param ConfigDataBase $ConfigDataBase
     */
    public function __construct($ConfigDataBase=null) {
        try {
			if($ConfigDataBase instanceof ConfigDataBase) {
				$this->DB_host      = $ConfigDataBase->getSettings('host');
				$this->DB_driver    = $ConfigDataBase->getSettings('driver');
				$this->DB_port      = $ConfigDataBase->getSettings('port');
				$this->DB_database  = $ConfigDataBase->getSettings('database');
				$this->DB_user      = $ConfigDataBase->getSettings('user');
				$this->DB_password  = $ConfigDataBase->getSettings('password');
				$this->showMsgError = $ConfigDataBase->getSettings('showMsgError');
				//$this->uniqId = uniqId(); //permet de verifie l'objet est declaré une fois
				
				if (is_null($this->_connexion) || empty($this->_connexion)) {
					$dsn = $this->DB_driver.':host='.$this->DB_host.';port='.$this->DB_port.';dbname='.$this->DB_database;
					$this->_connexion = new \PDO($dsn, $this->DB_user, $this->DB_password);
					unset($dsn);
				}
			}
			else {
				echo 'Probleme d\'identifiant pour la connexion a la base de donnée!';
				die;
			}
		} 
		catch (Exception $e) {
            $this->_connexion = $e;
        }
    }

	/**
	 * Exécute une requéte SQL statement et retourne le nombre de lignes affectées
	 *
	 * @param string $requete
	 * @param array|null $listData
	 * @param array|null $parametres
	 * @return array $res
	 */
	public function execStatement($req, $listData=null, $parametres=null) {
		$connect = $this->_connexion->prepare($req);

		if(is_array($listData)) {
			foreach($listData as $variable => $data) {
				$value = $data['value'];
				switch($data['type']) {
					case 'bool' :
						$value = (bool)$value;
						$connect->bindValue($variable, $value, PDO::PARAM_BOOL);
						break;
					case 'int' :
						$value = (int)$value;
						$connect->bindValue($variable, $value, PDO::PARAM_INT);
						break;
					case 'float' :
					case 'double' :
						$value = (string)$value;
						$connect->bindValue($variable, $value, PDO::PARAM_STR);
						break;
					case 'array'  :
					case 'object' :
						$value = json_encode($value);
						$connect->bindValue($variable, $value, PDO::PARAM_STR);
						break;
					case null   :
					case 'null' :
						$connect->bindValue($variable, null, PDO::PARAM_NULL);
						break;
					default :
						$value = (string)$value;
						$connect->bindValue($variable, $value, PDO::PARAM_STR);
						break;
				}
			}
			unset($variable, $data, $value);
		}
		
		$typeRequete = substr($req, 0, 6);
		if(in_array($typeRequete, array('DELETE', 'INSERT', 'UPDATE')) === true) {
			self::$_nbLigne = $connect->execute();
		}
		else {
			$connect->execute();
			self::$_nbLigne = 0;
		}
		unset($typeRequete);

		switch($connect->errorCode()) {
			case '00000' :
				self::setLastInsertId($this->_connexion->lastInsertId());
				return $this->returnResultat($connect, $parametres);
				break;
			case null :
				$dataError = array(
								0 => 'Retour de la fonction NULL',
								1 => '',
								2 => 'Retourne NULL si aucune opération n\'a été exécutée sur la base de données.',
							);
				echo $this->getWarningMsg($req, $dataError);
				break;
			default :
				$dataError = $connect->errorInfo();
				echo $this->getWarningMsg($req, $dataError);
				die;
				return false;
				break;
		}
	}

	/**
	 * Exécute une requéte SQL et retourne le nombre de lignes affectées
	 *
	 * @param string $requete
	 * @param array|null $parametres
	 * @return array $res
	 */
	public function exec($req, $parametres=null) {
		$connect = $this->_connexion->query($req);
		
		switch($this->_connexion->errorCode()) {
			case '00000' :
				self::$_nbLigne = $connect->rowCount();
				self::setLastInsertId($this->_connexion->lastInsertId());
				return $this->returnResultat($connect, $parametres);
				break;
			case null :
				$dataError = array(
								0 => 'Retour de la fonction NULL',
								1 => '',
								2 => 'Retourne NULL si aucune opération n\'a été exécutée sur la base de données.',
							);
				echo $this->getWarningMsg($req, $dataError);
				break;
			default :
				$dataError = $this->_connexion->errorInfo();
				echo $this->getWarningMsg($req, $dataError);
				die;
				return false;
				break;
		}
	}

	/**
	 * Retourne le resultat de la requete au format demandé dans les parametres
	 * 
	 * @param PDOStatement $connect
	 * @param array $parametres
	 * @return any $res
	 */
	public function returnResultat($connect, $parametres) {
		$resRecup = false;
		$res = null;
		if($parametres !== null && isset($parametres['methode']) === true) {
			switch($parametres['methode']) {
				case 'fetchObject' :
					$nameClass = 'stdClass';
					$dataClass = array();

					if(isset($parametres['nameClass']) === true && empty($parametres['nameClass']) === false) {
						$nameClass = $parametres['nameClass'];
					}
					if(isset($parametres['dataClass']) === true && is_array($parametres['dataClass']) === true) {
						$dataClass = $parametres['dataClass'];
					}

					$res = $connect->fetchObject($nameClass, $dataClass);
					$resRecup = true;
					break;
				case 'fetchAll' :
					if(isset($parametres['fetchStyle']) === true) {
						switch($parametres['fetchStyle']) {
							case 'FETCH_BOTH':
								$res = $connect->fetchAll(PDO::FETCH_BOTH);
								$resRecup = true;
								break;
							case 'FETCH_BOUND':
								$res = $connect->fetchAll(PDO::FETCH_BOUND);
								$resRecup = true;
								break;
							case 'FETCH_LAZY ':
								$res = $connect->fetchAll(PDO::FETCH_LAZY);
								$resRecup = true;
								break;
							case 'FETCH_NAMED':
								$res = $connect->fetchAll(PDO::FETCH_NAMED);
								$resRecup = true;
								break;
							case 'FETCH_NUM':
								$res = $connect->fetchAll(PDO::FETCH_NUM);
								$resRecup = true;
								break;
							case 'FETCH_OBJ':
								$res = $connect->fetchAll(PDO::FETCH_OBJ);
								$resRecup = true;
								break;
						}
					}
					break;
				case 'fetch' :
					if(isset($parametres['fetchStyle']) === true) {
						switch($parametres['fetchStyle']) {
							case 'FETCH_BOTH':
								$res = $connect->fetch(PDO::FETCH_BOTH);
								$resRecup = true;
								break;
							case 'FETCH_BOUND':
								$res = $connect->fetch(PDO::FETCH_BOUND);
								$resRecup = true;
								break;
							case 'FETCH_LAZY ':
								$res = $connect->fetch(PDO::FETCH_LAZY);
								$resRecup = true;
								break;
							case 'FETCH_NAMED':
								$res = $connect->fetch(PDO::FETCH_NAMED);
								$resRecup = true;
								break;
							case 'FETCH_NUM':
								$res = $connect->fetch(PDO::FETCH_NUM);
								$resRecup = true;
								break;
							case 'FETCH_OBJ':
								$res = $connect->fetch(PDO::FETCH_OBJ);
								$resRecup = true;
								break;
						}
					}
					break;
				default :
					$res = $connect->fetchAll(PDO::FETCH_ASSOC);
					$resRecup = true;
					break;
			}
		}

		if($resRecup === false) {
			$res = $connect->fetchAll(PDO::FETCH_ASSOC);
		}

		return $res;
	}
}