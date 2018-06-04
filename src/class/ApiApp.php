<?php
declare(strict_types = 1);
namespace AppApiRest;

/**
 * Class qui gere les demande du client
 */
class ApiApp extends ApiRest {

    private $langue = 'en_US';
    private $listLangue = array('fr_FR', 'en_US');
    public function __construct() {
        parent::__construct();
    }


    /** 
    * Methode public pour l'acces a l'api. 
    */ 
    public function processApi(){
        if(empty($this->request['request']) === false) {
            $listVar = explode('/', $this->request['request']);
            if(in_array($listVar[0], $this->listLangue) === true) {
                $this->langue = $listVar[0];
            }
            $func = strtolower(trim($listVar[1]));
            if((int)method_exists($this, $func) > 0) {
                $this->$func(); 
            }
            else {
                $this->response('', 404); // si la fonction n’existe pas, la réponse sera "Page not found". 
            }
        }
        else {
            $this->response('', 404); // si la fonction n’existe pas, la réponse sera "Page not found". 
        }
    }

    /** 
     * Encode les datas en JSON
     * @param array $data
    */ 
    private function json($data){ 
        if(is_array($data)){ 
            return json_encode($data);
        } 
    }

    /**
     * Retourne la list des Teams
     * 
     * @return string json de listTeam
     */
    private function getListTeam() {
        $listTeam = TeamManagerMYSQL::readListTeam();
        if(is_array($listTeam)) {
            $this->response($this->json($listTeam), 200); 
        }
        else {
            $this->response('', 204); 
        }
    }

    /**
     * Retourne la liste des utilisateurs
     * 
     * @return string json de listUtilisateur
     */
    private function getListUser() {
        $listUtilisateur = UtilisateurManagerMYSQL::readListUtilisateur();
        if(is_array($listUtilisateur)) {
            $this->response($this->json($listUtilisateur), 200); 
        }
        else {
            $this->response('', 204); 
        }
    }
}