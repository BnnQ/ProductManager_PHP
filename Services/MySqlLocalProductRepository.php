<?php

namespace Services;

use Exceptions\DatabaseConnectionException;
use Models\Product;
use mysqli;
use mysqli_result;
use mysqli_stmt;
use QueryFailedException;
use StatementPrepareFailedException;

class MySqlLocalProductRepository implements IProductRepository
{
    private readonly mysqli $context;

    /**
     * @throws DatabaseConnectionException
     */
    public function __construct($config)
    {
        $databaseName = $config['name'];
        $this->context = new mysqli(hostname: $config['host'], username: $config['username'], password: $config['password'], database: $databaseName);

        if ($this->context->connect_errno) {
            throw new DatabaseConnectionException($databaseName, $this->context->connect_errno);
        }
    }

    /**
     * @inheritDoc
     * @throws QueryFailedException
     */
    public function getAll(): array
    {
        $query = "SELECT * FROM Product";
        $response = $this->context->query($query);
        if (!$response)
            throw new QueryFailedException($query, $this->context->error);

        $products = [];
        while ($row = $response->fetch_assoc()) {
            $product = Product::parseFromAssoc($row);
            $products[] = $product;
        }

        $response->close();
        return $products;
    }

    /**
     * @throws StatementPrepareFailedException
     * @throws QueryFailedException
     */
    public function get(int $id): Product
    {
        $query = "SELECT * FROM Product WHERE Id = ?";

        $response = $this->prepareStatementAndGetResult($query, 'i', $id);
        if (!$response) {
            throw new QueryFailedException($query, $this->context->error);
        }

        $row = $response->fetch_assoc();
        $product = Product::parseFromAssoc($row);
        $response->close();
        return $product;
    }

    /**
     * @throws StatementPrepareFailedException
     * @throws QueryFailedException
     */
    public function add(Product $entity): void
    {
        $query = "INSERT INTO Product (Title, Quantity, Manufacturer) VALUES (?, ?, ?)";

        $response = $this->prepareStatementAndExecute($query, 'sis', $entity->title, $entity->quantity, $entity->manufacturer);
        if (!$response)
            throw new QueryFailedException($query, $this->context->error);
    }

    /**
     * @throws StatementPrepareFailedException
     * @throws QueryFailedException
     */
    public function edit(int $id, Product $editedProduct): void
    {
        $query = "UPDATE Product SET Title = ?, Quantity = ?, Manufacturer = ? WHERE Id = ?";

        $response = $this->prepareStatementAndExecute($query, 'sisi', $editedProduct->title, $editedProduct->quantity, $editedProduct->manufacturer, $id);
        if (!$response)
            throw new QueryFailedException($query, $this->context->error);
    }

    /**
     * @throws StatementPrepareFailedException
     * @throws QueryFailedException
     */
    public function delete(int $id): void
    {
        $query = "DELETE FROM Product WHERE Id = ?";

        $response = $this->prepareStatementAndExecute($query, 'i', $id);
        if (!$response)
            throw new QueryFailedException($query, $this->context->error);
    }

    /**
     * @throws StatementPrepareFailedException
     */
    private function prepareStatement(string $query, string $paramTypes, mixed ...$params): mysqli_stmt
    {
        $queryStatement = $this->context->prepare($query);
        if (!$queryStatement)
            throw new StatementPrepareFailedException($query, $this->context->error);

        $queryStatement->bind_param($paramTypes, ...$params);
        return $queryStatement;
    }

    /**
     * @throws StatementPrepareFailedException
     */
    private function prepareStatementAndExecute(string $query, string $paramTypes, mixed ...$params): bool
    {
        $queryStatement = $this->prepareStatement($query, $paramTypes, ...$params);
        return $queryStatement->execute();
    }

    /**
     * @throws StatementPrepareFailedException
     */
    private function prepareStatementAndGetResult(string $query, string $paramTypes, mixed ...$params): bool|mysqli_result
    {
        $queryStatement = $this->prepareStatement($query, $paramTypes, ...$params);
        $queryStatement->execute();
        return $queryStatement->get_result();
    }

    public function __destruct()
    {
        $this->context?->close();
    }

}