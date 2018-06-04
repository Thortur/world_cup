<?php
declare(strict_types = 1);
namespace Cagnotte;
use \Connexion\Database;
include_once 'Cagnotte.class.php';

class CagnotteManagerMYSQL {

    public static function insertCagnotte(Cagnotte $Cagnotte) {
        $Db   = Database::init();
        $req  = "INSERT INTO cagnotte (idUser, date, montant) VALUES (:idUser, :date, :montant);";
        $data = array(
            ':idUser' => array(
                'type'  => 'int',
                'value' => $Cagnotte->getIdUser(),
            ),
            ':date' => array(
                'type'  => 'string',
                'value' => $Cagnotte->getDate()->format('Y-m-d H:i:s'),
            ),
            ':montant' => array(
                'type'  => 'float',
                'value' => $Cagnotte->getMontant(),
            ),
        );
        $res = $Db->execStatement($req, $data);
        unset($req, $data);
        $Cagnotte->setId($Db->getLastInsertId());

        return $Cagnotte;
    }
}