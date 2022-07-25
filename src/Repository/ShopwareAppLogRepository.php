<?php

namespace Virtua\ShopwareAppLoggerBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Virtua\ShopwareAppLoggerBundle\Entity\ShopwareAppLog;

/**
 * @extends ServiceEntityRepository<ShopwareAppLog>
 *
 * @method ShopwareAppLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShopwareAppLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShopwareAppLog[]    findAll()
 * @method ShopwareAppLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShopwareAppLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShopwareAppLog::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(ShopwareAppLog $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);

        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(ShopwareAppLog $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);

        if ($flush) {
            $this->_em->flush();
        }
    }
}
