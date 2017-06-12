<?php

namespace FioulMarket\PriceBundle\Command;

use FioulMarket\PriceBundle\Entity\Energy;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Kevin Nazzari <nazzari.kevin@gmail.com>
 *
 * @since  2017-06-08
 */
class ImportCommand extends ContainerAwareCommand
{
    const COLUMN_DELIMITER = ',';
    const COLUMN_DATE = 2;
    const COLUMN_POSTAL_CODE = 0;
    const COLUMN_PRICE = 1;
    const DEFAULT_ENERGY = 'fuel';
    const OPTIMIZED_SIZE = 500;

    protected function configure()
    {
        $this
            ->setName('import:csv')
            ->setDescription('Import de fichier CSV contenant les prix du fuel dans le temps.')
            ->addArgument('filename', InputArgument::REQUIRED, 'Nom du fichier CSV ?')
            ->addArgument('energy', InputArgument::OPTIONAL, 'Energie choisie ? [fuel]')
            ->addOption('details', null, InputOption::VALUE_NONE, 'Option permettant d\'avoir plus de détails lors de l\'exécution (moins performant).')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Debut
        $now = new \DateTime();
        $output->writeln('<comment>Début : '.$now->format('d-m-Y G:i:s').' ---</comment>');

        // Prepare les arguments
        $energy = $this->prepareEnergyArgument($input);
        $path = $this->getContainer()->get('kernel')->getRootDir().'/../var/';
        $filename = $path.$input->getArgument('filename');
        $details = (is_null($input->getOption('details'))) ? false : true;

        // Import
        $this->import($filename, $energy, $details, $output);

        // Fin
        $now = new \DateTime();
        $output->writeln('<comment>Fin : '.$now->format('d-m-Y G:i:s').' ---</comment>');
    }

    /**
     * @param string          $filename
     * @param Energy          $energy
     * @param bool            $details
     * @param OutputInterface $output
     *
     * @return bool
     */
    protected function import($filename, Energy $energy, $details, OutputInterface $output)
    {
        // Manager
        $cityManager = $this->getContainer()->get('fioulmarket.price.manager.city');
        $priceManager = $this->getContainer()->get('fioulmarket.price.manager.price');

        // ProgressBar
        if ($details) {
            $nbLines = $this->countLines($filename);
            $progress = new ProgressBar($output, $nbLines);
            $progress->start();
        }

        $cities = $cityManager->getCitiesByPostalCode();

        if (
            file_exists($filename)
            && is_readable($filename)
            && ($handle = fopen($filename, 'r')) !== false
        ) {
            $row = fgetcsv($handle, 1000, self::COLUMN_DELIMITER); // Header
            $count = 0; // Count ProgressBar

            // Pour chaque ligne
            while (($row = fgetcsv($handle, 1000, self::COLUMN_DELIMITER)) !== false) {
                $postalCode = $row[self::COLUMN_POSTAL_CODE];
                $amount = $row[self::COLUMN_PRICE];
                $date = $row[self::COLUMN_DATE];

                // City (Optimisation : isset mieux que in_array)
                if (isset($cities[$postalCode])) {
                    $city = $cities[$postalCode];
                } else {
                    $city = $cityManager->create($postalCode);
                    $cities[$postalCode] = $city;
                }

                // Price
                $price = $priceManager->create($amount, $city, $energy, $date);
                $priceManager->save($price, false);

                // Optimisation Doctrine
                if (($count % self::OPTIMIZED_SIZE) === 0) {
                    $priceManager->flushAndClear();

                    if ($details) {
                        $progress->advance(self::OPTIMIZED_SIZE);

                        $now = new \DateTime();
                        $output->writeln(' des prix importés ... | '.$now->format('d-m-Y G:i:s'));
                    }
                }

                ++$count;
            }

            $priceManager->flushAndClear();

            fclose($handle);

            // Fin ProgressBar
            if ($details) {
                $progress->finish();
            }
        } else {
            return false;
        }

        return true;
    }

    /**
     * Compte les lignes (utiles pour la progressbar).
     *
     * @param $filename
     *
     * @return int
     */
    protected function countLines($filename)
    {
        $file = fopen($filename, 'rb');
        $count = 0;

        while (fgets($file) !== false) {
            ++$count;
        }

        fclose($file);

        return $count;
    }

    /**
     * @param InputInterface $input
     *
     * @return Energy
     */
    protected function prepareEnergyArgument(InputInterface $input)
    {
        $energyManager = $this->getContainer()->get('fioulmarket.price.manager.energy');
        $energyName = (empty($input->getArgument('energy'))) ? self::DEFAULT_ENERGY : $input->getArgument('energy');
        $energy = $energyManager->get($energyName);

        if (empty($energy)) {
            $energy = $energyManager->save($energyName);
        }

        return $energy;
    }
}
