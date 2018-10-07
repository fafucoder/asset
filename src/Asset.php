<?php
namespace Dawn\Asset;

class Asset {
	/**
	 * The asset base url.
	 * 
	 * @var string
	 */
	public $baseUrl;

	/**
	 * The asset base path.
	 * 
	 * @var string
	 */
	public $basePath;

	/**
	 * The script assets.
	 * 
	 * @var array
	 */
	public $js = array();

	/**
	 * The style assets.
	 * 
	 * @var array
	 */
	public $css = array();

	/**
	 * Set asset base url.
	 * 
	 * @param string $base_url 
	 */
	public function setBaseUrl($base_url) {
		$this->baseUrl = $base_url;
	}

	/**
	 * Get asset base url.
	 * 
	 * @return string 
	 */
	public function getBaseUrl() {
		return $this->baseUrl;
	}

	/**
	 * Set asset base path.
	 * 
	 * @param string $base_path 
	 */
	public function setBasePath($base_path) {
		$this->basePath = $base_path;
	}

	/**
	 * Get asset base path.
	 * 
	 * @return string 
	 */
	public function getBasePath() {
		return $this->basePath;
	}

	/**
	 * Get current asset url.
	 * 
	 * @return string 
	 */
	public function assetUrl() {

	}

	/**
	 * Get current asset path.
	 * 
	 * @return string 
	 */
	public function assetPath() {

	}

	/**
	 * Output the asset.
	 * 
	 * @return string 
	 */
	public function render() {

	}
}