<?php

declare(strict_types=1);

namespace Siketyan\KagawaBundle\Service;

use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;
use GeoIp2\Model\City;
use MaxMind\Db\Reader\InvalidDatabaseException;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class GeoIpService
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * GeoIpService constructor.
     *
     * @param ContainerBagInterface $container
     *
     * @throws InvalidDatabaseException
     */
    public function __construct(ContainerBagInterface $container)
    {
        $this->reader = new Reader(
            $container->get('kagawa.config')['geoip_db']
        );
    }

    /**
     * Gets the city from the address.
     *
     * @param string $address the IP address
     *
     * @return City the city where the address associated
     *
     * @throws InvalidDatabaseException
     */
    public function getCity(string $address): ?City
    {
        try {
            return $this->reader->city($address);
        } catch (AddressNotFoundException $exception) {
            return null;
        }
    }
}
