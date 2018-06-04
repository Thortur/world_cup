<?php
declare(strict_types = 1);
namespace GroupeMatch;
use \Connexion\Database;
include_once 'GroupeMatch.class.php';

class GroupeMatchManagerMYSQL {
    /**
     * Retourne la liste complete des groupe
     * 
     * @return array $listGroup
     */
    public static function loadListAllGroupe() {
        $listGroup = array();
        $Db = Database::init();
        $req = "SELECT
                    *
                FROM groupe_match";
        $res = $Db->exec($req);
        if(is_array($res) === true && empty($res) === false) {
            foreach($res as $data) {
                $listGroup[] = new GroupeMatch($data);
            }
            unset($data);
        }
        unset($res);

        return $listGroup;
    }
}