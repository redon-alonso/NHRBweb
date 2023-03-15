<?php

namespace App\Models;

use Doctrine\Mapping as ORM;

/**
 * Collaborators
 *
 * @Entity(repositoryClass=App\Models\Repositories\CollaboratorsRepository::class)
 * @Table(name="collaborators")
 */
class Collaborators
{
  /**
   * @var int
   *
   * @Column(name="idCollaborator", type="integer", nullable=false)
   * @Id
   * @GeneratedValue(strategy="IDENTITY")
   */
  private $idcollaborator;

  /**
   * @var string
   *
   * @Column(name="name", type="string", length=255, nullable=false)
   */
  private $name;

  /**
   * @var string
   *
   * @Column(name="contact", type="string", length=255, nullable=false)
   */
  private $contact;

  /**
   * @var string
   *
   * @Column(name="company_link", type="string", length=255, nullable=false)
   */
  private $companyLink;

  /**
   * @var string
   *
   * @Column(name="logo_link", type="string", length=255, nullable=false)
   */
  private $logoLink;

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

  function get_idcollaborator()
  {
    return $this->idcollaborator;
  }

  function get_name()
  {
    return $this->name;
  }

  function get_contact()
  {
    return $this->contact;
  }

  function get_company_link()
  {
    return $this->companyLink;
  }

  function get_logo_link()
  {
    return $this->logoLink;
  }

  function get_active()
  {
    return $this->active;
  }
}
