<?php

namespace App\Models\Repositories;

use App\Models\Publications;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class PublicationsRepository extends EntityRepository
{
  public function customPersist(Publications $publication)
  {
    try {
      $this->getEntityManager()->persist($publication);
      $this->getEntityManager()->flush();
    } catch (Exception $e) {
      $publication = null;
    }

    return $publication;
  }

  private function paginate($dql, $page = 1, $limit = 10)
  {
    $paginator = new Paginator($dql);

    $paginator->getQuery()
      ->setFirstResult($limit * ($page - 1)) // Offset
      ->setMaxResults($limit); // Limit

    return $paginator;
  }

  public function getAllObjects(int $currentPage = 1, int $limit = 10, string $where = null): array
  {
    /* Crea la query siempre comprueba active */
    $qb = $this->createQueryBuilder('p')->andWhere('p.active=1');
    if (isset($where)) $qb->andWhere("p.$where");
    $query = $qb->getQuery();

    /* 
    $qb = $this->createQueryBuilder('p');
    $qb = $qb->orderBy('p.idproject', 'DESC');
    $query = $qb->getQuery();
    */

    $paginator = $this->paginate($query, $currentPage, $limit);

    return array('paginator' => $paginator, 'query' => $query);
  }

  public function getWithRelation(int $currentPage = 1, int $limit = 10, array $relation = null): array
  {
    /* Crea la query siempre comprueba active */
    $qb = $this->createQueryBuilder('p')->andWhere('p.active=1');
    if (isset($relation)) {
      /* Hacer inner join de la relación y siempre que esté active */
      $qb->join("p.$relation[key]", 't')->andWhere("t.$relation[key]=$relation[value]")->andWhere('t.active=1');
    }

    /* Obtiene resultado */
    $query = $qb->getQuery();

    /* Envia a paginador */
    $paginator = $this->paginate($query, $currentPage, $limit);

    return array('paginator' => $paginator, 'query' => $query);
  }
}
