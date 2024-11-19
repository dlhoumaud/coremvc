<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-19 15:34:14
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-11-19 15:40:02
 * @ Description: classe de log pour le terminal
 */
namespace App\Helpers;

/**
 * Helpers de gestion des logs.
 * 3 types de log sont disponible \
 * Les logs standard, html, cmd
 * 
 * @return stdClass
 */
class Log {
	
	/** 
	 * bash green color.
	 * @var string TEXT_SUCESS  
	 */
	public const TEXT_SUCCESS		=	"\033[32m";
	/** 
	 * bash orange color
	 * @var string TEXT_WARNING
	 */
	public const TEXT_WARNING		=	"\033[33m";
	/** 
	 * bash red color
	 * @var string TEXT_ERROR
	 */
	public const TEXT_ERROR			=	"\033[31m";
	/** 
	 * bash magenta color
	 * @var string TEXT_DEBUG
	 */
	public const TEXT_DEBUG			=	"\033[35m";
	/** 
	 * bash cyan color
	 * @var string TEXT_INFO
	 */
	public const TEXT_INFO			=	"\033[36m";
	/** 
	 * bash bold font
	 * @var string TEXT_BOLD
	 */
	public const TEXT_BOLD				=	"\033[1m";
	/** 
	 * clean bash color
	 * @var string TEXT_NONE
	 */
	public const TEXT_NONE				=	"\033[0m";

	/** 
	 * Type de LOG
	 * @internal string $_TYPE_ 
	 */
	private $_TYPE_;
	/** 
	 * Message du LOG
	 * @internal string $_LOG_ 
	 */
	private $_LOG_;
	private $_COUNT_;

	/**
	 * Initialise la classe de log
	 * 
	 * @param string $type Type de log à afficher
	 * @return void
	 */
	public function __construct($type='standard'){
		$this->_LOG_='';
		$this->_TYPE_=$type;
		$this->_COUNT_=0;
	}
	/**
	 * Changement du type de log
	 * 
	 * @param string $type Type de log à afficher
	 * @return void
	 */
	public function type($type='standard'){
		$this->_TYPE_=$type;
	}
	
	/**
	 * Nettoyage des logs
	 * 
	 * @param boolean $return retourner le log ou l'afficher
	 * @return string|void
	 */
	public function clear($return=false){
		$clean='';
		for ($z=0; $z<strlen($this->_LOG_); $z++) $clean.=chr(8);
		if (!$return) echo $clean;
		else return $clean;
	}
	
	/**
	 * Nettoyage de tout les logs afficher à l'écran
	 * 
	 * @return void
	 */
	public function clean_screen(){
		$clean='';
		// echo $this->_COUNT_."\n";
		for ($z=0; $z<$this->_COUNT_; $z++) $clean.=chr(8);
		$this->_COUNT_=0;
		echo $clean;
	}
	
	/**
	 * Affiche un log basique sans couleur
	 * 
	 * @param string $msg message à envoyer
	 * @param string $code code du log
	 * @param boolean $return retourner le log ou l'afficher
	 * @param string $fcolor couleur du texte
	 * @return string|void
	 */
	public function l($msg='',$code='LOG', $return=false, $fcolor='initial') {
		if ($this->_TYPE_=='cmd') $color='';
		else $color='initial';
		if (!$return) echo self::msg($msg, $code, $color, $fcolor);
		else return self::msg($msg, $code, $color, $fcolor);
	}

	/**
	 * Affiche un log de succès en vert
	 * 
	 * @param string $msg message à envoyer
	 * @param string $code code du log
	 * @param boolean $return retourner le log ou l'afficher
	 * @return string|void
	 */
	public function o($msg='',$code='OK', $return=false) {
		$fcolor='white';
		if ($this->_TYPE_=='cmd') $color=self::TEXT_SUCCESS;
		else $color='green';
		if (!$return) echo self::msg($msg, $code, $color, $fcolor);
		else return self::msg($msg, $code, $color, $fcolor);
	}
	
	/**
	 * Affiche un log de debuggage en violet
	 * 
	 * @param string $msg message à envoyer
	 * @param string $code code du log
	 * @param boolean $return retourner le log ou l'afficher
	 * @return string|void
	 */
	public function d($msg='',$code='DBG', $return=false) {
		$fcolor='white';
		if ($this->_TYPE_=='cmd') $color=self::TEXT_DEBUG;
		else $color='magenta';
		if (!$return) echo self::msg($msg, $code, $color, $fcolor);
		else return self::msg($msg, $code, $color, $fcolor);
	}
	
	/**
	 * Affiche un log d'info en cyan
	 * 
	 * @param string $msg message à envoyer
	 * @param string $code code du log
	 * @param boolean $return retourner le log ou l'afficher
	 * @return string|void
	 */
	public function i($msg='',$code='INFO', $return=false) {
		$fcolor='initial';
		if ($this->_TYPE_=='cmd') $color=self::TEXT_INFO;
		else $color='cyan';
		if (!$return) echo self::msg($msg, $code, $color, $fcolor);
		else return self::msg($msg, $code, $color, $fcolor);
	}
	
	/**
	 * Affiche un log de warning en orange
	 * 
	 * @param string $msg message à envoyer
	 * @param string $code code du log
	 * @param boolean $return retourner le log ou l'afficher
	 * @return string|void
	 */
	public function w($msg='',$code='WRN', $return=false) {
		$fcolor='initial';
		if ($this->_TYPE_=='cmd') $color=self::TEXT_WARNING;
		else $color='orange';
		if (!$return) echo self::msg($msg, $code, $color, $fcolor);
		else return self::msg($msg, $code, $color, $fcolor);
	}
	
	/**
	 * Affiche un log d'erreur en rouge
	 * 
	 * @param string $msg message à envoyer
	 * @param string $code code du log
	 * @param boolean $return retourner le log ou l'afficher
	 * @return string|void
	 */
	public function e($msg='',$code='ERR', $return=false) {
		$fcolor='white';
		if ($this->_TYPE_=='cmd') $color=self::TEXT_ERROR;
		else $color='red';
		if (!$return) error_log(self::msg($msg, $code, $color, $fcolor));
		else return self::msg($msg, $code, $color, $fcolor);
	}

	/**
	 * Affiche retourne le message du log formaté
	 * 
	 * @param string $msg message à envoyer
	 * @param string $code code du log
	 * @param string $color couleur du fond
	 * @param string $fcolor couleur du text
	 * @return string
	 */
	private function msg($msg, $code, $color, $fcolor='initial'){
		$date=date("d-m-Y H:i:s");
		switch($this->_TYPE_){
			case 'html':
				$this->_LOG_	='<p class="coremvc_log" style="line-height:1"><span style="background-color:'.$color.';color:'.$fcolor.'"><b>'.$date.'&nbsp;&nbsp;&nbsp;&nbsp;'.$code.'</b></span>&nbsp;&nbsp;&nbsp;&nbsp;<span style="background-color:'.$color.';color:'.$fcolor.'">'.$msg.'</span></p>';
			break;
			case 'cmd':
				$this->_LOG_	= $color.self::TEXT_BOLD.$date."\t".$code.self::TEXT_NONE."\t".$color.$msg.self::TEXT_NONE;
			break;
			default:
				$this->_LOG_	= $date."\t".$code."\t".$msg;
		}
		if ($code!='ERR') $this->_LOG_.="\n";
		$this->_COUNT_+=strlen($this->_LOG_);
		// echo $this->_COUNT_."\n";
		return $this->_LOG_;
	}

}