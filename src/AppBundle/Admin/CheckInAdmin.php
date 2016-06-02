<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class CheckInAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->with('Основное')
            ->add('arrivalDate', 'sonata_type_date_picker', [
                'label' => 'Дата приезда'
            ])
            ->add('departureDate', 'sonata_type_date_picker', [
                'label' => 'Дата отъезда'
            ])
            ->end()
            ->with('Дополнительное')
            ->add('guests', 'sonata_type_model_autocomplete', [
                'multiple' => true,
                'by_reference' => false,
                'property' => 'fullname',
                'label' => 'Гости'
            ])
            ->add('contracts', 'sonata_type_collection', [
                'by_reference' => false,
                'label' => 'Договоры'
            ], [
                'edit'=>'inline'
            ])
            ->end();
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id')
            ->add('arrivalDate')
            ->add('departureDate')
            ->add('_action', 'actions', [
                'actions' => [
                    'edit' => []
                ]
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('arrivalDate')
            ->add('departureDate');
    }

}
