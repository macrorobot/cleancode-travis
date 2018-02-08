<?php

namespace Shopping\Test;

use Shopping\ProductRepository,
    PHPUnit\Framework\TestCase,
    TypeError,
    PDO,
    PDOStatement;

class ProductRepositoryTest extends TestCase
{
    public function testConstructorWithoutPDO()
    {
        $this->expectException(TypeError::class);
        new ProductRepository(null);
    }

    public function testConstructorWithPDO()
    {
        $pdoMock = $this->createMock(PDO::class);
        $repo = new ProductRepository($pdoMock);
        $this->assertInstanceOf(PDO::class, $pdoMock);
    }

    public function testFindOneWithTypeErrorId()
    {
        $this->expectException(\InvalidArgumentException::class);

        $pdoStmt = $this->getPDOStatement();
        $pdoMock = $this->getPDOMock($pdoStmt);

        $repo = new ProductRepository($pdoMock);
        $repo->findOne([]);
    }

    public function testFindOneWithEmptyId()
    {
        $pdoStmt = $this->getPDOStatement();
        $pdoMock = $this->getPDOMock($pdoStmt);

        $repo = new ProductRepository($pdoMock);
        $product = $repo->findOne(5);
        $this->assertNull($product);
    }

    public function testFindOneExecuteReturnsFalse()
    {
        $this->expectException(\Exception::class);

        $pdoStmt = $this->getPDOStatement();
        $pdoStmt->expects($this->once())
                ->method('execute')
                ->willReturn(false);

        $pdoMock = $this->getPDOMock($pdoStmt);

        $repo = new ProductRepository($pdoMock);
        $repo->findOne(5);
    }

    public function testReturnsProduct()
    {
        $row = new \stdClass();
        $row->id = 1;
        $row->name = 'item1';
        $row->description = '';
        $row->price = 50;

        $pdoStmt = $this->getPDOStatement();
        $pdoStmt->expects($this->once())->method('execute')->willReturn(true);
        $pdoStmt->expects($this->once())->method('fetch')->willReturn($row);

        $pdoMock = $this->getPDOMock($pdoStmt);

        $repo = new ProductRepository($pdoMock);
        $product = $repo->findOne(1);

        $this->assertEquals(1, $product->getId());
    }

    protected function getPDOMock(PDOStatement $pdoStmt): PDO
    {
        $pdoMock = $this->getMockBuilder(PDO::class)
            ->disableOriginalConstructor()
            ->setMethods(['prepare'])
            ->getMock();

        $pdoMock->method('prepare')->willReturn($pdoStmt);

        return $pdoMock;
    }

    protected function getPDOStatement()
    {
        return $this->getMockBuilder(PDOStatement::class)
            ->setMethods(['execute', 'fetch', 'fetchAll'])
            ->getMock();
    }
}
