<?php
namespace Bongers\ElsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Bongers\ElsBundle\ParamConverter\ParamConverterCompiler;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 *
 */
class ElsBundle extends Bundle
{
    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ParamConverterCompiler());
    }
}
