<?php

namespace AppBundle\Form\Type;

use libphonenumber\PhoneNumberFormat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class VoterProfileValidationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('zipCode', null, array('label' => 'label.zipCode'))
            ->add('phoneNumber', 'tel', array(
                'default_region' => 'FR',
                'format' => PhoneNumberFormat::NATIONAL,
                'label' => 'label.phoneNumber',
            ))
            ->add('correctInformation', 'checkbox', array(
                'mapped' => false,
                'constraints' => array(new NotBlank()),
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
            'validation_groups' => array('freeze'),
        ));
    }

    public function getName()
    {
        return 'voter_profile_validation';
    }
}
