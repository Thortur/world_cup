<?php
namespace WorldCup;
use \DateTime;

class CardClassement {
    /**
     * id utilisateur connecter
     * 
     * @var int $idUserConnecter
     */
    private $idUserConnecter;
    /**
     * list des utilisateurs
     * 
     * @var array $listUser
     */
    private $listUser;
    /**
     * list des cagnottes
     * 
     * @var array $listCagnotte
     */
    private $listCagnotte;
    /**
     * nombre de pari terminer
     * 
     * @var int $nbParisEnd
     */
    private $nbParisEnd;
    /**
     * liste des groupe de l'utilisateur
     * 
     * @var array $listGroupeUser
     */
    private $listGroupeUser;

    /**
     * Construct de la class
     * 
     * @param object $datas
     */
    public function __construct(int $idUserConnecter, object $datas) {
        $this->setIdUserConnecter($idUserConnecter);
        $this->setListUser($datas);
        $this->setListCagnotte($datas->listCagnotte);
        $this->setNbParisEnd($datas->listResultat);
        $this->setListGroupeUser($datas);
    }

    /**
     * Retoure le code html de la carte classement
     * 
     * @return string $html
     */
    public function getCard() {
        $htmlHeaderTab = '<ul class="nav nav-tabs" id="ongletGroupeMatchHeader" role="tablist">';
        $htmlContentTab = '<div class="tab-content" id="ongletGroupeMatchContent">';
        if(is_array($this->listGroupeUser) === true && empty($this->listGroupeUser) === false) {
            $clasShowTabHeader = ' active';
            $clasShowTabContent = ' show active';
            foreach($this->listGroupeUser as $groupe) {
                $htmlHeaderTab .= '<li class="nav-item">';
                    $htmlHeaderTab .= '<a class="nav-link'.$clasShowTabHeader.'" id="'.$groupe->code.'-tab" data-toggle="tab" href="#'.$groupe->code.'" role="tab" aria-controls="'.$groupe->code.'" aria-selected="true">'.$groupe->nom.'</a>';
                $htmlHeaderTab .= '</li>';

                $htmlContentTab .= '<div class="tab-pane fade'.$clasShowTabContent.'" id="'.$groupe->code.'" role="tabpanel" aria-labelledby="'.$groupe->code.'-tab">';
                    $htmlContentTab .= '<table class="table table-striped table-bordered base-style">';
                        $htmlContentTab .= '<thead>';
                            $htmlContentTab .= $this->getHeaderTableClassement();
                        $htmlContentTab .= '</thead>';
                        $htmlContentTab .= '<tbody>';
                            if(empty($groupe->listUser) === false) {
                                foreach($groupe->listUser as $idUser) {
                                    $user = $this->listUser[$idUser];

                                    $htmlContentTab .= '<tr>';
                                        $htmlContentTab .= '<td><span class="avatar"><img src="/src/images/portrait/dessin/'.$user->avatar.'.png" alt="avatar"><i></i></span></td>';
                                        $htmlContentTab .= '<td>'.$user->pseudo.'</td>';
                                        $htmlContentTab .= '<td>'.$this->listCagnotte[$user->id]->montant.' €</td>';
                                        $htmlContentTab .= '<td>'.$user->pariWin.'</td>';
                                        $htmlContentTab .= '<td>'.$user->nbPari.'</td>';
                                        $htmlContentTab .= '<td>'.$this->listCagnotte[$user->id]->totalMise.' €</td>';
                                    $htmlContentTab .= '</tr>';
                                }
                                unset($idUser, $user);
                            }
                        $htmlContentTab .= '</tbody>';
                        $htmlContentTab .= '<tfoot>';
                            $htmlContentTab .= $this->getHeaderTableClassement();
                        $htmlContentTab .= '</tfoot>';
                    $htmlContentTab .= '</table>';
                $htmlContentTab .= '</div>';

                $clasShowTabHeader = null;
                $clasShowTabContent = null;
            }
            unset($groupe, $clasShowTabHeader, $clasShowTabContent);
        }
        $htmlHeaderTab .= '</ul>';
        $htmlContentTab .= '</div>';
        $html = '<div class="card">';
            $html .= '<div class="card-header card-head-inverse bg-blue"">';
                $html .= '<h4 class="card-title">CLASSEMENT</h4>';
            $html .= '</div>';
            $html .= '<div class="card-content collapse show">';
                $html .= '<div class="card-body card-dashboard">';
                    $html .= $htmlHeaderTab;
                    $html .= $htmlContentTab;
                $html .= '</div>';
            $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    private function getHeaderTableClassement() {
        $html = '<tr>';
            $html .= '<th>Avatar</th>';
            $html .= '<th>Joueur</th>';
            $html .= '<th>Cagnotte</th>';
            $html .= '<th>Paris gagnés (sur '.$this->getNbParisEnd().')</th>';
            $html .= '<th>Nb Paris</th>';
            $html .= '<th>Total des mises</th>';
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
     * Get $listUser
     *
     * @return  array
     */ 
    public function getListUser()
    {
        return $this->listUser;
    }

    /**
     * Set $listUser
     *
     * @param  object  $datas
     *
     * @return  self
     */ 
    public function setListUser(object $datas)
    {
        $this->listUser = array();
        if(is_object($datas->listUser) === true && empty($datas->listUser) === false) {
            foreach($datas->listUser as $user) {
                $this->listUser[$user->id] = (object)array(
                    'id'       => $user->id,
                    'pseudo'   => $user->pseudo,
                    'avatar'   => $user->avatar,
                    'mail'     => $user->mail,
                    'nbPari'   => 0,
                    'pariWin'  => 0,
                );
            }
            unset($User);
        }
        if(is_object($datas->listPari) === true && empty($datas->listPari) === false) {
            foreach($datas->listPari as $pari) {
                if(empty($this->listUser[$pari->idUser]) === false) {
                    $this->listUser[$pari->idUser]->nbPari++;
                    if($pari->gain > 0) {
                        $this->listUser[$pari->idUser]->pariWin++;
                    }
                }
            }
            unset($pari);
        }

        return $this;
    }

    /**
     * Get $listCagnotte
     *
     * @return  array
     */ 
    public function getListCagnotte()
    {
        return $this->listCagnotte;
    }

    /**
     * Set $listCagnotte
     *
     * @param  array  $listCagnotte  $listCagnotte
     *
     * @return  self
     */ 
    public function setListCagnotte(object $listCagnotte)
    {
        $this->listCagnotte = array();
        if(is_object($listCagnotte) === true && empty($listCagnotte) === false) {
            foreach($listCagnotte as $listRowCagnotteUser) {
                if(is_array($listRowCagnotteUser) === true && empty($listRowCagnotteUser) === false) {
                    foreach($listRowCagnotteUser as $cagnotte) {
                        if(empty($this->listUser[$cagnotte->idUser]) === false) {
                            if(empty($this->listCagnotte[$cagnotte->idUser]) === true) {
                                $this->listCagnotte[$cagnotte->idUser] = (object)array(
                                    'montant'   => 0,
                                    'totalMise' => 0,
                                    'detail'    => array(),
                                );
                            }
                            $this->listCagnotte[$cagnotte->idUser]->detail[$cagnotte->id] = $cagnotte;
                            $this->listCagnotte[$cagnotte->idUser]->montant += $cagnotte->montant;
                            if($cagnotte->montant < 0) {
                                $this->listCagnotte[$cagnotte->idUser]->totalMise += $cagnotte->montant * -1;
                            }
                        }
                    }
                    unset($cagnotte);
                }
            }
            unset($listRowCagnotteUser);
        }

        return $this;
    }


    /**
     * Get $nbParisEnd
     *
     * @return  int
     */ 
    public function getNbParisEnd()
    {
        return $this->nbParisEnd;
    }

    /**
     * Set $nbParisEnd
     *
     * @param  object  $listResultat  $listResultat
     *
     * @return  self
     */ 
    public function setNbParisEnd(object $listResultat)
    {
        $this->nbParisEnd = count((array)$listResultat);

        return $this;
    }

    /**
     * Get $listGroupeUser
     *
     * @return  int
     */ 
    public function getListGroupeUser()
    {
        return $this->listGroupeUser;
    }

    /**
     * Set $listGroupeUser
     *
     * @param  object  $datas  $datas
     *
     * @return  self
     */ 
    public function setListGroupeUser(object $datas)
    {
        $idGroupeGenerale = 1;
        $this->listGroupeUser = array();

        if(is_object($datas->listGroupeUser) === true && empty($datas->listGroupeUser) === false) {
            foreach($datas->listGroupeUser as $groupeUser) {
                if($groupeUser->code === 'generale') {
                    $this->listGroupeUser[$groupeUser->id] = $groupeUser;
                    $this->listGroupeUser[$groupeUser->id]->listUser = new class{};
                    
                    if(is_object($datas->listUser) === true && empty($datas->listUser) === false) {
                        $listUserGroupeGenerale = array();
                        foreach($datas->listUser as $user) {
                            $listUserGroupeGenerale[] = $user->id;
                        }
                        $this->listGroupeUser[$groupeUser->id]->listUser = (object)$listUserGroupeGenerale;
                        unset($user, $listUserGroupeGenerale);
                    }
                }
                else {
                    $idGroupUser = $groupeUser->id;
                    if(is_object($datas->listGroupeUserDetail->$idGroupUser) === true && empty($datas->listGroupeUserDetail->$idGroupUser) === false) {
                        foreach($datas->listGroupeUserDetail->$idGroupUser as $userGroupe) {
                            if($userGroupe->idUser === $this->getIdUserConnecter() || $this->getIdUserConnecter() === 1) {
                                $this->listGroupeUser[$groupeUser->id] = $groupeUser;
                                $this->listGroupeUser[$groupeUser->id]->listUser = new class{};
                                
                                $listUserGroupeGenerale = array();
                                foreach($datas->listGroupeUserDetail->$idGroupUser as $userGroupeTemp) {
                                    $listUserGroupeGenerale[] = $userGroupeTemp->idUser;
                                }
                                $this->listGroupeUser[$groupeUser->id]->listUser = (object)$listUserGroupeGenerale;
                                unset($listUserGroupeGenerale);
                                break;
                            }
                        }
                        unset($userGroupe);
                    }
                }
            }
            unset($groupeUser);
        }

        return $this;
    }
}