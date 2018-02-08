<?php

namespace Shopping\Test;

use PHPUnit\Framework\TestCase;
use Shopping\Product;

class ProductTest extends TestCase
{
    public function testConstructor()
    {
        $product = new Product(1, 'item1', '', 0.0);
        $this->assertInstanceOf(Product::class, $product);

        $this->assertEquals(1, $product->getId());
        $this->assertEquals(0, $product->getPrice());
        $this->assertEquals('item1', $product->getName());
        $this->assertEquals('', $product->getDescription());
    }
}
