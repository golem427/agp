<?php

namespace App\Controller\Admin;

use App\Entity\Commentaire;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class CommentaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commentaire::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
             AssociationField::new('blogpost'),
             AssociationField::new('realisation'),
             TextField::new('auteur'),
             DateTimeField::new('createdAt'),
             TextareaField::new('contenu'),
             BooleanField::new('isPublished')
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud ->setDefaultSort(['createdAt' => 'DESC'])
                    ->setPageTitle('index', 'commentaire')
                    ->setPageTitle('edit', 'Editer les commentaires');
    }
}
