<?php

use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\RangeTermFeeCalculator;
use PragmaGoTech\Interview\Model\LoanProposal;

class RangeTermFeeCalculatorTest extends TestCase
{
    public function testCalculateFee()
    {
        $calculator = new RangeTermFeeCalculator();
        
        // Test with different term and loan amount combinations and their expected results
        $testCases = [
            ['term' => 12, 'amount' => 19100, 'expectedFee' => 385],
            ['term' => 12, 'amount' => 1000, 'expectedFee' => 50],
            ['term' => 24, 'amount' => 3650, 'expectedFee' => 150],
            ['term' => 24, 'amount' => 4327, 'expectedFee' => 175],
            ['term' => 24, 'amount' => 1000, 'expectedFee' => 70],
            ['term' => 12, 'amount' => 1000, 'expectedFee' => 50],
            ['term' => 12, 'amount' => 20000, 'expectedFee' => 400],
            ['term' => 24, 'amount' => 20000, 'expectedFee' => 800],
            ['term' => 12, 'amount' => 25000, 'expectedFee' => 0],
            ['term' => 24, 'amount' => 500, 'expectedFee' => 0], // Below the minimum amount
        ];

        foreach ($testCases as $testCase) {
            $term = $testCase['term'];
            $amount = $testCase['amount'];
            $loanProposal = new LoanProposal($term, $amount);
            $expectedFee = $testCase['expectedFee'];
            
            try {
                $fee = $calculator->calculate($loanProposal);
                
                // Check that the calculated fee matches the expected fee
                $this->assertEquals($expectedFee, $fee);
            } catch (\InvalidArgumentException $e) {
                // Check that an exception is thrown for out-of-range cases
                $this->assertSame("Loan amount must be between 1000 PLN and 20000 PLN", $e->getMessage());
            }
        }
    }
}
