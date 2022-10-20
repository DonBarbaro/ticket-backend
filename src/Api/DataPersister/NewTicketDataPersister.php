<?php

namespace App\Api\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Status;
use App\Entity\Ticket;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;

class NewTicketDataPersister implements ContextAwareDataPersisterInterface
{
    public function __construct(
        private ManagerRegistry $registry,
        private ContextAwareDataPersisterInterface $decorated
    )
    {}

    public function supports($data, array $context = []): bool
    {
        return $this->decorated->supports($data, $context);
    }

    /**
     * @param Ticket $data
     */
    public function persist($data, array $context = [])
    {
        $em = $this->registry->getManager();
        $result = $this->decorated->persist($data, $context);

        if ($data instanceof Ticket && (($context['collection_operation_name'] ?? null) === 'post'))
        {
            $statuses = $data->getProject()->getStatuses()->toArray();
            $firstStatus = array_filter($statuses,
                function (Status $status){
                    return $status->getOrderIndex() === 0;
                })[0];
//            $source = $data->getSource()
            $data->setStatus($firstStatus);
            $em->persist($data);
            $em->flush();
        }

        return $result;
    }

    public function remove($data, array $context = [])
    {

    }
}