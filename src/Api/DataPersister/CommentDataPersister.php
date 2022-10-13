<?php

namespace App\Api\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Comment;
use Symfony\Component\Security\Core\Security;

class CommentDataPersister implements ContextAwareDataPersisterInterface
{

    public function __construct(private ContextAwareDataPersisterInterface $dataPersister, private Security $security)
    {
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Comment;
    }

    /**
     * @param Comment $data
     * @param array $context
     * @return object|void
     */
    public function persist($data, array $context = [])
    {
        $user = $this->security->getUser();
        $data->setAuthor($user);
        $this->dataPersister->persist($data);


    }

    public function remove($data, array $context = [])
    {
        // TODO: Implement remove() method.
    }
}