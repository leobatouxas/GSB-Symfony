<?php

namespace App\Controller\Admin;

use App\Entity\Employee;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EmployeeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Employee::class;
    }
    

    
    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('employeeType'),
            TextField::new('username'),
            TextField::new('password'),
            TextField::new('firstname'),
            TextField::new('lastname'),
            TextField::new('city'),
            TextField::new('postalcode')
        ];
    }
    
}
