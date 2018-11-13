<?php
namespace Dawn\Asset\Tests\Fixtures;

use Dawn\Asset\Asset;

class React extends Asset {
    public $name = "react";
    public $version = "1.0.0";
    public $url = "http://localhost/example/";
    public $js = array('react.min.js');
    public $css = array('react.css');
    public $dependency = array('jquery');
}