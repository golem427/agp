<?php

namespace App\Repository;

use App\Entity\Blogpost;
use App\Entity\Commentaire;
use App\Entity\Realisation;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Commentaire>
 *
 * @method Commentaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commentaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commentaire[]    findAll()
 * @method Commentaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commentaire::class);
    }

    public function save(Commentaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Commentaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


        public function findCommentaires($value)
        {

            if ($value instanceof Blogpost) {
                $object = 'blogpost';
            }

            if ($value instanceof Realisation) {
                 $object = 'realisation';
            }           
                return $this->createQueryBuilder('c')
                ->where('c.' . $object . '= :val')
                ->andWhere('c.isPublished = true')
                ->setParameter('val', $value->getId())
                ->orderBy('c.id', 'DESC')
                ->getQuery()
                ->getResult();
        }
}
