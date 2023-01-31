<?php

namespace App\Repository;

use App\Entity\Book;
use App\DTO\SearchBookCriteria;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function add(Book $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Book $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllOrderedByPrice(): array
    {
        $qd = $this->createQueryBuilder('book');

        return $qd->orderBy('book.price', 'DESC')
            ->setMaxResults(20)
            ->getQuery()
            ->getResult();
    }

    /**
     * return books by category 
     */
    public function findAllOrderedByCategory($categoryId): array
    {
        $qd = $this->createQueryBuilder('book');

        return $qd->leftJoin('book.categories', 'category')
            ->andWhere('category.id = :id')
            ->setParameter('id', $categoryId)
            ->orderBy('book.price', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * research with DTO 
     */
    public function findByCriteria(SearchBookCriteria $criteria): array
    {
        $qd = $this->createQueryBuilder('book');

        if ($criteria->title) {
            $qd->andWhere('book.title LIKE :title')
                ->setParameter('title', "%$criteria->title%");
        }
        if (!empty($criteria->authors)) {
            $qd->leftJoin('book.author', 'author')
                ->andWhere('author.id IN (:authorIds)')
                ->setParameter('authorIds', $criteria->authors);
        }
        if (!empty($criteria->categories)) {
            $qd->leftJoin('book.categories', 'category')
                ->andWhere('category.id IN (:categoryId)')
                ->setParameter('categoryId', $criteria->categories);
        }
        if ($criteria->minPrice) {
            $qd->andWhere('book.price >= :minPrice')
                ->setParameter('minPrice', $criteria->minPrice);
        }
        if ($criteria->maxPrice) {
            $qd->andWhere('book.price <= :maxPrice')
                ->setParameter('maxPrice', $criteria->maxPrice);
        }

        return $qd->getQuery()->getResult();
    }

    //    /**
    //     * @return Book[] Returns an array of Book objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Book
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
