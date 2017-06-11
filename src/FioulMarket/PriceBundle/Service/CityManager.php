<?php

namespace FioulMarket\PriceBundle\Service;

use Doctrine\Common\Persistence\ObjectManager;
use FioulMarket\PriceBundle\Entity\City;

/**
 * @author Kevin Nazzari <nazzari.kevin@gmail.com>
 *
 * @since  2017-06-08
 */
class CityManager
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
     * @param $postalCode
     *
     * @return City
     */
    public function create($postalCode)
    {
        return (new $this->className())
            ->setPostalCode($postalCode);
    }

    /**
     * Retourne tous les objets City dans un tableau par clé du code postal
     * (optimisation pour éviter un in_array).
     *
     * @return array
     */
    public function getCitiesByPostalCode()
    {
        $citiesWithKey = [];
        $cities = $this->entityManager
            ->getRepository($this->className)
            ->findAll();

        foreach ($cities as $city) {
            /* @var City $city */
            $citiesWithKey[$city->getPostalCode()] = $city;
        }

        return $citiesWithKey;
    }
}
