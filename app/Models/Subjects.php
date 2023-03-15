<?php

namespace App\Models;

/**
 * Subjects
 *
 * @Entity(repositoryClass=App\Models\Repositories\SubjectsRepository::class)
 * @Table(name="subjects", indexes={@Index(name="FK_subjects_users", columns={"idUser"})})
 */
class Subjects
{
  /**
   * @var int
   *
   * @Id
   * @Column(name="idSubject", type="integer", nullable=false)
   * @GeneratedValue(strategy="IDENTITY")
   */
  private $idsubject;

  /**
   * @var string
   *
   * @Column(name="name", type="string", length=100, nullable=false)
   */
  private $name = '';

  /**
   * @var string|null
   *
   * @Column(name="center", type="string", length=50, nullable=true)
   */
  private $center;

  /**
   * @var string
   *
   * @Column(name="year", type="string", length=100, nullable=false)
   */
  private $year = '';

  /**
   * @var float
   *
   * @Column(name="credits", type="float", precision=10, scale=0, nullable=false)
   */
  private $credits = '0';

  /**
   * @var bool
   *
   * @Column(name="active", type="boolean", nullable=false, options={"default"="1"})
   */
  private $active = true;

  /**
   * @var \Users
   *
   * @ManyToOne(targetEntity="Users")
   * @JoinColumn(name="idUser", referencedColumnName="idUser")
   */
  private $iduser;

  public function __construct($data = null)
  {
    if ($data) {
      $this->active = ($data["active"] === "on") ? 1 : 0;

      /* TODO: implementar users */
      unset($data["active"]);

      foreach ($data as $key => $value) {
        $this->$key = $value;
      }
    }
  }

  public function update($data)
  {
    $this->active = ($data["active"] === "on") ? 1 : 0;

    /* TODO: implementar users */
    unset($data["active"]);

    foreach ($data as $key => $value) {
      $this->$key = $value;
    }
  }

  /* getters */

  function get_idsubject()
  {
    return $this->idsubject;
  }

  function get_name()
  {
    return $this->name;
  }

  function get_center()
  {
    return $this->center;
  }

  function get_year()
  {
    return $this->year;
  }

  function get_credits()
  {
    return $this->credits;
  }

  function get_active()
  {
    return $this->active;
  }

  function get_iduser()
  {
    return $this->iduser;
  }
}
