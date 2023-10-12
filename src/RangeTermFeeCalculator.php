<?php

namespace PragmaGoTech\Interview;

use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\FeeCalculator;

class RangeTermFeeCalculator implements FeeCalculator
{
    private $feeStructure;

    public function __construct()
    {
        $this->feeStructure = [
            12 => [
                1000 => 50,
                2000 => 90,
                3000 => 90,
                4000 => 115,
                5000 => 100,
                6000 => 120,
                7000 => 140,
                8000 => 160,
                9000 => 180,
                10000 => 200,
                11000 => 220,
                12000 => 240,
                13000 => 260,
                14000 => 280,
                15000 => 300,
                16000 => 320,
                17000 => 340,
                18000 => 360,
                19000 => 380,
                20000 => 400,
            ],
            24 => [
                1000 => 70,
                2000 => 100,
                3000 => 120,
                4000 => 160,
                5000 => 200,
                6000 => 240,
                7000 => 280,
                8000 => 320,
                9000 => 360,
                10000 => 400,
                11000 => 440,
                12000 => 480,
                13000 => 520,
                14000 => 560,
                15000 => 600,
                16000 => 640,
                17000 => 680,
                18000 => 720,
                19000 => 760,
                20000 => 800,
            ],
        ];
    }

    public function calculate(LoanProposal $application): float
    {
        $term = $application->term();
        $amount = $application->amount();

        // Throw an error if the loan proposal is outside of the range
        if ($amount < min(array_keys($this->feeStructure[$term])) || $amount > max(array_keys($this->feeStructure[$term]))) {
            throw new \InvalidArgumentException("Loan amount must be between " . min(array_keys($this->feeStructure[$term])) . " PLN and " . max(array_keys($this->feeStructure[$term])) . " PLN");
        }

        // Determine the fee 
        $fee = $this->calculateFee($term, $amount);

        // Ensure that the fee + loan amount is a multiple of 5
        $fee = $this->roundUpToMultipleOf5($fee);

        return $fee;
    }

    private function calculateFee($term, $amount): float
    {
        // Get the fee structure for the given term
        $feeStructure = $this->feeStructure[$term];

        // Initialize the fee and previous amount
        $fee = 0;
        $prevAmount = 0;

        // Iterate through the fee structure
        foreach ($feeStructure as $lowerBound => $feeAmount) {
            // If the loan amount matches a predefined value, return the corresponding fee
            if ($amount == $lowerBound) {
                return $feeAmount;
            } 
            // If the loan amount is greater than the current lower bound, update the fee and previous amount
            elseif ($amount > $lowerBound) {
                $fee = $feeAmount;
                $prevAmount = $lowerBound;
            } 
            // If the loan amount falls between two lower bounds, calculate the fee using linear interpolation
            else {
                $nextAmount = $lowerBound;
                // Calculate the fee based on the linear interpolation formula
                $fee += (($amount - $prevAmount) / ($nextAmount - $prevAmount)) * ($feeAmount - $fee);

                break;
            }
        }

        // Return the fee
        return $fee;
    }


    private function roundUpToMultipleOf5($value): float
    {
        return ceil($value / 5) * 5;
    }
}
