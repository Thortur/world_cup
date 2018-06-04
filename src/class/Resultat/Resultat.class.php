<?php
declare(strict_types = 1);
namespace Resultat;

class Resultat {
    /**
     * id resultat
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
     * id de la Team
     *
     * @var int
     */
    private $idTeam;
    /**
     * score du match
     *
     * @var int
     */
    private $score;

    /**
     * Construct
     * 
     * @param array $data
     */
    public function __constract($data) {
        $this->setId((int)$data['id']);
        $this->setIdMatch((int)$data['idMatch']);
        $this->setIdTeam((int)$data['idTeam']);
        $this->setScore((int)$data['score']);
    }

    /**
     * Get id resultat
     *
     * @return  int
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id resultat
     *
     * @param  int  $id  id resultat
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
     * Get id de la Team
     *
     * @return  int
     */ 
    public function getIdTeam()
    {
        return $this->idTeam;
    }

    /**
     * Set id de la Team
     *
     * @param  int  $idTeam  id de la Team
     *
     * @return  self
     */ 
    public function setIdTeam(int $idTeam)
    {
        $this->idTeam = $idTeam;

        return $this;
    }

    /**
     * Get score du match
     *
     * @return  int
     */ 
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set score du match
     *
     * @param  int  $score  score du match
     *
     * @return  self
     */ 
    public function setScore(int $score)
    {
        $this->score = $score;

        return $this;
    }
}