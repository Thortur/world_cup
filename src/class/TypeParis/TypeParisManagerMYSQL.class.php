<?php
declare(strict_types = 1);
namespace TypeParis;
use \Connexion\Database;
include_once 'TypeParis.class.php';

class TypeParisManagerMYSQL {
    /**
     * Retourne la liste des type de paris
     * 
     * @return array $listTypeParis
     */
    public static function loadListAllTypeParis() {
        $listTypeParis = array();
        $Db = Database::init();
        $req = "SELECT
                    *
                FROM type_paris";
        $res = $Db->exec($req);
        if(is_array($res) === true && empty($res) === false) {
            foreach($res as $data) {
                $listTypeParis[] = new TypeParis($data);
            }
            unset($data);
        }
        unset($res);

        return $listTypeParis;
    }
}