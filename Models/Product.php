<?php
namespace Models;

class Product
{
    public int $id;
    public string $title;
    public int $quantity;
    public string $manufacturer;

    public function __construct(?int $id, string $title, int $quantity, string $manufacturer)
    {
        if ($id !== null)
            $this->id = $id;

        $this->title = $title;
        $this->quantity = $quantity;
        $this->manufacturer = $manufacturer;
    }

    public static function parseFromAssoc(array $associativeArray): Product
    {
        return new Product($associativeArray['Id'] ?? $associativeArray['id'] ?? null, $associativeArray['Title'] ?? $associativeArray['title'], $associativeArray['Quantity'] ?? $associativeArray['quantity'], $associativeArray['Manufacturer'] ?? $associativeArray['manufacturer']);
    }

}