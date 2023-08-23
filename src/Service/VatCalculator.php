<?php 

namespace App\Service;

class VatCalculator
{
    private $history = [];

    private $vatRate = 0;
    private $vatAmount = 0.00;

    public function setVatRate(float $vatRate): void
    {
        $this->vatRate = $vatRate;
    }

    public function setVatAmount(float $vatAmount): void
    {
        $this->vatAmount = $vatAmount;
    }

    public function calculateTotalAmount(float $amount, float $vatAmount, bool $incVat): float
    {
        if ($incVat) {
            // Calculate total amount for inclusive VAT
            return $amount + $vatAmount;
        } else {
            // Calculate total amount for exclusive VAT
            return $amount + $vatAmount;
        }
    }

    public function calculateVatAmount(float $amount, float $vatRate, bool $incVat): float
    {
        if ($incVat) {
            // Calculate the VAT amount for inclusive VAT
            return $amount * ($vatRate / (100 + $vatRate));
        } else {
            // Calculate the VAT amount for exclusive VAT
            return $amount * ($vatRate / 100);
        }
    }

    public function getHistory()
    {
        return $this->history;
    }

    public function clearHistory()
    {
        $this->history = [];
    }
}
