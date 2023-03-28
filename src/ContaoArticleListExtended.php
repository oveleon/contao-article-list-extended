<?php

namespace Oveleon\ContaoArticleListExtended;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ContaoArticleListExtended extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
