<?php

namespace AppBundle;

use AppBundle\DependencyInjection\Compiler\ElectionRulesCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

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
