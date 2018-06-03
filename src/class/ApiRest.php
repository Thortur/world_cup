<?php
declare(strict_types = 1);
namespace AppApiRest;
/**
 * Class qui gere les demande du client
 */
class ApiRest {
	
	public $allow       = array();
	public $contentType = "application/json";
	public $request     = array();
	public $requestData = array();
	
	private $method     = "";		
	private $code       = 200;
	private $debug      = true;
	
	/**
	 * Construct de la class
	 */
	public function __construct(){
		$this->inputs();
	}
	
	/**
	 * Retourne l'adresse de la page (si elle existe) qui a conduit le client à la page courante.
	 * @return {string} HTTP_REFERER
	 */
	public function getReferer(){
		return $_SERVER['HTTP_REFERER'];
	}
	
	/**
	 * Affichage résultat
	 * @param any $data
	 * @param int $status
	 */
	public function response($data, $status){
		$this->code = ($status) ? $status:200;
		$this->setHeaders();
		echo $data;
		exit;
	}
	
	/**
	 * Retourne le status de la demande request
	 */
	private function getStatusMessage(){
		$status = array(
					100 => 'Continue',  
					101 => 'Switching Protocols',  
					200 => 'OK',
					201 => 'Created',  
					202 => 'Accepted',  
					203 => 'Non-Authoritative Information',  
					204 => 'No Content',  
					205 => 'Reset Content',  
					206 => 'Partial Content',  
					300 => 'Multiple Choices',  
					301 => 'Moved Permanently',  
					302 => 'Found',  
					303 => 'See Other',  
					304 => 'Not Modified',  
					305 => 'Use Proxy',  
					306 => '(Unused)',  
					307 => 'Temporary Redirect',  
					400 => 'Bad Request',  
					401 => 'Unauthorized',  
					402 => 'Payment Required',  
					403 => 'Forbidden',  
					404 => 'Not Found',  
					405 => 'Method Not Allowed',  
					406 => 'Not Acceptable',  
					407 => 'Proxy Authentication Required',  
					408 => 'Request Timeout',  
					409 => 'Conflict',  
					410 => 'Gone',  
					411 => 'Length Required',  
					412 => 'Precondition Failed',  
					413 => 'Request Entity Too Large',  
					414 => 'Request-URI Too Long',  
					415 => 'Unsupported Media Type',  
					416 => 'Requested Range Not Satisfiable',  
					417 => 'Expectation Failed',  
					500 => 'Internal Server Error',  
					501 => 'Not Implemented',  
					502 => 'Bad Gateway',  
					503 => 'Service Unavailable',  
					504 => 'Gateway Timeout',  
					505 => 'HTTP Version Not Supported');
		return ($status[$this->code])?$status[$this->code]:$status[500];
	}
	
	/**
	 * Retourne la méthode de requête utilisée pour accéder à la page; 
	 */
	public function getRequestMethod(){
		return $_SERVER['REQUEST_METHOD'];
	}
	
	/**
	 * Save dans l'objet de la requete du client
	 */
	private function inputs(){
		$this->request     = $this->cleanInputs($_GET);
		$this->requestData = $this->cleanInputs($_POST);
	}

	/**
	 * on nettoie les données
	 * @param array|string $data
	 */
	private function cleanInputs($data){
		$cleanInput = array();
		if(is_array($data) === true) {
			foreach($data as $k => $v){
				$cleanInput[$k] = $this->cleanInputs($v);
			}
		}
		else {
			if(get_magic_quotes_gpc()){
				$data = trim(stripslashes($data));
			}
			$data       = strip_tags($data);
			$cleanInput = htmlentities(trim($data));
		}
		return $cleanInput;
	}		
	
	/**
	 * Retourne les headers de la page
	 */
	private function setHeaders(){
		if($this->debug === false){
			header("HTTP/1.1 ".$this->code." ".$this->getStatusMessage());
			header("Content-Type:".$this->contentType);
		}
	}
}
?>