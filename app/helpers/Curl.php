<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-19 15:32:20
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-11-19 15:33:06
 * @ Description: classe pour utiliser Curl
 */

namespace App\Helpers;

/**
 * Helpers de gestion des requete web avec CURL
 * 
 * @return stdClass
 */
class Curl {

	private $headers;
	private $header;
	private $cookieFile;
	private $referer;
	private $userAgent;
	private $timeout;
	private $connecttimeout;
	private $followLocation;
	private $returnTransfer;
	private $noBody;
	private $maxDir;
	private $USE_PROXY;
	private $PROXY;

	private $_error;
	private $_status;
	private $_url;
	private $_content;
	private $_infos;

	public function __construct() {
		$this->headers[] = 'Content-Type: application/x-www-form-urlencoded;charset=UTF-8';
		$this->header=false;
		$this->cookieFile = tempnam(sys_get_temp_dir(), 'cookie-'.md5(microtime()).':'.time().'.');
		$this->referer='https://www.google.com';
		$this->userAgent='Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:66.0) Gecko/20100101 Firefox/66.0';
		$this->maxDir=4;
		$this->timeout=600;
		$this->connecttimeout=10;
		$this->followLocation=true;
		$this->returnTransfer=true;
		$this->noBody=false;
		$this->USE_PROXY=false;
		$this->PROXY=array(
			'ip'=>'',
			'port'=>''
		);
	}

	public function headers($array) {
		$this->headers = $array;
	}

	public function addHeader($key, $value) {
		$this->headers[] = $key.': '.$value;
	}

	public function setReferer($value) {
		$this->referer=$value;
	}

	public function setUserAgent($value) {
		$this->userAgent=$value;
	}
	public function getUserAgent() {
		return $this->userAgent;
	}

	public function setCookieFile($value) {
		$this->cookieFile=$value;
	}

	public function setTimeout($value) {
		$this->timeout=$value;
	}

	public function setConnectTimeout($value) {
		$this->connecttimeout=$value;
	}

	public function setFollowLocation($value) {
		$this->followLocation=$value;
	}

	public function setReturnTransfer($value) {
		$this->returnTransfer=$value;
	}
	public function setNoBody($value) {
		$this->noBody=$value;
	}

	public function setMaxDir($value) {
		$this->maxDir=$value;
	}

	public function setHeader($value) {
		$this->header=$value;
	}

	public function getCookieFile() {
		return $this->cookieFile;
	}

	public function getCookieContent() {
		return (file_exists($this->cookieFile)?file_get_contents($this->cookieFile):'');
	}

	public function proxy($ip='', $port='', $use=false) {
		$this->USE_PROXY=$use;
		$this->PROXY=array(
			'ip'=>$ip,
			'port'=>$port
		);
		if (empty($this->PROXY['ip']) || empty($this->PROXY['port'])) $this->USE_PROXY=false;
	}

	public function get($url, $method='GET') {
		$process = curl_init($url);
		curl_setopt($process, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($process, CURLOPT_REFERER, $this->referer);
		curl_setopt($process, CURLOPT_HEADER, false);
		curl_setopt($process, CURLOPT_CONNECTTIMEOUT, $this->connecttimeout);
		curl_setopt($process, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($process, CURLOPT_TIMEOUT, $this->timeout);
		curl_setopt($process, CURLOPT_MAXREDIRS, $this->maxDir);
		curl_setopt($process, CURLOPT_RETURNTRANSFER, $this->returnTransfer);
		curl_setopt($process, CURLOPT_NOBODY, $this->noBody);
		curl_setopt($process, CURLOPT_COOKIEJAR,  $this->cookieFile);
		curl_setopt($process, CURLOPT_COOKIEFILE, $this->cookieFile);
		curl_setopt($process, CURLOPT_FOLLOWLOCATION, $this->followLocation);
		curl_setopt($process, CURLOPT_USERAGENT, $this->userAgent);
		self::ifUseProxy($process);
		$this->_content = curl_exec($process);
		$this->_error 	= ($this->_content === false ? curl_error($process) : null);
		$this->_status 	= curl_getinfo($process,CURLINFO_HTTP_CODE);
		$this->_url 		= curl_getinfo($process,CURLINFO_EFFECTIVE_URL);
		curl_close($process);
		return self::_return();
	}

	public function delete($url) {
		return self::get($url, 'DELETE');
	}

	public function post($url, $data, $method='POST') {
		$process = curl_init($url);
		curl_setopt($process, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($process, CURLOPT_HEADER, false);
		curl_setopt($process, CURLOPT_CONNECTTIMEOUT, $this->connecttimeout);
		curl_setopt($process, CURLOPT_TIMEOUT, $this->timeout);
		curl_setopt($process, CURLOPT_POSTFIELDS, $data);
		curl_setopt($process, CURLOPT_RETURNTRANSFER, $this->returnTransfer);
		curl_setopt($process, CURLOPT_NOBODY, $this->noBody);
		curl_setopt($process, CURLOPT_POST, true);
		curl_setopt($process, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($process, CURLOPT_MAXREDIRS, $this->maxDir);
		curl_setopt($process, CURLOPT_COOKIEJAR,  $this->cookieFile);
		curl_setopt($process, CURLOPT_COOKIEFILE, $this->cookieFile);
		curl_setopt($process, CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($process, CURLOPT_FRESH_CONNECT, false);
		curl_setopt($process, CURLOPT_FOLLOWLOCATION, $this->followLocation);
		curl_setopt($process, CURLOPT_REFERER, $this->referer);
		curl_setopt($process, CURLOPT_USERAGENT, $this->userAgent);
		self::ifUseProxy($process);
		$this->_content = curl_exec($process);
		$this->_error 	= ($this->_content === false ? curl_error($process) : null);
		$this->_status 	= curl_getinfo($process,CURLINFO_HTTP_CODE);
		$this->_url 		= curl_getinfo($process,CURLINFO_EFFECTIVE_URL);
		$this->_infos 	= curl_getinfo($process);
		curl_close($process);
		return self::_return();
	}

	public function put($url, $data) {
		return self::post($url, $data, 'PUT');
	}

	/**
	 * Ajoute les entête necessaire à l'utilisation des proxy
	 * @param object $curl Object curl pour requete web
	 * @param integer $start
	 */
	private function ifUseProxy(&$curl){
		if ($this->USE_PROXY){
			$host=$this->PROXY['ip'].':'.$host=$this->PROXY['port'];
			curl_setopt($curl, CURLOPT_HTTPPROXYTUNNEL, false);
			curl_setopt($curl, CURLOPT_PROXY, $host);
		}
	}

	public function cleanCookieFile(){
		if (file_exists($this->cookieFile)) {
			unlink($this->cookieFile);
		}
	}

	public function createCookieFile(){
		$this->cookieFile = tempnam(sys_get_temp_dir(), 'cookie-'.md5(microtime()).':'.time().'.');
	}

	public function _return() {
		return array(
			'error'		=>$this->_error,
			'status'	=>$this->_status,
			'url'			=>$this->_url,
			'infos'		=> $this->_infos,
			'cookie'	=>array(
				'file'		=>$this->cookieFile,
				'content'	=>(file_exists($this->cookieFile)?file_get_contents($this->cookieFile):'')
			),
			'content'	=>$this->_content
		);
	}
}
?>
