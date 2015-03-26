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
    private $user;

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
    private $score;

    /**
     * @ORM\Column(type="integer", name="link_likes", nullable=true)
     */
    private $likes;

    /**
     * @ORM\Column(type="integer", name="link_reports", options={"default"=0})
     */
    private $dislikes;

    /**
     * @ORM\Column(type="integer", name="link_comments", options={"default"=0})
     */
    private $comments;

    /**
     * @ORM\Column(type="integer", name="link_debate_score", nullable=true)
     */
    private $debateScore;

    /**
     * @deprecated
     * @ORM\Column(type="decimal", precision=10, scale=2, name="link_karma", options={"default"=0.00})
     */
    private $karma;

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
    private $lang;

    /**
     * @deprecated
     * @ORM\Column(length=200, name="link_url", options={"default"=""})
     */
    private $url;

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
    private $tags;

    /**
     * @deprecated
     * @ORM\Column(length=255, name="link_field1", options={"default"=""})
     */
    private $link_field1;

    /**
     * @deprecated
     * @ORM\Column(length=255, name="link_field2", options={"default"=""})
     */
    private $link_field2;

    /**
     * @deprecated
     * @ORM\Column(length=255, name="link_field3", options={"default"=""})
     */
    private $link_field3;

    /**
     * @deprecated
     * @ORM\Column(length=255, name="link_field4", options={"default"=""})
     */
    private $link_field4;

    /**
     * @deprecated
     * @ORM\Column(length=255, name="link_field5", options={"default"=""})
     */
    private $link_field5;

    /**
     * @deprecated
     * @ORM\Column(length=255, name="link_field6", options={"default"=""})
     */
    private $link_field6;

    /**
     * @deprecated
     * @ORM\Column(length=255, name="link_field7", options={"default"=""})
     */
    private $link_field7;

    /**
     * @deprecated
     * @ORM\Column(length=255, name="link_field8", options={"default"=""})
     */
    private $link_field8;

    /**
     * @deprecated
     * @ORM\Column(length=255, name="link_field9", options={"default"=""})
     */
    private $link_field9;

    /**
     * @deprecated
     * @ORM\Column(length=255, name="link_field10", options={"default"=""})
     */
    private $link_field10;

    /**
     * @deprecated
     * @ORM\Column(length=255, name="link_field11", options={"default"=""})
     */
    private $link_field11;

    /**
     * @deprecated
     * @ORM\Column(length=255, name="link_field12", options={"default"=""})
     */
    private $link_field12;

    /**
     * @deprecated
     * @ORM\Column(length=255, name="link_field13", options={"default"=""})
     */
    private $link_field13;

    /**
     * @deprecated
     * @ORM\Column(length=255, name="link_field14", options={"default"=""})
     */
    private $link_field14;

    /**
     * @deprecated
     * @ORM\Column(length=255, name="link_field15", options={"default"=""})
     */
    private $link_field15;

    /**
     * @ORM\Column(type="integer", name="link_group_id", options={"default"=0})
     */
    private $group;

    /**
     * @deprecated
     * @ORM\Column(type="string", name="link_group_status", options={"default"="new"})
     */
    private $groupStatus;

    /**
     * @deprecated
     * @ORM\Column(type="integer", name="link_out", options={"default"=0})
     */
    private $out;

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
     * Set user.
     *
     * @param integer $user
     *
     * @return Post
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return integer
     */
    public function getUser()
    {
        return $this->user;
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
     * Set randkey.
     *
     * @param integer $randkey
     *
     * @return Post
     */
    public function setRandkey($randkey)
    {
        $this->randkey = $randkey;

        return $this;
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
     * Set score.
     *
     * @param integer $score
     *
     * @return Post
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
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
     * Set likes.
     *
     * @param integer $likes
     *
     * @return Post
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;

        return $this;
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
     * Set dislikes.
     *
     * @param integer $dislikes
     *
     * @return Post
     */
    public function setDislikes($dislikes)
    {
        $this->dislikes = $dislikes;

        return $this;
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
     * Set comments.
     *
     * @param integer $comments
     *
     * @return Post
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments.
     *
     * @return integer
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set debateScore.
     *
     * @param integer $debateScore
     *
     * @return Post
     */
    public function setDebateScore($debateScore)
    {
        $this->debateScore = $debateScore;

        return $this;
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
     * Set karma.
     *
     * @param string $karma
     *
     * @return Post
     */
    public function setKarma($karma)
    {
        $this->karma = $karma;

        return $this;
    }

    /**
     * Get karma.
     *
     * @return string
     */
    public function getKarma()
    {
        return $this->karma;
    }

    /**
     * Set updated.
     *
     * @param \DateTime $updated
     *
     * @return Post
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
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
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return Post
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
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
     * Set published.
     *
     * @param \DateTime $published
     *
     * @return Post
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published.
     *
     * @return \DateTime
     */
    public function getPublished()
    {
        return $this->published;
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
     * Set lang.
     *
     * @param integer $lang
     *
     * @return Post
     */
    public function setLang($lang)
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * Get lang.
     *
     * @return integer
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * Set url.
     *
     * @param string $url
     *
     * @return Post
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set urlTitle.
     *
     * @param string $urlTitle
     *
     * @return Post
     */
    public function setUrlTitle($urlTitle)
    {
        $this->urlTitle = $urlTitle;

        return $this;
    }

    /**
     * Get urlTitle.
     *
     * @return string
     */
    public function getUrlTitle()
    {
        return $this->urlTitle;
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
     * Set slug.
     *
     * @param string $slug
     *
     * @return Post
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
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
     * Set summary.
     *
     * @param string $summary
     *
     * @return Post
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
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

    /**
     * Set groupStatus.
     *
     * @param string $groupStatus
     *
     * @return Post
     */
    public function setGroupStatus($groupStatus)
    {
        $this->groupStatus = $groupStatus;

        return $this;
    }

    /**
     * Get groupStatus.
     *
     * @return string
     */
    public function getGroupStatus()
    {
        return $this->groupStatus;
    }

    /**
     * Set out.
     *
     * @param integer $out
     *
     * @return Post
     */
    public function setOut($out)
    {
        $this->out = $out;

        return $this;
    }

    /**
     * Get out.
     *
     * @return integer
     */
    public function getOut()
    {
        return $this->out;
    }
}
