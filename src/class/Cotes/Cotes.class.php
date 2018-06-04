<?php
declare(strict_types = 1);
namespace Cotes;
use \DateTime;

class Cotes {
    /**
     * id Cotes
     *
     * @var int
     */
    private $id;
    /**
     * id du match
     *
     * @var int
     */
    private $idMatch;
    /**
     * type de pari
     *
     * @var int
     */
    private $idTypePari;
    /**
     * id team
     *
     * @var int
     */
    private $idTeam;
    /**
     * id cote
     *
     * @var float
     */
    private $cote;
    /**
     * date de la cote
     *
     * @var DateTime
     */
    private $date;

    /**
     * Construct
     * 
     * @param array $data
     */
    public function __construct(array $data) {
        $this->setId((int)$data['id']);
        $this->setIdMatch((int)$data['idMatch']);
        $this->setIdTypePari((int)$data['idTypePari']);
        $this->setIdTeam((int)$data['idTeam']);
        $this->setIdTeam((int)$data['idTeam']);
        $this->setCote((float)$data['cote']);
        $this->setDate($data['date']);
    }

    /**
     * Get id Cotes
     *
     * @return  int
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id Cotes
     *
     * @param  int  $id  id Cotes
     *
     * @return  self
     */ 
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id du match
     *
     * @return  int
     */ 
    public function getIdMatch()
    {
        return $this->idMatch;
    }

    /**
     * Set id du match
     *
     * @param  int  $idMatch  id du match
     *
     * @return  self
     */ 
    public function setIdMatch(int $idMatch)
    {
        $this->idMatch = $idMatch;

        return $this;
    }

    /**
     * Get type de pari
     *
     * @return  string
     */ 
    public function getIdTypePari()
    {
        return $this->idTypePari;
    }

    /**
     * Set type de pari
     *
     * @param  int  $idTypePari id type de pari
     *
     * @return  self
     */ 
    public function setIdTypePari(int $idTypePari)
    {
        $this->idTypePari = $idTypePari;

        return $this;
    }

    /**
     * Get id team
     *
     * @return  int
     */ 
    public function getIdTeam()
    {
        return $this->idTeam;
    }

    /**
     * Set id team
     *
     * @param  int  $idTeam  id team
     *
     * @return  self
     */ 
    public function setIdTeam(int $idTeam)
    {
        $this->idTeam = $idTeam;

        return $this;
    }

    /**
     * Get id cote
     *
     * @return  float
     */ 
    public function getCote()
    {
        return $this->cote;
    }

    /**
     * Set id cote
     *
     * @param  float  $cote  id cote
     *
     * @return  self
     */ 
    public function setCote(float $cote)
    {
        $this->cote = $cote;

        return $this;
    }

    /**
     * Get date de la cote
     *
     * @return DateTime
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set date de la cote
     *
     * @param DateTime|string  $date  date de la cote
     *
     * @return  self
     */ 
    public function setDate($date)
    {
        if($date instanceof DateTime) {
            $this->date = $date;
        }
        else {
            $this->date = new DateTime($date);
        }

        return $this;
    }
}