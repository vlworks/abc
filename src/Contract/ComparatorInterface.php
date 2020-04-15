<?php


namespace Contract;


interface ComparatorInterface
{
    public function compare ($a, $b): int;
}