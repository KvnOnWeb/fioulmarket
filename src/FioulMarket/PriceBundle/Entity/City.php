<?php

namespace FioulMarket\PriceBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * City.
 *
 * @ORM\Table(name="city")
 * @ORM\Entity(repositoryClass="FioulMarket\PriceBundle\Repository\CityRepository")
 */
class City
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
     * @var int
     *
     * @ORM\Column(name="postal_code", type="integer", unique=true)
     */
    private $postalCode;

    /**
     * @ORM\OneToMany(targetEntity="Price", mappedBy="city")
     */
    private $prices;

    public function __construct()
    {
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
     * Set postalCode.
     *
     * @param int $postalCode
     *
     * @return City
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get postalCode.
     *
     * @return int
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Add prices.
     *
     * @param \FioulMarket\PriceBundle\Entity\Price $prices
     *
     * @return City
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
