<?php

namespace SD6Production\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* Member
*
* @ORM\Table(name="member")
* @ORM\Entity(repositoryClass="SD6Production\AppBundle\Repository\MemberRepository")
*/
class Member
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
  * @var string
  *
  * @ORM\Column(name="name", type="string", length=255, nullable=true)
  */
  private $name;

  /**
  * @var string
  *
  * @ORM\Column(name="firstName", type="string", length=255)
  */
  private $firstName;

  /**
  * @var string
  *
  * @ORM\Column(name="post", type="string", length=255)
  */
  private $post;

  /**
  * @var string
  *
  * @ORM\Column(name="description", type="text", nullable=true)
  */
  private $description;

  /**
  * @ORM\ManyToOne(targetEntity="SD6Production\AppBundle\Entity\Image", cascade={"persist"})
  * @ORM\JoinColumn(nullable=true)
  */
  private $image;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Member
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Member
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set post
     *
     * @param string $post
     *
     * @return Member
     */
    public function setPost($post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return string
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Member
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set image
     *
     * @param \SD6Production\AppBundle\Entity\Image $image
     *
     * @return Member
     */
    public function setImage(\SD6Production\AppBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \SD6Production\AppBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }
}
