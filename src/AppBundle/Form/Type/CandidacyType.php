<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class CandidacyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description')
            ->add('user', new CandidacyEmbedUserType())
            ->add('confirmation', 'checkbox', array(
                'mapped' => false,
                'constraints' => array(new NotBlank()),
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Poll\Candidacy',
            'validation_groups' => array('candidacy', 'Default'),
        ));
    }

    public function getName()
    {
        return 'candidacy';
    }
}
