<?php

namespace AppBundle\Admin;

use libphonenumber\PhoneNumberFormat;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class UserAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('email')
            ->add('enabled', null, array('required' => false))
            ->add('locked', null, array('required' => false))
            ->add('phoneNumber', 'tel', array(
                'default_region' => 'FR',
                'format' => PhoneNumberFormat::NATIONAL,
                'label' => 'label.phoneNumber',
            ))
            ->add('phoneConfirmed', null, array('required' => false))
            ->add('firstName')
            ->add('lastName')
            ->add('gender')
            ->add('postCode')
            ->add('city')
            ->add('country')
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('email')
            ->add('username')
            ->add('enabled')
            ->add('locked')
            ->add('phoneNumber', 'tel', array(
                'default_region' => 'FR',
                'format' => PhoneNumberFormat::NATIONAL,
                'label' => 'label.phoneNumber',
            ))
            ->add('phoneConfirmed')
            ->add('firstName')
            ->add('lastName')
            ->add('gender')
            ->add('postCode')
            ->add('city')
            ->add('country')
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('username')
            ->add('email')
            ->add('phoneNumber')
            ->add('enabled')
            ->add('phoneConfirmed')
            ->add('locked')
            ->add('firstName')
            ->add('lastName')
            ->add('gender')
            ->add('city')
            ->add('country')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('username')
            ->add('email')
            ->add('enabled')
            ->add('locked')
            ->add('phoneNumber')
            ->add('phoneConfirmed')
            ->add('firstName')
            ->add('lastName')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                ),
            ))
        ;
    }
}
