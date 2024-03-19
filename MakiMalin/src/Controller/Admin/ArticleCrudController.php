<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('nom'),
            ImageField::new('image')->setUploadDir('/public/uploads/images')->setBasePath('uploads/images')->setLabel('Image'),
            MoneyField::new('prix')->setCurrency('EUR'),
            TextField::new('description'),
            AssociationField::new('categorie_id'),
            AssociationField::new('magasin')
        ];
    }
}
