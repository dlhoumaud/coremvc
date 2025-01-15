<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-19 15:44:48
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-11-19 15:45:35
 * @ Description: Classe pour la gestion des permissions
 */

namespace App\Helpers;

/**
 * Helpers de gestion des permission fichier
 * 
 * @return stdClass
 */
class Permission {

	private $filename;
	private $perms;

	public function __construct($filename=NULL){
		$this->filename=NULL;
		$this->perms=NULL;
		self::file($filename, false);
		return;
	}

	private function file($filename=NULL, $stop=true){
		if (!is_null($filename)) $this->filename=$filename;
		if ($stop && is_null($this->filename)) {
			die('File or directory not define');
		} else if (
			$stop &&
			is_null($this->filename) &&
			(!file_exists($this->filename) || !is_dir($this->filename))
		) {
			die('File or directory '.$this->filename.' not found');
		}
	}

	public function toString($perms){
		$this->perms=$perms;
		$info='';
		switch ($this->perms & 0xF000) {
			case 0xC000: // Socket
				$info = 's';
			break;
			case 0xA000: // Lien symbolique
				$info = 'l';
			break;
			case 0x8000: // Régulier
				$info = '-';
			break;
			case 0x6000: // Block special
				$info = 'b';
			break;
			case 0x4000: // dossier
				$info = 'd';
			break;
			case 0x2000: // Caractère spécial
				$info = 'c';
			break;
			case 0x1000: // pipe FIFO
				$info = 'p';
			break;
			default: // Inconnu
				$info = 'u';
		}
		// Propriétaire
		$info .= (($this->perms & 0x0100) ? 'r' : '-');
		$info .= (($this->perms & 0x0080) ? 'w' : '-');
		$info .= (($this->perms & 0x0040) ?
								(($this->perms & 0x0800) ? 's' : 'x' ) :
								(($this->perms & 0x0800) ? 'S' : '-'));

		// Groupe
		$info .= (($this->perms & 0x0020) ? 'r' : '-');
		$info .= (($this->perms & 0x0010) ? 'w' : '-');
		$info .= (($this->perms & 0x0008) ?
								(($this->perms & 0x0400) ? 's' : 'x' ) :
								(($this->perms & 0x0400) ? 'S' : '-'));

		// Tout le monde
		$info .= (($this->perms & 0x0004) ? 'r' : '-');
		$info .= (($this->perms & 0x0002) ? 'w' : '-');
		$info .= (($this->perms & 0x0001) ?
								(($this->perms & 0x0200) ? 't' : 'x' ) :
								(($this->perms & 0x0200) ? 'T' : '-'));
		return $info;
	}

	public function toOctal($perms){
		return substr(
			sprintf('%o', $perms),
			-4
		);
	}

	public function get($filename=NULL, $toString=false){
		self::file($filename);
		$this->perms = fileperms($this->filename);
		if ($toString) return $this->toString();
		return $this->toOctal();
	}

	public function verif($from=NULL, $to=NULL){
		if ($from===$to) return true;
		return false;
	}

	public function set($mode, $filename=NULL){
		self::file($filename);
		if (!chmod($this->filename, $mode)) {
			die('Impossible to change permissions for '.$this->filename);
		}
	}

}