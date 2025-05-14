<?php

declare(strict_types=1);

namespace App\Repository;

use App\Filter\Filter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * @template TEntity of object
 * @template TCollection of ArrayCollection
 * @template-extends EntityRepository<TEntity>
 */
abstract class AbstractRepository extends EntityRepository
{
    public const int DEFAULT_LIMIT = 24;

    protected string $alias = '';
    /** @var class-string<TEntity> $className */
    protected string $className;
    /** @var class-string<TCollection<array-key, TEntity>> $collectionType */
    protected string $collectionType;
    protected EntityManagerInterface $em;

    public function __construct(
        EntityManagerInterface $em
    ) {
        $this->em = $em;

        parent::__construct(
            $em,
            new ClassMetadata($this->className)
        );
    }

    /**
     * @param TCollection<int,TEntity> $collection
     * @return TCollection<int, TEntity>
     */
    public function add(iterable $collection): iterable
    {
        foreach ($collection as $entity) {
            $this->em->persist($entity);
        }

        $this->em->flush();

        return $collection;
    }

    /**
     * @param TEntity $entity
     * @return TEntity
     */
    public function addOne(object $entity): object
    {
        $this->em->persist($entity);

        $this->em->flush();

        return $entity;
    }

    /**
     * @param Filter|null $filter
     * @return TCollection<array-key, TEntity>
     */
    public function get(?Filter $filter = null): ArrayCollection
    {
        $query = $this
            ->createQueryBuilder($this->alias);

        if ($filter?->column !== null) {
            $query->orderBy($this->alias . '.' . $filter->column, 'ASC');
        }

        if ($filter !== null) {
            $query
                ->setMaxResults($filter->getLimit())
                ->setFirstResult($filter->getOffset());
        } else {
            $query->setMaxResults(self::DEFAULT_LIMIT);
        }

        $records = $query
            ->getQuery()
            ->getResult();

        return new $this->collectionType($records);
    }

    /**
     * @param non-negative-int $id
     * @return TEntity|null
     */
    public function findOneById(int $id): object
    {
        return $this->findOneBy(['id' => $id]);
    }

    /**
     * @param TEntity $entity
     * @return TEntity
     */
    public function editOne(object $entity): object
    {
        $this->em->persist($entity);

        $this->em->flush();

        return $entity;
    }
}

