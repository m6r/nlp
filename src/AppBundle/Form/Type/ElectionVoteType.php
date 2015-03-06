<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Poll\Candidacy;
use AppBundle\Entity\Poll\ElectionVote;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ElectionVoteType extends AbstractType
{
    private $candidacies;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('candidacies', 'entity', array(
                'class' => 'AppBundle:Poll\Candidacy',
                'choices' => $options['candidacies'],
                'expanded' => true,
                'multiple' => true,
                'property' => 'user.username',
                'constraints' => array(
                    new Assert\Count(array('max' => $options['voteNumber'])),
                ),
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Poll\ElectionVote',
        ));
        $resolver->setRequired('candidacies');
        $resolver->setRequired('voteNumber');
    }

    public function getName()
    {
        return 'election_vote';
    }
}
