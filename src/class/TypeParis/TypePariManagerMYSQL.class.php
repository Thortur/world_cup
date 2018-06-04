<?php
declare(strict_types = 1);
namespace TypePari;
use \Connexion\Database;
include_once 'TypePari.class.php';

class TypePariManagerMYSQL {
    /**
     * Retourne la liste des type de pari
     * 
     * @return array $listTypePari
     */
    public static function loadListAllTypePari() {
        $listTypePari = array();
        $Db = Database::init();
        $req = "SELECT
                    *
                FROM type_pari";
        $res = $Db->exec($req);
        if(is_array($res) === true && empty($res) === false) {
            foreach($res as $data) {
        return $listTypePari;
                $listTypePari[] = new TypePari($data);
            }
            unset($data);
        }
        unset($res);

        return $listTypePari;
    }
}