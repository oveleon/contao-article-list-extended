<?php

declare(strict_types=1);

namespace Oveleon\ContaoArticleListExtended\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Oveleon\ContaoArticleListExtended\ContaoArticleListExtended;

class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(ContaoArticleListExtended::class)
                ->setLoadAfter([ContaoCoreBundle::class,])
                ->setReplace(['contao-article-list-extended'])
        ];
    }
}
