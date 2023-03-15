<?php

use App\Core\DataBase;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once __DIR__ . '/../app/Core/DataBase.php';

$entityManager = (new DataBase)->getEntityManager();

return ConsoleRunner::createHelperSet($entityManager);
