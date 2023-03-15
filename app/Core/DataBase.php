<?php

namespace App\Core;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class DataBase
{
  public $paths = array("app/Models/");
  public $devMode = true;

  public $entityManager;

  public function __construct()
  {
    if ($url = getenv('DATABASE_URL')) $this->prepareConnectionEnv($url);
    else $this->prepareConnectionFile();
  }

  private function prepareConnectionEnv($url)
  {
    $dbopts = parse_url($url);
    $dbParams = array(
      'charset'  =>  'utf8',
      'driver'   => "pdo_" . $dbopts["scheme"],
      'user'     => $dbopts["user"],
      'password' => $dbopts["pass"],
      'host'     => $dbopts["host"],
      'port'     => $dbopts["port"],
      'dbname'   => ltrim($dbopts["path"], '/')
    );

    $config = Setup::createAnnotationMetadataConfiguration($this->paths, $this->devMode);
    $this->entityManager = EntityManager::create($dbParams, $config, null, null, false);
  }

  private function prepareConnectionFile()
  {
    $dbConfig = json_decode(file_get_contents(__DIR__ . "/../../config/db-config.json"), true);

    $dbParams = array(
      'charset'  =>  'utf8',
      'host' =>       $dbConfig["server"],
      'driver' =>     $dbConfig["driver"],
      'user' =>       $dbConfig["user"],
      'password' =>   $dbConfig["password"],
      'dbname' =>     $dbConfig["dbname"]
    );

    $config = Setup::createAnnotationMetadataConfiguration($this->paths, $this->devMode);
    $this->entityManager = EntityManager::create($dbParams, $config, null, null, false);
  }

  public function getEntityManager()
  {
    return $this->entityManager;
  }
}
