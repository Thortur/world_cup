<?php
declare(strict_types = 1);
namespace Team;

class Team {
    /**
     * id team
     *
     * @var int
     */
    private $id;
    /**
     * nom de la team
     *
     * @var string
     */
    private $nom;
    /**
     * si pour les flag
     *
     * @var string
     */
    private $iso;

    /**
     * Construct
     * 
     * @param array $data
     */
    public function __construct(array $data) {
        $this->setId((int)$data['id']);
        $this->setNom((string)$data['nom']);
        $this->setIso((string)$data['iso']);
    }

    /**
     * @param int $id de la team
     */
    public function setId(int $id) {
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
    public function setNom(string $nom) {
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
    public function setIso(string $iso) {
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