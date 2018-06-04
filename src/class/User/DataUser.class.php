<?php
declare(strict_types = 1);
namespace User;
use \DateTime;
use Cagnotte\Cagnotte;

class DataUser {
    /**
     * list historique cagnotte
     * 
     * @var array list de cagnotte
     */
    protected $cagnotte;
    /**
     * Construct
     * 
     * @param float $cagnotteEnCours
     */
    protected $cagnotteEnCours;

    public function __construct(array $data)
    {
        if(empty($data['cagnotte']) === true) {
            $data['cagnotte'] = array();
        }
        $this->setCagnotte($data['cagnotte']);
    }

    protected function recalculCagnotteEnCours() {
        $this->cagnotteEnCours = 0;
        if(is_array($this->cagnotte) === true && empty($this->cagnotte) === false) {
            foreach($this->cagnotte as $Cagnotte) {
                $this->cagnotteEnCours += $Cagnotte->getMontant();
            }
            unset($Cagnotte);
        }
    }

    /**
     * Get list de cagnotte
     *
     * @return  array
     */ 
    public function getCagnotte()
    {
        return $this->cagnotte;
    }

    /**
     * Set list de cagnotte
     *
     * @param  array  $cagnotte  list de cagnotte
     *
     * @return  self
     */ 
    public function setCagnotte(array $cagnotte)
    {
        $this->cagnotte = $cagnotte;
        $this->recalculCagnotteEnCours();
        return $this;
    }

    /**
     * Get construct
     */ 
    public function getCagnotteEnCours()
    {
        return $this->cagnotteEnCours;
    }

    /**
     * Set construct
     *
     * @return  self
     */ 
    public function setCagnotteEnCours($cagnotteEnCours)
    {
        $this->cagnotteEnCours = $cagnotteEnCours;

        return $this;
    }
}