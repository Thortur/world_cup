<?php
declare(strict_types = 1);
namespace Team;

class Team {

    private $id;
    private $nom;
    private $iso;

    public function __construct($data) {
        $this->setId($data['id']);
        $this->setNom($data['nom']);
        $this->setIso($data['iso']);
    }

    /**
     * @param int $id de la team
     */
    public function setId($id) {
        $this->id = (int)$id;
    }

    /**
     * @return int id de la team
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param string $nom de la team
     */
    public function setNom($nom) {
        $this->nom = (string)$nom;
    }

    /**
     * @return string nom de la team
     */
    public function getNom() {
        return $this->nom;
    }

    /**
     * @param string $nom de la team
     */
    public function setIso($iso) {
        $this->iso = (string)$iso;
    }

    /**
     * @return string nom de la team
     */
    public function getIso() {
        return $this->iso;
    }

    /**
     * Retourne la flag de la team
     * 
     * @return string $flag
     */
    public function getflag() {
        return $flag;
    }
}