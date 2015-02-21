<?php

namespace AppBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class ElectionRulesCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('app.election_ruler')) {
            return;
        }

        $definition = $container->getDefinition(
            'app.election_ruler'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'app.election_rule'
        );

        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall(
                'addElectionRule',
                array(new Reference($id))
            );
        }
    }
}
