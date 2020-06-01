<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\Dto\ArticleSearchDto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    /**
     * @var PaginatorInterface
     */
    private $paginator;

    public function __construct(ManagerRegistry $registry,
                                PaginatorInterface $paginator)
    {
        parent::__construct($registry, Article::class);
        $this->paginator = $paginator;
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function search(ArticleSearchDto $dto) : PaginationInterface
    {
        try {
            $q = $this
                ->createQueryBuilder('a')
                ->innerJoin('a.marque', 'm')
                ->select('a');

            if (!empty($dto->q)) {
                $q = $q
                    ->andWhere('a.nom LIKE :q OR a.description LIKE :q')
                    ->setParameter('q',"%{$dto->q}%");
            }

            if (!empty($dto->min)) {
                $q = $q
                    ->andWhere('a.quantite >= :qtmin')
                    ->setParameter('qtmin',$dto->min);
            }
            if (!empty($dto->max)) {
                $q = $q
                    ->andWhere('a.quantite <= :qtmax')
                    ->setParameter('qtmax',$dto->max);
            }           

            //dump($dto->marques);
            //var_dump($dto->marques);

            if (!empty($dto->marques) && count($dto->marques)>0) {
                $q = $q
                    ->andWhere('m.id IN (:marques)')
                    ->setParameter('marques', $dto->marques);
            }

            if (!empty($dto->tag)) {
                $q = $q
                    ->andWhere('(a.tag1 like :tag) OR (a.tag2 like :tag) OR (a.tag3 like :tag) OR (a.tag4 like :tag) OR (a.tag5 like :tag) OR (a.tag6 like :tag)')
                    ->setParameter('tag', "%{$dto->tag}%");
            }

            if (!empty($dto->ref)) {
                $q = $q
                    ->andWhere('(a.ref1 like :ref) OR (a.ref2 like :ref)')
                    ->setParameter('ref', "%{$dto->ref}%");
            }

            $pagination = $this->paginator->paginate(
                $q, /* query NOT result */
                $dto->page, /*page number*/
                $dto->limitPerPage /*limit per page*/
            );

            return $pagination;

        } catch (NonUniqueResultException $e) {
            return null;
        }
    }
}
