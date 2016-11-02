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

namespace spec\BenGorUser\TwigBridgeBundle;

use BenGorUser\TwigBridgeBundle\TwigBridgeBundle;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Spec file of TwigBridgeBundle class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class TwigBridgeBundleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(TwigBridgeBundle::class);
    }

    function it_extends_symfony_bundle()
    {
        $this->shouldHaveType(Bundle::class);
    }

    function it_builds_without_dependent_bundles_enabled(ContainerBuilder $container)
    {
        $this->shouldThrow(RuntimeException::class)->duringBuild($container);
    }

    function it_builds(ContainerBuilder $container)
    {
        $container->getParameter('kernel.bundles')->shouldBeCalled()->willReturn([
            'BenGorUserBundle' => 'BenGorUser\\UserBundle\\BenGorUserBundle',
            'TwigBundle'       => 'Symfony\\Bundle\\TwigBundle\\TwigBundle',
        ]);

        $container->loadFromExtension('framework', Argument::type('array'))->shouldBeCalled()->willReturn($container);
        $container->loadFromExtension('twig', Argument::type('array'))->shouldBeCalled()->willReturn($container);

        $this->build($container);
    }
}
