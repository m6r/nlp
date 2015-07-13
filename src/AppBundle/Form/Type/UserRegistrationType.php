<?php

namespace AppBundle\Form\Type;

use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Symfony\Component\Form\FormBuilderInterface;

class UserRegistrationType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', null, array('label' => 'label.firstName'))
            ->add('lastName', null, array('label' => 'label.lastName'))
        ;
        parent::buildForm($builder, $options);
        $builder
            ->add('phoneNumber', 'tel', array(
                'default_region' => 'FR',
                'label' => 'label.phoneNumber',
            ))
            ->add('zipCode', null, array('label' => 'label.zipCode', 'required' => true))
            ->add('city', null, array('label' => 'label.city'))
            ->add('country', null, array('label' => 'label.country', 'preferred_choices' => array('FR')))
            ->add('birthDate', 'birthday', array('label' => 'label.birthDate'))
        ;
    }

    public function getName()
    {
        return 'user_registration';
    }
}
