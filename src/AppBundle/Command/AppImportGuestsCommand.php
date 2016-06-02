<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use DomainBundle\Entity\Guest;

class AppImportGuestsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:import:guests')
            ->setDescription('import guests from CSV-file')
            ->addArgument('file', InputArgument::REQUIRED, 'path to CSV-file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = $input->getArgument('file');
        if ( ! file_exists($file)) {
            throw new \RuntimeException('Couldn`t find a file "' . $file . '"');
        }

        $output->writeln('Parsing "' . $file . '"…');

        $rows = [];
        if (($fh = fopen($file, "r")) !== false) {
            while (($row = fgetcsv($fh)) !== false) {
                $rows[] = $row;
            }
            fclose($fh);
        }

        $output->writeln("Importing " . count($rows) . " rows…");

        $objectManager = $this->getContainer()->get('doctrine')->getManager();
        foreach ($rows as $row) {
            $fullname = $row[0];
            $birthday = $row[1];
            $guest = new Guest();
            $guest->setFullname($fullname)
                ->setBirthday(new \DateTime($birthday));
            $objectManager->persist($guest);

            unset($row, $fullname, $birthday, $guest);
        }

        $output->writeln('Flushing…');
        $objectManager->flush();
        $output->writeln('Success.');
    }

}
