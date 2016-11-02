<?php

/*
 * This file is part of the BenGorUser package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BenGorUser\TwigBridgeBundle;

use BenGorUser\UserBundle\DependentBenGorUserBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Twig bridge bundle kernel class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class TwigBridgeBundle extends Bundle
{
    use DependentBenGorUserBundle;

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $this->checkDependencies(['BenGorUserBundle', 'TwigBundle'], $container);

        $container->loadFromExtension('framework', [
            'translator' => [
                'paths' => [
                    $this->basePath() . '/Translations',
                ],
            ],
        ]);
        $container->loadFromExtension('twig', [
            'paths' => [
                $this->basePath() . '/Twig/views' => 'bengor_user',
            ],
        ]);
    }

    /**
     * Gets the base path obtained via reflection,
     * agnostic to the Symfony root dir location.
     *
     * @return string
     */
    private function basePath()
    {
        $directory = dirname((new \ReflectionClass(self::class))->getFileName());

        return $directory . '/../../../../twig-bridge/src/BenGorUser/TwigBridge/Infrastructure/Ui';
    }
}
