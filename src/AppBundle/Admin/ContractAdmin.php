<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ContractAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->with('Основное')
            ->add('number', null, [
                'label' => 'Номер'
            ])
            ->add('date', 'sonata_type_date_picker', [
                'label' => 'Дата'
            ])
            ->add('subject', null, [
                'label' => 'Заказчик'
            ])
            ->add('billingAddress', null, [
                'label' => 'Реквизиты'
            ])
            ->end()
            ->with('Счет-фактура')
            ->add('invoice', 'sonata_type_admin', [
                'label' => 'Счет-фактура'
            ])
            ->end();
    }

}
