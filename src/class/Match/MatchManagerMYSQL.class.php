<?php
declare(strict_types = 1);
namespace Match;
use \Connexion\Database;
include_once 'Match.class.php';

class MatchManagerMYSQL {
    /**
     * Retourne la liste complete des match
     * 
     * @return array $listMatch
     */
    public static function loadListAllMatch() {
        $listMatch = array();
        $Db = Database::init();
        $req = "SELECT
                    *
                FROM `match`";
        $res = $Db->exec($req);
        if(is_array($res) === true && empty($res) === false) {
            foreach($res as $data) {
                $listMatch[] = new Match($data);
            }
            unset($data);
        }
        unset($res);

        return $listMatch;
    }
}