<?php

namespace App\Controller\Admin;

use App\Entity\Blogpost;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class BlogpostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Blogpost::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return
        [
        TextField::new('titre'),
        TextareaField::new('contenu'),
        DateField::new('createdAt')->hideOnForm(),
        TextField::new('imageFile')->setFormType(VichImageType::class)->onlyWhenCreating(),
        ImageField::new('file')->setBasePath('uploads/blogposts')->onlyOnIndex(),
        SlugField::new('slug')->setTargetFieldName('titre')->hideOnIndex(),
        ];
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['createdAt'=>'DESC']);
    }
}
