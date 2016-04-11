<?php

namespace AppBundle\Entity;

/**
 * Category
 */
class Category
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;


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
     * @return Category
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


    private $adds;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->adds = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add adds
     *
     * @param \AppBundle\Entity\Advertisement $adds
     * @return Category
     */
    public function addAdd(\AppBundle\Entity\Advertisement $adds)
    {
        $this->adds[] = $adds;

        return $this;
    }

    /**
     * Remove products
     *
     * @param \AppBundle\Entity\Advertisement $adds
     */
    public function removeAdd(\AppBundle\Entity\Advertisement $adds)
    {
        $this->adds->removeElement($adds);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdds()
    {
        return $this->adds;
    }

    function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->name;
    }
}

