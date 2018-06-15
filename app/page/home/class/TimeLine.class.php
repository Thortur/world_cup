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

        $listMatch = '';
        $listMatchDetail = '';
        if(is_array($this->listMatch) === true) {
            $selected = ' class="selected"';
            foreach($this->listMatch as $match) {
                $listMatch .= '<li><a href="#0" data-date="'.$match->dateFausse.'"'.$selected.'><img class="flag" src="/src/images/flags/'.$match->teamA->flag.'.png" style="width:24px;margin-right:1px;"><img class="flag" src="/src/images/flags/'.$match->teamB->flag.'.png" style="width:24px;"></a></li>';
        
                $listMatchDetail .= '<li'.$selected.' data-date="'.$match->dateFausse.'">';
                    $listMatchDetail .= '<h3>';
                        $listMatchDetail .= $match->teamA->equipe;
                        $listMatchDetail .= ' - ';
                        $listMatchDetail .= $match->teamB->equipe;
                    $listMatchDetail .= '</h3>';
                    $listMatchDetail .= '<h4 class="text-muted mb-1"><em>'.$match->typeMatch.' - '.$match->date->format('d/m/Y H:i').'</em></h4>';
                    $listMatchDetail .= '<div id="listBtnGoPari" data-type-pari="1" data-match="'.$match->idMatch.'" data-nom-team-a="'.$match->teamA->equipe.'" data-nom-team-b="'.$match->teamB->equipe.'">';
                        $listMatchDetail .= '<div class="item">';
                            $listMatchDetail .= '<h5>'.$match->teamA->equipe.'</h5>';
                            $listMatchDetail .= '<button type="button" class="btn mr-1 btn-block btn-info btnChoixPari" data-cote="'.$match->teamA->idCote.'" >'.$match->teamA->cote.'</button>';
                        $listMatchDetail .= '</div>';
                        $listMatchDetail .= '<div class="item">';
                            $listMatchDetail .= '<h5>'.$match->teamNull->equipe.'</h5>';
                            $listMatchDetail .= '<button type="button" class="btn mr-1 btn-block btn-secondary btnChoixPari" data-cote="'.$match->teamNull->idCote.'">'.$match->teamNull->cote.'</button>';
                        $listMatchDetail .= '</div>';
                        $listMatchDetail .= '<div class="item">';
                            $listMatchDetail .= '<h5>'.$match->teamB->equipe.'</h5>';
                            $listMatchDetail .= '<button type="button" class="btn mr-1 btn-block btn-info btnChoixPari" data-cote="'.$match->teamB->idCote.'">'.$match->teamB->cote.'</button>';
                        $listMatchDetail .= '</div>';
                    $listMatchDetail .= '</div>';
                $listMatchDetail .= '</li>';
        
                unset($selected);
            }
            unset($match);
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
     * @var object $datas
     * @return array $tabMatch
     */
    public function setListMatch($datas) {
        $this->listMatch    = array();
        $tabListPari        = array();

        if(is_object($datas->listPari) === true && empty($datas->listPari) === false) {
            foreach($datas->listPari as $pari) {
                if($pari->idUser === $this->getIdUserConnecter()) {
                    $tabListPari[$pari->idMatch] = $pari;
                }
            }
            unset($pari);
        }
        
        if(is_object($datas->listMatch) && empty($datas->listMatch) === false) {
            $datetime = new DateTime();
            foreach($datas->listMatch as $match) {
                $datetime->add(new DateInterval('P1D'));

                $idMatch = $match->id;

                if(empty($tabListPari) === true || empty($tabListPari[$idMatch]) === true) {
                    $idTeamA       = $match->teamA;
                    $idTeamB       = $match->teamB;
                    $idGroupeMatch = $match->idGroupeMatch;
                    $idTypePari    = 1;
                    $coteNul       = 0;
                    
                    $this->listMatch[$idMatch] = (object)array(
                        'idMatch'    => $idMatch,
                        'date'       => new DateTime($match->date),
                        'dateFausse' => $datetime->format('d/m/Y'),
                        'typeMatch'  => $datas->listGroupeMatch->$idGroupeMatch->groupe,
                        'teamA'      => (object)array(
                            'idTeam' => $idTeamA,
                            'equipe' => $datas->listTeam->$idTeamA->nom,
                            'flag'   => $datas->listTeam->$idTeamA->iso2,
                            'cote'   => $datas->listCotesLast->$idMatch->$idTypePari->$idTeamA->cote,
                            'idCote' => $datas->listCotesLast->$idMatch->$idTypePari->$idTeamA->id,
                        ),
                        'teamB'      => (object)array(
                            'idTeam' => $idTeamB,
                            'equipe' => $datas->listTeam->$idTeamB->nom,
                            'flag'   => $datas->listTeam->$idTeamB->iso2,
                            'cote'   => $datas->listCotesLast->$idMatch->$idTypePari->$idTeamB->cote,
                            'idCote' => $datas->listCotesLast->$idMatch->$idTypePari->$idTeamB->id,
                        ),
                        'teamNull'      => (object)array(
                            'idTeam' => 0,
                            'equipe' => 'Match Nul',
                            'flag'   => $datas->listTeam->$idTeamB->iso2,
                            'cote'   => $datas->listCotesLast->$idMatch->$idTypePari->$coteNul->cote,
                            'idCote' => $datas->listCotesLast->$idMatch->$idTypePari->$coteNul->id,
                        ),
                    );
                    unset($idTeamA, $idTeamB, $idTypePari, $coteNul, $idGroupeMatch);
                }

                unset($idMatch);
            }
            unset($datetime, $match);
        }
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