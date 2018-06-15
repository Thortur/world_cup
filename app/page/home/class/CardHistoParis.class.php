<?php
namespace WorldCup;
use \DateTime;

class CardHistoParis {
    /**
     * id utilisateur connecter
     * 
     * @var int $idUserConnecter
     */
    private $idUserConnecter;
    /**
     * liste des matchs
     * 
     * @var array $listMatch
     */
    private $listMatch;
    /**
     * liste des historque des paris
     * 
     * @var array $listHistoPari
     */
    private $listHistoPari;
    /**
     * liste des historque des cotes
     * 
     * @var array $listCotesHisto
     */
    private $listCotesHisto;

    /**
     * Construct de la class
     * 
     * @param object $datas
     */
    public function __construct(int $idUserConnecter, object $datas) {
        $this->setIdUserConnecter($idUserConnecter);
        $this->setListMatch($datas);
        $this->setListHistoPari($datas->listPari);
        $this->setListCotesHisto($datas->listCotesHisto);
    }

    /**
     * Retoure le code html de la carte des paris
     * 
     * @return string $html
     */
    public function getCard() {
        $html = '<div class="card">';
            $html .= '<div class="card-header card-head-inverse bg-blue"">';
                $html .= '<h4 class="card-title">VOS PARIS REALISES</h4>';
            $html .= '</div>';
            $html .= '<div class="card-content collapse show">';
                $html .= '<div class="card-body card-dashboard">';
                    $html .= '<table class="table table-striped table-bordered base-style">';
                        $html .= '<thead>';
                            $html .= '<tr>';
                                $html .= '<th>Match</th>';
                                $html .= '<th>Mise</th>';
                                $html .= '<th>Choix</th>';
                                $html .= '<th>Cote</th>';
                                $html .= '<th>Résultat</th>';
                                $html .= '<th>Date</th>';
                            $html .= '</tr>';
                        $html .= '</thead>';
                        $html .= '<tbody>';
                            if(is_array($this->listHistoPari)) {
                                foreach($this->listHistoPari as $pari) {
                                    $idCote     = $pari->idCotes;
                                    $idTeamPari = $this->listCotesHisto->$idCote->idTeam;
                                    $team       = 'teamA';
                                    if($idTeamPari === $this->listMatch[$pari->idMatch]->teamB->idTeam) {
                                        $team = 'teamB';
                                    }
                                    $html .= '<tr>';
                                        $html .= '<td>'.$this->listMatch[$pari->idMatch]->teamA->equipe.' - '.$this->listMatch[$pari->idMatch]->teamB->equipe.'</td>';
                                        $html .= '<td>'.$pari->montant.'</td>';
                                        $html .= '<td><img class="flag" src="/src/images/flags/'.$this->listMatch[$pari->idMatch]->$team->flag.'.png" style="width:24px;"></td>';
                                        $html .= '<td>'.number_format($this->listCotesHisto->$idCote->cote,2,'.','').'</td>';
                                        $html .= '<td>'.$pari->gain.'</td>';
                                        $html .= '<td>'.$pari->date->format('d/m/Y H:i:s').'</td>';
                                    $html .= '</tr>';
                                    unset($idCote, $idTeamPari);
                                }
                                unset($pari);
                            }
                            unset($tabHistoPari);
                        $html .= '</tbody>';
                        $html .= '<tfoot>';
                            $html .= '<tr>';
                                $html .= '<th>Match</th>';
                                $html .= '<th>Mise</th>';
                                $html .= '<th>Choix</th>';
                                $html .= '<th>Cote</th>';
                                $html .= '<th>Résultat</th>';
                                $html .= '<th>Date</th>';
                            $html .= '</tr>';
                        $html .= '</tfoot>';
                    $html .= '</table>';
                $html .= '</div>';
            $html .= '</div>';
        $html .= '</div>';

        return $html;
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
     * Get $listHistoPari
     *
     * @return  array
     */ 
    public function getListHistoPari()
    {
        return $this->listHistoPari;
    }

    /**
     * Set $listHistoPari
     *
     * @param  object  $listHistoPari  $listHistoPari
     *
     * @return  self
     */ 
    public function setListHistoPari(object $listPari)
    {
        $this->listHistoPari = array();
        if(is_object($listPari)) {
            foreach($listPari as $pari) {
                if($pari->idUser === $this->getIdUserConnecter()) {
                    $this->listHistoPari[$pari->id] = clone $pari;
                    $this->listHistoPari[$pari->id]->date = new DateTime($this->listHistoPari[$pari->id]->date);
                }
            }
            unset($pari);
        }

        return $this;
    }

    /**
     * Get $listHistoPari
     *
     * @return  array
     */ 
    public function getListMatch()
    {
        return $this->listMatch;
    }

    /**
     * Set $listHistoPari
     *
     * @param  object  $listMatch  $datas
     *
     * @return  self
     */ 
    public function setListMatch(object $datas)
    {
        $this->listMatch = array();
        
        if(is_object($datas->listMatch) && empty($datas->listMatch) === false) {
            foreach($datas->listMatch as $match) {
                $idMatch       = $match->id;
                $idTeamA       = $match->teamA;
                $idTeamB       = $match->teamB;
                $idGroupeMatch = $match->idGroupeMatch;
                $idTypePari    = 1;
                $coteNul       = 0;
                
                $this->listMatch[$idMatch] = (object)array(
                    'idMatch'    => $idMatch,
                    'date'       => new DateTime($match->date),
                    'typeMatch'  => $datas->listGroupeMatch->$idGroupeMatch->groupe,
                    'teamA'      => (object)array(
                        'idTeam' => $idTeamA,
                        'equipe' => $datas->listTeam->$idTeamA->nom,
                        'flag'   => $datas->listTeam->$idTeamA->iso2,
                    ),
                    'teamB'      => (object)array(
                        'idTeam' => $idTeamB,
                        'equipe' => $datas->listTeam->$idTeamB->nom,
                        'flag'   => $datas->listTeam->$idTeamB->iso2,
                    ),
                    'teamNull'      => (object)array(
                        'idTeam' => 0,
                        'equipe' => 'Match Nul',
                        'flag'   => $datas->listTeam->$idTeamB->iso2,
                    ),
                );
                unset($idTeamA, $idTeamB, $idTypePari, $coteNul, $idGroupeMatch);
            }
        }

        return $this;
    }

    /**
     * Get $listCotesHisto
     *
     * @return  array
     */ 
    public function getListCotesHisto()
    {
        return $this->listCotesHisto;
    }

    /**
     * Set $listCotesHisto
     *
     * @param  object  $listCotesHisto  $listCotesHisto
     *
     * @return  self
     */ 
    public function setListCotesHisto(object $listCotesHisto)
    {
        $this->listCotesHisto = $listCotesHisto;

        return $this;
    }
}