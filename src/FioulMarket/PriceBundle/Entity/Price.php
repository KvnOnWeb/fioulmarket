<?php

namespace FioulMarket\PriceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Price.
 *
 * @ORM\Table(name="price")
 * @ORM\Entity(repositoryClass="FioulMarket\PriceBundle\Repository\PriceRepository")
 */
class Price
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="City", inversedBy="prices", cascade={"persist"})
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity="Energy", inversedBy="prices", cascade={"persist"})
     * @ORM\JoinColumn(name="energy_id", referencedColumnName="id")
     */
    private $energy;

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
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return Price
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set city.
     *
     * @param City $city
     *
     * @return Price
     */
    public function setCity(City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city.
     *
     * @return City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set energy.
     *
     * @param Energy $energy
     *
     * @return Price
     */
    public function setEnergy(Energy $energy = null)
    {
        $this->energy = $energy;

        return $this;
    }

    /**
     * Get energy.
     *
     * @return Energy
     */
    public function getEnergy()
    {
        return $this->energy;
    }

    /**
     * Set price.
     *
     * @param int $price
     *
     * @return Price
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }
}
