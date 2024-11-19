<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-19 15:47:07
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-11-19 15:52:04
 * @ Description: Classe pour la gestion de la session
 */

 namespace App\Helpers;

/**
 * Helpers de gestion de la session.
 * 
 * @return stdClass
 */
class Session {
	
	/**
	 * Initialise la session
	 * 
	 * @return void
	 */
	public function __construct() {
		if (!isset($_SESSION)) session_start();
	}
	
	/**
	 * Nettoye la variable de session $_SESSION
	 * 
	 * @return void
	 */
	public static function clear(){
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
	}
	
	/**
	 * Récupère une variable de session
	 * la clé est sous forme de chemin d'accès en string
	 * 
	 * @param string|null $key clé de la variable de session à récupérer
	 * @return mixed
	 */
	public static function get($key=false) {
		if (!$key) return $_SESSION??false;
		else {
			$path=explode('/', $key);
			if (count($path)>1){
				$return=$_SESSION;
				for ($i=0; $i<count($path); $i++){
					if (isset($return[$path[$i]])){
						$return=$return[$path[$i]];
					} else return false;
				}
				return $return;
			}
			return $_SESSION[$key]??false;
		}
	}
	
	/**
	 * Supprimer une variable de session
	 * la clé est sous forme de chemin d'accès en string
	 * 
	 * @param string $key clé de la variable de session à supprimer
	 * @return boolean Retourne true si la suppression a été faite sinon false
	 */
	public static function unset($key) {
		$path=explode('/', $key);
		if (count($path)>1){
			$return=$_SESSION;
			$_r='';
			for ($i=0; $i<count($path); $i++){
				if (isset($return[$path[$i]])){
					$_r.='[\''.$path[$i].'\']';
					$return=$return[$path[$i]];
				}else return false;
			}
			eval('unset($_SESSION'.$_r.');');
			return true;
		}
		if (isset($_SESSION[$key])){
			unset($_SESSION[$key]);
			return true;
		}
		return false;
	}
	
	/**
	 * Écris une variable de session
	 * la clé est sous forme de chemin d'accès en string
	 * 
	 * @param string $key clé de la variable de session à écrire
	 * @param mixed|null $value valeur à mettre dans la variable
	 * @return void
	 */
	public static function set($key, $value=null) {
		$path=explode('/', $key);
		if (count($path)>1){
			$return=$_SESSION;
			$_r='';
			for ($i=0; $i<count($path); $i++){
				$_r.='[\''.$path[$i].'\']';
				if (isset($return[$path[$i]])){
					$return=$return[$path[$i]];
				}else break;
			}
			eval('$_SESSION'.$_r.'=$value;');
			return;
		}
		$_SESSION[$key]=$value;
	}
	
	/**
	 * Vérifie si une variable de session existe
	 * la clé est sous forme de chemin d'accès en string
	 * 
	 * @param string $key clé de la variable de session à vérifier
	 * @return boolean Retourne true si la variable existe sinon false
	 */
	public static function exists($key) {
		$path=explode('/', $key);
		if (count($path)>1){
			$return=$_SESSION;
			$_r='';
			for ($i=0; $i<count($path); $i++){
				$_r.='[\''.$path[$i].'\']';
				if (isset($return[$path[$i]])){
					$return=$return[$path[$i]];
				}else return false;
			}
			return true;
		}
		if (isset($_SESSION[$key])) return true;
		return false;
	}
	
	/**
	 * Génère une chaine de caractère aléatoire
	 * 
	 * @param integer $length longueur de la chaine de caractère à générer
	 * @return string Retourne la chaine de caractère générée
	 */
	private function random_string($length=20){
		$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ=_-+*/!:;,?./$%#~@';
		$string = '';
		for($i=0; $i<$length; $i++){
			$string .= $chars[mt_rand(0, strlen($chars)-1)];
		}
		return $string;
	}
	
	/**
	 * Initialise et retourne un token ACCESS aléatoire pour les formulaires HTML
	 * 
	 * @param $force_init force l'initialisation de la variable de session $_SESSION['__coremvc_access__']
	 * @return string Retourne la variable de session $_SESSION['__coremvc_access__']
	 */
	public static function access($force_init=false){
		if (!isset($_SESSION['__coremvc_access__']) || $force_init) $_SESSION['__coremvc_access__']=sha1(microtime().self::random_string());
		return $_SESSION['__coremvc_access__'];
	}
	
	/**
	 * Supprime les variables ayant le token ACCESS dans leur clé.
	 * 
	 * @return void
	 */
	public static function clean_access(){
		foreach ($_GET as $key=>$value){
			if (preg_match('/'.$_SESSION['__coremvc_access__'].'/',$key)) unset($_GET[$key]);
		}
		foreach ($_POST as $key=>$value){
			if (preg_match('/'.$_SESSION['__coremvc_access__'].'/',$key)) unset($_POST[$key]);
		}
		foreach ($_COOKIE as $key=>$value){
			if (preg_match('/'.$_SESSION['__coremvc_access__'].'/',$key)) unset($_COOKIE[$key]);
		}
		foreach ($_SESSION as $key=>$value){
			if (preg_match('/'.$_SESSION['__coremvc_access__'].'/',$key)) unset($_SESSION[$key]);
		}
	}
}