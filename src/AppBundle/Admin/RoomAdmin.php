<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class RoomAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('name', null, [
            'label' => 'Имя'
        ])
            ->add('isAvailable', null, [
                'label' => 'Доступна'
            ])
            ->add('comment', null, [
                'label' => 'Комментарий'
            ]);
        if ( ! $this->hasParentFieldDescription()) {
            $formMapper->add('roomCategory', 'sonata_type_model', [
                'by_reference' => false
            ]);
        }
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id')
            ->addIdentifier('name', null, [
                'label' => 'Имя'
            ])
            ->add('isAvailable', null, [
                'editable' => true,
                'label' => 'Доступна'
            ])
            ->add('roomCategory.name', null, [
                'label' => 'Категория'
            ])
            ->add('roomCategory.class', null, [
                'label' => 'Классификатор'
            ])
            ->add('_action', 'actions', [
                'actions' => [
                    'edit' => []
                ]
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name', null, [
            'label' => 'Имя'
        ])
            ->add('roomCategory.class', null, [
                'label' => 'Классификатор'
            ]);
    }

}
