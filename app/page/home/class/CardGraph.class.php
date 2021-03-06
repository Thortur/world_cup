<?php
namespace WorldCup;

class CardGraph {
    /**
     * id utilisateur connecter
     * 
     * @var int $idUserConnecter
     */
    private $idUserConnecter;

    /**
     * Construct de la class
     * 
     * @param object $datas
     */
    public function __construct(int $idUserConnecter, object $datas) {
        $this->setIdUserConnecter($idUserConnecter);
        $this->dataGraph = $this->calculGraph($datas);
        $this->dataGraphDraw = $this->drawGraph($this->dataGraph);
        // echo '<pre>'.print_r($datas,true).'</pre>';
    }

    /**
     * Retoure le code html de la carte des paris
     * 
     * @return string $html
     */
    public function getCard($datas) {

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

    private function calculGraph(object $datas) {
        // echo '<pre>';
        // print_r($datas->listTeam);
        // echo '</pre>';
        if(is_object($datas->listPari)) {
            foreach($datas->listPari as $pari) {
                $tabUser[$pari->idUser][$pari->idMatch]['montant'] = $pari->montant;
                $tabUser[$pari->idUser][$pari->idMatch]['gain'] = $pari->gain;
            }
        }

        if(is_object($datas->listResultat)) {
            if(is_array($tabUser)) {
                foreach($tabUser as $k_user => $v_user) {
                    $tab[0][$k_user] = 500;
                    $cagnotte[$k_user] = 500;

                    foreach($datas->listResultat as $k_match => $v_match) {
                        if(in_array($k_match,array(17,33))) {
                            $cagnotte[$k_user] += 500;
                        }
                        $cagnotte[$k_user] -= $v_user[$k_match]['montant'];
                        $cagnotte[$k_user] += $v_user[$k_match]['gain'];
                        $tab[$k_match][$k_user] = $cagnotte[$k_user];
                    }
                }
            }
        }

        return $tab;
    }

    private function drawGraph(array $tab) {
        $sepa      = null;
        $tabReturn = array(
            'label'   => null,
            'moyenne' => null,
            'perso'   => null,
        );

        if(is_array($tab) === true && empty($tab) === false) {
            foreach($tab as $k_match => $v_match) {
                $moy = 0;
                $per = 0;
                if(is_array($v_match) === true && empty($v_match) === false) {
                    $total = 0;
                    foreach($v_match as $k_user => $v_user) {
                        $total += $v_user;
                        if($k_user === $this->getIdUserConnecter()) {
                            $per = $v_user;
                        }
                    }
                    unset($k_user, $v_user);
                    $moy = round(($total / count($v_match)),0);
                }
                $tabReturn['label']   .= $sepa.'"Match '.$k_match.'"';
                $tabReturn['moyenne'] .= $sepa.$moy;
                $tabReturn['perso']   .= $sepa.$per;
                $sepa = ',';
            }
            unset($k_match, $v_match, $moy, $per);
        }


        return $tabReturn;
    }
}