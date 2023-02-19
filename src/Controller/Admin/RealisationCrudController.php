<?php

namespace App\Controller\Admin;

use App\Entity\Realisation;
use App\Form\AttachmentType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
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
        $imageFile = ImageField::new('attachment')->setFormType(VichImageType::class);
        $image = ImageField::new('image')->setBasePath('uploads/thumbnails');

        return
            [
                TextField::new('nom'),
                SlugField::new('slug')->setTargetFieldName('nom')->hideOnIndex(),
                TextareaField::new('description')->hideOnIndex(),
                ImageField::new('image', 'image: l : 800px par h : 1200px')
                ->setBasePath('uploads/')
                ->setUploadDir('public/uploads')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
                TextField::new('attachments')->setFormType(VichImageType::class),
                CollectionField::new('attachments')->setEntryType(AttachmentType::class)->onlyOnForms(),
                CollectionField::new('attachments')->setTemplatePath('images.html.twig')->onlyOnDetail(),
                DateField::new('createdAt'),
                BooleanField::new('portfolio'),
                AssociationField::new('categorie'),
            ];

        if ($pageName == Crud::PAGE_INDEX || $pageName == Crud::PAGE_DETAIL) {
            $fields[] = $image;
        } else {
            $fields[] = $imageFile;
        }
        return $fields;
    }


    public function configureActions(Actions $actions): Actions
    {
        return $actions->add('index', 'detail');
    }
}
