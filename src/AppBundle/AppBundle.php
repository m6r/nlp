<?php

namespace AppBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use AppBundle\DependencyInjection\Compiler\ElectionRulesCompilerPass;

class AppBundle extends Bundle
{
    public function boot()
    {
        $this
            ->container
            ->get('doctrine.dbal.default_connection')
            ->getDatabasePlatform()
            ->registerDoctrineTypeMapping('enum', 'string')
        ;
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ElectionRulesCompilerPass());
    }
}
