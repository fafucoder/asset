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
	public $inline = array();

	/**
	 * Style media type
	 *
	 * @var string
	 */
	public $media = 'screen';

	/**
	 * Conditon
	 *
	 * @var string
	 */
	public $condition;

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

	/**
	 * Render style and script
	 *
	 * @return void
	 */
	public function render() {
		$condition_before = $condition_after = '';
		if ($this->condition) {
			$condition_before = "<!--[if {$conditional}]>\n";
			$condition_after = "<![endif]-->\n";
		}

		$inline_before = $inline_after = '';
		foreach ($this->inline as $type => $data) {
			if ($type === 'js') {
				extract($this->inlineScript($data, $inline_before, $inline_after), EXTR_PREFIX_ALL, 'inline');
			}

			if ($type === 'css') {
				extract($this->inlineStyle($data, $inline_before, $inline_after), EXTR_PREFIX_ALL, 'inline');
			}
		}

		$scripts = '';
		foreach ($this->js as $script) {
			$scripts .= $this->renderScript($script);
		}

		$styles = '';
		foreach ($this->css as $style) {
			$styles .= $this->renderStyle($style);
		}

		return "{$condition_bofore}{$inline_before}{$styles}{$scripts}{$inline_after}{$condition_after}";
	}

	//@TODO
	public function localize($name, $data = array()) {

	}

	public function inline($data, $position = 'after', $type = 'js') {
		$this->inline[$type] = array(
			'data' => $data,
			'position' => $position,
		);
	}

	public function inlineScript($data = array(), $inline_before = '', $inline_after = '') {
		$content = '';

		if (isset($data['data'])) {
			$content = sprintf("<script type='text/javascript'>\n%s\n</script>\n", $data['data']);
		}

		if ($data['position'] === 'before') {
			$inline_before .= $content;
		} else {
			$inline_after .= $content;
		}
		
		return array($inline_before, $inline_after);
	}

	public function inlineStyle($data = array(), $inline_before = '', $inline_after = '') {
		$content = '';
		if (isset($data['data'])) {
			$content = sprintf( "<style type='text/css'>\n%s\n</style>\n", $data['data']);
		}

		if ($data['position'] === 'before') {
			$inline_before .= $content;
		} else {
			$inline_after .= $content;
		}

		return array($inline_before, $inline_after);
	}

	public function renderStyle($css) {
		$css = $this->getAssetPath($css);

		if ($this->version) {
			$css = sprintf('%s?version=%s', $css, $this->version);
		}

		return sprintf("<link type='text/css' src='%s' media ='%s'>", $css, $this->media);
	}

	public function renderScript($js) {
		$js = $this->getAssetPath($js);

		if ($this->version) {
			$js = sprintf('%s?version=%s', $js, $this->version);
		}

		return sprintf("<script type='text/javascript' src='%s' async=%s defer=%s></script>", $js, $this->async, $this->defer);
	}

	public function getAssetPath($asset) {
		if (preg_match("#^(https|http|ftp)?://#", $asset)) {
			return $asset;
		}

		if ($this->url) {
			return rtrim($this->url , '/\\') . '/' . $asset;
		}

		if ($this->path) {
			return rtrim($this->path , '/\\') . '/' . $asset;
		}
	}
}