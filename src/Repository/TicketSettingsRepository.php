<?php

namespace App\Repository;

use App\Entity\Status;
use App\Entity\Ticket;
use App\Entity\TicketSettings;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\Query\Expr\Join;
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
        $qb = $this->createQueryBuilder('ts')
            ->leftJoin('ts.owner', 'o')
            ->andWhere('o IN (:user)')
            ->setParameter(':user', array_map(function (User $user) {
                return $user->getId();
            }, $users), Connection::PARAM_STR_ARRAY);

        if ($ticket) {
            $qb->andWhere('ts.ticket = :ticket')
                ->setParameter('ticket', $ticket);
        }

        if ($status) {
            $qb->andWhere('ts.status = :status')
                ->setParameter('status', $status);
        }

        return $qb->getQuery()->getResult();

    }

//    public function findNoSettings(array $users, ?Ticket $ticket, ?Status $status): ?TicketSettings
//    {
//        return $this->createQueryBuilder('ts')
//            ->andWhere('ts.status || ts.ticket = :')
//            ->setParameter('val', $ticket)
//            ->getQuery()->getResult();
//        ;
//    }
}
