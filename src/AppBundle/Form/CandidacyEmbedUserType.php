<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CandidacyEmbedUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gender', 'choice', array(
                'expanded' => true,
                'choices' => array('F' => 'F', 'M' => 'M'),
            ))
            ->add('firstName')
            ->add('lastName')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
            'validation_groups' => array('candidacy'),
        ));
    }

    public function getName()
    {
        return 'candidacy_embed_user';
    }
}
