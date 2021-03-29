<?php

namespace App\Utils\AbstractController;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class CategoryTreeAbstract{
    public $categoriesArrayFromDb;
    protected static $dbConnection;
    public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator)
    {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->categoriesArrayFromDb= $this->getCategories();
        
    }
    abstract public function getCategoryList(array $array_categories);

    public function getCategories(){
        if(self::$dbConnection){
            return self::$dbConnection;
        }
        $conn = $this->entityManager->getConnection();
        $sql = 'SELECT * from categories';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return self::$dbConnection = $stmt->fetchAllNumeric();
    }
}