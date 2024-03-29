<?php

namespace App\Repository;

use App\Entity\Blogpost;
use App\Entity\Categorie;
use App\Entity\Realisation;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Realisation>
 *
 * @method Realisation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Realisation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Realisation[]    findAll()
 * @method Realisation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RealisationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Realisation::class);
    }

    public function save(Realisation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Realisation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // /**
    // * @return Realisation[] Returns an array of Realisation objects
    // */
    public function last3(): array
    {
        return $this->createQueryBuilder('l')
            //    ->andWhere('l.exampleField = :val')
            //    ->setParameter('val', $value)
            ->orderBy('l.id', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
        ;
    }

    // @Method("findOneWithAttachments")
    public function findOneWithAttachments(int $id): ?Realisation
{
    $queryBuilder = $this->createQueryBuilder('r');
    
    $queryBuilder->leftJoin('r.attachments', 'a')
        ->addSelect('a')
        ->andWhere('r.id = :id')
        ->setParameter('id', $id);
    
    return $queryBuilder->getQuery()->getOneOrNullResult();
}

//    /**
//  * @return Realisation[] Returns an array of Realisation objects
//  */

public function findAllPortfolio(Categorie $categorie): array
{
    return $this->createQueryBuilder('r')
        ->select('r')
        ->where(':categorie MEMBER OF r.categorie')
        ->andWhere('r.portfolio = TRUE')
        ->andWhere('r.slug = :val')
        ->setParameter('categorie', $categorie)
        ->setParameter('val', $categorie->getSlug())
        ->getQuery()
        ->getResult();
}



    public function findbyId($id)
    {
        return $this->createQueryBuilder('i')
            ->Where('i.realisation = :val')
            ->andWhere('i'. '$id' . '=:val')
            ->setParameter('val', $id->getId()->getAttachments())
            ->getQuery()
            ->getResult()
        ;
    }
}
