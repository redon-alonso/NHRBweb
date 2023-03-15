<?php

namespace App\Models\Repositories;

use App\Models\Users;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class UsersRepository extends EntityRepository
{
  public function customPersist(Users $user)
  {
    try {
      $this->getEntityManager()->persist($user);
      $this->getEntityManager()->flush();
    } catch (Exception $e) {
      $user = null;
    }

    return $user;
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
