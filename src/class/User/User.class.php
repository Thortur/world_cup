<?php
declare(strict_types = 1);
namespace User;

class User {
    /**
     * id User
     *
     * @var int
     */
    private $id;
    /**
     * nom user
     *
     * @var string
     */
    private $nom;
    /**
     * prenom user
     *
     * @var string
     */
    private $prenom;
    /**
     * pseudo user
     *
     * @var string
     */
    private $pseudo;
    /**
     * mail user
     *
     * @var string
     */
    private $mail;
    /**
     * password user
     *
     * @var string
     */
    private $password;

    public function __construct($data)
    {
        if(empty($data['id']) === true) {
            $data['id'] = -1;
        }
        
        $this->setId($data['id']);
        $this->setNom($data['nom']);
        $this->setPrenom($data['prenom']);
        $this->setPseudo($data['pseudo']);
        $this->setMail($data['mail']);
        $this->setPassword($data['password']);
    }

    

    /**
     * Get id User
     *
     * @return int
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id User
     *
     * @param int $id id User
     *
     * @return self
     */ 
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get nom user
     *
     * @return  string
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set nom user
     *
     * @param string  $nom  nom user
     *
     * @return  self
     */ 
    public function setNom(string $nom)
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * Get prenom user
     *
     * @return string
     */ 
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set prenom user
     *
     * @param string $prenom  prenom user
     *
     * @return  self
     */ 
    public function setPrenom(string $prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get pseudo user
     *
     * @return string
     */ 
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Set pseudo user
     *
     * @param string  $pseudo  pseudo user
     *
     * @return self
     */ 
    public function setPseudo(string $pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get mail user
     *
     * @return string
     */ 
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set mail user
     *
     * @param string  $mail  mail user
     *
     * @return self
     */ 
    public function setMail(string $mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get password user
     *
     * @return string
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set password user
     *
     * @param string  $password  password user
     *
     * @return  self
     */ 
    public function setPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }    
}