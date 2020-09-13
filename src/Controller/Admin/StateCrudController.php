<?php

namespace App\Controller\Admin;

use App\Entity\State;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class StateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return State::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('name');
        $country = AssociationField::new('country');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $country];
        }
        if (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $name, $country];
        }
        if (Crud::PAGE_NEW === $pageName) {
            return [$name, $country];
        }
        if (Crud::PAGE_EDIT === $pageName) {
            return [$name, $country];
        }
    }
}
