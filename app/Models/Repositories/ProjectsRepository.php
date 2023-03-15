<?php

namespace App\Models\Repositories;

use App\Models\Projects;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class ProjectsRepository extends EntityRepository
{
  public function customPresist(Projects $project)
  {
    try {
      $this->getEntityManager()->persist($project);
      $this->getEntityManager()->flush();
    } catch (Exception $e) {
      // echo "Error: $e";
      $project = null;
    }

    return $project;
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
