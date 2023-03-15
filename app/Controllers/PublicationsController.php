<?php

namespace App\Controllers;

use App\Core\DataBase;
use App\Core\Render;
use App\Models\Projects;
use App\Models\Publications;
use App\Models\Repositories\PublicationsRepository;
use App\Models\Tags;
use App\Models\Users;
use Doctrine\ORM\EntityManager;
use Exception;

class PublicationsController
{
  private Render $render;
  private EntityManager $em;
  private PublicationsRepository $publiRepo;

  function __construct()
  {
    $this->render = new Render;
    $this->em = (new DataBase)->getEntityManager();
    $this->publiRepo = $this->em->getRepository(Publications::class);
  }

  function index($param) // ha crecido excesivamente. Debería refactorizar
  {
    /* necesita projects para el menú */
    $projectsRepo = $this->em->getRepository(Projects::class);
    $currentProjects = $projectsRepo->findBy(["active" => 1, "currentproject" => 1]);

    /* necesita tags para desplegable */
    $tagsRepo = $this->em->getRepository(Tags::class);
    $tags = $tagsRepo->findBy(["active" => 1]);

    /* necesita users para desplegable */
    $usersRepo = $this->em->getRepository(Users::class);
    $users = $usersRepo->findBy(["active" => 1]);

    /* necesita years para desplegable */
    $years = [];
    $query = $this->publiRepo->createQueryBuilder('p')->select('p.year')->groupBy('p.year')->getQuery();
    foreach ($query->execute() as $year) {
      array_push($years, $year["year"]);
    }

    /* necesita types para desplegable */
    $types = [];
    $query = $this->publiRepo->createQueryBuilder('p')->select('p.type')->groupBy('p.type')->getQuery();
    foreach ($query->execute() as $type) {
      array_push($types, $type["type"]);
    }

    /* Para el paginador determina página actual y límite */
    $currentPage = (isset($param["page"])) ? $param["page"] : 1;
    $limit = 15;

    /* Usa función auxiliar (private) para obtener publications */
    $publications = $this->getPublications($param, $currentPage, $limit);

    if (is_array($publications)) {
      /* Reordena las publicaciones */
      /* quizá innecesario, solo poner abajo */
      $publicationsResultado = $publications['paginator'];
      $publicationsQueryCompleta =  $publications['query'];

      /* Determina el total de páginas */
      $maxPages = ceil($publications['paginator']->count() / $limit);
    }

    echo $this->render->view->render(
      "/pages/publications/index.html",
      [
        "title" => "Publications",
        "currentProjects" => $currentProjects,
        "years" => $years,
        "types" => $types,
        "tags" => $tags,
        "users" => $users,
        "publications" => isset($publicationsResultado) ? $publicationsResultado : null,
        "maxPages" => isset($maxPages) ? $maxPages : null,
        "thisPage" => $currentPage,
        "all_items" => isset($publicationsQueryCompleta) ? $publicationsQueryCompleta : null,
        "where" => $this->getWhereFromUrl($param)
      ]
    );
    return;
  }

  /* No es necesario... solo los links y eso... */
  function show($param)
  {
    header("Location: /publications/index");
    return;
  }

  private function getWhereFromUrl($param)
  {
    if (!isset($param["GET"]) || count($param["GET"]) !== 1) {
      return null;
    }

    $key = array_key_last($param["GET"]);
    $value = $param["GET"][$key];

    return "$key=$value";
  }

  private function getPublications($param, $currentPage, $limit)
  {
    /* Si llega algo por _GET lo usa como clausula where */
    /* si el where se refiere a una relación la resuelve */
    $where = $this->getWhereFromUrl($param);
    if ($where && (str_contains($where, 'idtag') || str_contains($where, 'iduser'))) {
      $relation["key"] = explode("=", $where)[0];
      $relation["value"] = explode("=", $where)[1];
    }

    /* Si existe relación usa getWithRelation innerjoin */
    if (isset($relation)) $publications = $this->publiRepo->getWithRelation($currentPage, $limit, $relation);
    else $publications = $this->publiRepo->getAllObjects($currentPage, $limit, $where);

    /* Comprueba errores */
    /* Si no hay resultados no redirigir */
    /* mejor mostrar tarjeta no resultados */
    try {
      $paginatorCount = $publications['paginator']->count();
    } catch (Exception $e) {
      header("Location: /publications/index");
      return;
    }

    if ($paginatorCount === 0) {
      // header("Location: /publications/index");
      return;
    }
    /* Fin Comprueba errores */

    return $publications;
  }
}
