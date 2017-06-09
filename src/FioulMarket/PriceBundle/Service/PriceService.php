<?php

namespace FioulMarket\PriceBundle\Service;

use Doctrine\ORM\EntityRepository;
use FioulMarket\PriceBundle\Entity\Price;

/**
 * @author Kevin Nazzari <nazzari.kevin@gmail.com>
 *
 * @since  2017-06-09
 */
class PriceService
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
     * @param $postalCode
     * @param $startDate
     * @param $endDate
     */
    public function getPriceByCityAndDate($postalCode, $startDate, $endDate)
    {
        $startDate = ($startDate instanceof \DateTime) ? $startDate : new \DateTime($startDate);
        $endDate   = ($endDate instanceof \DateTime) ? $endDate : new \DateTime($endDate);

        return $this->repository->findByCityAndDate($postalCode, $startDate, $endDate);
    }
}
