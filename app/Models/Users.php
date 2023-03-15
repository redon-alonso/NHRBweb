<?php

namespace App\Models;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Users
 *
 * @Entity(repositoryClass=App\Models\Repositories\UsersRepository::class)
 * @Table(name="users", uniqueConstraints={@UniqueConstraint(name="name", columns={"name"})})
 */
class Users
{
  /**
   * @var int
   *
   * @Id
   * @Column(name="idUser", type="integer", nullable=false)
   * @GeneratedValue(strategy="IDENTITY")
   */
  private $iduser;

  /**
   * @var string
   *
   * @Column(name="name", type="string", length=100, nullable=false)
   */
  private $name = '';

  /**
   * @var string
   *
   * @Column(name="education", type="string", length=255, nullable=false)
   */
  private $education;

  /**
   * @var string
   *
   * @Column(name="position", type="string", length=255, nullable=false)
   */
  private $position;

  /**
   * @var string
   *
   * @Column(name="description", type="text", length=65535, nullable=false)
   */
  private $description;

  /**
   * @var string
   *
   * @Column(name="photo_link", type="string", length=255, nullable=false)
   */
  private $photoLink;

  /**
   * @var string|null
   *
   * @Column(name="researchGate_link", type="string", length=255, nullable=true)
   */
  private $researchgateLink;

  /**
   * @var string|null
   *
   * @Column(name="linkedIn_link", type="string", length=255, nullable=true)
   */
  private $linkedinLink;

  /**
   * @var string|null
   *
   * @Column(name="scholar_link", type="string", length=255, nullable=true)
   */
  private $scholarLink;

  /**
   * @var string|null
   *
   * @Column(name="orcid_link", type="string", length=255, nullable=true)
   */
  private $orcidLink;

  /**
   * @var bool
   *
   * @Column(name="active", type="boolean", nullable=false, options={"default"="1"})
   */
  private $active = true;

  /**
   *  @var Subjects|null
   *
   * @OneToMany(targetEntity="Subjects", mappedBy="iduser")
   */
  private $idsubject;

  /**
   * @var \Doctrine\Common\Collections\Collection
   *
   * @ManyToMany(targetEntity="Publications", mappedBy="iduser")
   */
  private $idarticle;

  /**
   * @var \Doctrine\Common\Collections\Collection
   *
   * @ManyToMany(targetEntity="Tags", inversedBy="idusers")
   * @JoinTable(name="rel_user_tag",
   *   joinColumns={
   *     @JoinColumn(name="idUser", referencedColumnName="idUser")
   *   },
   *   inverseJoinColumns={
   *     @JoinColumn(name="idTag", referencedColumnName="idTag")
   *   }
   * )
   */
  private $idtag;

  public function __construct($data = null)
  {
    $this->idarticle = new ArrayCollection();

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

    return;
  }

  /* getters */

  function get_iduser()
  {
    return $this->iduser;
  }

  function get_name()
  {
    return $this->name;
  }

  function get_education()
  {
    return $this->education;
  }

  function get_position()
  {
    return $this->position;
  }

  function get_description()
  {
    return $this->description;
  }

  function get_photo_link()
  {
    return $this->photoLink;
  }

  function get_researchgate_link()
  {
    return $this->researchgateLink;
  }

  function get_linkedin_link()
  {
    return $this->linkedinLink;
  }

  function get_scholar_link()
  {
    return $this->scholarLink;
  }

  function get_orcid_link()
  {
    return $this->orcidLink;
  }

  function get_active()
  {
    return $this->active;
  }

  function get_idsubject()
  {
    return $this->idsubject;
  }

  function get_idarticle()
  {
    return $this->idarticle;
  }

  function get_idtag()
  {
    return $this->idtag;
  }
}
