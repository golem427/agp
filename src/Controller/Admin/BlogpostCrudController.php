<?php

namespace App\Controller\Admin;

use App\Entity\Blogpost;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BlogpostCrudController extends AbstractCrudController

{
    public static function getEntityFqcn(): string
    {
        return Blogpost::class;
    }

    public function configureFields(string $pageName): iterable
    {
            return [
            IdField::new('id')->hideOnForm(),
            TextField::new('titre'),
            TextField::new('slug'),
            TextEditorField::new('contenu'),
            DateField::new('createdAt'),
        ];
    }
    
    public function configureCrud(Crud $crud):Crud
    {       
        return $crud->setDefaultSort(['createdAt'=>'DESC']);
    }
}
