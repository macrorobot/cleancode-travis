<?php

namespace Shopping\Test;

use InvalidArgumentException,
    PHPUnit\Framework\TestCase,
    Shopping\Cart,
    Shopping\Product,
    Exception;

class CartTest extends TestCase
{
    /**
     * @var Cart
     */
    private $cart;

    public function setUp()
    {
        $this->cart = new Cart();
    }

    public function tearDown()
    {
        $this->cart = null;
    }

    public function testConstructor()
    {
        $this->assertEquals(0, $this->cart->getTotal());
        $this->assertEquals([], $this->cart->getProducts());
        $this->assertEquals([], $this->cart->getQuantity());
        $this->assertEquals(1, $this->cart->getMinQuantity());
        $this->assertEquals(30, $this->cart->getMaxQuantity());
    }

    public function testMinQuantityWithZero()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->cart->setMinQuantity(0);
    }

    public function testMinQuantityWithNegativeQuantity()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->cart->setMinQuantity(-40);
    }

    public function testAddToCart()
    {
        $product = new Product(5, 'item5', 'lorem ipsum', 10.99);
        $this->cart->add($product);

        $this->assertEquals($product, $this->cart->getProducts()[5]);
        $this->assertEquals(1, $this->cart->getQuantity()[5]);
    }

    public function testAddToCartWithOverMaximumQuantity()
    {
        $this->expectException(InvalidArgumentException::class);
        $product = new Product(6, '', '', 10);
        $this->cart->add($product, $this->cart->getMaxQuantity() + 1);
    }

    public function testAddToCartWithZeroQuantity()
    {
        $this->expectException(InvalidArgumentException::class);
        $product = new Product(6, '', '', 10);
        $this->cart->add($product, 0);
    }

    public function testAddToCartWithUnderMinimumQuantity()
    {
        $this->expectException(InvalidArgumentException::class);
        $product = new Product(6, '', '', 10);
        $this->cart->add($product, $this->cart->getMinQuantity() -1);
    }

    public function testAddToCartWithQuantity()
    {
        $this->assertCount(0, $this->cart->getProducts());
        $product = new Product(7, 'item6', '', 9.99);
        $this->cart->add($product);

        $this->assertCount(1, $this->cart->getProducts());
        $this->cart->add($product);
        $this->assertCount(1, $this->cart->getProducts());

        $product->setId(9);
        $this->cart->add($product);

        $this->assertCount(2, $this->cart->getProducts());
    }

    public function testHasProduct()
    {
        $this->assertFalse($this->cart->has(5));

        $product = new Product(5, 'item5', 'lorem ipsum', 10.99);
        $this->cart->add($product);

        $this->assertTrue($this->cart->has(5));
    }

    public function testRemoveProductNotFound()
    {
        $this->expectException(Exception::class);
        $product = new Product(30, 'item5', 'lorem ipsum', 10.99);
        $this->cart->remove($product);
    }

    public function testRemoveProductWithQuantity()
    {
        $product = new Product(26, 'item5', 'lorem ipsum', 10.99);
        $this->cart->add($product, 3);
        $this->cart->remove($product);

        $this->assertEquals(2, $this->cart->getQuantity()[26]);
    }

    public function testRemoveProductWithQuantityGreaterThanExists()
    {
        $product = new Product(20, 'item20', 'lorem ipsum', 10.99);
        $this->cart->add($product, 5);
        $this->cart->remove($product, 10);

        $this->assertFalse($this->cart->has($product->getId()));
    }

    public function testRemoveProductWithNegativeQuantity()
    {
        $this->expectException(InvalidArgumentException::class);
        $product = new Product(20, 'item20', '', 10.99);
        $this->cart->add($product, 5);
        $this->cart->remove($product, -80);
    }

    public function testClearAllProducts()
    {
        $product = new Product(90, 'item90', '', 10.99);
        $this->cart->add($product, 20);
        $this->cart->clear();

        $this->assertEquals([], $this->cart->getProducts());
        $this->assertEquals([], $this->cart->getQuantity());
    }
}
