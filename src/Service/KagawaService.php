<?php

declare(strict_types=1);

namespace Siketyan\KagawaBundle\Service;

use GeoIp2\Record\Subdivision;
use MaxMind\Db\Reader\InvalidDatabaseException;
use Siketyan\KagawaBundle\Controller\KagawaController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class KagawaService
{
    private const SESSION_PREFIX = 'bundles.kagawa.';
    private const SESSION_CONTINUED = self::SESSION_PREFIX . 'continued';
    private const SESSION_REQUEST = self::SESSION_PREFIX . 'request';
    private const SESSION_CONTROLLER = self::SESSION_PREFIX . 'controller';

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var KagawaController
     */
    private $kagawaController;

    /**
     * @var GeoIpService
     */
    private $geoIpService;

    public function __construct(
        ContainerInterface $container,
        SessionInterface $session,
        KagawaController $kagawaController,
        GeoIpService $geoIpService
    ) {
        $this->container = $container;
        $this->session = $session;
        $this->kagawaController = $kagawaController;
        $this->geoIpService = $geoIpService;
    }

    /**
     * Routes the request via Kagawa checks.
     *
     * @param Request  $request the request to route
     * @param callable $controller the original controller
     *
     * @return callable the routed controller
     *
     * @throws InvalidDatabaseException
     */
    public function route(Request $request, callable $controller): callable
    {
        if (
            strpos($request->getRequestUri(), '/_wdt/') === 0 ||
            strpos($request->getRequestUri(), '/_profiler/') === 0
        ) {
            return $controller;
        }

        if (!$this->isFromKagawa($request) || $this->session->get(self::SESSION_CONTINUED)) {
            return $controller;
        }

        if (
            $this->session->has(self::SESSION_REQUEST) &&
            $this->session->has(self::SESSION_CONTROLLER)
        ) {
            if ($request->isMethod('POST')) {
                /** @var Request $originalRequest */
                $originalRequest = $this->session->get(self::SESSION_REQUEST);
                $this->container->set('request', $originalRequest);
                $this->session->set(self::SESSION_CONTINUED, true);

                return $this->session->get(self::SESSION_CONTROLLER);
            }
        }

        $this->session->set(self::SESSION_REQUEST, $request);
        $this->session->set(self::SESSION_CONTROLLER, $controller);

        return [$this->kagawaController, 'view'];
    }

    /**
     * Checks whether the request is from Kagawa or not.
     *
     * @param Request $request the request to check
     *
     * @return bool true if the request from Kagawa
     *
     * @throws InvalidDatabaseException
     */
    private function isFromKagawa(Request $request): bool
    {
        $city = $this->geoIpService->getCity($request->getClientIp());
        $country = $city->country;

        /** @var Subdivision $prefecture */
        $prefecture = $city->subdivisions[0];

        return $country->isoCode === 'JP' && $prefecture->isoCode === '37';
    }
}
