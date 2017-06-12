<?php

namespace FioulMarket\PriceBundle\Service;

use Doctrine\Common\Persistence\ObjectManager;
use FioulMarket\PriceBundle\Entity\City;
use FioulMarket\PriceBundle\Entity\Energy;
use FioulMarket\PriceBundle\Entity\Price;

/**
 * @author Kevin Nazzari <nazzari.kevin@gmail.com>
 *
 * @since  2017-06-09
 */
class PriceManager
{
    protected $className;
    protected $entityManager;

    /**
     * @param ObjectManager $entityManager
     */
    public function __construct(ObjectManager $entityManager, $className)
    {
        $this->className = $className;
        $this->entityManager = $entityManager;
    }

    /**
     * @param City      $city
     * @param Energy    $energy
     * @param           $amount
     * @param \DateTime $date
     *
     * @return Price
     */
    public function create($amount, City $city, Energy $energy, $date)
    {
        $date = ($date instanceof \DateTime) ? $date : new \DateTime($date);

        return (new $this->className())
            ->setCity($city)
            ->setEnergy($energy)
            ->setPrice($amount)
            ->setDate($date);
    }

    /**
     * @param Price $price
     * @param bool  $flush
     */
    public function save(Price $price, $flush = true)
    {
        $this->entityManager->merge($price);

        if ($flush) {
            $this->entityManager->flush();
        }
    }

    /**
     * Flush et clear Doctrine (reduit consommation memoire).
     */
    public function flushAndClear()
    {
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    /**
     * @param $postalCode
     * @param $startDate
     * @param $endDate
     */
    public function getPriceByCityAndDate($postalCode, $startDate, $endDate)
    {
        $startDate = ($startDate instanceof \DateTime) ? $startDate : new \DateTime($startDate);
        $endDate = ($endDate instanceof \DateTime) ? $endDate : new \DateTime($endDate);

        return $this->entityManager
            ->getRepository($this->className)
            ->findByCityAndDate($postalCode, $startDate, $endDate);
    }
}
