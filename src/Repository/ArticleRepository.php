<?php

namespace App\Repository;

use App\Common\dto\TagsDto;
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
    public function toString(): string {
        return '';
    }


    /**
     * @return Article[] Returns an array of Article objects
     */
    public function findForTag1(): array {
        $q = $this->createQueryBuilder('a')
            ->distinct()
            ->select('a.tag1')
            ->where('a.tag1 is not null')
            ->orderBy('a.tag1', 'ASC')
            ->getQuery()
            ->getArrayResult()
        ;

        $ret = [];
        foreach ($q as $item) {
            $ret[$item['tag1']] = $item['tag1'];
        }
        return $ret;
    }

    /**
     * @return Article[] Returns an array of Article objects
     */
    public function findForTag2(): array {
        $q = $this->createQueryBuilder('a')
            ->distinct()
            ->select('a.tag2')
            ->where('a.tag2 is not null')
            ->orderBy('a.tag2', 'ASC')
            ->getQuery()
            ->getArrayResult()
            ;

        $ret = [];
        foreach ($q as $item) {
            $ret[$item['tag2']] = $item['tag2'];
        }
        return $ret;
    }


    /**
     * @return Article[] Returns an array of Article objects
     */
    public function findForTag3(): array {
        $q = $this->createQueryBuilder('a')
            ->distinct()
            ->select('a.tag3')
            ->where('a.tag3 is not null')
            ->orderBy('a.tag3', 'ASC')
            ->getQuery()
            ->getArrayResult()
        ;

        $ret = [];
        foreach ($q as $item) {
            $ret[$item['tag3']] = $item['tag3'];
        }
        return $ret;
    }

    /**
     * @return Article[] Returns an array of Article objects
     */
    public function findForTag4(): array {
        $q = $this->createQueryBuilder('a')
            ->distinct()
            ->select('a.tag4')
            ->where('a.tag4 is not null')
            ->orderBy('a.tag4', 'ASC')
            ->getQuery()
            ->getArrayResult()
        ;

        $ret = [];
        foreach ($q as $item) {
            $ret[$item['tag4']] = $item['tag4'];
        }
        return $ret;
    }


    /**
     * @return Article[] Returns an array of Article objects
     */
    public function findForTag5(): array {
        $q = $this->createQueryBuilder('a')
            ->distinct()
            ->select('a.tag5')
            ->where('a.tag5 is not null')
            ->orderBy('a.tag5', 'ASC')
            ->getQuery()
            ->getArrayResult()
        ;

        $ret = [];
        foreach ($q as $item) {
            $ret[$item['tag5']] = $item['tag5'];
        }
        return $ret;
    }

    /**
     * @return Article[] Returns an array of Article objects
     */
    public function findForTag6(): array {
        $q = $this->createQueryBuilder('a')
            ->distinct()
            ->select('a.tag6')
            ->where('a.tag6 is not null')
            ->orderBy('a.tag6', 'ASC')
            ->getQuery()
            ->getArrayResult()
        ;

        $ret = [];
        foreach ($q as $item) {
            $ret[$item['tag6']] = $item['tag6'];
        }
        return $ret;
    }


    public function searchByTags(TagsDto $dto) : ?PaginationInterface
    {
        try {
            $q = $this
                ->createQueryBuilder('a')
                ->innerJoin('a.marque', 'm')
                ->select('a');

            if ($dto->getTag1() != '')
                $q = $q->andWhere('a.tag1 like :tag1')->setParameter('tag1', "%{$dto->getTag1()}%");
            else
                $q = $q->andWhere('a.tag1 is null');

            if ($dto->getTag2() != '')
                $q = $q->andWhere('a.tag2 like :tag2')->setParameter('tag2', "%{$dto->getTag2()}%");
            else
                $q = $q->andWhere('a.tag2 is null');

            if ($dto->getTag3() != '')
                $q = $q->andWhere('a.tag3 like :tag3')->setParameter('tag3', "%{$dto->getTag3()}%");
            else
                $q = $q->andWhere('a.tag3 is null');

            if ($dto->getTag4() != '')
                $q = $q->andWhere('a.tag4 like :tag4')->setParameter('tag4', "%{$dto->getTag4()}%");
            else
                $q = $q->andWhere('a.tag4 is null');

            if ($dto->getTag5() != '')
                $q = $q->andWhere('a.tag5 like :tag5')->setParameter('tag5', "%{$dto->getTag5()}%");
            else
                $q = $q->andWhere('a.tag5 is null');

            if ($dto->getTag6() != '')
                $q = $q->andWhere('a.tag6 like :tag6')->setParameter('tag6', "%{$dto->getTag6()}%");
            else
                $q = $q->andWhere('a.tag6 is null');


            $q = $q->orderBy('a.nom');

            //die($q->getQuery()->getDQL());

            $pagination = $this->paginator->paginate(
                $q, /* query NOT result */
                1,  /*page number*/
                20  /*limit per page*/
            );

            return $pagination;

        } catch (NonUniqueResultException $e) {
            return null;
        }

    }

    public function search(ArticleSearchDto $dto) : ?PaginationInterface
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



    public function findaaaa(): array {
        $q = $this->createQueryBuilder('a')
            ->select('a.tag1, a.tag2, a.tag3, a.tag4, a.tag5, a.tag6, count(a.id) as total')
            ->orderBy('a.tag1, a.tag2, a.tag3, a.tag4, a.tag5, a.tag6')
            ->groupBy('a.tag1, a.tag2, a.tag3, a.tag4, a.tag5, a.tag6')
            ->getQuery()
            ->getArrayResult();
        return $q;
    }

}
