<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @Gedmo\Tree(type="nested")
 * @ORM\Entity()
 * @ORM\Table(
 *     name="categories",
 *     indexes={
 *         @ORM\Index(name="category_id", columns={"category_id"}),
 *         @ORM\Index(name="category_parent", columns={"category_parent"}),
 *         @ORM\Index(name="category_safe_name", columns={"category_safe_name"})
 *     }
 * )
 */
class Category
{
    /**
     * @ORM\Column(type="integer", name="category__auto_id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @deprecated
     * @ORM\Column(type="string", length=2, name="category_lang", options={"default"="en"})
     */
    private $lang = 'en';

    /**
     * For a weird reason the category table in pligg has to ID, the auto id and this column.
     * This column has always the same value as category__auto_id.
     *
     * @ORM\Column(type="integer", name="category_id", options={"default"=0})
     */
    private $legacyId = '0';

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(name="category_parent", referencedColumnName="category__auto_id", nullable=false)
     */
    private $parent;

    /**
     * Just to define a default value for the column so it match pligg schema.
     *
     * @ORM\Column(type="integer", name="category_parent", options={"default"=0})
     */
    private $parentId;

    /**
     * ORM\OneToMany(targetEntity="Category", mappedBy="parent").
     */
    private $children;

    /**
     * @ORM\Column(type="string", length=64, name="category_name", options={"default"=""})
     */
    private $name = '';

    /**
     * @ORM\Column(type="string", length=64, name="category_safe_name", options={"default"=""})
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(type="integer", name="rgt", options={"default"=0})
     */
    private $rgt;

    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(type="integer", name="lft", options={"default"=0})
     */
    private $lft;

    /**
     * @ORM\Column(type="integer", name="category_enabled", options={"default"=1})
     */
    private $enabled = 'true';

    /**
     * @ORM\Column(type="integer", name="category_order", options={"default"=0})
     */
    private $order = '0';

    /**
     * Description.
     *
     * @ORM\Column(type="string", name="category_desc")
     */
    private $description;

    /**
     * @deprecated
     * @ORM\Column(type="string", name="category_keywords")
     */
    private $keywords = '';

    /**
     * @deprecated
     * @ORM\Column(type="string", name="category_author_level", options={"default"="normal"})
     */
    private $authorLevel = 'normal';

    /**
     * @ORM\Column(type="string", name="category_author_group", options={"default"=""})
     */
    private $authorGroup = '';

    /**
     * Number of votes to publish.
     *
     * @deprecated
     * @ORM\Column(type="string", length=4, name="category_votes", options={"default"=""})
     */
    private $votes = '';

    /**
     * Karma to publish.
     *
     * @deprecated
     * @ORM\Column(type="string", length=4, name="category_karma", options={"default"=""})
     */
    private $karma = '';

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Update legacy ID and return false if it needs to be persisted again.
     *
     * @return bool
     */
    public function updateLegacyId()
    {
        $equal = ($this->id === $this->legacyId);
        $this->legacyId = $this->id;

        return $equal;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Category
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set enabled.
     *
     * @param int $enabled
     *
     * @return Category
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Is enabled.
     *
     * @return int
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set order.
     *
     * @param int $order
     *
     * @return Category
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order.
     *
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set authorLevel.
     *
     * @param string $authorLevel
     *
     * @return Category
     */
    public function setAuthorLevel($authorLevel)
    {
        $this->authorLevel = $authorLevel;

        return $this;
    }

    /**
     * Get authorLevel.
     *
     * @return string
     */
    public function getAuthorLevel()
    {
        return $this->authorLevel;
    }

    /**
     * Set authorGroup.
     *
     * @param string $authorGroup
     *
     * @return Category
     */
    public function setAuthorGroup($authorGroup)
    {
        $this->authorGroup = $authorGroup;

        return $this;
    }

    /**
     * Get authorGroup.
     *
     * @return string
     */
    public function getAuthorGroup()
    {
        return $this->authorGroup;
    }

    /**
     * Set parent.
     *
     * @param \AppBundle\Entity\Category $parent
     *
     * @return Category
     */
    public function setParent(\AppBundle\Entity\Category $parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent.
     *
     * @return \AppBundle\Entity\Category
     */
    public function getParent()
    {
        return $this->parent;
    }
}
