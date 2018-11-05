<?php
namespace Dawn;

class Asset {
	/**
	 * Base url
	 * 
	 * @var string
	 */
	public $url;

	/**
	 * Base path
	 * 
	 * @var string
	 */
	public $path;

	/**
	 * Src 
	 *
	 * @var string
	 */
	public $src;

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
	 * the asset dependency
	 *
	 * @var array
	 */
	public $dependency = array();

	/**
	 * version
	 *
	 * @var string
	 */
	public $version = '1.0.0';

	/**
	 * Asset data.
	 *
	 * @var array
	 */
	public $data = array();

	/**
	 * Asset name.
	 *
	 * @var string
	 */
	public $name;

	/**
	 * Defer script
	 *
	 * @var boolean
	 */
	public $defer = false;

	/**
	 * Check if async script
	 *
	 * @var boolean
	 */
	public $async = false;

	/**
	 * Inline asset
	 *
	 * @var mixed
	 */
	public $inline;

	/**
	 * Style media type
	 *
	 * @var string
	 */
	public $media = 'screen';

	/**
	 * Undocumented function
	 *
	 * @param array $config
	 */
	public function __construct($config = array()) {
		foreach ($config as $key => $value) {
			$this->$key = $value;
		}
	}

	/**
	 * Get magic function.
	 *
	 * @param string $name
	 * 
	 * @return mixed
	 */
	public function __get($name) {
		$name = str_replace('get', '', $name);
		$name = strtolower(trim($name, ''));

		if (isset($this->$name)) {
			return $this->$name;
		}
	}

	/**
	 * Set magix function.
	 *
	 * @param string $name
	 * @param mixed $value
	 */
	public function __set($name, $value) {
		$name = strtolower(str_replace('set', '', $name));

		$this->$name = $value;
	}

	public function render() {

	}

	public function localize($name, $data = array()) {

	}

	public function inline() {

	}
}