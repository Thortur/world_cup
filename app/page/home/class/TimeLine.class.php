<?php
namespace worldCup;
use \SendRequete\SendRequete;
use \DateTime;
use \DateInterval;


class TimeLine {
    private $datas;

    public function __construct($datas) {
        $this->setDatas($datas);
    }

    public function getCardParis($tabMatch) {
        $listMatch = '';
        $listMatchDetail = '';
        if(is_array($tabMatch)) {
            $selected = ' class="selected"';
            foreach($tabMatch as $k_match => $v_match) {
                $listMatch .= '<li><a href="#0" data-date="'.$v_match['dateFausse'].'"'.$selected.'><img class="flag" src="/app/src/flags/4x3/'.$v_match['flagA'].'.svg" style="width:20px;border:1px solid black;margin-right:1px;"><img class="flag" src="/app/src/flags/4x3/'.$v_match['flagB'].'.svg" style="width:20px;border:1px solid black;"></a></li>';
                // $listMatch .= '<li><a href="#0" data-date="'.$v_match['dateFausse'].'"'.$selected.'><img class="flag" src="flags/4x3/'.$v_match['flagA'].'.svg" style="width:20px;border:1px solid black;margin-right:1px;"><img class="flag" src="flags/4x3/'.$v_match['flagB'].'.svg" style="width:20px;border:1px solid black;"></a></li>';
        
                $listMatchDetail .= '<li'.$selected.' data-date="'.$v_match['dateFausse'].'">';
                $listMatchDetail .= '<h3>';
                    $listMatchDetail .= $v_match['equipeA'];
                    $listMatchDetail .= ' - ';
                    $listMatchDetail .= $v_match['equipeB'];
                $listMatchDetail .= '</h3>';
                $listMatchDetail .= '<h4 class="text-muted mb-1"><em>'.$v_match['typeMatch'].' - '.$v_match['date']->format('d/m/Y H:i').'</em></h4>';
                $listMatchDetail .= '<p class="lead">';
                    $listMatchDetail .= '<div class="row">';
                        $listMatchDetail .= '<div class="col-sm"><button type="button" class="btn mr-1 btn-block btn-info" data-toggle="modal" data-target="#modalPari">'.$v_match['equipeA'].' '.$v_match['coteA'].'</button></div>';
                        $listMatchDetail .= '<div class="col-sm"><button type="button" class="btn mr-1 btn-block btn-secondary" data-toggle="modal" data-target="#modalPari">Match Nul '.$v_match['coteNul'].'</button></div>';
                        $listMatchDetail .= '<div class="col-sm"><button type="button" class="btn mr-1 btn-block btn-info" data-toggle="modal" data-target="#modalPari">'.$v_match['equipeB'].' '.$v_match['coteB'].'</button></div>';
                    $listMatchDetail .= '</div>';
                $listMatchDetail .= '</p>';
                $listMatchDetail .= '</li>';
        
                unset($selected);
            }
            unset($k_match, $v_match);
        }
    
        $html = '<div class="card text-center">';
            $html .= '<div class="card-content">';
            $html .= '<div class="card-body">';
                $html .= '<div class="card-text">';
                $html .= '<section class="cd-horizontal-timeline">';
                    $html .= '<div class="timeline">';
                    $html .= '<div class="events-wrapper">';
                        $html .= '<div class="events">';
                        $html .= '<ol>';
                            $html .= $listMatch;
                        $html .= '</ol>';
                        $html .= '<span class="filling-line" aria-hidden="true"></span>';
                        $html .= '</div>';
                    $html .= '</div>';
                    $html .= '<ul class="cd-timeline-navigation">';
                        $html .= '<li><a href="#0" class="prev inactive">Prev</a></li>';
                        $html .= '<li><a href="#0" class="next">Next</a></li>';
                    $html .= '</ul>';
                    $html .= '</div>';
                    $html .= '<div class="events-content">';
                    $html .= '<ol>';
                        $html .= $listMatchDetail;
                    $html .= '</ol>';
                    $html .= '</div>';
                $html .= '</section>';
                $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
        $html .= '</div>';
  
        $html .= '<div class="modal fade text-left" id="modalPari" tabindex="-1" role="dialog" aria-hidden="true">';
            $html .= '<div class="modal-dialog" role="document">';
            $html .= '<div class="modal-content">';
                $html .= '<div class="modal-header">';
                $html .= '<h3 class="modal-title">Titre du pari à remplir</h3>';
                $html .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                $html .= '</div>';
                $html .= '<form>';
                $html .= '<div class="modal-body">';
                    $html .= '<label>Montant de votre pari (max = ###): </label>';
                    $html .= '<div class="form-group position-relative has-icon-left">';
                    $html .= '<input type="number" placeholder="Votre montant à parier" class="form-control">';
                    $html .= '</div>';
                $html .= '</div>';
                $html .= '<div class="modal-footer">';
                    $html .= '<input type="reset" class="btn btn-outline-secondary" data-dismiss="modal" value="Fermer">';
                    $html .= '<input type="submit" class="btn btn-outline-primary" value="Valider ce pari">';
                $html .= '</div>';
                $html .= '</form>';
            $html .= '</div>';
            $html .= '</div>';
        $html .= '</div>';
  
        return $html;
    }
    
    /**
     * On tir les donn�es pour avoir un tableau exploitable
     * 
     * @return array $tabMatch
     */
    public function getTabMatch() {
        $tabMatch = array();

        if(is_array($this->datas->listTeam)) {
            foreach($this->datas->listTeam as $k_team => $v_team) {
                $tabTeam[$v_team->id] = array(
                    'nom'  => $v_team->nom,
                    'iso2' => $v_team->iso2,
                );
            }
            unset($k_team, $v_team);
        }
        if(is_array($this->datas->listGroupeMatch)) {
            foreach($this->datas->listGroupeMatch as $k_groupe => $v_groupe) {
                $tabGroupe[$v_groupe->id] = array(
                    'nom' => $v_groupe->groupe,
                );
            }
            unset($k_groupe, $v_groupe);
        }

        if(is_array($this->datas->listMatch)) {
            $datetime = new DateTime();
            foreach($this->datas->listMatch as $k_match => $v_match) {
                $datetime->add(new DateInterval('P1D'));

                $idMatch = $v_match->id;
                $idTeamA = $v_match->teamA;
                $idTeamB = $v_match->teamB;
                $idTypePari = 1;
                $coteNul = 0;

                $tab[$idMatch] = array(
                    'date'       => new DateTime($v_match->date),
                    'dateFausse' => $datetime->format('d/m/Y'),
                    'equipeA'    => $tabTeam[$idTeamA]['nom'],
                    'flagA'      => $tabTeam[$idTeamA]['iso2'],
                    'equipeB'    => $tabTeam[$idTeamB]['nom'],
                    'flagB'      => $tabTeam[$idTeamB]['iso2'],
                    'typeMatch'  => $tabGroupe[$v_match->idGroupeMatch]['nom'],
                    'coteA'      => $this->datas->listCotes->$idMatch->$idTypePari->$idTeamA->cote,
                    'coteB'      => $this->datas->listCotes->$idMatch->$idTypePari->$idTeamB->cote,
                    'coteNul'    => $this->datas->listCotes->$idMatch->$idTypePari->$coteNul->cote,
                );

                unset($idMatch, $idTeamA, $idTeamB, $idTypePari, $coteNul);
            }
        }

        return $tab;
    }

    /**
     * Get the value of datas
     */ 
    public function getDatas() {
        return $this->datas;
    }

    /**
     * Set the value of datas
     *
     * @return  self
     */ 
    public function setDatas($datas) {
        $this->datas = $datas;

        return $this;
    }
}


?>