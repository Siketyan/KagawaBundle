<?php

declare(strict_types=1);

namespace Siketyan\KagawaBundle\EventListener;

use MaxMind\Db\Reader\InvalidDatabaseException;
use Siketyan\KagawaBundle\Service\KagawaService;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

class ControllerListener
{
    /**
     * @var KagawaService
     */
    private $kagawaService;

    public function __construct(KagawaService $kagawaService)
    {
        $this->kagawaService = $kagawaService;
    }

    /**
     * Listens the kernel controller event.
     *
     * @param ControllerEvent $event the event arguments
     *
     * @throws InvalidDatabaseException
     *
     * @noinspection PhpUnused
     */
    public function onKernelController(ControllerEvent $event): void
    {
        $controller = $this->kagawaService->route(
            $event->getRequest(),
            $event->getController()
        );

        $event->setController($controller);
    }
}
