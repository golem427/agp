<?php

namespace App\Controller\Admin;

use App\Entity\Blogpost;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
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
            TextField::new('titre'),
            TextEditorField::new('contenu'),
            DateField::new('createdAt'),
            TextField::new('imageFile')->setFormType(VichImageType::class)->onlyWhenCreating(),
            ImageField::new('file')->setBasePath('uploads/blogposts')->onlyOnIndex(),
            SlugField::new('slug')->setTargetFieldName('titre')->hideOnIndex(),
        ];
    }
    
    public function configureCrud(Crud $crud):Crud
    {       
        return $crud->setDefaultSort(['createdAt'=>'DESC']);
    }
}
