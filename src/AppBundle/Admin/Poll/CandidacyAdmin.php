<?php

namespace AppBundle\Admin\Poll;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CandidacyAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('description')
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('user')
            ->add('election')
            ->add('description')
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('user', 'doctrine_orm_callback', array(
                'callback' => function ($queryBuilder, $alias, $field, $value) {
                    if (empty($value['value'])) {
                        return;
                    }

                    $queryBuilder->leftJoin(sprintf('%s.user', $alias), 'u');
                    $queryBuilder->where('u.username LIKE :username');
                    $queryBuilder->setParameter('username', '%'.$value['value'].'%');

                    return true;
                },
                'field_type' => 'text',
            ))
            ->add('election')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('user')
            ->add('election')
            ->add('created')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                ),
            ))
        ;
    }
}
