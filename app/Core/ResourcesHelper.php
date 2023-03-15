<?php

namespace App\Core;

class ResourcesHelper
{
  static function getFilesFromResources($directory)
  {
    $knownDirs = ["users", "projects", "publications", "collaborators"];

    if (!in_array($directory, $knownDirs)) {
      echo "Error: directorio no conocido";
      return null;
    }

    $response = [];
    foreach (scandir(__DIR__ . "/../../public/resources/$directory") as $objectInDir) {
      if (is_dir($objectInDir)) continue;
      if ($objectInDir === ".gitkeep") continue;
      array_push($response, $objectInDir);
    }

    return $response;
  }
}
