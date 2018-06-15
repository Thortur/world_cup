<?php
namespace WorldCup;

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
     * Construct de la class
     * 
     * @param object $datas
     */
    public function __construct(int $idUserConnecter, object $datas) {
        $this->setIdUserConnecter($idUserConnecter);
        $this->setListUser($datas);
        $this->setListCagnotte($datas->listCagnotte);
    }

    /**
     * Retoure le code html de la carte classement
     * 
     * @return string $html
     */
    public function getCard() {
        $html = '<div class="card">';
            $html .= '<div class="card-header card-head-inverse bg-blue"">';
                $html .= '<h4 class="card-title">CLASSEMENT</h4>';
            $html .= '</div>';
            $html .= '<div class="card-content collapse show">';
                $html .= '<div class="card-body card-dashboard">';
                    $html .= '<table class="table table-striped table-bordered base-style">';
                        $html .= '<thead>';
                            $html .= '<tr>';
                                $html .= '<th>Avatar</th>';
                                $html .= '<th>Joueur</th>';
                                $html .= '<th>Cagnotte</th>';
                                $html .= '<th>Paris gagnés</th>';
                                $html .= '<th>Total côtes</th>';
                                $html .= '<th>Total des mises</th>';
                            $html .= '</tr>';
                        $html .= '</thead>';
                        $html .= '<tbody>';
                            if(empty($this->getListUser()) === false) {
                                foreach($this->getListUser() as $user) {
                                    $html .= '<tr>';
                                        $html .= '<td><span class="avatar"><img src="/src/images/portrait/dessin/'.$user->avatar.'.png" alt="avatar"><i></i></span></td>';
                                        $html .= '<td>'.$user->pseudo.'</td>';
                                        $html .= '<td>'.$this->listCagnotte[$user->id]->montant.' €</td>';
                                        $html .= '<td>'.$user->pariWin.'</td>';
                                        $html .= '<td>1</td>';
                                        $html .= '<td>'.$this->listCagnotte[$user->id]->totalMise.' €</td>';
                                    $html .= '</tr>';
                                }
                                unset($user);
                            }
                        $html .= '</tbody>';
                        $html .= '<tfoot>';
                            $html .= '<tr>';
                                $html .= '<th>Avatar</th>';
                                $html .= '<th>Joueur</th>';
                                $html .= '<th>Cagnotte</th>';
                                $html .= '<th>Paris gagnés</th>';
                                $html .= '<th>Total côtes</th>';
                                $html .= '<th>Total des mises</th>';
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
                    'pariWin'  => 0,
                );
            }
            unset($User);
        }
        if(is_array($datas->listPari) === true && empty($datas->listPari) === false) {
            foreach($datas->listPari as $pari) {
                if(empty($this->listUser[$user->id]) === false && $pari->gain > 0) {
                    $this->listUser[$pari->idUser]->pariWin++;
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

}