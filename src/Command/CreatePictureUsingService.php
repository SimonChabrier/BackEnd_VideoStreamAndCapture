<?php

namespace App\Command;

use App\Service\jpegConverterService;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PictureRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


class CreatePictureUsingService extends Command
{
    protected static $defaultName = 'generate:picture:service';

    private $pictureRepository;
    private $jpegConverterService;
    private $entityManagerInterface;

    public function __construct(PictureRepository $pictureRepository, jpegConverterService $jpegConverterService, EntityManagerInterface $entityManagerInterface)
    {
        $this->pictureRepository = $pictureRepository; 
        $this->entityManagerInterface = $entityManagerInterface;   
        $this->jpegConverterService = $jpegConverterService;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->info(sprintf('On démarre'));

        $imgages = $this->pictureRepository->findAll();

        foreach ($imgages as $image) {

            $pictureFile = $image->getPictureFile();

            if ($pictureFile) {

                continue;
                
            } else {

            $image->setPictureFile($this->jpegConverterService->convertPictureService($image->getPicture()));

            $io->success('Résultat : ' . $image->getPictureFile());
  
            }
        }

         $this->entityManagerInterface->flush();

         //message de sortie
         $io->success(sprintf('Terminé'));
         return Command::SUCCESS; 

      
    }
}
