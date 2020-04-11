<?php

declare(strict_types = 1);

namespace Service\Product;

use Comparator\ProductNameComparator;
use Comparator\ProductPriceComparator;
use Model;
use Model\Entity\Product;
use Model\Repository\ProductRepository;

class ProductService
{
    /**
     * Получаем информацию по конкретному продукту
     * @param int $id
     * @return Product|null
     */
    public function getInfo(int $id): ?Product
    {
        $product = $this->getProductRepository()->search([$id]);
        return count($product) ? $product[0] : null;
    }

    /**
     * Получаем все продукты
     * @param string $sortType
     * @return Product[]
     */
    public function getAll(string $sortType): array
    {
        $productList = $this->getProductRepository()->fetchAll();



        /**
         * Первый вариант, но тут опять же остаются IF
         */

        if ($sortType === 'name'){
            $productSorter = new ProductSorter(new ProductNameComparator());
            $productSorter->sort($productList);
        }
        if ($sortType === 'price'){
            $productSorter = new ProductSorter((new ProductPriceComparator()));
            $productSorter->sort($productList);
        }

        /**
         * Второй вариант, а так можно?
         */

        $sorter = [
            'price' => new ProductPriceComparator(),
            'name' => new ProductNameComparator()
        ];

        $productSorter = new ProductSorter($sorter[$sortType]);
        $productSorter->sort($productList);


        // Применить паттерн Стратегия
        // $sortType === 'price'; // Сортировка по цене
        // $sortType === 'name'; // Сортировка по имени

        return $productList;
    }

    /**
     * Фабричный метод для репозитория Product
     * @return ProductRepository
     */
    protected function getProductRepository(): ProductRepository
    {
        return new ProductRepository();
    }
}
