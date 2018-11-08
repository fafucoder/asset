<?php
namespace Dawn\Tests\Fixtures;

use Dawn\Asset;

class Bootstrap extends Asset {
    public $name = "bootstrap";
    public $version = "2.0.0";
    public $url = "http://localhost/example/";
    public $js = array('bootstrap.min.js');
    public $css = array('bootstrap.css');
    public $dependency = array('react', 'jquery');
}