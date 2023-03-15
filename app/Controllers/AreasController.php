<?php

namespace App\Controllers;

use App\Core\DataBase;
use App\Core\Render;
use App\Models\Projects;
use App\Models\Repositories\ProjectsRepository;

class AreasController
{
  private Render $render;
  private ProjectsRepository $projectsRepo;

  function __construct()
  {
    $this->render = new Render;
    $this->projectsRepo = (new DataBase)->getEntityManager()->getRepository(Projects::class);
  }

  function index()
  {
    $currentProjects = $this->projectsRepo->findBy(["active" => 1, "currentproject" => 1]);

    echo $this->render->view->render(
      "/pages/areas/index.html",
      [
        "title" => "Areas",
        "currentProjects" => $currentProjects
      ]
    );
    return;
  }

  function show($param) // recime param["name"]
  {
    // Si es uno de los que conozco... ["balance", "unilateral", "self", "upper", "disorders","techno"]
    $knownAreas = ["balance", "unilateral", "self", "upper", "disorders", "techno"];

    if (!in_array($param["name"], $knownAreas)) {
      header("Location: /areas/index");
      return;
    }

    $currentProjects = $this->projectsRepo->findBy(["active" => 1, "currentproject" => 1]);

    echo $this->render->view->render(
      "/pages/areas/details/$param[name].html",
      [
        "title" => $param["name"],
        "knownAreas" => $knownAreas,
        "currentProjects" => $currentProjects,
      ]
    );
    return;
  }
}
