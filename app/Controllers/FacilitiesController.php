<?php

namespace App\Controllers;

use App\Core\DataBase;
use App\Core\Render;
use App\Models\Projects;
use Doctrine\ORM\EntityManager;

class FacilitiesController
{
  private Render $render;
  private EntityManager $em;

  function __construct()
  {
    $this->render = new Render();
    $this->em = (new DataBase())->getEntityManager();
  }

  function index()
  {
    /* Para completar el nav necesito los projects */
    /* Quizá sería mejor ponerlos manualmente */
    $projectRepo = $this->em->getRepository(Projects::class);
    $currentProjects = $projectRepo->findBy([
      "active" => 1,
      "currentproject" => 1,
    ]);

    /* Para completar el nav necesito los proyects */
    /* Quizá sería mejor ponerlos manualmente */
    $folder_path = "../resources/uploads/project/carousel/"; //image's folder path

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

    echo $this->render->view->render("/pages/facilities/index.html", [
      "title" => "Facilities",
      "currentProjects" => $currentProjects,
      "images" => $imagenes
    ]);
  }
}
