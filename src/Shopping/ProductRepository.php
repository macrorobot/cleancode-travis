<?php

namespace Shopping;

use PDO;

class ProductRepository
{
    /**
     * @var PDO
     */
    protected $pdo;

    /**
     * ProductRepository constructor.
     *
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findOne($id): ?Product
    {
        if (!is_int($id)) {
            throw new \InvalidArgumentException('invalid id');
        }

        $sql = 'SELECT * FROM product WHERE id=?';
        $stmt = $this->pdo->prepare($sql);

        if ($stmt->execute([$id]) === false) {
            throw new \Exception('unable to find product');
        }

        $row = $stmt->fetch(PDO::FETCH_OBJ);
        if ($row === null) {
            return null;
        }

        return $this->mapToProduct($row);
    }

    public function mapToProduct(\stdClass $row): Product
    {
        return new Product(
            $row->id,
            $row->name,
            $row->description,
            $row->price
        );
    }
}
