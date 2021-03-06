<?php
namespace WorldCup;
use \SendRequete\SendRequete;
use \DateTime;
use \DateInterval;


class TimeLine {
    /**
     * id user connecter
     *
     * @var int $idUserConnecter
     */
    private $idUserConnecter;
    /**
     * data des Matchs
     * 
     * @var array $listMatch
     */
    private $listMatch;
    /**
     * cagnottes
     * 
     * @var float
     */
    private $cagnottes;

    public function __construct(int $idUserConnecter, object $datas, float $cagnotteRestante) {
        $this->setIdUserConnecter((int)$idUserConnecter);
        $this->setListMatch((object) $datas);
        $this->setCagnottes((float) $cagnotteRestante);
    }

    public function getCardParis() {

        $listMatch       = '';
        $listMatchDetail = '';
        $dateNow = new DateTime();

        if(is_array($this->listMatch) === true) {
            $selected = ' class="selected"';
            foreach($this->listMatch as $match) {
                $tauxA = 0;
                $tauxB = 0;
                $tauxNul = 0;
                if($match->nbPariMatch > 0) {
                    $tauxA = round((($match->teamA->nbPari * 100) / $match->nbPariMatch),0);
                    $tauxB = round((($match->teamB->nbPari * 100) / $match->nbPariMatch),0);
                    $tauxNul = round((($match->teamNull->nbPari * 100) / $match->nbPariMatch),0);
                }
                
                $listMatch .= '<li><a href="#0" data-date="'.$match->dateFausse.'"'.$selected.'><img class="flag" src="/src/images/flags/'.$match->teamA->flag.'.png" style="width:24px;margin-right:1px;"><img class="flag" src="/src/images/flags/'.$match->teamB->flag.'.png" style="width:24px;"></a></li>';
        
                $listMatchDetail .= '<li'.$selected.' data-date="'.$match->dateFausse.'">';
                    $listMatchDetail .= '<h3>';
                        $listMatchDetail .= $match->teamA->equipe;
                        $listMatchDetail .= ' - ';
                        $listMatchDetail .= $match->teamB->equipe;
                    $listMatchDetail .= '</h3>';
                    $listMatchDetail .= '<h4 class="text-muted mb-1"><em>'.$match->typeMatch.' - '.$match->date->format('d/m/Y H:i').'</em></h4>';
                    if($dateNow < $match->date) {                    
                        $listMatchDetail .= '<div class="listBtnGoPari" data-type-pari="1" data-match="'.$match->idMatch.'" data-nom-team-a="'.$match->teamA->equipe.'" data-nom-team-b="'.$match->teamB->equipe.'">';
                            $listMatchDetail .= '<div class="item">';
                                $listMatchDetail .= '<h5>'.$match->teamA->equipe.'</h5>';
                                $listMatchDetail .= '<button type="button" class="btn mr-1 btn-block btn-info btnChoixPari" data-cote="'.$match->teamA->idCote.'" >'.$match->teamA->cote.' ('.$tauxA.'%)</button>';
                            $listMatchDetail .= '</div>';
                            $listMatchDetail .= '<div class="item">';
                                $listMatchDetail .= '<h5>'.$match->teamNull->equipe.'</h5>';
                                $listMatchDetail .= '<button type="button" class="btn mr-1 btn-block btn-secondary btnChoixPari" data-cote="'.$match->teamNull->idCote.'">'.$match->teamNull->cote.' ('.$tauxB.'%)</button>';
                            $listMatchDetail .= '</div>';
                            $listMatchDetail .= '<div class="item">';
                                $listMatchDetail .= '<h5>'.$match->teamB->equipe.'</h5>';
                                $listMatchDetail .= '<button type="button" class="btn mr-1 btn-block btn-info btnChoixPari" data-cote="'.$match->teamB->idCote.'">'.$match->teamB->cote.' ('.$tauxNul.'%)</button>';
                            $listMatchDetail .= '</div>';
                        $listMatchDetail .= '</div>';
                    }
                    else {
                        $listMatchDetail .= '<div class="divBtnSaisieResultat" data-match="'.$match->idMatch.'" data-nom-team-a="'.$match->teamA->equipe.'" data-id-team-a="'.$match->teamA->idTeam.'" data-nom-team-b="'.$match->teamB->equipe.'" data-id-team-b="'.$match->teamB->idTeam.'">';
                        $listMatchDetail .= '<h5>'.$match->teamA->equipe.'</h5>';
                        $listMatchDetail .= '<button type="button" class="btn mr-1 btn-purple btnSaisieResultat" data-id-team="'.$match->teamA->idTeam.'" value="0">Saisire le résultat du match</button>';
                    }
                $listMatchDetail .= '</li>';
        
                unset($selected);
            }
            unset($match,$tauxA,$tauxB,$tauxNul);
        }
    
        $html = '<div class="card text-center">';
            $html .= '<div class="card-header card-head-inverse bg-blue">';
                $html .= '<h4 class="card-title">Vos prochains paris</h4>';
            $html .= '</div>';
            $html .= '<div class="card-content">';
                $html .= '<div class="card-body">';
                    $html .= '<div class="card-text">';
                        $html .= '<section class="cd-horizontal-timeline">';
                            $html .= '<div class="timeline" id="divTimeline">';
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
                                $html .= '<ol id="olDetailMatch">';
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
                $html .= '</div>';
            $html .= '</div>';
        $html .= '</div>';

        $html .= '<div class="modal fade text-left" id="modalResultatMatch" tabindex="-1" role="dialog" aria-hidden="true">';
            $html .= '<div class="modal-dialog" role="document">';
                $html .= '<div class="modal-content">';
                    $html .= '<div class="modal-header">';
                        $html .= '<h3 class="modal-title">Titre du pari à remplir</h3>';
                        $html .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                    $html .= '</div>';
                    $html .= '<div class="modal-body">';
                        $html .= '<input type="hidden" name="resultat[match]" id="idMatchResultat" value="">';
                        $html .= '<input type="hidden" name="resultat[idTeamA]" id="idTeamAResultat" value="">';
                        $html .= '<input type="hidden" name="resultat[idTeamB]" id="idTeamBResultat" value="">';
                        $html .= '<div id="listEquipeMatch" >';
                            $html .= '<div class="item form-group">';
                                $html .= '<label id="labelTeamA" ></label>';
                                $html .= '<input type="number" name="resultat[scoreA]" id="idScoreAResultat" class="form-control" min="0"/>';
                            $html .= '</div>';
                            $html .= '&nbsp;&nbsp;&nbsp;Vs&nbsp;&nbsp;&nbsp;';
                            $html .= '<div class="item form-group">';
                                $html .= '<label id="labelTeamB" ></label>';
                                $html .= '<input type="number" name="resultat[scoreB]" id="idScoreBResultat" class="form-control" min="0"/>';
                            $html .= '</div>';
                        $html .= '</div>';
                    $html .= '</div>';
                    $html .= '<div class="modal-footer">';
                        $html .= '<input type="reset" class="btn btn-outline-secondary" data-dismiss="modal" value="Fermer">';
                        $html .= '<input type="submit" name="btnVaildResultat" id="btnVaildResultat" class="btn btn-outline-primary" value="Valider le résultat du match">';
                    $html .= '</div>';
                $html .= '</div>';
            $html .= '</div>';
        $html .= '</div>';
  
        return $html;
    }
    
    /**
     * On tir les données pour avoir un tableau exploitable
     * 
     * @var object $datas
     * @return array $tabMatch
     */
    public function setListMatch($datas) {
        $this->listMatch    = array();
        $tabListPari        = array();
        $tabListPariGlobal  = array();
        $dateNow            = new DateTime();
        $idTypePari         = 1;

        if(is_object($datas->listPari) === true && empty($datas->listPari) === false) {
            foreach($datas->listPari as $pari) {
                if($pari->idUser === $this->getIdUserConnecter()) {
                    $tabListPari[$pari->idMatch] = $pari;
                }

                $idMatch = $pari->idMatch;
                if(is_object($datas->listCotesLast->$idMatch->$idTypePari)) {
                    foreach($datas->listCotesLast->$idMatch->$idTypePari as $team) {
                        if($team->id === $pari->idCotes) {
                            $tabListPariGlobal[$idMatch][$team->idTeam][$pari->id] = $pari;
                        }
                    }
                    unset($team);
                }
            }
            unset($pari,$idMatch);
        }
        
        if(is_object($datas->listMatch) && empty($datas->listMatch) === false) {
            $datetime = new DateTime();
            foreach($datas->listMatch as $match) {
                $datetime->add(new DateInterval('P1D'));
                $dateMatch = new DateTime($match->date);
                $idMatch = $match->id;

                if((in_array($this->getIdUserConnecter(), array(1, 2)) === true && empty($datas->listResultat->$idMatch) === true && $dateNow > $dateMatch) || ($dateNow < $dateMatch && empty($tabListPari[$idMatch]) === true)) {
                    $idTeamA       = $match->teamA;
                    $idTeamB       = $match->teamB;
                    $idGroupeMatch = $match->idGroupeMatch;
                    $coteNul       = 0;
                    $countA        = ((is_array($tabListPariGlobal[$idMatch][$idTeamA])) ? count($tabListPariGlobal[$idMatch][$idTeamA]) : 0);
                    $countB        = ((is_array($tabListPariGlobal[$idMatch][$idTeamB])) ? count($tabListPariGlobal[$idMatch][$idTeamB]) : 0);
                    $countNul        = ((is_array($tabListPariGlobal[$idMatch][$coteNul])) ? count($tabListPariGlobal[$idMatch][$coteNul]) : 0);
                    
                    $idTypeMatch = $match->idTypeMatch;
                    switch ($match->idTypeMatch) {
                        case 1:
                            $labelTypeMatch = $datas->listGroupeMatch->$idGroupeMatch->groupe;
                            break;
                        default:
                            $labelTypeMatch = $datas->listTypeMatch->$idTypeMatch->nom;
                    }
                    unset($idTypeMatch);

                    $this->listMatch[$idMatch] = (object)array(
                        'idMatch'    => $idMatch,
                        'date'       => clone $dateMatch,
                        'dateFausse' => $datetime->format('d/m/Y'),
                        'typeMatch'  => $labelTypeMatch,
                        'nbPariMatch'=> ($countA + $countB + $countNul),
                        'teamA'      => (object)array(
                            'idTeam' => $idTeamA,
                            'equipe' => $datas->listTeam->$idTeamA->nom,
                            'flag'   => $datas->listTeam->$idTeamA->iso2,
                            'cote'   => $datas->listCotesLast->$idMatch->$idTypePari->$idTeamA->cote,
                            'idCote' => $datas->listCotesLast->$idMatch->$idTypePari->$idTeamA->id,
                            'nbPari' => $countA,
                        ),
                        'teamB'      => (object)array(
                            'idTeam' => $idTeamB,
                            'equipe' => $datas->listTeam->$idTeamB->nom,
                            'flag'   => $datas->listTeam->$idTeamB->iso2,
                            'cote'   => $datas->listCotesLast->$idMatch->$idTypePari->$idTeamB->cote,
                            'idCote' => $datas->listCotesLast->$idMatch->$idTypePari->$idTeamB->id,
                            'nbPari' => $countB,
                        ),
                        'teamNull'      => (object)array(
                            'idTeam' => 0,
                            'equipe' => 'Match Nul',
                            'flag'   => $datas->listTeam->$idTeamB->iso2,
                            'cote'   => $datas->listCotesLast->$idMatch->$idTypePari->$coteNul->cote,
                            'idCote' => $datas->listCotesLast->$idMatch->$idTypePari->$coteNul->id,
                            'nbPari' => $countNul,
                        ),
                    );
                    unset($idTeamA, $idTeamB, $coteNul, $countA, $countB, $countNul, $idGroupeMatch);
                }

                unset($idMatch);
            }
            unset($datetime, $match);
        }
        unset($idTypePari);
    }

    /**
     * Get $idUserConnecter
     *
     * @return  int
     */ 
    public function getIdUserConnecter()
    {
        return $this->idUserConnecter;
    }

    /**
     * Set $idUserConnecter
     *
     * @param  int  $idUserConnecter  $idUserConnecter
     *
     * @return  self
     */ 
    public function setIdUserConnecter(int $idUserConnecter)
    {
        $this->idUserConnecter = $idUserConnecter;

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