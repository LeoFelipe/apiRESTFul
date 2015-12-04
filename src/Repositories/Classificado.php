<?php
namespace Api\Repositories;

use Api\Helpers\URIHelper;
use Doctrine\ORM\EntityRepository;

class Classificado extends EntityRepository
{
    private $entity = 'Api\Entities\Classificado',
            $alias = 'c';

    public function getBy($fields, $orderBy, $where = null, $params = null)
    {
        if (empty($where))
            $where = '1 = 1';

        $query = $this->getEntityManager()->createQueryBuilder()
            ->select($fields)
            ->from($this->entity, $this->alias)
            ->where($where)
            ->add('orderBy', $orderBy)
            ->setFirstResult(URIHelper::$arrayParams['offset'])
            ->setMaxResults(URIHelper::$arrayParams['limit'])
            ->getQuery();

        if (!empty($params))
            $query->setParameters($params);

        return $query->getArrayResult();
    }
}