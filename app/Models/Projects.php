<?php

namespace App\Models;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Projects
 *
 * @Entity(repositoryClass=App\Models\Repositories\ProjectsRepository::class)
 * @Table(name="projects", uniqueConstraints={@UniqueConstraint(name="title", columns={"title"})})
 */
class Projects
{
  /**
   * @var int
   *
   * @Id
   * @Column(name="idProject", type="integer", nullable=false)
   * @GeneratedValue(strategy="IDENTITY")
   */
  private $idproject;

  /**
   * @var string
   *
   * @Column(name="title", type="string", length=255, nullable=false)
   */
  private $title = '';

  /**
   * @var string
   *
   * @Column(name="acronym", type="string", length=50, nullable=false)
   */
  private $acronym = '';

  /**
   * @var string
   *
   * @Column(name="agency", type="string", length=255, nullable=false)
   */
  private $agency = '';

  /**
   * @var string
   *
   * @Column(name="years", type="string", length=100, nullable=false)
   */
  private $years = '';

  /**
   * @var string|null
   *
   * @Column(name="grant_number", type="string", length=100, nullable=true)
   */
  private $grantNumber = '';

  /**
   * @var string|null
   *
   * @Column(name="total_funding_amount", type="string", length=100, nullable=true)
   */
  private $totalFundingAmount = '';

  /**
   * @var string|null
   *
   * @Column(name="partners", type="string", length=400, nullable=true)
   */
  private $partners = '';

  /**
   * @var string
   *
   * @Column(name="description", type="text", length=65535, nullable=false)
   */
  private $description;

  /**
   * @var string|null
   *
   * @Column(name="logo", type="string", length=255, nullable=true)
   */
  private $logo;

  /**
   * @var bool
   *
   * @Column(name="active", type="boolean", nullable=false, options={"default"="1"})
   */
  private $active = true;

  /**
   * @var bool
   *
   * @Column(name="currentProject", type="boolean", nullable=false)
   */
  private $currentproject = '0';

  /* Relations */

  /**
   * @var \Doctrine\Common\Collections\Collection
   *
   * @ManyToMany(targetEntity="Tags", inversedBy="idprojects")
   * @JoinTable(name="rel_projects_tag",
   *   joinColumns={
   *     @JoinColumn(name="idProjects", referencedColumnName="idProject")
   *   },
   *   inverseJoinColumns={
   *     @JoinColumn(name="idTag", referencedColumnName="idTag")
   *   }
   * )
   */
  private $idtag;

  /**
   * Constructor
   */
  public function __construct($data = null)
  {
    $this->idtag = new ArrayCollection();

    if ($data) {
      /* check active */
      $this->active = ($data["active"] === "on") ? 1 : 0;
      unset($data["active"]);
      /* check current */
      $this->currentproject = ($data["currentproject"] === "on") ? 1 : 0;
      unset($data["currentproject"]);

      /* check logo */
      unset($data["logo_link"]);

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
    /* check current */
    $this->currentproject = ($data["currentproject"] === "on") ? 1 : 0;
    unset($data["currentproject"]);

    /* TODO: check logo */
    unset($data["logo_link"]);

    foreach ($data as $key => $value) {
      $this->$key = $value;
    }
  }

  public function __set($name, $value)
  {
    if ($name === "idproject") return null;
    $this->$name = $value;
  }

  /* getters */

  function get_idproject()
  {
    return $this->idproject;
  }

  function get_title()
  {
    return $this->title;
  }

  function get_acronym()
  {
    return $this->acronym;
  }

  function get_agency()
  {
    return $this->agency;
  }

  function get_years()
  {
    return $this->years;
  }

  function get_grant_number()
  {
    return $this->grantNumber;
  }

  function get_total_funding_amount()
  {
    return $this->totalFundingAmount;
  }

  function get_partners()
  {
    return $this->partners;
  }

  function get_description()
  {
    return $this->description;
  }

  function get_logo()
  {
    return $this->logo;
  }

  function get_active()
  {
    return $this->active;
  }

  function get_current_project()
  {
    return $this->currentproject;
  }

  function get_idtag()
  {
    return $this->idtag;
  }
}
