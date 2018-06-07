<?php
declare(strict_types = 1);
namespace SendRequete;

class SendRequete {
    /**
     * appel de la function du web service
     * 
     * @var string $requete
     */
    private $requete;
    /**
     * parametre du web service
     * 
     * @var array $data
     */
    private $data;
    /**
     * url du web service
     * 
     * @var string url
     */
    private $url;

    public function __construct(string $requete, array $data) {
        $this->setRequete($requete);
        $this->setData($data);
        $this->setURl();
    }

    /**
     * Get $requete
     *
     * @return  string
     */ 
    public function getRequete()
    {
        return $this->requete;
    }

    /**
     * Set $requete
     *
     * @param  string  $requete  $requete
     *
     * @return  self
     */ 
    public function setRequete(string $requete)
    {
        $this->requete = $requete;

        return $this;
    }

    /**
     * Get $data
     *
     * @return  array
     */ 
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set $data
     *
     * @param  array  $data  $data
     *
     * @return  self
     */ 
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get url
     *
     * @return  string
     */ 
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set url
     *
     * @return  self
     */ 
    public function setUrl()
    {
        $this->url = 'http://www.lefevrechristophe.fr/world_cup_api/public/index.php?request='.$this->getRequete();
        if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $this->url = 'http://localhost/world_cup_api/public/index.php?request='.$this->getRequete();
        }

        return $this;
    }

    /**
     * Lancement de la requete
     * 
     * @return bool|string|array $response
     */
    public function exec() {
        $ch = curl_init();
        curl_setopt_array($ch, array(
                                    CURLOPT_URL            => $this->getUrl(),
                                    CURLOPT_POST           => count($this->getData()),
                                    CURLOPT_POSTFIELDS     => http_build_query($this->getData()),
                                    CURLOPT_RETURNTRANSFER => true,
                                ));
        $response = curl_exec($ch);
        curl_close($ch);
        unset($ch);
        
        if(empty($response) === false) {
            try {
                $response = \json_decode($response);
            }
            catch(Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "<br/>";
                $response = false;
            }
        }
        else {
            $response = false;
        }

        return $response;
    }
}