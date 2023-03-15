<?php

namespace App\Core;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

use Twig\Extra\Markdown\DefaultMarkdown;
use Twig\Extra\Markdown\MarkdownRuntime;
use Twig\RuntimeLoader\RuntimeLoaderInterface;

class Render
{
  public $view;

  function __construct()
  {
    $loader = new FilesystemLoader('../app/Views');
    $this->view = new Environment(
      $loader,
      ['debug' => true]
    );

    $this->view->addRuntimeLoader(new class implements RuntimeLoaderInterface
    {
      public function load($class)
      {
        if (MarkdownRuntime::class === $class) {
          return new MarkdownRuntime(new DefaultMarkdown());
        }
      }
    });

    $this->view->addExtension(new \Twig\Extension\DebugExtension);
    $this->view->addExtension(new \Twig\Extra\Markdown\MarkdownExtension);

    if (isset($_SESSION)) $this->view->addGlobal('session', $_SESSION);
  }
}
