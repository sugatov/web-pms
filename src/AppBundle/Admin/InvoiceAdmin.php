<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class InvoiceAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->with('Основное')
            ->add('isClosed', null, [
                'label' => 'Закрыта'
            ])
            ->end()
            ->with('Дополнительное')
            ->add('services', 'sonata_type_collection', [
                'by_reference' => false,
                'label' => 'Услуги'
            ], [
                'edit'=>'inline',
                'inline'=>'table'
            ])
            ->end();
    }

}
