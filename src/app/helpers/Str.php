<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-19 15:27:01
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-11-19 15:29:25
 * @ Description: classe de fonctions de manipulation de chaine de caractère
 */

namespace App\Helpers;

/**
 * Helpers de gestion des chaines de caractère
 * 
 * @return stdClass
 */
class Str {

	public function __construct(){}

	/**
	 * Vérifie si la chaine est une expression régulière
	 * 
	 * @param string $pattern chaine de caractère à vérifier
	 * @return boolean
	 */
	public function is_regex($pattern){
		if (
			strlen($pattern)>1																&&
			preg_match('/[\/#£§]/', substr($pattern, 0, 1)) 	&&
			(
				substr($pattern, 0, 1) == substr($pattern, -1) ||
				substr($pattern, 0, 1) == substr($pattern, -2) ||
				substr($pattern, 0, 1) == substr($pattern, -3)
			)
		) return true;
		return false;
	}
	
	/**
	 * Retourne une chaine d'espace par rapport à une chaine de caractère
	 * 
	 * @param string $str chaine à traiter
	 * @return string
	 */
	public function charToSpace($str=''){
		$_result='';
		for($i=0;$i<strlen($str); $i++){
			$_result.=' ';
		}
		return $_result;
	}

}