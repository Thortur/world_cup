<?php
declare(strict_types = 1);
namespace GroupeMatchDetail;

class GroupeMatchDetail {
    /**
     * id type groupe match detail
     *
     * @var int
     */
    private $id;
    /**
     * id groupe
     *
     * @var int
     */
    private $idGroupeMatch;
    /**
     * ordre de la team dans le groupe
     *
     * @var int
     */
    private $ordre;

    /**
     * id de la team
     *
     * @var int
     */
    private $idTeam;


    /**
     * Construct
     * 
     * @param array $data
     */
    public function __construct(array $data) {
        $this->setId((int)$data['id']);
        $this->setIdGroupeMatch((int)$data['idGroupeMatch']);
        $this->setOrdre((int)$data['ordre']);
        $this->setIdTeam((int)$data['idTeam']);
    }
    

    /**
     * Get id type pari
     *
     * @return  int
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id type pari
     *
     * @param  int  $id  id type pari
     *
     * @return  self
     */ 
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    

    /**
     * Get id groupe
     *
     * @return  int
     */ 
    public function getIdGroupeMatch()
    {
        return $this->idGroupeMatch;
    }

    /**
     * Set id groupe
     *
     * @param  int  $idGroupeMatch  id groupe
     *
     * @return  self
     */ 
    public function setIdGroupeMatch(int $idGroupeMatch)
    {
        $this->idGroupeMatch = $idGroupeMatch;

        return $this;
    }

    /**
     * Get ordre de la team dans le groupe
     *
     * @return  int
     */ 
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Set ordre de la team dans le groupe
     *
     * @param  int  $ordre  ordre de la team dans le groupe
     *
     * @return  self
     */ 
    public function setOrdre(int $ordre)
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * Get id de la team
     *
     * @return  int
     */ 
    public function getIdTeam()
    {
        return $this->idTeam;
    }

    /**
     * Set id de la team
     *
     * @param  int  $idTeam  id de la team
     *
     * @return  self
     */ 
    public function setIdTeam(int $idTeam)
    {
        $this->idTeam = $idTeam;

        return $this;
    }
}