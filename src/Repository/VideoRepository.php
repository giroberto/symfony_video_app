<?php

namespace App\Repository;

use App\Entity\Video;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Video|null find($id, $lockMode = null, $lockVersion = null)
 * @method Video|null findOneBy(array $criteria, array $orderBy = null)
 * @method Video[]    findAll()
 * @method Video[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoRepository extends ServiceEntityRepository
{
    /**
     * @var PaginatorInterface
     */
    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Video::class);
        $this->paginator = $paginator;
    }

    public function findByChildIds(array $ids, int $page, ?string $sort_method)
    {
        if ($sort_method != 'rating') {
            $dbquery = $this->createQueryBuilder('v')
                ->leftJoin('v.comments', 'c')
                ->leftJoin('v.usersThatLike', 'l')
                ->leftJoin('v.usersThatDontLike', 'd')
                ->addSelect('c', 'l', 'd')
                ->andWhere('v.category IN (:val)')
                ->setParameter('val', $ids)
                ->orderBy('v.title', $sort_method);
        } else {
            $dbquery = $this->createQueryBuilder('v')
                ->addSelect('COUNT(l) as HIDDEN likes')
                ->leftJoin('v.usersThatLike', 'l')
                ->andWhere('v.category IN (:val)')
                ->setParameter('val', $ids)
                ->groupBy('v')
                ->orderBy('likes', 'DESC');
        }
        $dbquery->getQuery();
        return $this->paginator->paginate($dbquery, $page, Video::perPage);
    }

    public function findByTitle(string $query, int $page, ?string $sort_method)
    {
        $querybuilder = $this->createQueryBuilder('v');

        $searchTerms = $this->prepareQuery($query);

        foreach ($searchTerms as $key => $term) {
            $querybuilder->orWhere('v.title LIKE :t_' . $key)
                ->setParameter('t_' . $key, '%' . trim($term) . '%');
        }

        if ($sort_method != 'rating') {
            $querybuilder->leftJoin('v.comments', 'c')
                ->leftJoin('v.usersThatLike', 'l')
                ->leftJoin('v.usersThatDontLike', 'd')
                ->addSelect('c', 'l', 'd')
                ->orderBy('v.title', $sort_method);
        } else {
            $querybuilder->addSelect('COUNT(l) as HIDDEN likes', 'c')
                ->leftJoin('v.usersThatLike', 'l')
                ->leftJoin('v.comments', 'c')
                ->groupBy('v', 'c')
                ->orderBy('likes', 'DESC');
        }

        $dbquery = $querybuilder->getQuery();
        return $this->paginator->paginate($dbquery, $page, Video::perPage);
    }

    private function prepareQuery($query)
    {
        $terms = array_unique(explode(' ', $query));
        return array_filter($terms, function ($term) {
            return 2 <= mb_strlen($term);
        });
    }

    public function videoDetails($id)
    {
        return $this->createQueryBuilder('v')
            ->leftJoin('v.comments', 'c')
            ->leftJoin('v.user', 'u')
            ->addSelect('c', 'u')
            ->where('v.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    // /**
    //  * @return Video[] Returns an array of Video objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Video
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
