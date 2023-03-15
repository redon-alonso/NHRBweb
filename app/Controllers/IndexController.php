<?php

namespace App\Controllers;

use App\Core\DataBase;
use App\Core\Render;
use App\Models\Projects;
use Doctrine\ORM\EntityManager;

class IndexController
{
  private Render $render;
  private EntityManager $em;

  function __construct()
  {
    $this->render = new Render;
    $this->em = (new DataBase)->getEntityManager();
  }

  function index()
  {
    /* Para completar el nav necesito los proyects */
    /* Quizá sería mejor ponerlos manualmente */
    $folder_path = "resources/uploads/project/carousel/"; //image's folder path

    $num_files = glob($folder_path . "*.png", GLOB_BRACE);

    $folder = opendir('resources/uploads/project/carousel/');

    $imagenes [] = "";
    $index = 0;

    if ($num_files > 0) {
      while (false !== ($file = readdir($folder))) {
        $file_path = $folder_path . $file;
        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if ($extension == 'png') {
          $imagenes[$index] = $file_path;
          $index++;
        }
      }
    }

    closedir($folder);

    $projectRepo = $this->em->getRepository(Projects::class);
    $currentProjects = $projectRepo->findBy(["active" => 1, "currentproject" => 1]);

    echo $this->render->view->render(
      "/pages/home/index.html",
      [
        "title" => "Home",
        "currentProjects" => $currentProjects,
        "images" => $imagenes
      ]
    );
    return;
  }

  function contact()
  {
    $projectRepo = $this->em->getRepository(Projects::class);
    $currentProjects = $projectRepo->findBy(["active" => 1, "currentproject" => 1]);

    echo $this->render->view->render(
      "/pages/contact/index.html",
      [
        "title" => "Contact",
        "currentProjects" => $currentProjects
      ]
    );
    return;
  }

  function conferences()
  {
    $projectRepo = $this->em->getRepository(Projects::class);
    $currentProjects = $projectRepo->findBy(["active" => 1, "currentproject" => 1]);

    echo $this->render->view->render(
      "/pages/conferences/index.html",
      [
        "title" => "Conferences",
        "currentProjects" => $currentProjects
      ]
    );
    return;
  }
}
