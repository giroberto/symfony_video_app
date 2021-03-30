<?php

namespace App\Utils\AbstractController;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class CategoryTreeAbstract
{
    public $categoriesArrayFromDb;
    public $categorylist;
    protected static $dbConnection;
    public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator)
    {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->categorylist = '';
        $this->categoriesArrayFromDb = $this->getCategories();
    }
    abstract public function getCategoryList(array $array_categories);

    public function getCategories()
    {
        if (self::$dbConnection) {
            return self::$dbConnection;
        }
        $conn = $this->entityManager->getConnection();
        $sql = 'SELECT * from categories';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return self::$dbConnection = $stmt->fetchAllAssociative();
    }

    public function buildTree(int $parent_id = null): array
    {
        $subcategory= [];
        foreach ($this->categoriesArrayFromDb as $category) {
            if ($category['parent_id'] == $parent_id) {
                $children = $this->buildTree($category['id']);
                if ($children) {
                    $category['children'] = $children;
                }
                $subcategory[] = $category;
            }
        }
        return $subcategory;
    }
}
