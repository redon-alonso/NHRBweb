<?php

namespace App\Models;

use Doctrine\Common\Util\Debug;
use Doctrine\Mapping as ORM;

/**
 * FormerMembers
 *
 * @Entity(repositoryClass=App\Models\Repositories\FormersRepository::class)
 * @Table(name="former_members")
 */
class Formers
{
  /**
   * @var int
   *
   * @Id
   * @Column(name="idFormerMember", type="integer", nullable=false)
   * @GeneratedValue(strategy="IDENTITY")
   */
  private $idformer;

  /**
   * @var string
   *
   * @Column(name="name", type="string", length=255, nullable=false)
   */
  private $name;

  /**
   * @var string
   *
   * @Column(name="education", type="string", length=255, nullable=false)
   */
  private $education;

  /**
   * @var int
   *
   * @Column(name="`group`", type="integer", nullable=false)
   */
  private $group = 0;

  /**
   * @var int
   *
   * @Column(name="year", type="integer", nullable=false)
   */
  private $year;

  /**
   * @var string|null
   *
   * @Column(name="link", type="string", length=255, nullable=true)
   */
  private $link;

  /**
   * @var bool
   *
   * @Column(name="active", type="boolean", nullable=false, options={"default"="1"})
   */
  private $active = true;

  public function __construct($data = null)
  {
    if ($data) {
      $this->active = ($data["active"] === "on") ? 1 : 0;

      unset($data["active"]);

      foreach ($data as $key => $value) {
        $this->$key = $value;
      }
      return;
    }
  }

  public function update($data)
  {
    $this->active = ($data["active"] === "on") ? 1 : 0;

    unset($data["active"]);

    foreach ($data as $key => $value) {
      $this->$key = $value;
    }
  }

  /* getters */

  function get_idformer()
  {
    return $this->idformer;
  }

  function get_name()
  {
    return $this->name;
  }

  function get_education()
  {
    return $this->education;
  }

  function get_group()
  {
    return $this->group;
  }

  function get_year()
  {
    return $this->year;
  }

  function get_link()
  {
    return $this->link;
  }

  function get_active()
  {
    return $this->active;
  }
}
