<?php
declare(strict_types = 1);
namespace User;
use \Connexion\Database;
include_once 'User.class.php';

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
     * @return void
     */
    public static function insertUser(User $User) {
        $Db = Database::init();
        $req = "INSERT INTO user (nom, prenom, pseudo, mail, password) VALUES (:nom, :prenom, :pseudo, :mail, :password);";
        
        $data = array(
                    ':nom' => array(
                        'type' => 'string',
                        'value' => $User->getNom(),
                    ),
                    ':prenom' => array(
                        'type' => 'string',
                        'value' => $User->getPrenom(),
                    ),
                    ':pseudo' => array(
                        'type' => 'string',
                        'value' => $User->getPseudo(),
                    ),
                    ':mail' => array(
                        'type' => 'string',
                        'value' => $User->getMail(),
                    ),
                    ':password' => array(
                        'type' => 'string',
                        'value' => $User->getPassword(),
                    ),
                );
        $Db->execStatement($req, $data);
        return $Db::$_nbLigne;
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
                'type' => 'string',
                'value' => $User->getNom(),
            ),
            ':prenom' => array(
                'type' => 'string',
                'value' => $User->getPrenom(),
            ),
            ':pseudo' => array(
                'type' => 'string',
                'value' => $User->getPseudo(),
            ),
            ':mail' => array(
                'type' => 'string',
                'value' => $User->getMail(),
            ),
            ':id' => array(
                'type' => 'int',
                'value' => $User->getId(),
            ),
        );
        $Db->execStatement($req, $data);
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
                'type' => 'password',
                'value' => $User->getPassword(),
            ),
            ':id' => array(
                'type' => 'int',
                'value' => $User->getId(),
            ),
        );
        $Db->execStatement($req, $data);
        return $Db::$_nbLigne;
    }
}