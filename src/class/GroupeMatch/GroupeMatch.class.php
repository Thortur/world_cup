<?php
declare(strict_types = 1);
namespace GroupeMatch;

class GroupeMatch {
    /**
     * id groupe match
     *
     * @var int
     */
    private $id;
    /**
     * groupe
     *
     * @var string
     */
    private $groupe;

    /**
     * Construct
     * 
     * @param array $data
     */
    public function __construct(array $data) {
        $this->setId((int)$data['id']);
        $this->setGroupe((string)$data['groupe']);
    }
    

    /**
     * Get id groupe match
     *
     * @return  int
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id groupe match
     *
     * @param  int  $id  id groupe match
     *
     * @return  self
     */ 
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get groupe
     *
     * @return  string
     */ 
    public function getGroupe()
    {
        return $this->groupe;
    }

    /**
     * Set groupe
     *
     * @param  string  $groupe  groupe
     *
     * @return  self
     */ 
    public function setGroupe(string $groupe)
    {
        $this->groupe = $groupe;

        return $this;
    }
}