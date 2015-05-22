<?php

namespace AppBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="links",
 *     indexes={
 *         @ORM\Index(name="link_author", columns={"link_author"}),
 *         @ORM\Index(name="link_url", columns={"link_url"}),
 *         @ORM\Index(name="link_status", columns={"link_status"}),
 *         @ORM\Index(name="link_title_url", columns={"link_title_url"}),
 *         @ORM\Index(name="link_date", columns={"link_date"}),
 *         @ORM\Index(name="link_published_date", columns={"link_published_date"}),
 *         @ORM\Index(name="link_url_2", columns={
 *             "link_url",
 *             "link_url_title",
 *             "link_title",
 *             "link_content",
 *             "link_tags"
 *         }),
 *         @ORM\Index(name="link_tags", columns={"link_tags"}),
 *         @ORM\Index(name="link_search", columns={
 *             "link_title",
 *             "link_content",
 *             "link_tags"
 *         })
 *     }
 * )
 * @ORM\Entity()
 */
class Post
{
    /**
     * @ORM\Column(type="integer", name="link_id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", name="link_author", options={"default"=0})
     */
    private $author;

    /**
     * @ORM\Column(type="string", name="link_status", options={"default"="discard"})
     */
    private $status;

    /**
     * @ORM\Column(type="integer", name="link_randkey", options={"default"=0})
     */
    private $randkey;

    /**
     * @ORM\Column(type="integer", name="link_votes", options={"default"=0})
     */
    private $score = 0;

    /**
     * @ORM\Column(type="integer", name="link_likes", nullable=true)
     */
    private $likes = 0;

    /**
     * @ORM\Column(type="integer", name="link_reports", options={"default"=0})
     */
    private $dislikes = 0;

    /**
     * @ORM\Column(type="integer", name="link_comments", options={"default"=0})
     */
    private $commentsNumber = 0;

    /**
     * @ORM\Column(type="integer", name="link_debate_score", nullable=true)
     */
    private $debateScore = 0;

    /**
     * @deprecated
     * @ORM\Column(type="decimal", precision=10, scale=2, name="link_karma", options={"default"=0.00})
     */
    private $karma = '0';

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", name="link_modified")
     */
    private $updated;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", name="link_date", options={"default"="0000-00-00 00:00:00"})
     */
    private $created;

    /**
     * Pligg distinguish 'new' post from 'published' post (by default you need 5 likes
     * to be published). We don't use this so published is always equal to created.
     * @deprecated
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", name="link_published_date", options={"default"="0000-00-00 00:00:00"})
     */
    private $published;

    /**
     * @ORM\Column(type="integer", name="link_category", options={"default"=0})
     */
    private $category;

    /**
     * @deprecated
     * @ORM\Column(type="integer", name="link_lang", options={"default"=1})
     */
    private $lang = 1;

    /**
     * @deprecated
     * @ORM\Column(length=200, name="link_url", options={"default"=""})
     */
    private $url = '';

    /**
     * @deprecated
     * @ORM\Column(type="text", name="link_url_title", nullable=true)
     */
    private $urlTitle;

    /**
     * @ORM\Column(type="text", name="link_title")
     */
    private $title;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=255, name="link_title_url", nullable=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="text", name="link_content")
     */
    private $content;

    /**
     * @ORM\Column(type="text", name="link_summary", nullable=true)
     */
    private $summary;

    /**
     * @ORM\Column(type="text", name="link_tags", nullable=true)
     */
    private $tags = '';

    /**
     * @deprecated
     * @ORM\Column(length=255, name="link_field1", options={"default"=""})
     */
    private $link_field1 = '';

    /**
     * @deprecated
     * @ORM\Column(length=255, name="link_field2", options={"default"=""})
     */
    private $link_field2 = '';

    /**
     * @deprecated
     * @ORM\Column(length=255, name="link_field3", options={"default"=""})
     */
    private $link_field3 = '';

    /**
     * @deprecated
     * @ORM\Column(length=255, name="link_field4", options={"default"=""})
     */
    private $link_field4 = '';

    /**
     * @deprecated
     * @ORM\Column(length=255, name="link_field5", options={"default"=""})
     */
    private $link_field5 = '';

    /**
     * @deprecated
     * @ORM\Column(length=255, name="link_field6", options={"default"=""})
     */
    private $link_field6 = '';

    /**
     * @deprecated
     * @ORM\Column(length=255, name="link_field7", options={"default"=""})
     */
    private $link_field7 = '';

    /**
     * @deprecated
     * @ORM\Column(length=255, name="link_field8", options={"default"=""})
     */
    private $link_field8 = '';

    /**
     * @deprecated
     * @ORM\Column(length=255, name="link_field9", options={"default"=""})
     */
    private $link_field9 = '';

    /**
     * @deprecated
     * @ORM\Column(length=255, name="link_field10", options={"default"=""})
     */
    private $link_field10 = '';

    /**
     * @deprecated
     * @ORM\Column(length=255, name="link_field11", options={"default"=""})
     */
    private $link_field11 = '';

    /**
     * @deprecated
     * @ORM\Column(length=255, name="link_field12", options={"default"=""})
     */
    private $link_field12 = '';

    /**
     * @deprecated
     * @ORM\Column(length=255, name="link_field13", options={"default"=""})
     */
    private $link_field13 = '';

    /**
     * @deprecated
     * @ORM\Column(length=255, name="link_field14", options={"default"=""})
     */
    private $link_field14 = '';

    /**
     * @deprecated
     * @ORM\Column(length=255, name="link_field15", options={"default"=""})
     */
    private $link_field15 = '';

    /**
     * @ORM\Column(type="integer", name="link_group_id", options={"default"=0})
     */
    private $group = 0;

    /**
     * @deprecated
     * @ORM\Column(type="string", name="link_group_status", options={"default"="new"})
     */
    private $groupStatus = 'new';

    /**
     * @deprecated
     * @ORM\Column(type="integer", name="link_out", options={"default"=0})
     */
    private $out = 0;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->randkey = rand(10000, 10000000);
    }

    /**
     * Get id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set author.
     *
     * @param integer $user
     *
     * @return Post
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author.
     *
     * @return integer
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set status.
     *
     * @param string $status
     *
     * @return Post
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get randkey.
     *
     * @return integer
     */
    public function getRandkey()
    {
        return $this->randkey;
    }

    /**
     * Get score.
     *
     * @return integer
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Get likes.
     *
     * @return integer
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * Get dislikes.
     *
     * @return integer
     */
    public function getDislikes()
    {
        return $this->dislikes;
    }

    /**
     * Get comments.
     *
     * @return integer
     */
    public function getCommentsNumber()
    {
        return $this->commentsNumber;
    }

    /**
     * Get debateScore.
     *
     * @return integer
     */
    public function getDebateScore()
    {
        return $this->debateScore;
    }

    /**
     * Get updated.
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Get created.
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set category.
     *
     * @param integer $category
     *
     * @return Post
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category.
     *
     * @return integer
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
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
     * Set content.
     *
     * @param string $content
     *
     * @return Post
     */
    public function setContent($content)
    {
        $this->content = $content;
        $this->summary = substr($content, 0, 600);

        return $this;
    }

    /**
     * Get content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Get summary.
     *
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set tags.
     *
     * @param string $tags
     *
     * @return Post
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags.
     *
     * @return string
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set group.
     *
     * @param integer $group
     *
     * @return Post
     */
    public function setGroup($group)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group.
     *
     * @return integer
     */
    public function getGroup()
    {
        return $this->group;
    }
}
