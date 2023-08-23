<?php
// src/Entity/CalculationHistory.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class CalculationHistory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $amount;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $vatRate;

    private $vatAmount;

  
    private $totalAmount;


    private $incVat;

    // Getter and setter methods for properties
    

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVatAmount(): ?float
    {
        return $this->vatAmount;
    }

    public function setVatAmount(float $vatAmount): self
    {
        $this->vatAmount = $vatAmount;

        return $this;
    }
    public function getVatRate(): ?float
    {
        return $this->vatRate;
    }

    public function setVatRate(float $vatRate): self
    {
        $this->vatRate = $vatRate;

        return $this;
    } 
    
    public function getTotalAmount(): ?float
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(float $totalAmount): self
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }
    public function getIncVat(): ?bool
    {
        return $this->incVat;
    }

    public function setIncVat(bool $incVat): self
    {
        $this->incVat = $incVat;
        return $this;
    }
    

}
