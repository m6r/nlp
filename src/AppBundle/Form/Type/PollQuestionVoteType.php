<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class PollQuestionVoteType extends AbstractType
{
    private $candidacies;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $question = $event->getData()->getQuestion();
            $form = $event->getForm();

            $form->add('choice', 'entity', array(
                'label' => $question->getText(),
                'class' => 'AppBundle:Poll\PollChoice',
                'choices' => $question->getChoices(),
                'expanded' => true,
                'multiple' => false,
                'property' => 'description'
            ));
        });
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Poll\PollQuestionVote',
        ));
    }

    public function getName()
    {
        return 'poll_question_vote';
    }
}
