<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Repository\PictureRepository;
use Doctrine\ORM\EntityManagerInterface;

class GeneratePictures extends Command
{
    protected static $defaultName = 'generate:picture';

    private $pictureRepository;
    private $entityManagerInterface;

    public function __construct(PictureRepository $pictureRepository, EntityManagerInterface $entityManagerInterface)
    {
        $this->pictureRepository = $pictureRepository; 
        $this->entityManagerInterface = $entityManagerInterface;   

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->info(sprintf('On démarre'));

        $imgs = $this->pictureRepository->findAll();

        foreach ($imgs as $imgItem) {

            $pictureFile = $imgItem->getPictureFile();

            if ($pictureFile) {
                //je ne fait rien sil y a déjà une valeur dans pictureFile
            } else {

                $img = $imgItem->getPicture();
                    
                $img = str_replace('data:image/jpeg;base64,', '', $img);
                $img = str_replace(' ', '+', $img);
                $data = base64_decode($img);
                $newFileName = uniqid() . '.jpeg';
                $file = "public/assets/upload/pictures/" . $newFileName;
                $success = file_put_contents($file, $data);
                    
                $img = $imgItem->setPictureFile($newFileName);
    
                $io->success('Résultat : ' . $img->getPictureFile($newFileName));
  
            }
        }

   
         $this->entityManagerInterface->flush();

         //message de sortie
         $io->success(sprintf('Terminé'));
         return Command::SUCCESS; 

      
    }
}

// bin/console regenerate-app-secret to generate a new app secret