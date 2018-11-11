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
                $this->register($handle['name'], $handle);
            }

            foreach ($handle as $name => $handle_asset) {
                //if is class handle asset is classname
                if (is_numeric($name)) {
                    $name = $handle_asset;
                    $handle_asset = $asset;
                }

                $asset = array_merge($asset, $handle_asset);
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
     * @param string|array $handle
     * 
     * @return void
     */
    public function deregister($handle) {
        if (is_array($handle)) {
            foreach ($handle as $h) {
                $this->deregister($h);
            }
        } else {
            if ($this->has($handle)) {
                unset($this->registered[$handle]);
            }
        }
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
        $output = '';
        if (array_key_exists($handle, $this->enqueued)) {
            return;
        }

        if (!array_key_exists($handle, $this->registered)) {
            $this->register($handle, $asset);
        }

        $dependency = $this->dependency($handle);
        foreach ($dependency as $dependent => $asset) {
            if (array_key_exists($dependent, $this->enqueued)) {
                continue;
            }

            $output .= $asset->output();
            $this->enqueued[$dependent] = $asset;
        }

        return $output;
    }

    /**
     * Dequeue asset.
     *
     * @param string $handle
     * @return void
     */
    public function dequeue($handle) {
        if (isset($this->enqueued[$handle])) {
            unset($this->enqueued[$handle]);
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
     * Get handle asset all dependency
     *
     * @param string $handle
     * @return array
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