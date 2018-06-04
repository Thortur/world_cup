<?php
declare(strict_types = 1);
namespace GroupeMatchDetail;
use \Connexion\Database;
include_once 'GroupeMatchDetail.class.php';

class GroupeMatchDetailManagerMYSQL {
    /**
     * Retourne la liste complete des groupe detail
     * 
     * @return array $listGroupDetail
     */
    public static function loadListAllGroupeDetail() {
        $listGroupDetail = array();
        $Db = Database::init();
        $req = "SELECT
                    *
                FROM groupe_match_detail";
        $res = $Db->exec($req);
        if(is_array($res) === true && empty($res) === false) {
            foreach($res as $data) {
                $listGroupDetail[] = new GroupeMatchDetail($data);
            }
            unset($data);
        }
        unset($res);

        return $listGroupDetail;
    }
}