<?php

namespace Shopping;

use InvalidArgumentException,
    Exception;

class Cart
{
    /**
     * @var int
     */
    private $minQuantity;

    /**
     * @var int
     */
    private $maxQuantity;

    /**
     * @var float
     */
    private $total;

    /**
     * @var array
     */
    private $products = [];

    /**
     * @var array
     */
    private $quantity = [];

    /**
     * Cart constructor.
     */
    public function __construct()
    {
        $this->setTotal(0);
        $this->setMinQuantity(1);
        $this->setMaxQuantity(30);
    }

    /**
     * @param int $quantity
     * @return Cart
     */
    public function setMinQuantity(int $quantity): Cart
    {
        $this->minQuantity = 1;
        $this->validMinQuantity($quantity);
        $this->minQuantity = $quantity;
        return $this;
    }

    /**
     * @return int
     */
    public function getMinQuantity(): int
    {
        return $this->minQuantity;
    }

    /**
     * @param int $quantity
     * @return Cart
     */
    public function setMaxQuantity(int $quantity): Cart
    {
        $this->maxQuantity = $quantity;
        return $this;
    }

    /**
     * @return int
     */
    public function getMaxQuantity(): int
    {
        return $this->maxQuantity;
    }

    /**
     * Returns the total of product.
     *
     * @return float
     */
    public function getTotal(): float
    {
        return $this->total;
    }

    /**
     * Sets the total of products.
     *
     * @param float $total
     * @return Cart
     */
    public function setTotal(float $total): Cart
    {
        $this->total = $total;
        return $this;
    }

    /**
     * Returns all products.
     *
     * @return array
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * Returns quantity.
     *
     * @return array
     */
    public function getQuantity(): array
    {
        return $this->quantity;
    }

    /**
     * Add adds a product.
     *
     * @param Product $product
     * @param int $quantity
     */
    public function add(Product $product, int $quantity = 1)
    {
        $this->validMinQuantity($quantity);

        if ($quantity > $this->getMaxQuantity()) {
            throw new InvalidArgumentException(sprintf(
                'quantity "%d" is invalid',
                $quantity
            ));
        }

        if (!$this->has($product->getId())) {
            $this->products[$product->getId()] = $product;
            $this->quantity[$product->getId()] = 0;
        }

        $this->quantity[$product->getId()] += $quantity;
    }

    /**
     * Checks if the product exists.
     *
     * @param int $id
     * @return bool
     */
    public function has($id)
    {
        return array_key_exists($id, $this->products);
    }

    /**
     * Remove product.
     *
     * @param Product $product
     * @param int $quantity
     * @throws Exception
     */
    public function remove(Product $product, $quantity = 1)
    {
        $this->validMinQuantity($quantity);

        if (!$this->has($product->getId())) {
            throw new Exception('product does not exists');
        }

        if ($quantity >= $this->quantity[$product->getId()]) {
            unset($this->quantity[$product->getId()]);
            unset($this->products[$product->getId()]);
            return;
        }

        $this->quantity[$product->getId()] -= $quantity;
    }

    /**
     * Clear products
     */
    public function clear()
    {
        $this->products = [];
        $this->quantity = [];
    }

    protected function validMinQuantity(int $quantity)
    {
        if ($quantity < $this->getMinQuantity()) {
            throw new InvalidArgumentException(sprintf(
                'quantity "%d" is invalid',
                $quantity
            ));
        }
    }
}
