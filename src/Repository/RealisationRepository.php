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
    public function lastthree(): array
    {
        return $this->createQueryBuilder('r')
            //    ->andWhere('r.exampleField = :val')
            //    ->setParameter('val', $value)
            ->orderBy('r.id', 'DESC')
            // ->setMaxResults(1)
            ->getQuery()
            ->getResult()
            ;
    }

//    /**
//     * @return Realisation[] Returns an array of Categorie objects
//     */
   public function findAllPortfolio(Categorie $categorie): array /*on rassemble la collection*/
   {
       return $this->createQueryBuilder('p')
           ->where(':categorie MEMBER OF p.categorie') 
           /*est-ce que la variable :catégorie-de-ma-realisation-du-AllPortfolio
           fait bien partie des réalisations de CETTE catégorie ? */
           ->andWhere('p.portfolio = TRUE') /* oui elle en fait partie /non, elle n'en fait pas */
           ->setParameter('categorie', $categorie)
           ->getQuery()
           ->getResult() /* le "finAllPortfolio" capture les réalisations suivant sa catégorie */
       ;
   }
//    VOIR LA FONCTION IDENTIQUE MISE DANS BLOGPOSTREPOSITORY/INUTILE DONC DE LA METTRE ICI
//     public function findCommentaire($value): array
//    {
//         if ($value instanceof Blogpost){
//             $object = 'blogpost';
//         }
//         if ($value instanceof Realisation){
//             $object = 'realisation';
//         }

//        return $this->createQueryBuilder('c')
//            ->andWhere('c.'. $object .' = :val')
//            ->andWhere('c.isPublished = true')
//            ->setParameter('val', $value->getId())
//            ->orderBy('c.id', 'DESC')
//         //    ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }
}
