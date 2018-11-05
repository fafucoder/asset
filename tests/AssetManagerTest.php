<?php
namespace Dawn\Tests;

use PHPUnit\Framework\TestCase;
use Dawn\Tests\Fixtures\Jquery;

class AssetManager extends TestCase {
    public function setUp() {
        $this->manager = Manager::getInstance();
    }

    public function testRegister() {
        $this->manager->register(Jquery::class);
    }
}