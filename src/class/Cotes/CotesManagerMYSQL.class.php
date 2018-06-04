<?php
declare(strict_types = 1);
namespace Cotes;
use \Connexion\Database;
use \DateTime;
use \Match\Match;
include_once 'Cotes.class.php';

class CotesManagerMYSQL {
    /**
     * Retourne tout les deniere cotes a jour de tout les matchs
     * 
     * @param DateTime $Date
     * @return array $lastCotes
     */
    public static function loadLastCotesToDate(DateTime $Date) {
        $Db        = Database::init();
        $lastCotes = array();

        $req = "SELECT
                    *
                FROM cotes
                WHERE
                    cotes.date <= :dateCote
                ORDER BY cotes.date ASC, cotes.idTeam";
        $data = array(
            ':dateCote' => array(
                'type'  => 'string',
                'value' => $Date->format('Y-m-d H:i:s'),
            ),
        );

        $res = $Db->execStatement($req, $data);
        unset($req, $data);
        if(empty($res) === false) {
            foreach($res as $dataRow) {
                $Cotes = new Cotes($dataRow);

                if($Cotes->getDate() <= $Date) {
                    if(empty($lastCotes[$Cotes->getIdMatch()]) === true) {
                        $lastCotes[$Cotes->getIdMatch()] = array();
                    }
                    if(empty($lastCotes[$Cotes->getIdMatch()][$Cotes->getIdTypePari()]) === true) {
                        $lastCotes[$Cotes->getIdMatch()][$Cotes->getIdTypePari()] = array();
                    }
                    $lastCotes[$Cotes->getIdMatch()][$Cotes->getIdTypePari()][$Cotes->getIdTeam()] = clone $Cotes;

                }
            }
            unset($dataRow, $Cotes);
        }
        unset($res);
        
        return $lastCotes;
    }

    /**
     * Retour tout les cotes d'un match
     * 
     * @param Match $Match
     * @return array $lastCotes;
     */
    public static function loadAllCoteMatch(Match $Match) {
        $Db        = Database::init();
        $lastCotes = array();

        $req = "SELECT
                *
                FROM cotes
                WHERE
                    cotes.idMatch <= :idMatch
                ORDER BY cotes.date ASC, cotes.idTeam";
        $data = array(
            ':idMatch' => array(
                'type'  => 'int',
                'value' => $Match->getId(),
            ),
        );

        $res = $Db->execStatement($req, $data);
        unset($req, $data);
        if(empty($res) === false) {
            foreach($res as $dataRow) {
                $Cotes = new Cotes($dataRow);
                if(empty($lastCotes[$Cotes->getIdMatch()]) === true) {
                    $lastCotes[$Cotes->getIdMatch()] = array();
                }
                if(empty($lastCotes[$Cotes->getIdMatch()][$Cotes->getIdTypePari()]) === true) {
                    $lastCotes[$Cotes->getIdMatch()][$Cotes->getIdTypePari()] = array();
                }
                if(empty($lastCotes[$Cotes->getIdMatch()][$Cotes->getIdTypePari()][$Cotes->getIdTeam()]) === true) {
                    $lastCotes[$Cotes->getIdMatch()][$Cotes->getIdTypePari()][$Cotes->getIdTeam()] = array();
                }
                $lastCotes[$Cotes->getIdMatch()][$Cotes->getIdTypePari()][$Cotes->getIdTeam()][$Cotes->getId()] = clone $Cotes;
            }
            unset($dataRow, $Cotes);
        }
        unset($res);
        return $lastCotes;
    }

    /**
     * Retour les derniere cotes du match
     * 
     * @param Match $Match
     * @return array $lastCotes;
     */
    public static function loadLastCoteMatch(Match $Match) {
        $Db        = Database::init();
        $lastCotes = array();
        $LastDate  = null;

        $req = "SELECT
                    *
                FROM cotes
                WHERE
                    cotes.idMatch <= :idMatch
                ORDER BY cotes.date ASC, cotes.idTeam";
        $data = array(
            ':idMatch' => array(
                'type'  => 'int',
                'value' => $Match->getId(),
            ),
        );

        $res = $Db->execStatement($req, $data);
        unset($req, $data);
        if(empty($res) === false) {
            foreach($res as $dataRow) {
                $Cotes   = new Cotes($dataRow);
                if($LastDate === null) {
                    $LastDate = clone $Cotes->getDate();
                }
                
                if($Cotes->getDate() >= $LastDate) {
                    $LastDate = clone $Cotes->getDate();
                    if(empty($lastCotes[$Cotes->getIdTypePari()]) === true) {
                        $lastCotes[$Cotes->getIdTypePari()] = array();
                    }
                    
                    $lastCotes[$Cotes->getIdTypePari()][$Cotes->getIdTeam()] = clone $Cotes;
                }
            }
            unset($dataRow, $Cotes);
        }
        unset($res);
        
        return $lastCotes;
    }

    /**
     * Insert une nouvelle cotes d'un match
     * 
     * @param Cotes $cotes
     * @return int nb ligne
     */
    public static function insertCotes(Cotes $Cotes) {
        $Db = Database::init();
        $req = "INSERT INTO cotes (idMatch, idTypePari, idTeam, cote, date) VALUES (:idMatch, :idTypePari, :idTeam, :cote, :date);";
        $data = array(
            ':idMatch' => array(
                'type'  => 'int',
                'value' => $Cotes->getIdMatch(),
            ),
            ':idTypePari' => array(
                'type'  => 'int',
                'value' => $Cotes->getIdTypePari(),
            ),
            ':idTeam' => array(
                'type'  => 'int',
                'value' => $Cotes->getIdTeam(),
            ),
            ':cote' => array(
                'type'  => 'float',
                'value' => $Cotes->getCote(),
            ),
            ':date' => array(
                'type'  => 'string',
                'value' => $Cotes->getDate()->format('Y-m-d H:i:s'),
            ),
        );
        
        $Db->execStatement($req, $data);
        unset($req, $data, $Cotes);

        return $Db::$_nbLigne;
    }
}