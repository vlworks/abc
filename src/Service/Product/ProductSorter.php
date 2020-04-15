<?php


namespace Service\Product;


use Contract\ComparatorInterface;

class ProductSorter
{
    private $comparator;

    public function __construct(ComparatorInterface $comparator)
    {
        $this->comparator = $comparator;
    }

    public function sort(array $product): array {
        usort($product, [$this->comparator, 'compare']);
        return $product;
    }
}