<?php

declare(strict_types=1);

namespace Siketyan\KagawaBundle;

use Siketyan\KagawaBundle\DependencyInjection\SiketyanKagawaBundleExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SiketyanKagawaBundle extends Bundle
{
    public function getContainerExtension()
    {
        return $this->extension ?? ($this->extension = new SiketyanKagawaBundleExtension());
    }
}
