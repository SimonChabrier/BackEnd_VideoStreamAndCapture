<?php

namespace App\Controller\Admin;

use App\Entity\Picture;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PictureCrudController extends AbstractCrudController
{
    /**
     * Set the entity we use 
     * @return string
     */
    public static function getEntityFqcn(): string
    {
        return Picture::class;
    }

    /**
     * This crud global config.
     * https://symfony.com/bundles/EasyAdminBundle/current/crud.html#search-order-and-pagination-options
     */
    public function configureCrud(Crud $crud): Crud
    {
        return $crud

            ->setSearchFields(['createdAt'])
            ->setDefaultSort(['createdAt' => 'DESC'])
            // Si je n'ai pas fermé la visibilité dans la sidebar dans AdminController.php : configureMenuItems()
            // alors, ici je peux aussi décider de cacher le contenu de ce CRUD aux rôle non autorisés
            ->setEntityPermission('ROLE_ADMIN')
            ->setPaginatorPageSize(30)
            ->setPaginatorRangeSize(4)
            // https://www.doctrine-project.org/projects/doctrine-orm/en/2.7/tutorials/pagination.html
            // ->setPaginatorUseOutputWalkers(true)
            // ->setPaginatorFetchJoinCollection(true)
        ;
    }

    /**
     * This crud hide actions
     * @return Actions
     */
    public function configureActions(Actions $actions): Actions
    {
        return $actions

            ->disable(Action::NEW, Action::EDIT);
    }

    /**
     * This crud displayed fields
     * @return iterable
     */
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            ImageField::new('pictureFile')
                ->setBasePath('media/cache/portrait/assets/upload/pictures'),
            TextField::new('pictureFile'),
            DateField::new('createdAt'),
            TextField::new('lat'),
            TextField::new('lng'),
        ];
    }

    /**
     * This crud Filters
     * @return Filters
     */
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('createdAt')
            ->add('pictureFile')
        ;
    }
}
