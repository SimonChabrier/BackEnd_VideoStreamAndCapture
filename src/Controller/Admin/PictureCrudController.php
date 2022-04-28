<?php

namespace App\Controller\Admin;

use App\Entity\Picture;
// use DateTime;
// use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
// use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
// use Symfony\Bridge\Doctrine\Form\Type\EntityType;

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

    public function configureCrud(Crud $crud): Crud
    {
        return $crud

            ->setSearchFields(['createdAt'])
            ->setDefaultSort(['createdAt' => 'DESC'])
        ;
    }

    /**
     * Hide actions on admin panel
     * @return Actions
     */
    public function configureActions(Actions $actions): Actions
    {
        return $actions

        ->disable(Action::NEW, Action::EDIT)
        ;
    }

    /**
     * Configure displayed fields
     * @return iterable
     */
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            ImageField::new('pictureFile')->setBasePath('media/cache/portrait/assets/upload/pictures'),
            DateField::new('createdAt'),
            TextField::new('lat'),
            TextField::new('lng'),
        ];

    }

}
