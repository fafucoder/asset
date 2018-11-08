<?php
namespace Dawn;

class AssetManager {
    /**
     * Singleton object
     *
     * @var object
     */
    protected static $instance;

    /**
     * Registered asset
     *
     * @var array
     */
    public $registered = array();

    /**
     * Enqueued asset.
     *
     * @var array
     */
    public $enqueued = array();

    /**
     * Instance function
     *
     * @return object
     */
    public static function getInstance() {
        self::$instance || self::$instance = new self();

        return self::$instance;
    }

    /**
     * Register asset
     *
     * @param mixed $handle
     * @param array $asset
     * 
     * @return void
     */
    public function register($handle, $asset = array()) {
        if (is_array($handle)) {
            if (array_key_exists('name', $handle)) {
                $this->register($asset['name'], $handle);
            }

            foreach ($handle as $name => $asset) {
                $this->register($name, $asset);
            }
        } else {
            if (class_exists($handle)) {
                $handle = new $handle();
            } else {
                $handle = new Asset($asset);
            }

            if ($handle instanceof Asset) {
                $this->registered[$handle->getName()] = $handle;
            }
        }
    }

    /**
     * Deregister asset
     *
     * @param string $handle
     * 
     * @return void
     */
    public function deregister($handle) {
        if ($this->has($handle, 'registered')) {
            unset($this->registered[$handle]);
        }
    }

    /**
     * Check if asset registered or enqueued
     *
     * @param string $handle
     * 
     * @return boolean
     */
    public function has($handle) {
        return isset($this->registered[$handle]);
    }

    /**
     * Get registered asset.
     *
     * @param string $handle
     * @return null|object
     */
    public function get($handle) {
        if ($this->has($handle)) {
            return $this->registered[$handle];
        }
    }

    /**
     * Get all registered asset
     *
     * @return void
     */
    public function all() {
        return $this->registered;
    }

    /**
     * Enqueue asset
     *
     * @param string $handle
     * @param array $asset
     * 
     * @return string
     */
    public function enqueue($handle, $asset = array()) {
        if (array_key_exists($handle, $this->enqueued)) {
            return $this->enqueued[$handle];
        }

        $output = '';
        $this->register($handle, $asset);

        $dependencs = $this->dependency($handle);
        foreach ($dependencs as $dependent => $asset) {
            $output .= $asset->render();
        }
        $output .= $this->get($handle)->render();

        $this->enqueued[$handle] = $output;
        return $output;
    }

    /**
     * Enqueue asset
     *
     * @param array $asset
     * @return void
     */
    public function enqueues($asset = array()) {
        $output = '';
        foreach ($asset as $handle => $a) {
            $output .= $this->enqueue($handle, $a);
        }

        return $output;
    }

    /**
     * Get handle all dependency
     *
     * @param string $handle
     * @return void
     */
    protected function dependency($handle, &$dependent = array()) {
        if ($asset = $this->get($handle)) {
            $dependency = $asset->getDependency();
            foreach ($dependency as $dep) {
                if ($this->has($dep)) {
                    $this->dependency($dep, $dependent);
                }
            }
            
            if (!array_key_exists($handle, $dependent)) {
                $dependent[$handle] = $asset;
            }
        }

        return $dependent;
    }
}