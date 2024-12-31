<?php

namespace App\Controller\Admin;

use App\Entity\Einkauf;
use App\Entity\Sorte;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;


class EinkaufCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Einkauf::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // ...
            ->showEntityActionsInlined()
        ;
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            ArrayField::new('sorte'),
            TextField::new('menge_kg'),
            DateField::new('datum')->renderAsNativeWidget(true)
        ];
    }
    
}
