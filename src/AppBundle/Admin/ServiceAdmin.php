<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ServiceAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->with('Основное')
            ->add('date', 'sonata_type_date_picker', [
                'label' => 'Дата'
            ])
            ->add('price', 'tbbc_money', [
                'label' => 'Стоимость'
            ])
            ->end();
    }

}
