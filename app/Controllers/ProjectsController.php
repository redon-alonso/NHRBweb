<?php

namespace App\Controllers;

use App\Core\DataBase;
use App\Core\Render;
use App\Models\Projects;
use App\Models\Repositories\ProjectsRepository;
use Doctrine\Common\Util\Debug;
use Doctrine\ORM\EntityManager;

class ProjectsController
{
  private Render $redner;
  private EntityManager $em;
  private ProjectsRepository $projectsRepo;

  function __construct()
  {
    $this->redner = new Render;
    $this->em = (new DataBase)->getEntityManager();
    $this->projectsRepo = $this->em->getRepository(Projects::class);
  }

  function index()
  {
    $currentProjects = $this->projectsRepo->findBy(["active" => 1, "currentproject" => 1]);

    $projects = $this->projectsRepo->findBy(["active" => 1]);

    echo $this->redner->view->render(
      "/pages/projects/index.html",
      [
        "title" => "Projects",
        "currentProjects" => $currentProjects,
        "projects" => $projects,
      ]
    );
  }

  function show($param)
  {
    $currentProjects = $this->projectsRepo->findBy(["active" => 1, "currentproject" => 1]);

    $project = $this->projectsRepo->find($param["id"]);
    if ($project === NULL || !$project->get_active()) {
      header("Location: /projects/index");
      return;
    }

    echo $this->redner->view->render(
      "/pages/projects/details.html",
      [
        "title" => "Details",
        "currentProjects" => $currentProjects,
        "project" => $project,
      ]
    );
  }
}
