<?php

namespace FioulMarket\PriceBundle\Service;

use Doctrine\ORM\EntityRepository;
use FioulMarket\PriceBundle\Entity\City;

/**
 * @author Kevin Nazzari <nazzari.kevin@gmail.com>
 *
 * @since  2017-06-08
 */
class CityService
{
    protected $repository;

    /**
     * @param EntityRepository $repository
     */
    public function __construct(EntityRepository $repository)
    {
        $this->repository = $repository;
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
        $cities = $this->repository->findAll();

        foreach ($cities as $city) {
            /* @var City $city */
            $citiesWithKey[$city->getPostalCode()] = $city;
        }

        return $citiesWithKey;
    }
}
