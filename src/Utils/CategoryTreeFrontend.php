<?php

namespace App\Utils;
use App\Utils\AbstractController\CategoryTreeAbstract;

class CategoryTreeFrontend extends CategoryTreeAbstract{
    public function getCategoryList(array $array_categories){
        dump($array_categories);
    }
}