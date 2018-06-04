<?php
declare(strict_types = 1);
namespace TypePari;

class TypePari {
    /**
     * id type pari
     *
     * @var int
     */
    private $id;
    /**
     * type de pari
     *
     * @var string
     */
    private $typePari;

    /**
     * Construct
     * 
     * @param array $data
     */
    public function __construct(array $data) {
        $this->setId((int)$data['id']);
        $this->setTypePari((string)$data['typePari']);
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
     * Get type de pari
     *
     * @return  string
     */ 
    public function getTypePari()
    {
        return $this->typePari;
    }

    /**
     * Set type de pari
     *
     * @param  string  $typePari  type de pari
     *
     * @return  self
     */ 
    public function setTypePari(string $typePari)
    {
        $this->typePari = $type;

        return $this;
    }
}