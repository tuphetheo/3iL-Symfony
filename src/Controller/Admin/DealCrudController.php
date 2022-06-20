<?php

namespace App\Controller\Admin;

use App\Entity\Deal;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DealCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Deal::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            TextEditorField::new('description'),
            DateTimeField::new('created_at')->hideOnForm(),
            DateTimeField::new('updated_at')->hideOnForm(),
            BooleanField::new('enabled'),
            MoneyField::new('price')->setCurrency('EUR'),
            AssociationField::new('categories')->setFormTypeOption('by_reference', false),
        ];
    }

}
