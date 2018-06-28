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

    private function getNumMatch(int $idMatch) {
        $numMatch = (string)$idMatch;
        for($i = 1; $i <= 3; $i++) {
            if(strlen($numMatch) < $i) {
                $numMatch = '0'.$numMatch;
            }
        }

        return $numMatch;
    }

    /**
     * Retoure le code html de la carte des paris
     * 
     * @return string $html
     */
    public function getCard() {
        $html       = '';
        $dateNow    = new DateTime();
        /*
        $listMatch  = array(
            'parisEnCours'  => array(),
            'parisTerminer' => array(),
        );
        $listOnglet = array(
            'parisEnCours'  => 'Paris en cours',
            'parisTerminer' => 'Paris terminer',
        );
        $listPari = array();

        if(is_array($this->listMatch) === true && empty($this->listMatch) === false) {
            foreach($this->listMatch as $match) {
                $dateString = $match->date->format('Y-m-d H:i');
                $code = 'parisEnCours';
                if($match->date <= $dateNow) {
                    $code = 'parisTerminer';
                }
                $listMatch[$code][$dateString][$match->idMatch] = $match;

                $numMatch = $this->getNumMatch((int)$match->idMatch);
                if(empty($listPari[$numMatch]) === true) {
                    if($numMatch !== '000') {
                        $listPari[$numMatch] = array();
                    }
                }
            }
            unset($match);
        }
        krsort($listMatch['parisEnCours']);
        krsort($listMatch['parisTerminer']);
        // krsort($listPari);
        
        if(is_array($this->listHistoPari) === true && empty($this->listHistoPari) === false) {
            foreach($this->listHistoPari as $pari) {
                $numMatch = $this->getNumMatch((int)$pari->idMatch);
                $listPari[$numMatch][$pari->idTypePari] = $pari;
            }
            unset($pari, $numMatch);
        }
        // echo '<pre>';
        // print_r($listMatch);
        // echo '</pre>';
*/
        $html = '<div class="card">';
            $html .= '<div class="card-header card-head-inverse bg-blue">';
                $html .= '<h4 class="card-title">VOS PARIS REALISES</h4>';
            $html .= '</div>';
            $html .= '<div class="card-content collapse show">';
                $html .= '<div class="card-body card-dashboard">';
                    $html .= '<table class="table table-striped table-bordered base-style">';
                        $html .= '<thead>';
                            $html .= $this->getHeaderTableClassement();
                        $html .= '</thead>';
                        $html .= '<tbody>';
                            // if(empty($listMatch) === false) {
                            //     foreach($listMatch as $code => $data){
                            //         if(is_array($data) === true && empty($data) === false) {
                            //             foreach($data as $match) {

                            //             }
                            //             unset($match);
                            //         }
                            //     }
                            //     unse($code, $data);
                            // }
                            if(is_array($this->listHistoPari)) {
                                foreach($this->listHistoPari as $pari) {
                                    $idCote     = $pari->idCotes;
                                    $idTeamPari = $this->listCotesHisto->$idCote->idTeam;
                                    $team = 'teamNull';
                                    if($idTeamPari === $this->listMatch[$pari->idMatch]->teamA->idTeam) {
                                        $team = 'teamA';
                                    }
                                    else if($idTeamPari === $this->listMatch[$pari->idMatch]->teamB->idTeam){
                                        $team = 'teamB';
                                    }
                                    $html .= '<tr>';
                                        $html .= '<td>'.$this->listMatch[$pari->idMatch]->date->format('d/m/Y H:i').'</td>';
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
                            $html .= $this->getHeaderTableClassement();
                        $html .= '</tfoot>';
                    $html .= '</table>';
                $html .= '</div>';
            $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    private function getHeaderTableClassement() {
        $html = '<tr>';
            $html .= '<th>Date Match</th>';
            $html .= '<th>Match</th>';
            $html .= '<th>Mise</th>';
            $html .= '<th>Choix</th>';
            $html .= '<th>Cote</th>';
            $html .= '<th>Résultat</th>';
            $html .= '<th>Date</th>';
        $html .= '</tr>';

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
                        'flag'   => '_United Nations',
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