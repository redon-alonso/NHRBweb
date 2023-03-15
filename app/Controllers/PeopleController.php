<?php

namespace App\Controllers;

use App\Core\DataBase;
use App\Core\Render;
use App\Models\Collaborators;
use App\Models\Formers;
use App\Models\Projects;
use App\Models\Repositories\UsersRepository;
use App\Models\Users;
use Doctrine\ORM\EntityManager;

class PeopleController
{
  private Render $render;
  private EntityManager $em;
  private UsersRepository $userRepo;

  function __construct()
  {
    $this->render = new Render;
    $this->em = (new DataBase)->getEntityManager();
    $this->userRepo = $this->em->getRepository(Users::class);
  }

  function index()
  {
    /* Para completar el nav necesito los proyects */
    /* Quizá sería mejor ponerlos manualmente */
    $projectRepo = $this->em->getRepository(Projects::class);
    $currentProjects = $projectRepo->findBy(["active" => 1, "currentproject" => 1]);

    /* users */
    $users = $this->userRepo->findBy(["active" => 1]);

    /* formers */
    $formers = $this->em->getRepository(Formers::class)->findBy(["active" => 1], ["group" => "ASC"]);

    /* collaborators */
    $collaborators = $this->em->getRepository(Collaborators::class)->findBy(["active" => 1]);

    echo $this->render->view->render(
      "/pages/people/index.html",
      [
        "title" => "People",
        "currentProjects" => $currentProjects,
        "users" => $users,
        "formers" => $formers,
        "collaborators" => $collaborators,
      ]
    );
    return;
  }

  function show($param)
  {
    /* Para completar el nav necesito los proyects */
    /* Quizá sería mejor ponerlos manualmente */
    $projectRepo = $this->em->getRepository(Projects::class);
    $currentProjects = $projectRepo->findBy(["active" => 1, "currentproject" => 1]);

    $user = $this->userRepo->find($param["id"]);
    if ($user === NULL || !$user->get_active()) {
      header("Location: /people/index");
      return;
    }

    echo $this->render->view->render(
      "/pages/people/details.html",
      [
        "title" => "Details",
        "currentProjects" => $currentProjects,
        "user" => $user,
      ]
    );
  }
}
