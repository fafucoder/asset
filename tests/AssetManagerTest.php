<?php
namespace Dawn\Tests;

use Dawn\Asset;
use Dawn\AssetManager;
use PHPUnit\Framework\TestCase;
use Dawn\Tests\Fixtures\Jquery;
use Dawn\Tests\Fixtures\Bootstrap;
use Dawn\Tests\Fixtures\React;

class AssetManagerTest extends TestCase {
    public function setUp() {
        $this->manager = new AssetManager();
    }

    public function testRegister() {
        $this->assertEmpty($this->manager->registered);

        $this->manager->register('bootstrap', array(
            'name' => 'bootstrap',
            'url' => 'http://localhost/exmpale/',
            'js' => array('bootstrap.min.js'),
            'css' => array('bootstrap.min.css'),
        ));
        
        $this->assertArrayHasKey('bootstrap', $this->manager->registered);
    }

    public function testRegisterAsArray() {
        $this->assertEmpty($this->manager->registered);

        $this->manager->register(array(
            'jquery' => array(
                'name' => 'jquery',
                'js' => array('jquery.js'),
                'path' => '/fixtures/jquery',
            ),
            'react' => array(
                'name' => 'react',
                'js' => array('react.js'),
                'path' => '/fixtures/react',
            ),
        ));

        $this->assertArrayHasKey('jquery', $this->manager->registered);
        $this->assertArrayHasKey('react', $this->manager->registered);
    }

    public function testRegisterAsClass() {
        $this->assertEmpty($this->manager->registered);

        $this->manager->register(array(
            Jquery::class,
            React::class,
        ));
        
        $this->assertArrayHasKey('jquery', $this->manager->registered);
        $this->assertArrayHasKey('react', $this->manager->registered);
        
        $this->assertInstanceOf(Asset::class, $this->manager->registered['jquery']);
    }

    public function testDeregister() {
        $this->assertEmpty($this->manager->registered);

        $this->manager->register(array(
            Jquery::class,
            React::class,
        ));
        
        $this->assertArrayHasKey('jquery', $this->manager->registered);
        $this->assertArrayHasKey('react', $this->manager->registered);

        $this->manager->deregister(array('jquery', 'react'));

        $this->assertArrayNotHasKey('jquery', $this->manager->registered);
        $this->assertArrayNotHasKey('react', $this->manager->registered);
    }

    public function testHas() {
        $this->manager->register(array(
            Jquery::class,
            React::class,
        ));

        $this->assertTrue($this->manager->has('jquery'));
        $this->assertTrue($this->manager->has('react'));
    }

    public function testGet() {
        $this->manager->register(array(
            Jquery::class,
            React::class,
        ));

        $this->assertEquals(new Jquery(), $this->manager->get('jquery'));
        $this->assertEquals(new React(), $this->manager->get('react'));
    }

    public function testAll() {
        $this->manager->register(array(
            Jquery::class,
            React::class,
        ));

        $expected = array(
            'jquery' => new Jquery(),
            'react' => new React(),
        );
        $this->assertEquals($expected, $this->manager->all());
    }

    public function testEnqueueAsClass() {
        $this->manager->register(Jquery::class);

        $expected = "<link type='text/css' src='http://localhost/example/jquery.css?version=1.0.0' media ='screen' />\n<script type='text/javascript' src='http://localhost/example/jquery.min.js?version=1.0.0'  ></script>\n";

        $output = $this->manager->enqueue('jquery');
        $this->assertEquals($expected, $output);
    }

    public function testEnqueueAsString() {
        $output = $this->manager->enqueue('bootstrap', array(
            'name' => 'bootstrap',
            'url' => 'http://localhost/example/',
            'js' => array('bootstrap.min.js'),
            'css' => array('bootstrap.min.css'),
            'dependency' => array('jquery'),
        ));

        $expected = "<link type='text/css' src='http://localhost/example/bootstrap.min.css?version=1.0.0' media ='screen' />\n<script type='text/javascript' src='http://localhost/example/bootstrap.min.js?version=1.0.0'  ></script>\n";

        $this->assertEquals($expected, $output);
    }

    public function testEnqueueAsDependency() {
        $this->manager->register(Jquery::class);

        $output = $this->manager->enqueue('bootstrap', array(
            'name' => 'bootstrap',
            'url' => 'http://localhost/example/',
            'js' => array('bootstrap.min.js'),
            'css' => array('bootstrap.min.css'),
            'dependency' => array('jquery'),
        ));

        $expected = "<link type='text/css' src='http://localhost/example/jquery.css?version=1.0.0' media ='screen' />\n<script type='text/javascript' src='http://localhost/example/jquery.min.js?version=1.0.0'  ></script>\n<link type='text/css' src='http://localhost/example/bootstrap.min.css?version=1.0.0' media ='screen' />\n<script type='text/javascript' src='http://localhost/example/bootstrap.min.js?version=1.0.0'  ></script>\n";

        $this->assertEquals($expected, $output);
    }

    public function testDequeue() {
        $this->manager->enqueue('bootstrap', array(
            'name' => 'bootstrap',
            'url' => 'http://localhost/example/',
            'js' => array('bootstrap.min.js'),
            'css' => array('bootstrap.min.css'),
            'dependency' => array('jquery'),
        ));

        $this->assertArrayHasKey('bootstrap', $this->manager->enqueued);
        $this->manager->dequeue('bootstrap');

        $this->assertArrayNotHasKey('bootstrap', $this->manager->enqueued);
    }
}