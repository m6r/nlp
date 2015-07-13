<?php

namespace AppBundle\Admin\Poll;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class PollQuestionAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('text')
            ->add('poll')
            ->add('choices', 'sonata_type_collection', array(), array(
                'edit' => 'inline',
            ))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('poll')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('text')
            ->add('poll')
        ;
    }

    public function prePersist($pollQuestion)
    {
        $this->preUpdate($pollQuestion);
    }

    public function preUpdate($pollQuestion)
    {
        $choices = $pollQuestion->getChoices();
        if (count($choices) > 0) {
            foreach ($choices as $choice) {
                $choice->setQuestion($pollQuestion);
            }
        }
    }
}
