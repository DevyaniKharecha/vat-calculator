<?php

namespace App\Command;

use App\Service\VatCalculator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CalculateVatCommand extends Command
{
    protected static $defaultName = 'app:calculate-vat';
    private $vatCalculator;

    public function __construct(VatCalculator $vatCalculator)
    {
        parent::__construct();
        $this->vatCalculator = $vatCalculator;
    }

    protected function configure()
    {
        $this->setDescription('Calculate VAT');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Implement calculation logic using $this->vatCalculator
        // Store calculations in history
    }
}
