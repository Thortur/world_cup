<?php
declare(strict_types = 1);
namespace User;
use \DateTime;
use \Connexion\Database;
use \Cagnotte\CagnotteManagerMYSQL;
use \Cagnotte\Cagnotte;
include_once 'User.class.php';
include_once 'DataUser.class.php';

class UserManagerMYSQL {

    /**
     * Retourne la list complete des utilisateurs
     *
     * @return array listUser
     */
    public static function loadListAllTeam() {
        $listUser = array();
        $Db = Database::init();
        $req = "SELECT
                    *
                FROM user";
        $res =  $Db->exec($req);
        if(is_array($res) === true && empty($res) === false) {
            foreach($res as $data) {
                $data['id'] = (int)$data['id'];
                $listUser[] = new User($data);
            }
            unset($data);
        }
        unset($res);

        return $listUser;
    }

    /**
     * Insert user
     *
     * @param User $User
     * @return User $User
     */
    public static function insertUser(User $User) {
        $Db = Database::init();
        $req = "INSERT INTO user (nom, prenom, pseudo, mail, password) VALUES (:nom, :prenom, :pseudo, :mail, :password);";
        $data = array(
                    ':nom' => array(
                        'type'  => 'string',
                        'value' => $User->getNom(),
                    ),
                    ':prenom' => array(
                        'type'  => 'string',
                        'value' => $User->getPrenom(),
                    ),
                    ':pseudo' => array(
                        'type'  => 'string',
                        'value' => $User->getPseudo(),
                    ),
                    ':mail' => array(
                        'type'  => 'string',
                        'value' => $User->getMail(),
                    ),
                    ':password' => array(
                        'type'  => 'string',
                        'value' => $User->getPassword(),
                    ),
                );
        $Db->execStatement($req, $data);
        $User->setId($Db->getLastInsertId());
        unset($req, $data);
        
        return $User;
    }

    /**
     * Update user
     *
     * @param User $User
     * @return bool success
     */
    public static function updateUser(User $User) {
        $Db = Database::init();
        $req = "UPDATE user SET nom = :nom, prenom = :prenom, pseudo = :pseudo, mail = :mail WHERE id = :id;";
        $data = array(
            ':nom' => array(
                'type'  => 'string',
                'value' => $User->getNom(),
            ),
            ':prenom' => array(
                'type'  => 'string',
                'value' => $User->getPrenom(),
            ),
            ':pseudo' => array(
                'type'  => 'string',
                'value' => $User->getPseudo(),
            ),
            ':mail' => array(
                'type'  => 'string',
                'value' => $User->getMail(),
            ),
            ':id' => array(
                'type'  => 'int',
                'value' => $User->getId(),
            ),
        );
        $Db->execStatement($req, $data);
        unset($req, $data, $User);

        return $Db::$_nbLigne;
    }

    /**
     * Update password user
     *
     * @param User $User
     * @return bool success
     */
    public static function updatePassWord(User $User) {
        $Db = Database::init();
        $req = "UPDATE user SET password = :password WHERE id = :id;";
        $data = array(
            ':password' => array(
                'type'  => 'password',
                'value' => $User->getPassword(),
            ),
            ':id' => array(
                'type'  => 'int',
                'value' => $User->getId(),
            ),
        );
        $Db->execStatement($req, $data);
        unset($req, $data, $User);

        return $Db::$_nbLigne;
    }

    /**
     * Connexion utilisateur
     * 
     * @param string $pseudo
     * @param string $password
     * 
     * @return bool|User $User
     */
    public static function connexion(string $pseudo, string $password) {
        $Db       = Database::init();
        $User     = false;
        $pseudo   = trim($pseudo);
        $password = trim($password);

        if(empty($pseudo) === false && empty($password) === false) {
            $req = "SELECT
                        *
                    FROM user
                    WHERE
                        user.pseudo = :pseudo
                        AND user.password = :password";
            $data = array(
                ':pseudo' => array(
                    'type'  => 'string',
                    'value' => $pseudo,
                ),
                ':password' => array(
                    'type'  => 'string',
                    'value' => $password,
                ),
            );

            $res = $Db->execStatement($req, $data);

            if(empty($res) === false) {
                reset($res);
                $firstKey = key($res);
                $data     = $res[$firstKey];
                unset($firstKey);

                $data['id'] = (int)$data['id'];
                $User = new User($data);
            }
            
            unset($req, $data, $res);
        }
        unset($login, $password);
        
        return $User;
    }
    
    /**
     * Test si le login ou le mail est deja utiliser
     * 
     * @param User $User
     * @return bool $error
     */
    public static function isLoginOrMailExiste($User) {
        $Db    = Database::init();
        $error = true;
        $req = "SELECT
                    *
                FROM user
                WHERE
                user.pseudo = :pseudo
                OR user.mail = :mail";
        $data = array(
            ':pseudo' => array(
                'type'  => 'string',
                'value' => $User->getPseudo(),
            ),
            ':mail' => array(
                'type'  => 'string',
                'value' => $User->getMail(),
            ),
        );
        $res = $Db->execStatement($req, $data);
        if(empty($res) === true) {
            $error = false;
        }
        
        return $error;
    }

    /**
     * Creation de l'utilisateur
     * 
     * @param User $User
     * @return User $User
     */
    public static function createUser(User $User) {
        if(self::isLoginOrMailExiste($User) === false) {
            $User = self::insertUser($User);
            $Cagnotte = new Cagnotte(array(
                'id'      => -1,
                'idUser'  => $User->getId(),
                'date'    => new DateTime(),
                'montant' => 500,
            ));
            $Cagnotte = CagnotteManagerMYSQL::insertCagnotte($Cagnotte);
            var_dump($Cagnotte);
            var_dump($User);
            $DataUser = new DataUser(array(
                'cagnotte' => array($Cagnotte),
            ));

            $User->setDataUser($DataUser);
        }
        else {
            $User = false;
        }

        return $User;
    }
}