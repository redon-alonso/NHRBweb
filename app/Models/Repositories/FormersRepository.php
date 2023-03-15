<?php

namespace App\Models\Repositories;

use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityRepository;

use App\Models\Formers;
use Doctrine\ORM\Tools\Pagination\Paginator;

class FormersRepository extends EntityRepository
{
  public function customPresist(Formers $model)
  {
    try {
      $this->getEntityManager()->persist($model);
      $this->getEntityManager()->flush();
    } catch (Exception $e) {
      // echo "<pre>";
      // echo "Error: $e";
      $model = null;
    }

    return $model;
  }

  private function paginate($dql, $page = 1, $limit = 3)
  {
    $paginator = new Paginator($dql);

    $paginator->getQuery()
      ->setFirstResult($limit * ($page - 1)) // Offset
      ->setMaxResults($limit); // Limit

    return $paginator;
  }

  public function getAllObjects($currentPage = 1, $limit = 3)
  {
    // Create our query
    $query = $this->createQueryBuilder('p')
      ->getQuery();

    /* 
    $qb = $this->createQueryBuilder('p');
    $qb = $qb->orderBy('p.idproject', 'DESC');
    $query = $qb->getQuery();
    */

    $paginator = $this->paginate($query, $currentPage, $limit);

    return array('paginator' => $paginator, 'query' => $query);
  }
}
