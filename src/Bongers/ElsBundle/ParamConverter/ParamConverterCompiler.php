<?php
namespace Bongers\ElsBundle\ParamConverter;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class ParamConverterCompiler implements CompilerPassInterface
{
    const TAG = 'param_converter';

    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition(self::TAG)) {
            return;
        }

        $definition = $container->getDefinition(self::TAG);

        foreach ($container->findTaggedServiceIds(self::TAG) as $id => $attributes) {
            $definition->addMethodCall('addProvider', array(new Reference($id)));
        }
    }
}