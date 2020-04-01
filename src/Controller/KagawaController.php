<?php

declare(strict_types=1);

namespace Siketyan\KagawaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\Response;

class KagawaController extends AbstractController
{
    /**
     * @var mixed[]
     */
    private $config;

    public function __construct(ContainerBagInterface $container)
    {
        $this->config = $container->get('kagawa.config');
    }

    /**
     * Renders a restricted view.
     *
     * @return Response
     */
    public function view(): Response
    {
        return $this->render('@SiketyanKagawa/Restricted/view.html.twig', [
            'config' => $this->config,
        ]);
    }
}
