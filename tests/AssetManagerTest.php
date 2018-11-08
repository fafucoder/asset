<?php
namespace Dawn\Tests;

use Dawn\AssetManager;
use PHPUnit\Framework\TestCase;
use Dawn\Tests\Fixtures\Jquery;
use Dawn\Tests\Fixtures\Bootstrap;
use Dawn\Tests\Fixtures\React;

class AssetManagerTest extends TestCase {
    public function setUp() {
        $this->manager = \Dawn\AssetManager::getInstance();
    }

    public function testRegister() {
        $this->manager->register(Jquery::class);
        $this->manager->register(Bootstrap::class);
        $this->manager->register(React::class);

        $data = $this->manager->enqueue('bootstrap');
        var_dump($data);
    }
}