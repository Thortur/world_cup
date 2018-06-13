<?php
namespace worldCup;
use \SendRequete\SendRequete;
use \DateTime;
use \DateInterval;


class TimeLine {
    /**
     * List des datas
     * @var array $datas
     */
    private $datas;
    /**
     * cagnottes
     * @var float
     */
    private $cagnottes;

    public function __construct($datas, $cagnotteRestante) {
        $this->setDatas($datas);
        $this->setCagnottes($cagnotteRestante);
    }

    public function getCardParis($tabMatch) {
        $listMatch = '';
        $listMatchDetail = '';
        if(is_array($tabMatch)) {
            $selected = ' class="selected"';
            foreach($tabMatch as $k_match => $v_match) {
                $listMatch .= '<li><a href="#0" data-date="'.$v_match['dateFausse'].'"'.$selected.'><img class="flag" src="/app/src/flags/4x3/'.$v_match['flagA'].'.svg" style="width:20px;border:1px solid black;margin-right:1px;"><img class="flag" src="/app/src/flags/4x3/'.$v_match['flagB'].'.svg" style="width:20px;border:1px solid black;"></a></li>';
        
                $listMatchDetail .= '<li'.$selected.' data-date="'.$v_match['dateFausse'].'">';
                    $listMatchDetail .= '<h3>';
                        $listMatchDetail .= $v_match['equipeA'];
                        $listMatchDetail .= ' - ';
                        $listMatchDetail .= $v_match['equipeB'];
                    $listMatchDetail .= '</h3>';
                    $listMatchDetail .= '<h4 class="text-muted mb-1"><em>'.$v_match['typeMatch'].' - '.$v_match['date']->format('d/m/Y H:i').'</em></h4>';
                    $listMatchDetail .= '<div class="listBtnGoPari">';
                        $listMatchDetail .= '<div class="itemListBtnGoPari">';
                            $listMatchDetail .= '<h5>'.$v_match['equipeA'].'</h5>';
                            $listMatchDetail .= '<button type="button" class="btn mr-1 btn-block btn-info btnChoixPari" data-cote="'.$v_match['idCoteA'].'" >'.$v_match['coteA'].'</button>';
                        $listMatchDetail .= '</div>';
                        $listMatchDetail .= '<div class="itemListBtnGoPari">';
                            $listMatchDetail .= '<h5>Match Nul</h5>';
                            $listMatchDetail .= '<button type="button" class="btn mr-1 btn-block btn-secondary btnChoixPari" data-cote="'.$v_match['idCoteNull'].'">'.$v_match['coteNul'].'</button>';
                        $listMatchDetail .= '</div>';
                        $listMatchDetail .= '<div class="itemListBtnGoPari">';
                            $listMatchDetail .= '<h5>'.$v_match['equipeB'].'</h5>';
                            $listMatchDetail .= '<button type="button" class="btn mr-1 btn-block btn-info btnChoixPari" data-cote="'.$v_match['idCoteB'].'">'.$v_match['coteB'].'</button>';
                        $listMatchDetail .= '</div>';
                    $listMatchDetail .= '</div>';

                    // $listMatchDetail .= '<div class="row" style="margin-top: 15px;">';
                    //     $listMatchDetail .= '<div class="col-sm">';
                    //         $listMatchDetail .= '<h5>'.$v_match['equipeA'].'</h5>';
                    //     $listMatchDetail .= '</div>';
                    //     $listMatchDetail .= '<div class="col-sm">';
                    //         $listMatchDetail .= '<h5>Match Nul</h5>';
                    //     $listMatchDetail .= '</div>';
                    //     $listMatchDetail .= '<div class="col-sm">';
                    //         $listMatchDetail .= '<h5>'.$v_match['equipeB'].'</h5>';
                    //     $listMatchDetail .= '</div>';
                    // $listMatchDetail .= '</div>';
                    // $listMatchDetail .= '<div class="row" data-type-pari="1" data-match="'.$k_match.'" data-nom-team-a="'.$v_match['equipeA'].'" data-nom-team-b="'.$v_match['equipeB'].'">';
                    //     $listMatchDetail .= '<div class="col-sm"><button type="button" class="btn mr-1 btn-block btn-info btnChoixPari" data-cote="'.$v_match['idCoteA'].'" >'.$v_match['coteA'].'</button></div>';
                    //     $listMatchDetail .= '<div class="col-sm"><button type="button" class="btn mr-1 btn-block btn-secondary btnChoixPari" data-cote="'.$v_match['idCoteNull'].'">'.$v_match['coteNul'].'</button></div>';
                    //     $listMatchDetail .= '<div class="col-sm"><button type="button" class="btn mr-1 btn-block btn-info btnChoixPari" data-cote="'.$v_match['idCoteB'].'">'.$v_match['coteB'].'</button></div>';
                    // $listMatchDetail .= '</div>';
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
                        $html .= '<h3 class="modal-title">Titre du pari Ã  remplir</h3>';
                            $html .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                        $html .= '</div>';
                    $html .= '<form>';
                        $html .= '<div class="modal-body">';
                            $html .= '<input type="hidden" name="pari[match]" id="idMatchPari" value="">';
                            $html .= '<input type="hidden" name="pari[type]" id="idTypePari" value="">';
                            $html .= '<input type="hidden" name="pari[cote]" id="idCotePari" value="">';
                            $html .= '<label>Montant de votre pari (max = <span id="spanMaxCote">'.$this->cagnottes.' €</span>): </label>';
                            $html .= '<div class="form-group position-relative has-icon-left">';
                                $html .= '<input type="number" name="pari[montant]" max="'.$this->cagnottes.'" id="montantPari" placeholder="Votre montant à parier" class="form-control">';
                            $html .= '</div>';
                        $html .= '</div>';
                        $html .= '<div class="modal-footer">';
                            $html .= '<input type="reset" class="btn btn-outline-secondary" data-dismiss="modal" value="Fermer">';
                            $html .= '<input type="submit" name="btnVaildPari" id="btnVaildPari" data-max-pari="'.$this->cagnottes.'" class="btn btn-outline-primary" value="Valider ce pari">';
                        $html .= '</div>';
                    $html .= '</form>';
                $html .= '</div>';
            $html .= '</div>';
        $html .= '</div>';
  
        return $html;
    }
    
    /**
     * On tir les données pour avoir un tableau exploitable
     * 
     * @return array $tabMatch
     */
    public function getTabMatch() {
        $tabMatch    = array();
        $tabTeam     = array();
        $tabGroupe   = array();
        $tabListPari = array();

        if(is_array($this->datas->listTeam) && empty($this->datas->listTeam) === false) {
            foreach($this->datas->listTeam as $team) {
                $tabTeam[$team->id] = array(
                    'nom'  => $team->nom,
                    'iso2' => $team->iso2,
                );
            }
            unset($team);
        }
        if(is_array($this->datas->listGroupeMatch) && empty($this->datas->listGroupeMatch) === false) {
            foreach($this->datas->listGroupeMatch as $groupeMatch) {
                $tabGroupe[$groupeMatch->id] = array(
                    'nom' => $groupeMatch->groupe,
                );
            }
            unset($groupeMatch);
        }
        if(is_array($this->datas->listPari) === true && empty($this->datas->listPari) === false) {
            foreach($this->datas->listPari as $pari) {
                $tabListPari[$pari->idMatch] = $pari;
            }
            unset($pari);
        }
        
        if(is_array($this->datas->listMatch)) {
            $datetime = new DateTime();
            foreach($this->datas->listMatch as $k_match => $v_match) {
                $datetime->add(new DateInterval('P1D'));

                $idMatch = $v_match->id;

                if(empty($tabListPari) === true || empty($tabListPari[$idMatch]) === true) {
                    $idTeamA = $v_match->teamA;
                    $idTeamB = $v_match->teamB;
                    $idTypePari = 1;
                    $coteNul = 0;
    
                    $tabMatch[$idMatch] = array(
                        'date'       => new DateTime($v_match->date),
                        'dateFausse' => $datetime->format('d/m/Y'),
                        'idTeamA'    => $idTeamA,
                        'equipeA'    => $tabTeam[$idTeamA]['nom'],
                        'flagA'      => $tabTeam[$idTeamA]['iso2'],
                        'idTeamB'    => $idTeamB,
                        'equipeB'    => $tabTeam[$idTeamB]['nom'],
                        'flagB'      => $tabTeam[$idTeamB]['iso2'],
                        'typeMatch'  => $tabGroupe[$v_match->idGroupeMatch]['nom'],
                        'coteA'      => $this->datas->listCotes->$idMatch->$idTypePari->$idTeamA->cote,
                        'idCoteA'    => $this->datas->listCotes->$idMatch->$idTypePari->$idTeamA->id,
                        'coteB'      => $this->datas->listCotes->$idMatch->$idTypePari->$idTeamB->cote,
                        'idCoteB'    => $this->datas->listCotes->$idMatch->$idTypePari->$idTeamB->id,
                        'coteNul'    => $this->datas->listCotes->$idMatch->$idTypePari->$coteNul->cote,
                        'idCoteNull' => $this->datas->listCotes->$idMatch->$idTypePari->$coteNul->id,
                    );
                    unset($idTeamA, $idTeamB, $idTypePari, $coteNul);
                }

                unset($idMatch);
            }
            unset($datetime);
        }

        return $tabMatch;
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

    /**
     * Get cagnottes
     *
     * @return  float
     */ 
    public function getCagnottes()
    {
        return $this->cagnottes;
    }

    /**
     * Set cagnottes
     *
     * @param  float  $cagnottes  cagnottes
     *
     * @return  self
     */ 
    public function setCagnottes(float $cagnottes)
    {
        $this->cagnottes = $cagnottes;

        return $this;
    }
}


?>