<?php

namespace FioulMarket\PriceBundle\Service;

use Doctrine\Common\Persistence\ObjectManager;
use FioulMarket\PriceBundle\Entity\Energy;

/**
 * @author Kevin Nazzari <nazzari.kevin@gmail.com>
 *
 * @since  2017-06-10
 */
class EnergyManager
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
     * @param string $energyName
     */
    public function get($energyName)
    {
        return $this->entityManager
            ->getRepository($this->className)
            ->findOneBy(['name' => $energyName]);
    }

    /**
     * @param string $energyName
     */
    public function save($energyName)
    {
        /* @var Energy $entity */
        $entity = new $this->className();
        $entity->setName($energyName);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }
}
