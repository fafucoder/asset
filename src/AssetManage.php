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
     * Enqueued asset
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
            //如果是class就实例化，否则等到enqueue的时候再实例化
            if (array_key_exists($handle, $this->registered)) {
                return;
            }

            if (class_exist($handle)) {
                $handle = new $handle();
            }

            if ($handle instanceof Asset) {
                $this->registered[$handle->getName()] = $handle;
            } else {
                $this->registered[$handle] = $asset;
            }
        }
    }

    /**
     * Enqueue asset
     *
     * @param mixed $handle
     * @param array $asset
     * 
     * @return void
     */
    public function enqueue($handle, $asset = array()) {
        if (is_array($handle)) {
            if (array_key_exists('name', $handle)) {
                $this->enqueue($handle['name'], $handle);
            }

            foreach ($handle as $name => $asset) {
                $this->enqueue($name, $asset);
            }
        } else {
            //如果是class就实例化，否则等到enqueue的时候再实例化
            if (array_key_exists($handle, $this->enqueued)) {
                return;
            }

            if (class_exist($handle)) {
                $handle = new $handle();
            } else {
                $handle = new Asset($asset);
            }

            if ($handle instanceof Asset) {
                if (!array_key_exists($handle->getName(), $this->registered)) {
                    $this->registered[$handle->getName()] = $handle;
                }

                $this->enqueued[$handle->getName()] = $handle;

            }
        }
    }

    /**
     * Dequeue asset
     *
     * @param string $handle
     * 
     * @return void
     */
    public function dequeue($handle) {
        if ($this->has($handle, 'enqueued')) {
            unset($this->enqueued[$handle]);
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

    public function render($handle) {

    }

    /**
     * Check if asset registered or enqueued
     *
     * @param string $handle
     * @param string $done
     * 
     * @return boolean
     */
    public function has($handle, $done="registered") {
        switch ($done) {
            case 'registered':
                return isset($this->registered[$handle]);
                break;
            case "enqueued":
                return isset($this->enqueued[$handle]);
            default:
                break;
        }
    }
}