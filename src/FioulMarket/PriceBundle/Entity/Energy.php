<?php

namespace FioulMarket\PriceBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Energy.
 *
 * @ORM\Table(name="energy")
 * @ORM\Entity(repositoryClass="FioulMarket\PriceBundle\Repository\EnergyRepository")
 */
class Energy
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Price", mappedBy="energy")
     */
    private $prices;

    public function __construct($name = '')
    {
        $this->name = $name;
        $this->prices = new ArrayCollection();
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
     * Set name.
     *
     * @param string $name
     *
     * @return Energy
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
     * Add prices.
     *
     * @param \FioulMarket\PriceBundle\Entity\Price $prices
     *
     * @return Energy
     */
    public function addPrice(\FioulMarket\PriceBundle\Entity\Price $prices)
    {
        $this->prices[] = $prices;

        return $this;
    }

    /**
     * Remove prices.
     *
     * @param \FioulMarket\PriceBundle\Entity\Price $prices
     */
    public function removePrice(\FioulMarket\PriceBundle\Entity\Price $prices)
    {
        $this->prices->removeElement($prices);
    }

    /**
     * Get prices.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPrices()
    {
        return $this->prices;
    }
}
