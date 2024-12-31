<?php

namespace App\Controller\Admin;

use App\Entity\Sorte;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class SorteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Sorte::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            
            TextField::new('name'),
            MoneyField::new('einkaufspreis_pro_kg')->setCurrency('EUR'),
            MoneyField::new('verkaufspreis_1g')->setCurrency('EUR'),
            MoneyField::new('verkaufspreis_05g')->setCurrency('EUR'),
        ];
    }
    
}
