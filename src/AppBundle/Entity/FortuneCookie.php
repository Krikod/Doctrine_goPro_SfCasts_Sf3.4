<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FortuneCookie
 *
 * @ORM\Table(name="fortune_cookie")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FortuneCookieRepository")
 */
class FortuneCookie
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category", inversedBy="fortuneCookies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="fortune", type="string", length=255)
     */
    private $fortune;


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
     * Set category.
     *
     * @param string $category
     *
     * @return FortuneCookie
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category.
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set fortune.
     *
     * @param string $fortune
     *
     * @return FortuneCookie
     */
    public function setFortune($fortune)
    {
        $this->fortune = $fortune;

        return $this;
    }

    /**
     * Get fortune.
     *
     * @return string
     */
    public function getFortune()
    {
        return $this->fortune;
    }
}
