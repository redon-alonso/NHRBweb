<?php

namespace App\Models;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Tags
 *
 * @Entity(repositoryClass=App\Models\Repositories\TagsRepository::class)
 * @Table(name="tags", uniqueConstraints={@UniqueConstraint(name="name", columns={"name"})}, indexes={@Index(name="FK_tags_projects", columns={"idProject"})})
 */
class Tags
{
  /**
   * @var int
   *
   * @Id
   * @Column(name="idTag", type="integer", nullable=false)
   * @GeneratedValue(strategy="IDENTITY")
   */
  private $idtag;

  /**
   * @var string|null
   *
   * @Column(name="name", type="string", length=100, nullable=true)
   */
  private $name = '';

  /**
   * @var string|null
   *
   * @Column(name="area_link", type="string", length=255, nullable=true)
   */
  private $areaLink = '';

  /**
   * @var string|null
   *
   * @Column(name="color", type="string", length=255, nullable=true)
   */
  private $color;

  /**
   * @var bool
   *
   * @Column(name="active", type="boolean", nullable=false, options={"default"="1"})
   */
  private $active = true;

  /* Relations */

  /**
   * @var \Doctrine\Common\Collections\Collection
   *
   * @ManyToMany(targetEntity="Publications", mappedBy="idtag")
   */
  private $idarticle;

  /**
   * @var \Doctrine\Common\Collections\Collection
   *
   * @ManyToMany(targetEntity="Projects", mappedBy="idtag")
   */
  private $idprojects;

  /**
   * @var \Doctrine\Common\Collections\Collection
   *
   * @ManyToMany(targetEntity="Users", mappedBy="idtag")
   */
  private $idusers;

  public function __construct($data = null)
  {
    $this->idarticle = new  ArrayCollection();
    $this->idprojects = new ArrayCollection();
    $this->idusers = new ArrayCollection();

    if ($data) {
      /* check active */
      $this->active = ($data["active"] === "on") ? 1 : 0;

      unset($data["active"]);

      foreach ($data as $key => $value) {
        $this->$key = $value;
      }
    }
  }

  public function update($data)
  {
    /* check active */
    $this->active = ($data["active"] === "on") ? 1 : 0;

    unset($data["active"]);

    foreach ($data as $key => $value) {
      $this->$key = $value;
    }
  }

  /* getters */

  function get_idtag()
  {
    return $this->idtag;
  }

  function get_name()
  {
    return $this->name;
  }

  function get_area_link()
  {
    return $this->areaLink;
  }

  function get_color()
  {
    return $this->color;
  }

  function get_active()
  {
    return $this->active;
  }
}
