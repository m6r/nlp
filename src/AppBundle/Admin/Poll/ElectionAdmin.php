<?php
namespace AppBundle\Admin\Poll;

use AppBundle\Poll\ElectionRuler;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class ElectionAdmin extends Admin
{
    /**
     * @var ElectionRuler
     */
    private $ruler;

    /**
     * @var array
     */
    private $ruleGroups;

    /**
     * @var array
     */
    private $ruleCriterias;

    public function __construct($code, $class, $baseControllerName, ElectionRuler $ruler)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->ruler = $ruler;
        $this->ruleGroups = array_keys($this->ruler->getValidCriterias());
        $this->ruleCriterias = array();
        foreach ($this->ruler->getValidCriterias() as $group => $criterias) {
            foreach ($criterias as $criteria) {
                if (array_key_exists($criteria, $this->ruleCriterias)) {
                    $newLabel = str_replace(')', ', '.$group.')', $this->ruleCriterias[$criteria]);
                    $this->ruleCriterias[$criteria] = $newLabel;
                } else {
                    $this->ruleCriterias[$criteria] = $criteria.' ('.$group.')';
                }
            }
        }
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('description')
            ->add('group', 'choice', array(
                'choices' => $this->ruleGroups,
                'label' => 'Rules group'
            ))
            ->add('criteria', 'choice', array(
                'choices' => $this->ruleCriterias,
                'label' => 'Rules criteria'
            ))
            ->add('openCandidacyDate')
            ->add('closeCandidacyDate')
            ->add('openDate')
            ->add('closeDate')
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('group')
            ->add('criteria')
            ->add('openCandidacyDate')
            ->add('closeCandidacyDate')
            ->add('openDate')
            ->add('closeDate')
        ;
    }
}
