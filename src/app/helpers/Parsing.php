<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-19 15:25:28
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-11-19 15:29:35
 * @ Description: classe pour parser les chaines de caractères
 */

namespace App\Helpers;

/**
 * Helpers de gestion du parsing de chaine de caractère
 * 
 * @return stdClass
 */
class Parsing extends Str{

	public function __construct(){}

	/**
	 * Récupère ce qu'il y à gauche de la chaine de caractère
	 * 
	 * @param string $_pattern sous chaine de caractère de séparation
	 * @param string $_string chaine de caractère complète
	 * @return string
	 */
	public function toLeft($_pattern, $_string) {
		$_tmp=$this->explode($_pattern, $_string);
		return (isset($_tmp[0])?$_tmp[0]:'');
	}

	/**
	 * Récupère ce qu'il y à droite de la chaine de caractère
	 * 
	 * @param string $_pattern sous chaine de caractère de séparation
	 * @param string $_string chaine de caractère complète
	 * @return string
	 */
	public function toRight($_pattern, $_string) {
		$_tmp=$this->explode($_pattern, $_string);
		return (isset($_tmp[1])?$_tmp[1]:'');
	}

	/**
	 * Récupère ce qu'il y a entre la chaine de caractère
	 * 
	 * @param string $_pattern_right sous chaine de caractère de séparation à droite
	 * @param string $_pattern_left sous chaine de caractère de séparation à gauche
	 * @param string $_string chaine de caractère complète
	 * @return string
	 */
	public function middle($_pattern_right, $_pattern_left,  $_string) {
		return $this->between($_pattern_right, $_pattern_left,  $_string);
	}

	/**
	 * Récupère ce qu'il y a entre la chaine de caractère
	 * 
	 * @param string $_pattern_right sous chaine de caractère de séparation à droite
	 * @param string $_pattern_left sous chaine de caractère de séparation à gauche
	 * @param string $_string chaine de caractère complète
	 * @return string
	 */
	public function between($_pattern_right, $_pattern_left,  $_string) {
		return self::toLeft(
			$_pattern_left,
			$this->toRight(
				$_pattern_right,
				$_string
			)
		);
	}

	/**
	 * Remplace une sous chaine de caractère
	 * 
	 * @param string $_pattern sous chaine de caractère à remplacer
	 * @param string $_new sous chaine de caractère de remplacement
	 * @param string $_string chaine de caractère complète
	 * @return string
	 */
	public function replace($_pattern, $_new, $_string) {
		if (is_array($_pattern)) {
			if (parent::is_regex($_pattern[0])) {
				return preg_replace($_pattern, $_new, $_string);
			} else {
				return str_replace($_pattern, $_new, $_string);
			}
		} else {
			if (parent::is_regex($_pattern)) {
				return preg_replace($_pattern, $_new, $_string);
			} else {
				return str_replace($_pattern, $_new, $_string);
			}
		}
	}
	
	/**
	 * Vérifie si une sous chaine existe dans la chaine de caractère courante
	 * 
	 * @param string $_pattern sous chaine de caractère à vérifier
	 * @param string $_string chaine de caractère complète
	 * @param boolean $_casse senssible à la casse
	 * @return boolean
	 */
	public function match($_pattern, $_string, $_casse=false) {
		if (parent::is_regex($_pattern)) $_pat=$_pattern;
		else $_pat='/'.str_replace('/', '\\/',$_pattern).'/'.($_casse?'':'i');
		return preg_match(
			$_pat,
			$_string
		);
	}

	/**
	 * Extrait une sous chaine existe dans la chaine de caractère courante
	 * 
	 * @param string $_pattern sous chaine de caractère à extraire
	 * @param string $_string chaine de caractère complète
	 * @return array
	 */
	public function explode($_pattern, $_string) {
		if (parent::is_regex($_pattern)) {
			return preg_split($_pattern, $_string);
		} else {
			return explode($_pattern, $_string);
		}
	}

}