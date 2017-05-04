<?php

namespace WorldBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class WorldBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
