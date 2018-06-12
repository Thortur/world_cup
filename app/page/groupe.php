<?php
declare (strict_types = 1);
namespace worldCup;
\session_start();
use \SendRequete\SendRequete;
header('Content-Type: text/html; charset=UTF-8');
require_once './../../app/class/SendRequete/SendRequete.class.php';

$SendRequete = new SendRequete('loadDataPageGroupe', array());
$datas = $SendRequete->exec();

require_once './../src/header.php';
$tabNavActive['groupe'] = ' active';
require_once './../src/nav.php';
echo '<pre>';
print_r($datas);
echo '</pre>';

$tabClassementGroupe = array();
if(is_array($datas->listGroupeMatch) === true && empty($datas->listGroupeMatch) === false && is_array($datas->listGroupeMatchDetail) === true && empty($datas->listGroupeMatchDetail) === false) {
    foreach($datas->listGroupeMatch as $groupe) {
        foreach($datas->listGroupeMatchDetail as $groupeMatchDetail) {
            if($groupeMatchDetail->idGroupeMatch === $groupe->id) {
                if(empty($tabClassementGroupe[$groupe->id]) === true) {
                    $tabClassementGroupe[$groupe->id] = array();
                }
                if(empty($tabClassementGroupe[$groupe->id][$groupeMatchDetail->idTeam]) === true) {
                    $tabClassementGroupe[$groupe->id][$groupeMatchDetail->idTeam] = array(
                        'joue'      => 0,
                        'gagne'     => 0,
                        'nul'       => 0,
                        'perdu'     => 0,
                        'butPour'   => 0,
                        'butContre' => 0,
                        'diff'      => 0,
                        'points'    => 0,
                    );
                }
    
                if(empty($datas->listResultat) === false) {
                    foreach((array)$datas->listResultat as $resultat) {
    
                        $idTeam = $groupeMatchDetail->idTeam;
                        if(empty($resultat->$idTeam) === false) {
                            $resultat = (array)$resultat;
                            $tabTeam = array_keys($resultat);
                            
                            $idTeamA = $tabTeam[0];
                            $idTeamB = $tabTeam[1];
                            
                            if($idTeamB === $groupeMatchDetail->idTeam) {
                                $idTeamA = $tabTeam[1];
                                $idTeamB = $tabTeam[0];
                            }
                            
                            
                            
                            $points = 1;
                            $typeResultat = 'null';
                            if($resultat[$idTeamA] > $resultat[$idTeamB]) {
                                $points = 3;
                                $typeResultat = 'gagne';
                            }
                            else if($resultat[$idTeamA] < $resultat[$idTeamB]) {
                                $points = 0;
                                $typeResultat = 'perdu';
                            }
    
                            $tabClassementGroupe[$groupe->id][$groupeMatchDetail->idTeam]['joue']++;
                            $tabClassementGroupe[$groupe->id][$groupeMatchDetail->idTeam][$typeResultat]++;
                            unset($typeResultat);
    
                            $tabClassementGroupe[$groupe->id][$groupeMatchDetail->idTeam]['butPour'] += $resultat[$idTeamA];
                            $tabClassementGroupe[$groupe->id][$groupeMatchDetail->idTeam]['butContre'] += $resultat[$idTeamB];
                            $tabClassementGroupe[$groupe->id][$groupeMatchDetail->idTeam]['diff'] = $tabClassementGroupe[$groupe->id][$groupeMatchDetail->idTeam]['butPour'] - $tabClassementGroupe[$groupe->id][$groupeMatchDetail->idTeam]['butContre'];
                            $tabClassementGroupe[$groupe->id][$groupeMatchDetail->idTeam]['points'] += $points;
    
                            unset($points, $typeResultat);
                        }
    
                    }
                    unset($resultat);
                }
            }
        }
        unset($groupeMatchDetail);
    }
    unset($groupe);
}

echo '<br/>';
echo '<br/>';
echo '<pre>';
print_r($tabClassementGroupe);
echo '</pre>';
if(empty($tabClassementGroupe) === false) {
    foreach($tabClassementGroupe as $idGroupe => $listTeamGroupe) {
        if($idGroupe > 1) break;
//         echo '<pre>';
// print_r($listTeamGroupe);
// echo '</pre>';
        // echo '<pre>'.print_r($listTeamGroupe, true).'</pre>';
        if(is_array($listTeamGroupe) === true && empty($listTeamGroupe) === false) {
            $ordreTeam = array_keys($listTeamGroupe);
            // $ordreTeam = array();
            foreach($listTeamGroupe as $idTeam => $resultatPoule) {
                if(empty($ordreTeam) === false) {
                    $newOrdreTeam = array();
                    foreach($ordreTeam as $ordre => $idTeamTemp) {
                        $ordreTeam[$ordre] = $idTeamTemp;
                        if($resultatPoule['points'] > $listTeamGroupe[$idTeamTemp]['points']) {
                            $ordreTeam[$ordre] = $idTeam;
                            $ordreTeam[$ordre+1] = $idTeamTemp;
                        }
                        else if($resultatPoule['points'] === $listTeamGroupe[$idTeamTemp]['points']) {
                            if($resultatPoule['gagne'] > $listTeamGroupe[$idTeamTemp]['gagne']) {
                                // $ordreTeam[] = $idTeam;
                            }
                            else {
                                // $ordreTeam[] = $idTeam;
                            }
                        }
                        else {
                            // $ordreTeam[] = $idTeam;
                        }
                    }
                    unset($ordre, $idTeamTemp);
                }
                else {
                    $ordreTeam[] = $idTeam;
                }
            }
            unset($idTeam, $resultatPoule);
            // echo '<pre>'.print_r($newOrdreTeam, true).'</pre>';
            echo '<pre>'.print_r($ordreTeam, true).'</pre>';
        }
        // $ordreTeam[]
        
    }
    unset($idGroupe, $listTeamGroupe);
}

require_once './../src/footer.php';