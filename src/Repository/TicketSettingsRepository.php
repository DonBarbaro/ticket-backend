<?php

namespace App\Repository;

use App\Entity\Status;
use App\Entity\Ticket;
use App\Entity\TicketSettings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TicketSettings>
 *
 * @method TicketSettings|null find($id, $lockMode = null, $lockVersion = null)
 * @method TicketSettings|null findOneBy(array $criteria, array $orderBy = null)
 * @method TicketSettings[]    findAll()
 * @method TicketSettings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketSettingsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TicketSettings::class);
    }

    public function add(TicketSettings $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TicketSettings $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return TicketSettings[] Returns an array of TicketSettings objects
     */
    public function findByTicket(array $users, ?Ticket $ticket, ?Status $status): array
    {
        $qb = $this->createQueryBuilder('t')
            ->andWhere('t.owner IN (:users)')
            ->setParameter('users', $users);
//            ->andWhere('t.ticket = :ticket')
//            ->setParameter('ticket', $ticket)
//            ->andWhere('t.status = :status')
//            ->setParameter('status', $status);
        if ($status == null)
        {
            $qb->andWhere('t.ticket = :ticket')
                ->setParameter('ticket', $ticket);
        }

        if ($ticket == null)
        {
            $qb->andWhere('t.status = :status')
            ->setParameter('status', $status);
        }

        return $qb->getQuery()->getResult();
    }

//    public function findOneBySomeField($value): ?TicketSettings
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
