<?php 

namespace Sdz\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sdz\BlogBundle\Entity\ArticleCompetence
 * 
 * @ORM\Entity
 */
class ArticleCompetence
{
    /**
     * @var Sdz\BlogBundle\Entity\Article $article
     * 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Sdz\BlogBundle\Entity\Article")
     */
    private $article;

    /**
     * @var Sdz\BlogBundle\Entity\Competence $competence
     * 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Sdz\BlogBundle\Entity\Competence")
     */
    private $competence;

    /**
     * @var string $level
     * 
     * @ORM\Column(name="level", type="string", length=255)
     */
    private $level;

    /**
     * Set level
     *
     * @param string $level
     *
     * @return ArticleCompetence
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set article
     *
     * @param \Sdz\BlogBundle\Entity\Article $article
     *
     * @return ArticleCompetence
     */
    public function setArticle(\Sdz\BlogBundle\Entity\Article $article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \Sdz\BlogBundle\Entity\Article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set competence
     *
     * @param \Sdz\BlogBundle\Entity\Competence $competence
     *
     * @return ArticleCompetence
     */
    public function setCompetence(\Sdz\BlogBundle\Entity\Competence $competence)
    {
        $this->competence = $competence;

        return $this;
    }

    /**
     * Get competence
     *
     * @return \Sdz\BlogBundle\Entity\Competence
     */
    public function getCompetence()
    {
        return $this->competence;
    }
}
