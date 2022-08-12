<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Order;
use App\Enum\OrderStatus;
use Doctrine\ORM\EntityRepository;

class OrderRepository extends EntityRepository
{
    /** @return Order[] */
    public function findAllActive(): iterable
    {
        return $this->createQueryBuilder('o')
            ->where('o.status <> :finalized')
            ->orderBy('o.createdAt', 'desc')
            ->setParameter('finalized', OrderStatus::FINALIZED)
            ->getQuery()
            ->getResult()
        ;
    }
}