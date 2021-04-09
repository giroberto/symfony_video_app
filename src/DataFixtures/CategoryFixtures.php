<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->loadMainCategories($manager);
        $this->loadSubcategories($manager, 'Electronics', 1);
        $this->loadSubcategories($manager, 'Computers', 6);
        $this->loadSubcategories($manager, 'Movies', 4);
    }
    
    private function loadMainCategories($manager){
        foreach($this->getMainCategories() as [$name]){
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);    
        }
        $manager->flush();

    }

    private function loadSubcategories($manager, $category, $parent_id){
        $method = "get{$category}Data";
        $categories = $this->$method();
        foreach($categories as [$name]){
            $parent = $manager->getRepository(Category::class)->find($parent_id);
            $category = new Category();
            $category->setName($name);
            $category->setParent($parent);
            $manager->persist($category);    
        }
        $manager->flush();

    }

    private function getMainCategories(){
        return [
            ["Electronics", 1],
            ["Toys", 2],
            ["Books", 3],
            ["Movies", 4]
        ];
    }

    private function getElectronicsData(){
        return [
            ["Cameras", 5],
            ["Computers", 6],
            ["Cell Phones", 7]
        ];
    }
    
    private function getComputersData(){
        return [
            ["Laptops", 8],
            ["Desktops", 9]
        ];
    }

    private function getMoviesData(){
        return [
            ["Family", 10],
            ["Romantic", 11]
        ];
    }

}
