<?php
declare(strict_types = 1);
namespace Connexion;

/**
 * interface qui gere la connexion a la base
 */
interface iDatabase {
    /**
	 * initialisation de la connexion a la base de donnée
	 *
	 * @param ConfigDataBase|null $ConfigDataBase
	 * @return object Retourne l'instance de la connexion a la base
     */
    public static function init($ConfigDataBase=null);

    /**
	 * Constuct de la class
	 * Sauvegarde les donnes pour la connexion a la base,
     * et etablie la connexion a la base
     *
	 * @param ConfigDataBase $ConfigDataBase
     */
    public function __construct($ConfigDataBase=null);

    /**
     * Execute la requete statement
     *
	 * @param string $requete
	 * @param array|null $data
	 * @param array|null $parametres
	 * @return array $res
	 */
    public function execStatement($req, $data=null, $parametres=null);

    /**
     * Execute la requete
     *
	 * @param string $requete
	 * @param array|null $parametres
	 * @return array $res
	 */
	public function exec($req, $parametres=null);
	
	/**
	 * Retourne le resultat de la requete au format demandé dans les parametres
	 * 
	 * @param PDOStatement $connect
	 * @param array $parametres
	 * @return any $res
	 */
	public function returnResultat($connect, $parametres);
}