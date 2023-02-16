<?php

namespace App\Controller\Admin;

use App\Entity\Realisation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;


class RealisationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Realisation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom'),
            TextareaField::new('description')->hideOnIndex(),
            DateField::new('createdAt'),
            // NumberField::new('largeur')->hideOnIndex(),
            // NumberField::new('longueur')->hideOnIndex(),
            // NumberField::new('prix')->hideOnIndex(),
            // BooleanField::new('enVente')->hideOnIndex(),
            BooleanField::new('portfolio'),
            TextField::new('imageFile')->setFormType(VichImageType::class)->onlyWhenCreating(),
            ImageField::new('file')->setBasePath('uploads/realisations')->onlyOnIndex(),
            SlugField::new('slug')->setTargetFieldName('nom')->hideOnIndex(),
            AssociationField::new('categorie'),
        ];
    }
    public function configureCrud(Crud $crud):Crud
    {       
        return $crud->setDefaultSort(['createdAt'=>'DESC']);
    }
}
