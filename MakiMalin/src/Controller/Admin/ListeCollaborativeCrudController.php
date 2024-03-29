<?php

namespace App\Controller\Admin;

use App\Entity\ListeCollaborative;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ListeCollaborativeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ListeCollaborative::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('listeDeCourses'),
            AssociationField::new('utilisateurs'),
        ];
    }
}
