<?php

namespace Night\DisplayBundle\Dao;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Allopneus\ApiBundle\Exception\InvalidArgumentException;

abstract class BaseDao
{
    /** @var ObjectManager */
    protected $om;

    /**
     * Constructor
     *
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * @return string the fully qualified class name managed by the dao
     */
    abstract public function getEntityClass();

    /**
     * @return object|null
     */
    public function find($id)
    {
        return $this->getRepository()->find($id);
    }

    public function findPrevious($id)
    {
         $qb = $this->getRepository()->createQueryBuilder('e')
             ->where('e.id < :id')
                ->setParameter('id', $id)
             ->orderBy('e.id', 'DESC')
             ->setMaxResults(1)
             ;

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function findNext($id)
    {
        $qb = $this->getRepository()->createQueryBuilder('e')
            ->where('e.id > :id')
            ->setParameter('id', $id)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(1)
        ;

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * {@inheritDoc}
     */
    public function persist($entity)
    {
        $em = $this->getEntityManager();

        if ($em->contains($entity)) {
            throw new InvalidArgumentException('This entity is already managed.');
        }

        $em->persist($entity);
        $em->flush($entity);
    }

    /**
     * {@inheritDoc}
     */
    public function update($entity)
    {
        $em = $this->getEntityManager();

        if (!$em->contains($entity)) {
            throw new InvalidArgumentException('This entity is not currently managed. You should persist it.');
        }

        $em->flush($entity);
    }

    /**
     * {@inheritDoc}
     */
    public function remove($entity)
    {
        $em = $this->getEntityManager();

        if (!$em->contains($entity)) {
            throw new InvalidArgumentException('This entity is not managed.');
        }

        $em->remove($entity);
        $em->flush($entity);
    }

    /**
     * Apply 'where' filters on a query.
     *
     * The $filterRules variable should be an associative array of 'filters'.
     *
     * Example:
     * $filterRules =  array(
     *     'width' => array('tire.width', '='),
     *     'height' => array('tire.height', '<'),
     *     'speed' => array('tire.speed', 'IN')
     * );
     *
     * The $parameters should be simple associative array containing the values
     * for the filters.
     *
     * Example:
     * $parameters =  array(
     *     'width' => '105',
     *     'height' => null,
     *     'speed' => array('speed', array('A','B','C'))
     * );
     *
     * The examples variables should call these methods of the QueryBuilder:
     * $qb
     *  ->addWhere('tire.width = 105')
     *  ->addWhere('tire.speed IN (A, B, C)')
     *
     *  // There is no 'addWhere'method called for the height parameter
     *  // because empty values are ignore by default
     *
     * @param QueryBuilder $qb Query to filter
     * @param array $filters Filters rules
     * @param array $parameters
     *
     * @throws \InvalidArgumentException
     */
    protected function addFiltersQuery(QueryBuilder $qb, $filters, $parameters)
    {
        // Check if the parameters are valid
        foreach ($parameters as $key => $value) {

            if (!array_key_exists($key, $filters)) {
                continue;
                // throw new InvalidArgumentException(sprintf('You must define a filter for the %s parameter', $key));
            }

            $filter = $filters[$key];
            if (!is_array($filter) || empty($filter)) {
                throw new InvalidArgumentException(sprintf('The filter %s must be an non empty array.', $key));
            }

            $field = $filter[0];
            $comparisonOperator = isset($filter[1]) ? $filter[1] : '=';
            $acceptEmptyValue = isset($filter[2]) ? $filter[2] : false;
            $this->addWhereQuery($qb, $field, $value, $comparisonOperator, $acceptEmptyValue);
        }
    }

    /**
     * Adds a where query to a QueryBuilder
     *
     * @param QueryBuilder $qb Query to filter
     * @param string $field Full qualified field name
     * @param string $value Value of the parameter
     * @param string $comparisonOperator Comparison operator
     * @param boolean $acceptEmptyValue If set to true, The where method will be called even if the value is empty
     *
     * @throws InvalidArgumentException
     */
    protected function addWhereQuery(QueryBuilder $qb, $field, $value, $comparisonOperator = '=', $acceptEmptyValue = false)
    {
        $expectedComparisonOperators = array('=', 'IN', 'NOT IN', '>', '<', '>=', '<=');

        if (!in_array($comparisonOperator, $expectedComparisonOperators)) {
            throw new InvalidArgumentException(sprintf('The comparison operator %s is invalid. The valid operators are %s', $comparisonOperator, implode(', ', $expectedComparisonOperators)));
        }

        if (!is_bool($acceptEmptyValue)) {
            throw new InvalidArgumentException(sprintf('The acceptEmptyValue is invalid. Only boolean are accepted.'));
        }

        if ($acceptEmptyValue || !empty($value)) {

            // The . char is forbidden for a placeholder
            $fieldPlaceholder = str_replace('.', '', $field);

            if (in_array($comparisonOperator, array('IN', 'NOT IN'))) {
                $wherePattern = '%s %s (:%s)';
                if (!is_array($value)) {
                    throw new InvalidArgumentException(sprintf('The value expected for the %s comparison operator is an array for the field %s.', $comparisonOperator, $field));
                }
            } else {
                $wherePattern = '%s %s :%s';
                if (is_array($value) || is_object($value)) {
                    throw new InvalidArgumentException(sprintf('The value expected for the %s comparison operator should not be an array or an object for the field %s.', $comparisonOperator, $field));
                }
            }

            $qb->andWhere(sprintf($wherePattern, $field, $comparisonOperator, $fieldPlaceholder));
            $qb->setParameter($fieldPlaceholder, $value);
        }
    }


    /**
     * Apply 'order by' clause to a query.
     *
     * To understand how this method works, here is an example:
     *
     * $sortRules =  array(
     *     'price' => array('tire.price'),
     *     'brand' => array('brand.name')
     * );
     *
     * $orderParams = array('price' => 'asc');
     *
     * // This will call:
     * $qb->orderBy('tire.price', 'asc');
     *
     * @param QueryBuilder $qb Query to filter
     * @param array $sortRules  Sort rules
     * @param array $orderParams
     *
     * @throws InvalidArgumentException
     */
    protected function addSortingQuery(QueryBuilder $qb, array $sortRules, array $orderParams)
    {
        // Check if the parameters are valid
        foreach ($orderParams as $orderKey => $sort) {

            if (!array_key_exists($orderKey, $sortRules)) {
                continue;
                // throw new InvalidArgumentException(sprintf('You must define a sorting rule for the %s parameter', $orderKey));
            }

            $orderField = $sortRules[$orderKey];
            if (!is_array($orderParams) || !is_string($orderField)) {
                throw new InvalidArgumentException(sprintf('The sort rule "%s" value must be an a string.', $orderKey));
            }
            $this->addOrderByQuery($qb, $orderField, $sort);
        }
    }

    /**
     * Add an orderBy query to a QueryBuilder
     *
     * @param QueryBuilder $qb
     * @param string       $orderField
     * @param string       $sortOperator
     */
    protected function addOrderByQuery(QueryBuilder $qb, $orderField, $sortOperator)
    {
        $sortOperatorsExpected = array('ASC', 'DESC');
        $sortOperator = strtoupper($sortOperator);
        if (!in_array($sortOperator, $sortOperatorsExpected)) {
            throw new InvalidArgumentException(sprintf('The sort operator %s is invalid. The valid operators are %s', $sortOperator, implode(', ', $sortOperatorsExpected)));
        }

        $qb->addOrderBy($orderField, $sortOperator);
    }

    /**
     * Get paginated results. Useful to get the desired amount of Entities
     * in case of a left join query.
     *
     * This method would add 1 additional sql request to a left join query type.
     * If the count method is called on the paginator instance then another additional sql request is done.
     *
     * @param QueryBuilder $qb
     * @param int          $limit Max number of products to return
     * @param int          $offset Offset of the first product to return
     * @return array Collection of items
     */
    protected function getPaginatedResult(QueryBuilder $qb, $limit, $offset)
    {
        $qb->setFirstResult($offset)
            ->setMaxResults($limit)
        ;

        $paginator = new Paginator($qb, true);

        // Use this method to return the total count of results (Without the limit clause)
        // $count = $paginator->count();

        // The serializer won't be able to serialize a Paginator object.
        // It is a Traversable object that will be then converted here to an array
        $items = array();
        foreach ($paginator as $item) {
            $items[] = $item;
        }
        return $items;
    }

    /**
     * Return the repository for the default class.
     *
     * @return EntityRepository
     */
    protected function getRepository()
    {
        return $this->om->getRepository($this->getEntityClass());
    }

    /**
     * @return \DOctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->om;
    }

    /**
     * @return \Doctrine\DBAL\Connection
     */
    protected function getConnection()
    {
        return $this->getEntityManager()->getConnection();
    }
}
