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
	 * Undocumented function
	 *
	 * @param array $config
	 */
	public function __construct($config = array()) {
		foreach ($config as $key => $value) {
			$this->$key = $value;
		}
	}
}