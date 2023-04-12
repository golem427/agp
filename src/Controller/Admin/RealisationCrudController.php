<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Entity\Realisation;
use App\Form\AttachmentType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class RealisationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Realisation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return
            [
                TextField::new('nom'),
                SlugField::new('slug')->setTargetFieldName('nom')->onlyOnForms(),
                TextEditorField::new('description')->hideOnIndex(),
                ImageField::new('thumbnail')
                    ->setBasePath('public/uploads')
                    ->setUploadDir('public/uploads/thumbnails')
                    ->setUploadedFileNamePattern('[randomhash].[extension]'),
                CollectionField::new('attachments')->setEntryType(AttachmentType::class)->onlyOnForms()
                    ->setFormTypeOption('by_reference', false),
                CollectionField::new('attachments')->setTemplatePath('images/images.html.twig')->onlyOnDetail(),
                DateField::new('createdAt')->hideOnForm(),
                BooleanField::new('portfolio'),
                AssociationField::new('categorie'),
            ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['createdAt' => 'DESC']);
    }
}
