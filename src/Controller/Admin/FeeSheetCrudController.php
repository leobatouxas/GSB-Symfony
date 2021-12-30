<?php

namespace App\Controller\Admin;

use App\Entity\FeeSheet;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class FeeSheetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return FeeSheet::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            DateField::new('date'),
            NumberField::new('nbDocuments'),
            AssociationField::new('state'),
            AssociationField::new('employee')
        ];
    }
    
}
