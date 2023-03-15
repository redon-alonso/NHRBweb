<?php

namespace App\Models;

/**
 * Publications
 *
 * @Entity(repositoryClass=App\Models\Repositories\PublicationsRepository::class)
 * @Table(name="publications", uniqueConstraints={@UniqueConstraint(name="title", columns={"title"})})
 */
class Publications
{
  /**
   * @var int
   *
   * @Id
   * @Column(name="idArticle", type="integer", nullable=false)
   * @GeneratedValue(strategy="IDENTITY")
   */
  private $idarticle;

  /**
   * @var string
   *
   * @Column(name="title", type="string", length=255, nullable=false)
   */
  private $title = '';

  /**
   * @var int
   *
   * @Column(name="type", type="integer", nullable=false)
   */
  private $type = '0';

  /**
   * @var string
   *
   * @Column(name="authors", type="string", length=255, nullable=false)
   */
  private $authors = '';

  /**
   * @var string
   *
   * @Column(name="journal", type="string", length=255, nullable=false)
   */
  private $journal = '';

  /**
   * @var int
   *
   * @Column(name="year", type="integer", nullable=false)
   */
  private $year = '0';

  /**
   * @var string
   *
   * @Column(name="cite", type="string", length=255, nullable=false)
   */
  private $cite = '';

  /**
   * @var string|null
   *
   * @Column(name="access_link", type="string", length=255, nullable=true)
   */
  private $accessLink = '';

  /**
   * @var string|null
   *
   * @Column(name="download_link", type="string", length=255, nullable=true)
   */
  private $downloadLink = '';

  /**
   * @var bool
   *
   * @Column(name="active", type="boolean", nullable=false, options={"default"="1"})
   */
  private $active = true;

  /**
   * @var \Doctrine\Common\Collections\Collection
   *
   * @ManyToMany(targetEntity="Tags", inversedBy="idarticle")
   * @JoinTable(name="rel_articles_tag",
   *   joinColumns={
   *     @JoinColumn(name="idArticle", referencedColumnName="idArticle")
   *   },
   *   inverseJoinColumns={
   *     @JoinColumn(name="idTag", referencedColumnName="idTag")
   *   }
   * )
   */
  private $idtag;

  /**
   * @var \Doctrine\Common\Collections\Collection
   *
   * @ManyToMany(targetEntity="Users", inversedBy="idarticle")
   * @JoinTable(name="rel_articles_user",
   *   joinColumns={
   *     @JoinColumn(name="idArticle", referencedColumnName="idArticle")
   *   },
   *   inverseJoinColumns={
   *     @JoinColumn(name="idUser", referencedColumnName="idUser")
   *   }
   * )
   */
  private $iduser;

  /**
   * Constructor
   */
  public function __construct($data = null)
  {
    $this->idtag = new \Doctrine\Common\Collections\ArrayCollection();
    $this->iduser = new \Doctrine\Common\Collections\ArrayCollection();

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

  function get_idarticle()
  {
    return $this->idarticle;
  }

  function get_title()
  {
    return $this->title;
  }

  function get_type()
  {
    return $this->type;
  }

  function get_authors()
  {
    return $this->authors;
  }

  function get_journal()
  {
    return $this->journal;
  }

  function get_year()
  {
    return $this->year;
  }

  function get_cite()
  {
    return $this->cite;
  }

  function get_access_link()
  {
    return $this->accessLink;
  }

  function get_download_link()
  {
    return $this->downloadLink;
  }

  function get_active()
  {
    return $this->active;
  }

  function get_idtag()
  {
    return $this->idtag;
  }

  function get_iduser()
  {
    return $this->iduser;
  }
}
