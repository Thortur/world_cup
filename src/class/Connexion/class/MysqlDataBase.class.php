<?php
declare(strict_types = 1);
namespace Connexion;
require_once "PHP7.php";
class MysqlDataBase extends Database implements iDatabase {
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
	 * Constuct de la class
	 * Sauvegarde les donnes pour la connexion a la base,
	 * et etablie la connexion a la base
	 *
	 * @param ConfigDataBase $ConfigDataBase
     */
	public function __construct($ConfigDataBase=null) {
		try {
			if($ConfigDataBase instanceof ConfigDataBase) {
				$this->DB_host     = $ConfigDataBase->getSettings('host');
				$this->DB_driver   = $ConfigDataBase->getSettings('driver');
				$this->DB_port     = $ConfigDataBase->getSettings('port');
				$this->DB_database = $ConfigDataBase->getSettings('database');
				$this->DB_user     = $ConfigDataBase->getSettings('user');
				$this->DB_password = $ConfigDataBase->getSettings('password');
				//$this->uniqId = uniqId(); //permet de verifie l'objet est declaré une fois
				
				if (is_null($this->_connexion) || empty($this->_connexion)) {
					$this->_connexion = mysqli_connect($this->DB_host, $this->DB_user, $this->DB_password, $this->DB_database);
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
	 * Execute la requete
	 *
	 * @param string $requete
	 * @param array|null $data
	 * @param array|null $parametres
	 * @return array $res
	 */
	public function execStatement($req, $data=null, $parametres=null) {
		//$req = str_replace('SELECT', 'PREPARE', $req);
		$res = $this->_connexion->query($req);
		return $this->returnResultat($res, $parametres);
	}

	/**
	 * Execute la requete
	 *
	 * @param string $requete
	 * @param array|null $data
	 * @param array|null $parametres
	 * @return array $res
	 */
	public function exec($req, $data=null, $parametres=null) {
		$res            = $this->_connexion->query($req);
		self::$_nbLigne = mysql_affected_rows($this->_connexion);
		self::setLastInsertId(mysql_insert_id($this->_connexion));
		return $this->returnResultat($res, $parametres);
	}

	/**
	 * Retourne le resultat de la requete au format demandé dans les parametres
	 * 
	 * @param PDOStatement $connect
	 * @param array $parametres
	 * @return any $tabRes
	 */
	public function returnResultat($connect, $parametres) {
		$tabRes = array();
		if($connect === false) {
			echo("Error description: ".mysql_error($this->_connexion));
			echo '<pre>'.print_r(debug_backtrace(), true).'</pre>';
			$tabRes = false;
		}
		else {
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
				while($tab = mysql_fetch_assoc($connect)) {
					$tabRes[] = $tab;
				}
				unset($tab);
			}
		}

		
		
		return $tabRes;
	}
}