<?php
declare(strict_types = 1);
namespace TypeParis;

class TypeParis {
    /**
     * id type paris
     *
     * @var int
     */
    private $id;
    /**
     * type de paris
     *
     * @var string
     */
    private $typeParis;

    /**
     * Construct
     * 
     * @param array $data
     */
    public function __construct(array $data) {
        $this->setId((int)$data['id']);
        $this->setTypeParis((string)$data['typeParis']);
    }
    

    /**
     * Get id type paris
     *
     * @return  int
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id type paris
     *
     * @param  int  $id  id type paris
     *
     * @return  self
     */ 
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get type de paris
     *
     * @return  string
     */ 
    public function getTypeParis()
    {
        return $this->typeParis;
    }

    /**
     * Set type de paris
     *
     * @param  string  $typeParis  type de paris
     *
     * @return  self
     */ 
    public function setTypeParis(string $typeParis)
    {
        $this->typeParis = $typeParis;

        return $this;
    }
}