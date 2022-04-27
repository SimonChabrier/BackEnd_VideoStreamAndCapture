<?php

namespace App\Controller\Admin;


use App\Entity\Picture;
//use DateTime;
//use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
//use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
// use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
     *
     * @return string
     */
    public static function getEntityFqcn(): string
    {
        return Picture::class;
    }

    //configuration du CRUD
    //todo il faut faire un form 
    //todo An error has occurred resolving the options of the form "Symfony\Bridge\Doctrine\Form\Type\EntityType": The required option "class" is missing.
    public function configureCrud(Crud $crud): Crud
    {
        return $crud

            ->setSearchFields(['createdAt'])
            ->setDefaultSort(['createdAt' => 'DESC'])
        ;
    }

    // On détermine quels filtres apparaissent au dessus du champ de recherche
    // Comme je n'ai pas de fomulaire pour uploader une image ça ne peut pas être utilisé actuellement.
    // je n'ai pas de raltions on plus pour déterminer des filtres.
    // public function configureFilters(Filters $filters): Filters
    // {
    //     return $filters
    //         ->add(EntityFilter::new('picture'))
    //     ;
    // }

    //champs affichés dans l'admin du crud
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            ImageField::new('pictureFile')
            ->setBasePath('media/cache/portrait/assets/upload/pictures'),
            //->setUploadDir('assets/upload/pictures'),
            DateField::new('createdAt'),
            TextField::new('lat'),
            TextField::new('lng'),
        ];

    }

}
