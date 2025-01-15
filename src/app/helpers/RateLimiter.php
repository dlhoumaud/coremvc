<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-19 15:42:34
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-11-19 15:45:45
 * @ Description: Classe pour la gestion des limite
 */

 namespace App\Helpers;



class RateLimiter {
	private $datas;
	private $memory;
	public function __construct($p=[null,null]){
		
		$this->datas=$p[0];
		$this->memory=$p[1];
	}

	public function ok(){
		$memory=$this->memory;
		// $memory->close();exit;
		$config=$this->datas['config']??null;
		if (is_null($this->memory) || is_null($config)) {
			$configFilePath = __DIR__ . '/../../config.json'; // Path to config.json
			$config = json_decode(file_get_contents($configFilePath), true);
			if (!isset($config['rate']) || ($config['rate']['limit']??-1)<0) {
				return true;
			}
			$memory=Helpers::load('memory');
			if (!$memory->ID()) {
				$memory->c(); // Créer la mémoire partagée
			} else {
				$memory->a(); // Accéder à la mémoire partagée existante
				// Lire le compteur actuel de visites (si disponible)
			}
			$this->datas = $memory->get();
		}
		$t=time();
		$d=$t-($this->datas['used']['rate']['time']??$t);
		if (!isset($this->datas['used']) || !isset($this->datas['used']['rate']) || $d>=($config['rate']['time']??1)){
			$this->datas['used']=[
				'rate'=>[
					'limit' => 0,
					'time'=>$t,
				]
			];
		}

		++$this->datas['used']['rate']['limit'] ;

		$memory->w();
		$memory->update($this->datas);

		// Vérifier si le compteur dépasse la limite
		if ($this->datas['used']['rate']['limit'] > $config['rate']['limit']) {
			return false;
		}
        return true;
    }

}