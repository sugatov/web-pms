<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class GuestAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->with('Основное')
            ->add('fullname', null, [
                'label' => 'Полное имя'
            ])
            ->add('birthday', 'sonata_type_date_picker', [
                'label' => 'Дата рождения'
            ])
            ->add('comment', null, [
                'label' => 'Комментарий'
            ])
            ->end()
            ->with('Дополнительное')
            ->add('documents', 'sonata_type_collection',[
                'by_reference' => false,
                'label' => 'Документы'
            ], [
                'edit'=>'inline',
                'inline'=>'table'
            ])
            ->end();
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id')
            ->add('fullname', null, [
                'label' => 'Полное имя'
            ])
            ->add('birthday', null, [
                'label' => 'Дата рождения'
            ])
            ->add('_action', 'actions', [
                'actions' => [
                    'edit' => []
                ]
            ]);
    }

    // FIXME: sonata_type_filter_date
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('fullname', null, [
            'label' => 'Полное имя'
        ])
            ->add('birthday'/*, 'sonata_type_filter_date'*/, null, [
                'label' => 'Дата рождения'
            ]);
    }

}
