<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class PollVoteType extends AbstractType
{
    private $candidacies;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $vote = $builder->getData();

        $builder->add('questionVotes', 'collection', array(
            'type' => new PollQuestionVoteType(),
            'options' => array('label' => ' '),
            'label' => ' '
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Poll\PollVote',
        ));
    }

    public function getName()
    {
        return 'poll_vote';
    }
}
