<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class RoomCategoryAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->with('Основное')
            ->add('name', null, [
                'label' => 'Имя'
            ])
            ->add('price', 'tbbc_money', [
                'label' => 'Цена'
            ])
            ->add('class', null, [
                'label' => 'Классификатор'
            ])
            ->end()
            ->with('Дополнительное')
            ->add('rooms', 'sonata_type_collection', [
                'by_reference' => false,
                'label' => 'Комнаты'
            ], [
                'edit' => 'inline',
                'inline' => 'table'
            ])
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name', null, [
            'label' => 'Имя'
        ])
            ->add('class', null, [
                'label' => 'Классификатор'
            ]);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name', null, [
            'label' => 'Имя'
        ])
            ->addIdentifier('class', null, [
                'label' => 'Классификатор'
            ])
            ->add('price', 'money', [
                'label' => 'Цена'
            ]);
    }

}
