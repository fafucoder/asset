<?php
namespace Dawn\Tests\Fixtures;

use Dawn\Asset;

class Jquery extends Asset {
    public $name = "jquery";
    public $version = "1.0.0";
    public $url = "http://localhost/example/";
    public $js = array('jquery.min.js');
    public $css = array('jquery.css');
    public $dependency = array();
}