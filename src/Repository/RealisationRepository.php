<?php

namespace App\Repository;

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

    //    /**
    //     * @return Realisation[] Returns an array of Realisation objects
    //     */
    public function lastthree()
    {
        return $this->createQueryBuilder('r')
            //    ->andWhere('r.exampleField = :val')
            //    ->setParameter('val', $value)
            ->orderBy('r.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
    }

    //   /**
//     * @return Realisation[] Returns an array of Categorie objects
//     */
   public function findAllPortfolio(Categorie $categorie): array
   {
       return $this->createQueryBuilder('p')
           ->Where(':categorie MEMBER OF p.categorie')
           ->andWhere('p.portfolio = TRUE')
           ->setParameter('categorie', $categorie)
           ->getQuery()
           ->getResult()
       ;
   }
}
