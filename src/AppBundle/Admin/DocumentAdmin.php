<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class DocumentAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('documentType', 'sonata_type_model', [
                'required' => true,
                'btn_add' => false,
                'label' => 'Тип'
            ])
            ->add('number', null, [
                'label' => 'Номер'
            ])
            ->add('date', 'sonata_type_date_picker', [
                'required' => false,
                'label' => 'Дата'
            ])
            ->add('data', null, [
                'label' => 'Дополнительно'
            ]);
        if ( ! $this->hasParentFieldDescription()) {
            $formMapper->add('guest', 'sonata_type_model_autocomplete', [
                'property' => 'fullname',
                'label' => 'Гость'
            ]);
        }
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id')
            ->add('documentType.name', null, [
                'label' => 'Тип документа'
            ])
            ->add('number', null, [
                'label' => 'Номер'
            ])
            ->add('date', null, [
                'label' => 'Дата'
            ])
            ->add('_action', 'actions', [
                'actions' => [
                    'edit' => []
                ]
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('number', null, [
            'label' => 'Номер'
        ])
            ->add('date', null, [
                'label' => 'Дата'
            ])
            ->add('documentType', null, [
                'label' => 'Тип документа'
            ]);
    }

}
