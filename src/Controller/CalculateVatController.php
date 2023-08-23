<?php

// src/Controller/CalculateVatController.php

namespace App\Controller;

use App\Service\VatCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Entity\CalculationHistory;
use Doctrine\ORM\EntityManagerInterface;



class CalculateVatController extends AbstractController
{
    private $vatCalculator;

    public function __construct(VatCalculator $vatCalculator)
    {
        $this->vatCalculator = $vatCalculator;
    }

    public function calculateVat(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Handle form submissions and history
        if ($request->isMethod('POST')) {
            
            $amount = floatval($request->request->get('amount'));
            $vatRate = floatval($request->request->get('vat_rate'));
            $incVat = $request->request->get('vat_type') === 'inc';

            $vatAmount = $this->vatCalculator->calculateVatAmount($amount, $vatRate, $incVat);
            $totalAmount = $this->vatCalculator->calculateTotalAmount($amount, $vatAmount, $incVat);

            // Store the calculation in the database
            $calculation = new CalculationHistory();
            $calculation->setAmount($amount); // Set the amount property
            $calculation->setVatRate($vatRate);
            $calculation->setVatAmount($vatAmount);
            $calculation->setTotalAmount($totalAmount);
            $calculation->setIncVat($incVat);
            $entityManager->persist($calculation);
            $entityManager->flush();
        }

        $history = $entityManager->getRepository(CalculationHistory::class)->findAll();

        // Export calculation history to CSV
        if ($request->query->get('export_csv')) {
            // Generate CSV data
            $csvData = $this->generateCsvData($history);
            // Create a temporary CSV file
            $csvFilePath = sys_get_temp_dir() . '/calculation_history.csv';
        
            // Open the file for writing
            $handle = fopen($csvFilePath, 'w');
        
            // Write the CSV header row
            fputcsv($handle, ['Amount', 'VAT Rate', 'VAT Amount', 'Total Amount']);
        
            // Write each row of CSV data to the file
            foreach ($csvData as $row) {
                fputcsv($handle, explode(",", $row));
            }
        
            // Close the file
            fclose($handle);
        
            // Prepare the response to download the CSV file
            $response = new BinaryFileResponse($csvFilePath);
            $response->headers->set('Content-Type', 'text/csv');
            $response->setContentDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                'calculation_history.csv'
            );
        
            return $response;
        }
            

        return $this->render('vat/index.html.twig', [
            'history' => $history,
        ]);
    }


    private function generateCsvData(array $history): array
    {
        $csvData[] = "Amount,VAT Rate,VAT Type,VAT Amount,Total Amount";
    
        foreach ($history as $entry) {
            // $vatType = $entry->isIncVat() ? 0 : 1;
            $csvData[] = $entry->getAmount() . "," . $entry->getVatRate() . "," . $entry->getVatAmount(). "," . $entry->getTotalAmount();
        }
    
        return $csvData;
    }

    public function clearHistory(EntityManagerInterface $entityManager): Response
    {
        // Delete all calculation history records
        $history = $entityManager->getRepository(CalculationHistory::class)->findAll();
        foreach ($history as $calculation) {
            $entityManager->remove($calculation);
        }
        $entityManager->flush();
    
        // Reset VAT rate and amount
        $this->vatCalculator->setVatRate(0);
        $this->vatCalculator->setVatAmount(0.00);
    
        return $this->redirectToRoute('calculate_vat'); // Redirect back to the main page
    }

}
