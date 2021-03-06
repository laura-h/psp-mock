<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace TechDivision\PspMock\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use TechDivision\PspMock\Entity\Configuration;

/**
 * @copyright  Copyright (c) 2019 TechDivision GmbH (https://www.techdivision.com)
 * @link       https://www.techdivision.com/
 * @author     Lukas Kiederle <l.kiederle@techdivision.com
 */
class ConfigurationRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Configuration::class);
    }

    /**
     * @param string $value
     * @return array
     */
    public function findAllConfigurationsByWildcard(string $value)
    {
        $value = $value . '%';
        $queryBuilder = $this->createQueryBuilder('c');
        $queryBuilder
            ->where('c.path LIKE :value')
            ->setParameter('value', $value);
        return $queryBuilder->getQuery()->getResult();
    }
}
